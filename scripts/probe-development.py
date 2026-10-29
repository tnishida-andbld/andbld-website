"""Fixed Development inventory; no arbitrary remote command or article input."""
import base64
import json
import os
from pathlib import Path
import re
import shlex
import subprocess
import sys

# Xserver's documented CLI path; never fall back to the system PHP.
PHP_CLI = '/usr/bin/php8.3'

def validate(env):
    if env.get('GITHUB_REF') != 'refs/heads/main' or env.get('GITHUB_EVENT_NAME') != 'workflow_dispatch':
        raise ValueError('main manual execution required')
    for key, pattern in {
        'DEV_SSH_HOST': r'[A-Za-z0-9][A-Za-z0-9.-]*',
        'DEV_SSH_USER': r'[A-Za-z0-9_][A-Za-z0-9_.-]*',
        'DEV_SSH_PORT': r'[0-9]{1,5}',
        'DEV_DEPLOY_PATH': r'/[A-Za-z0-9_./-]+',
    }.items():
        if not re.fullmatch(pattern, env.get(key, '')):
            raise ValueError('invalid configuration')
    if not 1 <= int(env['DEV_SSH_PORT']) <= 65535:
        raise ValueError('invalid port')
    parts = env['DEV_DEPLOY_PATH'].split('/')
    if any(p in ('.', '..') for p in parts) or 'dev-20260601.andbld.co.jp' not in parts or parts[-3:] != ['wp-content','themes','andbld']:
        raise ValueError('invalid Development path')


def php_bootstrap(source):
    encoded = base64.b64encode(source.encode()).decode()
    # Keep this wrapper compatible with older PHP; inspect version before eval.
    return ('file_put_contents("php://stderr", "ANDBLD_PROBE:php_started\\n");'
            'file_put_contents("php://stderr", "ANDBLD_PHP_VERSION_ID:".PHP_VERSION_ID."\\n");'
            'if (PHP_SAPI !== "cli") { echo json_encode(array("status"=>"ERROR","stage"=>"php_sapi")); exit(21); }'
            'if (PHP_VERSION_ID < 80000) { echo json_encode(array("status"=>"ERROR","stage"=>"php_version")); exit(22); }'
            'file_put_contents("php://stderr", "ANDBLD_PROBE:eval_started\\n");'
            'try { $loaded = eval(base64_decode("' + encoded + '")); }'
            'catch (Throwable $e) { echo json_encode(array("status"=>"ERROR","stage"=>"php_eval")); exit(23); }'
            'if ($loaded === false || !function_exists("probe_main")) { echo json_encode(array("status"=>"ERROR","stage"=>"php_load")); exit(24); }'
            'file_put_contents("php://stderr", "ANDBLD_PROBE:probe_started\\n");'
            'probe_main($argv[1], $argv[2]);')


def remote_script(env):
    validate(env)
    php = Path(__file__).with_suffix('.php').read_text(encoding='utf-8')
    bootstrap = php_bootstrap(php.removeprefix('<?php\n'))
    return ('set -eu\n'
            'printf "ANDBLD_PROBE:shell_started\\n" >&2\n'
            'test -x ' + shlex.quote(PHP_CLI) + ' || exit 20\n'
            'printf "ANDBLD_PROBE:php_found\\n" >&2\n'
            'available=no\ncommand -v wp >/dev/null 2>&1 && available=yes\n'
            'set +e\n' +
            shlex.quote(PHP_CLI) + ' -d display_errors=0 -d log_errors=0 -r ' +
            shlex.quote(bootstrap) + ' ' +
            shlex.quote(env['DEV_DEPLOY_PATH']) + ' "$available"\n'
            'rc=$?\nprintf "ANDBLD_PROBE:php_finished\\n" >&2\nexit "$rc"\n')


def response_diagnostics(result):
    """Classify output without copying any remote text into the report."""
    try:
        parsed = json.loads(result.stdout)
        shape = 'object' if isinstance(parsed, dict) else 'other_json'
    except (ValueError, TypeError):
        shape = 'empty' if not result.stdout.strip() else 'non_json'
    allowed = ('shell_started', 'php_found', 'php_started', 'eval_started', 'probe_started', 'php_finished')
    lines = result.stderr.splitlines()
    version_lines = [line for line in lines if re.fullmatch(r'ANDBLD_PHP_VERSION_ID:[1-9][0-9]{4,5}', line)]
    version_id = int(version_lines[0].split(':')[1]) if len(version_lines) == 1 else None
    milestones = [name for name in allowed if 'ANDBLD_PROBE:' + name in lines]
    stderr = '\n'.join(line for line in lines if line not in
                       {'ANDBLD_PROBE:' + name for name in allowed} and line not in version_lines).lower()
    if 'php parse error' in stderr or 'parse error:' in stderr:
        error_class = 'php_parse_error_marker'
    elif 'php fatal error' in stderr or 'fatal error:' in stderr:
        error_class = 'php_fatal_error_marker'
    elif 'usage: php' in stderr or 'error in argument' in stderr:
        error_class = 'php_usage_marker'
    else:
        error_class = 'unclassified' if stderr.strip() else 'empty'
    return {'exit_code': int(result.returncode), 'stdout_format': shape,
            'stderr_present': bool(stderr.strip()), 'stderr_class': error_class,
            'milestones': milestones, 'php_version_id': version_id}


