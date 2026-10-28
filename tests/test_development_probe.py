import importlib.util
import json
from pathlib import Path
import tempfile
import unittest
from unittest.mock import patch
from types import SimpleNamespace

spec = importlib.util.spec_from_file_location('probe', Path(__file__).parents[1]/'scripts/probe-development.py')
probe = importlib.util.module_from_spec(spec)
spec.loader.exec_module(probe)

class ProbeTests(unittest.TestCase):
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
        for data in ['SECRET', json.dumps({'status':'ERROR','stage':'SECRET'})]:
            rc, text, _ = self.run_mock(data, 1)
            self.assertEqual(rc,1); self.assertIn('remote_response',text)

    def test_only_fixed_failure_stage_is_reported(self):
        for remote, expected in [('config','remote_config'), ('SECRET','remote_response'),
                                 (['SECRET'],'remote_response')]:
            rc, text, _ = self.run_mock(json.dumps({'status':'ERROR','stage':remote}),1)
            self.assertEqual(rc,1); self.assertIn('Stage: `'+expected+'`',text)

    def test_transport_and_php_exit_codes(self):
        for code, expected in [(255,'ssh_execution'),(20,'remote_php_unavailable')]:
            rc, text, _ = self.run_mock('SECRET',code)
            self.assertEqual(rc,1); self.assertIn('Stage: `'+expected+'`',text)

    def test_only_allowlisted_metadata_reaches_summary(self):
        data = dict(status='OK',post_id=318,site_identity='development_verified',wordpress_bootstrap=False,
                    content_sha256='a'*64,content_bytes=123,php_version='8.2.0',wp_cli_on_path=False,
                    backup_parent_writable=False,unexpected='SECRET')
        rc, text, run = self.run_mock(json.dumps(data))
        self.assertEqual(rc,0); self.assertIn('not_verified',text)
        args = run.call_args.args[0]
        self.assertIn('StrictHostKeyChecking=yes',args)
        self.assertEqual(args[-1],'bash -s')

if __name__ == '__main__': unittest.main()
