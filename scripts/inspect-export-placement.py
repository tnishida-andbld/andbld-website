"""Manual metadata inspection; never exports article or key contents."""
import base64
import json
import os
from pathlib import Path
import re
import shlex
import subprocess
import sys
import tempfile
import time

LIMIT = 16384
PHP = '/usr/bin/php8.3'


def validate(env):
    required = {'GITHUB_REPOSITORY_ID': '1294571559',
                'GITHUB_REPOSITORY_OWNER_ID': '232493821',
                'GITHUB_REF': 'refs/heads/main', 'GITHUB_EVENT_NAME': 'workflow_dispatch'}
    if any(env.get(k) != v for k, v in required.items()):
        raise ValueError('execution_context')
    for key, pattern in {'DEV_SSH_HOST': r'[A-Za-z0-9][A-Za-z0-9.-]*',
                         'DEV_SSH_USER': r'[A-Za-z0-9_][A-Za-z0-9_.-]*',
                         'DEV_SSH_PORT': r'[0-9]{1,5}'}.items():
        if not re.fullmatch(pattern, env.get(key, '')):
            raise ValueError('configuration')
    if not 1 <= int(env['DEV_SSH_PORT']) <= 65535:
        raise ValueError('configuration')


def remote_command(user):
    source = Path(__file__).with_suffix('.php').read_text(encoding='utf-8')
    encoded = base64.b64encode(source.removeprefix('<?php\n').encode()).decode()
    code = ('if(PHP_SAPI!=="cli" || PHP_VERSION_ID<80000 || '
            '!function_exists("posix_geteuid") || !function_exists("posix_getpwuid")){exit(71);}'
            '$a=posix_getpwuid(posix_geteuid());'
            'if(!is_array($a) || $a["name"]!==$argv[1]){exit(72);}'
            'try{eval(base64_decode("' + encoded + '"));exit(placement_main());}'
            'catch(Throwable $e){exit(73);}')
    return PHP + ' -n -d display_errors=0 -d log_errors=0 -r ' + shlex.quote(code) + ' ' + shlex.quote(user)


def ssh_args(env, folder):
    return ['ssh', '-F', '/dev/null', '-T', '-i', str(folder / 'key'),
            '-p', env['DEV_SSH_PORT'], '-o', 'IdentitiesOnly=yes',
            '-o', 'IdentityAgent=none', '-o', 'BatchMode=yes',
            '-o', 'PreferredAuthentications=publickey', '-o', 'PasswordAuthentication=no',
            '-o', 'KbdInteractiveAuthentication=no', '-o', 'StrictHostKeyChecking=yes',
            '-o', 'UserKnownHostsFile=' + str(folder / 'known_hosts'),
            '-o', 'GlobalKnownHostsFile=/dev/null', '-o', 'ForwardAgent=no',
            '-o', 'ForwardX11=no', '-o', 'ClearAllForwardings=yes',
            '-o', 'ConnectTimeout=15', '-o', 'ServerAliveInterval=15',
            '-o', 'ServerAliveCountMax=2', env['DEV_SSH_USER'] + '@' + env['DEV_SSH_HOST'],
            remote_command(env['DEV_SSH_USER'])]


def run_bounded(args, timeout=90, limit=LIMIT):
    # Raw output is ephemeral, never logged. Poll file sizes to kill excess output.
    with tempfile.TemporaryFile() as out, tempfile.TemporaryFile() as err:
        proc = subprocess.Popen(args, stdin=subprocess.DEVNULL, stdout=out, stderr=err)
        start = time.monotonic()
        try:
            while proc.poll() is None:
                if time.monotonic() - start > timeout:
                    raise ValueError('timeout')
                if os.fstat(out.fileno()).st_size + os.fstat(err.fileno()).st_size > limit:
                    raise ValueError('output_limit')
                time.sleep(0.02)
            if proc.returncode or os.fstat(err.fileno()).st_size:
                raise ValueError('remote_failure')
            if os.fstat(out.fileno()).st_size > limit:
                raise ValueError('output_limit')
            out.seek(0)
            return out.read(limit + 1)
        finally:
            if proc.poll() is None:
                proc.kill()
            proc.wait()


def clean_response(raw):
    data = json.loads(raw)
    fixed = {'status': 'metadata_only', 'web_exposure': 'not_verified',
             'effective_key_sources': 'not_verified', 'recovery_access': 'not_verified',
             'ready_for_install': False}
    nodes = ('home', 'candidate', 'ssh_directory', 'authorized_keys')
    if type(data) is not dict or set(data) != set(fixed) | set(nodes):
        raise ValueError('response')
    if any(type(data[k]) is not type(v) or data[k] != v for k, v in fixed.items()):
        raise ValueError('response')
    for key in nodes:
        node = data[key]
        if type(node) is not dict:
            raise ValueError('response')
        kind = node.get('kind')
        if kind in ('not_checked', 'absent_or_unreadable'):
            if set(node) != {'kind'}:
                raise ValueError('response')
        elif kind in ('directory', 'file', 'symlink', 'other'):
            if set(node) != {'kind', 'owner_matches', 'mode', 'group_or_other_writable'}:
                raise ValueError('response')
            if type(node['mode']) is not str or not re.fullmatch(r'[0-7]{4}', node['mode']):
                raise ValueError('response')
            if any(type(node[k]) is not bool for k in ('owner_matches', 'group_or_other_writable')):
                raise ValueError('response')
            if node['group_or_other_writable'] != bool(int(node['mode'], 8) & 0o22):
                raise ValueError('response')
        else:
            raise ValueError('response')
    return data


def main():
    stage = 'configuration'
    try:
        env = os.environ
        validate(env)
        stage = 'credentials'
        with tempfile.TemporaryDirectory(prefix='placement-', dir=env['RUNNER_TEMP']) as temporary:
            folder = Path(temporary)
            for name, variable in [('key', 'DEV_SSH_PRIVATE_KEY'), ('known_hosts', 'DEV_SSH_KNOWN_HOSTS')]:
                value = env[variable].replace('\r', '')
                if not value.strip():
                    raise ValueError('credentials')
                path = folder / name
                path.write_text(value.rstrip('\n') + '\n', encoding='utf-8')
                path.chmod(0o600)
            stage = 'remote_inspection'
            raw = run_bounded(ssh_args(env, folder))
            stage = 'response_validation'
            report = clean_response(raw)
        stage = 'summary'
        Path(env['GITHUB_STEP_SUMMARY']).write_text(
            '## Export placement metadata\n\nNot an installation approval.\n\n```json\n'
            + json.dumps(report, indent=2) + '\n```\n', encoding='utf-8')
        print('Metadata inspection completed; installation readiness remains unverified.')
        return 0
    except Exception:
        print('Placement inspection failed at ' + stage + '; raw output suppressed.', file=sys.stderr)
        return 1


if __name__ == '__main__':
    raise SystemExit(main())