def clean_storage(data):
    if not isinstance(data, dict):
        raise ValueError('missing storage inventory')
    layout = data.get('layout')
    depth = data.get('levels_below_public_html')
    if layout not in ('ambiguous', 'no_public_html_component', 'root_named_public_html', 'root_below_public_html'):
        raise ValueError('invalid layout')
    if layout in ('ambiguous', 'no_public_html_component'):
        if depth is not None: raise ValueError('unexpected depth')
    elif type(depth) is not int or depth < 0 or (layout == 'root_named_public_html') != (depth == 0):
        raise ValueError('invalid depth')
    if data.get('candidate_inspection') != 'not_performed' or data.get('web_exposure') != 'not_verified' or data.get('ready_for_backup') is not False:
        raise ValueError('invalid assurance')
    return dict(layout=layout, levels_below_public_html=depth,
                candidate_inspection='not_performed', web_exposure='not_verified', ready_for_backup=False)


def main():
    stage = 'runner_configuration'
    diagnostics = None
    try:
        env = os.environ
        payload = remote_script(env)
        stage = 'runner_credentials'
        ssh_dir = Path(env['RUNNER_TEMP']) / 'article-probe-ssh'
        ssh_dir.mkdir(mode=0o700)
        for name, key in [('key','DEV_SSH_PRIVATE_KEY'), ('known_hosts','DEV_SSH_KNOWN_HOSTS')]:
            value = env[key].replace('\r','')
            if not value.strip():
                raise ValueError('missing secret')
            target = ssh_dir / name
            target.write_text(value + '\n', encoding='utf-8')
            target.chmod(0o600)
        stage = 'ssh_execution'
        result = subprocess.run([
            'ssh', '-T', '-i', str(ssh_dir/'key'), '-p', env['DEV_SSH_PORT'],
            '-o', 'IdentitiesOnly=yes', '-o', 'StrictHostKeyChecking=yes',
            '-o', 'UserKnownHostsFile='+str(ssh_dir/'known_hosts'),
            '-o', 'BatchMode=yes', '-o', 'ConnectTimeout=15',
            '-o', 'ServerAliveInterval=15', '-o', 'ServerAliveCountMax=2',
            env['DEV_SSH_USER']+'@'+env['DEV_SSH_HOST'], 'bash -s',
        ], input=payload, text=True, encoding='utf-8', errors='replace', capture_output=True, timeout=90)
        # Only emit enumerated fields, never raw SSH output/stderr.
        diagnostics = response_diagnostics(result)
        # 255 can originate from SSH or a remote program; do not call it auth failure.
        if result.returncode == 20:
            stage = 'remote_php_unavailable'
            raise ValueError('PHP unavailable')
        stage = 'remote_response'
        if diagnostics['stdout_format'] != 'object':
            stage = 'remote_output_' + diagnostics['stdout_format']
            raise ValueError('Invalid response shape')
        data = json.loads(result.stdout)
        if isinstance(data, dict) and data.get('status') == 'ERROR':
            allowed = {'installation', 'config', 'database', 'site_identity', 'article_identity',
                       'php_sapi', 'php_version', 'php_eval', 'php_load', 'storage',
                       'storage_layout', 'storage_parent', 'storage_container',
                       'storage_child', 'storage_capacity', 'response_encoding'}
            remote_stage = data.get('stage')
            if isinstance(remote_stage, str) and remote_stage in allowed:
                stage = 'remote_' + remote_stage
            raise ValueError('remote probe failed')
        if result.returncode:
            stage = 'remote_nonzero_exit'
            raise ValueError('remote process failed')
        if data.get('status') != 'OK':
            raise ValueError('remote probe failed')
        stage = 'response_validation'
        if data.get('post_id') != 318 or data.get('site_identity') != 'development_verified' or data.get('wordpress_bootstrap') is not False:
            raise ValueError('invalid identity')
        if not re.fullmatch(r'[a-f0-9]{64}', data.get('content_sha256','')):
            raise ValueError('invalid hash')
        if type(data.get('content_bytes')) is not int or data['content_bytes'] < 1:
            raise ValueError('invalid size')
        if not re.fullmatch(r'[0-9]+\.[0-9]+\.[0-9]+(?:[-+][A-Za-z0-9.-]+)?', data.get('php_version','')):
            raise ValueError('invalid version')
        for key in ['wp_cli_on_path']:
            if type(data.get(key)) is not bool:
                raise ValueError('invalid flag')
        clean = {key:data[key] for key in ['post_id','php_version','wp_cli_on_path','content_bytes','content_sha256']}
        clean['storage'] = clean_storage(data.get('storage'))
        clean.update(status='OK', ssh_scope='not_verified', wp_cli_execution='not_tested', backup_create_restore='not_tested', wordpress_bootstrap=False)
        report = '## Development article inventory\n\n```json\n'+json.dumps(clean, indent=2)+'\n```\n'
        stage = 'summary_write'
        Path(env['GITHUB_STEP_SUMMARY']).write_text(report, encoding='utf-8')
        print('Development inventory completed. See summary; no article update performed.')
    except Exception:
        # stage can only be a local constant or an explicitly allowlisted remote code.
        message = 'Development inventory failed at: ' + stage + '. Raw output suppressed.'
        print(message, file=sys.stderr)
        diagnostic_text = ''
        if diagnostics is not None:
            diagnostic_text = '\n```json\n'+json.dumps(diagnostics, indent=2)+'\n```\n'
            print(json.dumps(diagnostics), file=sys.stderr)
        try:
            Path(os.environ['GITHUB_STEP_SUMMARY']).write_text(
                '## Development article inventory\n\nStatus: ERROR\n\nStage: `'+stage+'`\n\n'
                'No update commands were executed. Acquisition is not confirmed.\n'+diagnostic_text, encoding='utf-8')
        except Exception:
            pass
        return 1
    finally:
        # Only our two ephemeral runner credential files, no recursive deletion.
        if 'ssh_dir' in locals():
            for name in ('key','known_hosts'):
                (ssh_dir/name).unlink(missing_ok=True)
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
