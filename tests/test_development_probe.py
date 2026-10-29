import importlib.util
import json
import os
import shlex
import subprocess
from pathlib import Path
import tempfile
import unittest
from unittest.mock import patch
from types import SimpleNamespace

spec = importlib.util.spec_from_file_location('probe', Path(__file__).parents[1]/'scripts/probe-development.py')
probe = importlib.util.module_from_spec(spec)
spec.loader.exec_module(probe)

class ProbeTests(unittest.TestCase):
    def storage(self):
        return dict(layout='root_below_public_html', levels_below_public_html=1,
                    candidate_inspection='not_performed', web_exposure='not_verified', ready_for_backup=False)

    def test_storage_metadata_rejects_untrusted_values(self):
        data = self.storage(); data['secret'] = 'SECRET'
        self.assertNotIn('SECRET', json.dumps(probe.clean_storage(data)))
        for key, value in [('layout','SECRET'), ('levels_below_public_html',True),
                           ('levels_below_public_html',0), ('levels_below_public_html',-1),
                           ('ready_for_backup',True), ('web_exposure','safe'),
                           ('candidate_inspection','performed')]:
            invalid = self.storage(); invalid[key] = value
            with self.assertRaises(ValueError): probe.clean_storage(invalid)

    def env(self):
        return dict(GITHUB_REF='refs/heads/main', GITHUB_EVENT_NAME='workflow_dispatch',
                    DEV_SSH_HOST='example.invalid', DEV_SSH_USER='fixture', DEV_SSH_PORT='22',
                    DEV_DEPLOY_PATH='/fixture/dev-20260601.andbld.co.jp/public_html/wp-content/themes/andbld')

    def test_rejects_wrong_environment_and_injection(self):
        for field, value in [('GITHUB_REF','refs/heads/test'), ('GITHUB_EVENT_NAME','pull_request'),
                             ('DEV_DEPLOY_PATH','/fixture/andbld.co.jp/public_html/wp-content/themes/andbld'),
                             ('DEV_DEPLOY_PATH','/fixture/dev-20260601.andbld.co.jp/../wp-content/themes/andbld'),
                             ('DEV_SSH_HOST','-oProxyCommand=bad'), ('DEV_SSH_USER','user;id'),
                             ('DEV_SSH_PORT','65536')]:
            with self.subTest(field=field, value=value):
                env = self.env(); env[field] = value
                with self.assertRaises(ValueError): probe.remote_script(env)

    def run_mock(self, stdout, code=0):
        with tempfile.TemporaryDirectory() as temp:
            env = self.env()
            env.update(RUNNER_TEMP=temp, GITHUB_STEP_SUMMARY=str(Path(temp)/'summary'),
                       DEV_SSH_PRIVATE_KEY='fixture-not-a-key', DEV_SSH_KNOWN_HOSTS='fixture-host')
            with patch.dict(probe.os.environ,env,clear=True), patch.object(probe.subprocess,'run',return_value=SimpleNamespace(stdout=stdout,stderr='SECRET',returncode=code)) as run:
                rc = probe.main()
                self.assertFalse((Path(temp)/'article-probe-ssh/key').exists())
                summary = Path(temp)/'summary'
                text = summary.read_text() if summary.exists() else ''
                self.assertNotIn('SECRET', text)
                return rc, text, run

    def test_failure_does_not_publish_raw_output(self):
        for data, expected in [('SECRET','remote_output_non_json'), (json.dumps({'status':'ERROR','stage':'SECRET'}),'remote_response')]:
            rc, text, _ = self.run_mock(data, 1)
            self.assertEqual(rc,1); self.assertIn(expected,text)

    def test_only_fixed_failure_stage_is_reported(self):
        for remote, expected in [('config','remote_config'), ('SECRET','remote_response'),
                                 (['SECRET'],'remote_response')]:
            rc, text, _ = self.run_mock(json.dumps({'status':'ERROR','stage':remote}),1)
            self.assertEqual(rc,1); self.assertIn('Stage: `'+expected+'`',text)

    def test_transport_and_php_exit_codes(self):
        for code, expected in [(255,'remote_output_non_json'),(20,'remote_php_unavailable')]:
            rc, text, _ = self.run_mock('SECRET',code)
            self.assertEqual(rc,1); self.assertIn('Stage: `'+expected+'`',text)

    def test_storage_failure_stages_are_allowlisted(self):
        for stage in ('storage_layout', 'storage_parent', 'storage_container',
                      'storage_child', 'storage_capacity', 'response_encoding'):
            rc, text, _ = self.run_mock(json.dumps({'status':'ERROR','stage':stage,'message':'SECRET'}),1)
            self.assertEqual(rc,1)
            self.assertIn('Stage: `remote_'+stage+'`',text)
            self.assertNotIn('SECRET',text)

    def test_output_shape_is_distinguished_without_raw_text(self):
        for raw, shape in [('', 'empty'), ('SECRET', 'non_json'), ('["SECRET"]','other_json'), ('{"secret":"SECRET"}', 'object')]:
            result = SimpleNamespace(stdout=raw,stderr='SECRET',returncode=255)
            report = probe.response_diagnostics(result)
            self.assertEqual(report['stdout_format'], shape)
            self.assertEqual(report['exit_code'],255)
            self.assertNotIn('SECRET',json.dumps(report))

    def test_error_markers_never_copy_paths_or_credentials(self):
        for raw, marker in [('PHP Parse error: SECRET','php_parse_error_marker'),
                            ('PHP Fatal error: SECRET','php_fatal_error_marker'),
                            ('Error in argument SECRET','php_usage_marker'), ('SECRET','unclassified')]:
            report = probe.response_diagnostics(SimpleNamespace(stdout='',stderr=raw,returncode=1))
            self.assertEqual(report['stderr_class'],marker)
            self.assertNotIn('SECRET',json.dumps(report))

    def test_empty_and_non_object_response_fail_safely(self):
        for raw, stage in [('', 'remote_output_empty'), ('[]', 'remote_output_other_json')]:
            rc,text,_=self.run_mock(raw)
            self.assertEqual(rc,1); self.assertIn(stage,text)

    def test_milestones_require_exact_allowlisted_lines(self):
        result = SimpleNamespace(stdout='', returncode=0, stderr=
            'ANDBLD_PROBE:shell_started\nANDBLD_PROBE:php_found\n'
            'ANDBLD_PROBE:SECRET\nprefix ANDBLD_PROBE:php_started\n')
        report = probe.response_diagnostics(result)
        self.assertEqual(report['milestones'], ['shell_started', 'php_found'])
        self.assertTrue(report['stderr_present'])
        self.assertNotIn('SECRET', json.dumps(report))
        result.stderr = 'ANDBLD_PROBE:shell_started\nANDBLD_PROBE:php_finished\n'
        report = probe.response_diagnostics(result)
        self.assertEqual(report['stderr_class'], 'empty')
        self.assertFalse(report['stderr_present'])

    @unittest.skipUnless(os.environ.get('PHP_TEST_BINARY'), 'Set PHP_TEST_BINARY for local PHP integration')
    def test_generated_php_executes_and_rejects_nonexistent_fixture(self):
        payload = probe.remote_script(self.env())
        command = next(line for line in payload.splitlines() if line.startswith(probe.PHP_CLI + ' -d'))
        args = shlex.split(command)
        args[0] = os.environ['PHP_TEST_BINARY']
        args[-1] = 'no'
        result = subprocess.run(args, capture_output=True, text=True, timeout=15)
        self.assertEqual(result.returncode, 1)
        self.assertEqual(json.loads(result.stdout), {'status':'ERROR', 'stage':'installation'})
        self.assertEqual(probe.response_diagnostics(result)['milestones'], ['php_started', 'eval_started', 'probe_started'])

    def test_remote_php_is_fixed_and_missing_binary_stops(self):
        env = self.env()
        env['PHP_CLI'] = '/untrusted/SECRET'
        script = probe.remote_script(env)
        self.assertIn('test -x /usr/bin/php8.3 || exit 20\n', script)
        self.assertIn('\n/usr/bin/php8.3 -d ', script)
        self.assertNotIn('SECRET', script)
        self.assertNotIn('\nphp -d ', script)
        self.assertLess(script.index('test -x '), script.index('/usr/bin/php8.3 -d '))

    def test_version_metadata_is_strictly_numeric_and_unique(self):
        for value, expected in [('ANDBLD_PHP_VERSION_ID:80200',80200),
                                ('ANDBLD_PHP_VERSION_ID:SECRET',None),
                                ('ANDBLD_PHP_VERSION_ID:80200\nANDBLD_PHP_VERSION_ID:80200',None)]:
            report = probe.response_diagnostics(SimpleNamespace(stdout='',stderr=value,returncode=0))
            self.assertEqual(report['php_version_id'],expected)
            self.assertNotIn('SECRET',json.dumps(report))

    @unittest.skipUnless(os.environ.get('PHP_TEST_BINARY'), 'Set PHP_TEST_BINARY for local PHP integration')
    def test_eval_failures_return_fixed_errors(self):
        for source, stage in [('invalid syntax SECRET', 'php_eval'), ('return false;', 'php_load'), ('', 'php_load')]:
            result = subprocess.run([os.environ['PHP_TEST_BINARY'], '-d', 'display_errors=0', '-d', 'log_errors=0',
                                     '-r',probe.php_bootstrap(source)], capture_output=True,text=True,timeout=15)
            self.assertNotEqual(result.returncode,0)
            self.assertEqual(json.loads(result.stdout), {'status':'ERROR','stage':stage})
            self.assertNotIn('SECRET',result.stdout+result.stderr)

    def test_only_allowlisted_metadata_reaches_summary(self):
        data = dict(status='OK',post_id=318,site_identity='development_verified',wordpress_bootstrap=False,
                    content_sha256='a'*64,content_bytes=123,php_version='8.2.0',wp_cli_on_path=False,
                    backup_parent_writable=False,unexpected='SECRET',storage=self.storage())
        rc, text, run = self.run_mock(json.dumps(data))
        self.assertEqual(rc,0); self.assertIn('not_verified',text)
        args = run.call_args.args[0]
        self.assertIn('StrictHostKeyChecking=yes',args)
        self.assertEqual(args[-1],'bash -s')

if __name__ == '__main__': unittest.main()
