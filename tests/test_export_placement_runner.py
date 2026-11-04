import copy
import importlib.util
import json
from pathlib import Path
import subprocess
import sys
import unittest
from unittest.mock import patch

spec = importlib.util.spec_from_file_location('placement', Path(__file__).resolve().parents[1] / 'scripts/inspect-export-placement.py')
m = importlib.util.module_from_spec(spec)
spec.loader.exec_module(m)


def environment():
    return dict(GITHUB_REPOSITORY_ID='1294571559', GITHUB_REPOSITORY_OWNER_ID='232493821',
                GITHUB_REF='refs/heads/main', GITHUB_EVENT_NAME='workflow_dispatch',
                DEV_SSH_HOST='example.invalid', DEV_SSH_USER='fixture', DEV_SSH_PORT='22')


def response():
    return dict(status='metadata_only', web_exposure='not_verified',
                effective_key_sources='not_verified', recovery_access='not_verified',
                ready_for_install=False, **{k: {'kind': 'not_checked'} for k in
                ('home', 'candidate', 'ssh_directory', 'authorized_keys')})


class RunnerTests(unittest.TestCase):
    def test_context_and_injection_rejected(self):
        for key, value in [('GITHUB_REF', 'refs/heads/other'), ('GITHUB_EVENT_NAME', 'push'),
                           ('GITHUB_REPOSITORY_ID', '1'), ('GITHUB_REPOSITORY_OWNER_ID', '1'),
                           ('DEV_SSH_USER', 'x; echo private'), ('DEV_SSH_HOST', '-oProxyCommand=x'),
                           ('DEV_SSH_PORT', '65536')]:
            env = environment()
            env[key] = value
            with self.subTest(key=key), self.assertRaises(ValueError):
                m.validate(env)
        m.validate(environment())

    def test_ssh_has_fixed_restrictions(self):
        args = m.ssh_args(environment(), Path('fixture'))
        for flag in ['IdentityAgent=none', 'StrictHostKeyChecking=yes', 'BatchMode=yes',
                     'PreferredAuthentications=publickey', 'ClearAllForwardings=yes']:
            self.assertIn(flag, args)
        self.assertEqual(args[1:3], ['-F', '/dev/null'])
        self.assertTrue(args[-1].startswith('/usr/bin/php8.3 -n '))
        self.assertNotIn('bash -s', args)

    def test_response_accepts_metadata(self):
        data = response()
        data['home'] = dict(kind='directory', owner_matches=True, mode='0700', group_or_other_writable=False)
        self.assertEqual(m.clean_response(json.dumps(data)), data)

    def test_response_rejects_extra_data_and_assurance(self):
        for key, value in [('private_path', '/private'), ('ready_for_install', True),
                           ('ready_for_install', 0), ('web_exposure', 'verified')]:
            data = response()
            data[key] = value
            with self.subTest(key=key), self.assertRaises(ValueError):
                m.clean_response(json.dumps(data))

    def test_node_shape_and_modes_rejected(self):
        for node in [dict(kind='not_checked', secret='private'),
                     dict(kind='file', owner_matches=1, mode='0600', group_or_other_writable=False),
                     dict(kind='file', owner_matches=True, mode='0666', group_or_other_writable=False),
                     dict(kind='/private')]:
            data = response()
            data['home'] = node
            with self.assertRaises(ValueError):
                m.clean_response(json.dumps(data))

    def test_local_process_success(self):
        self.assertEqual(m.run_bounded([sys.executable, '-c', 'print("ok")']), b'ok\r\n' if sys.platform == 'win32' else b'ok\n')

    def test_nonzero_and_stderr_are_not_exposed(self):
        for code in ['import sys;sys.exit(2)', 'import sys;sys.stderr.write("PRIVATE")']:
            with self.assertRaisesRegex(ValueError, '^remote_failure$'):
                m.run_bounded([sys.executable, '-c', code])

    def test_output_limit(self):
        with self.assertRaises(ValueError):
            m.run_bounded([sys.executable, '-c', 'print("x"*20000)'], limit=1000)

    def test_timeout(self):
        with self.assertRaisesRegex(ValueError, '^timeout$'):
            m.run_bounded([sys.executable, '-c', 'import time;time.sleep(10)'], timeout=0.1)


if __name__ == '__main__':
    unittest.main()
