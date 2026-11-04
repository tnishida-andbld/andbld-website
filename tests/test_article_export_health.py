"""Local PHP subprocess tests only. No SSH, credentials or server access."""
import os
from pathlib import Path
import subprocess
import unittest

SCRIPT = Path(__file__).resolve().parents[1] / 'scripts/article-export-health.php'
PHP = os.environ.get('PHP_TEST_BINARY', 'php')


class HealthTests(unittest.TestCase):
    def run_request(self, command, args=(), stdin=b''):
        env = os.environ.copy()
        env.pop('SSH_ORIGINAL_COMMAND', None)
        if command is not None:
            env['SSH_ORIGINAL_COMMAND'] = command
        return subprocess.run([PHP, '-n', str(SCRIPT), *args], env=env,
                              input=stdin, capture_output=True, timeout=5)

    def assert_denied(self, result):
        self.assertEqual(result.returncode, 64)
        self.assertEqual(result.stdout, b'ANDBLD_EXPORT_DENIED_V1\n')
        self.assertEqual(result.stderr, b'')

    def test_health(self):
        result = self.run_request('andbld-export-health-v1')
        self.assertEqual((result.returncode, result.stdout, result.stderr),
                         (0, b'ANDBLD_EXPORT_HEALTH_V1\n', b''))

    def test_absent_or_empty(self):
        for value in (None, ''):
            with self.subTest(value=value):
                self.assert_denied(self.run_request(value))

    def test_whitespace_and_case_not_normalized(self):
        for value in (' andbld-export-health-v1', 'andbld-export-health-v1 ',
                      'andbld-export-health-v1\n', 'andbld-export-health-v1\r\n',
                      'ANDBLD-EXPORT-HEALTH-V1'):
            with self.subTest(value=value):
                self.assert_denied(self.run_request(value))

    def test_export_subsystems_and_shell_requests_denied(self):
        for value in ('andbld-export-post-318-v1', 'andbld-export-post-319-v1',
                      'sftp', 'internal-sftp', 'sh', 'printf TEST',
                      'andbld-export-health-v1 extra',
                      'andbld-export-health-v1; printf TEST',
                      '$(printf TEST)', '`printf TEST`', 'x' * 8192):
            with self.subTest(value=value[:80]):
                self.assert_denied(self.run_request(value))

    def test_direct_arguments_denied(self):
        self.assert_denied(self.run_request('andbld-export-health-v1', ('extra',)))

    def test_stdin_not_executed_or_echoed(self):
        result = self.run_request('andbld-export-health-v1', stdin=b'printf PRIVATE\n')
        self.assertEqual((result.returncode, result.stdout, result.stderr),
                         (0, b'ANDBLD_EXPORT_HEALTH_V1\n', b''))


if __name__ == '__main__':
    unittest.main()
