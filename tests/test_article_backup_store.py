import importlib.util
import json
from pathlib import Path
import unittest

spec = importlib.util.spec_from_file_location('store', Path(__file__).resolve().parents[1] / 'scripts/article_backup_store.py')
store = importlib.util.module_from_spec(spec)
spec.loader.exec_module(store)


class FakeDrive:
    def __init__(self, corrupt=False, wrong_parent=False, fail_upload=False):
        self.calls = []
        self.corrupt = corrupt
        self.wrong_parent = wrong_parent
        self.fail_upload = fail_upload

    def __call__(self, method, url, body, content_type):
        self.calls.append((method, url))
        if method == 'POST':
            if self.fail_upload:
                raise RuntimeError('private response containing article text')
            boundary = content_type.split('boundary=')[1].encode()
            parts = body.split(b'--' + boundary)
            self.metadata = json.loads(parts[1].split(b'\r\n\r\n', 1)[1].removesuffix(b'\r\n'))
            self.package = parts[2].split(b'\r\n\r\n', 1)[1].removesuffix(b'\r\n')
            parent = self.metadata['parents'][0]
            return json.dumps({'id': 'fake_file_123456', 'driveId': parent,
                               'parents': ['wrong'] if self.wrong_parent else [parent]}).encode()
        return self.package + (b'changed' if self.corrupt else b'')


class BackupTests(unittest.TestCase):
    def test_exact_bytes_and_scope(self):
        content = '<strong>記事</strong>\r\n\r\n<pre>A\n B</pre>'.encode()
        client = FakeDrive()
        result = store.store_and_verify(content, '123', 'fake_drive_12345', client)
        self.assertEqual(result['status'], 'backup_bytes_verified')
        self.assertEqual(result['wordpress_restore'], 'not_tested')
        package = json.loads(client.package)
        self.assertEqual(package['scope'], 'post_content_only')
        self.assertEqual(package['content_bytes'], len(content))
        self.assertEqual([c[0] for c in client.calls], ['POST', 'GET'])

    def test_corruption_stops_without_delete_or_retry(self):
        client = FakeDrive(corrupt=True)
        with self.assertRaisesRegex(RuntimeError, '^backup_not_verified_file_may_exist$'):
            store.store_and_verify(b'original', '123', 'fake_drive_12345', client)
        self.assertEqual(len(client.calls), 2)

    def test_wrong_parent_stops_before_readback(self):
        client = FakeDrive(wrong_parent=True)
        with self.assertRaises(RuntimeError):
            store.store_and_verify(b'original', '123', 'fake_drive_12345', client)
        self.assertEqual(len(client.calls), 1)

    def test_ambiguous_upload_not_retried_and_error_suppressed(self):
        client = FakeDrive(fail_upload=True)
        with self.assertRaisesRegex(RuntimeError, '^backup_not_verified_file_may_exist$'):
            store.store_and_verify(b'original', '123', 'fake_drive_12345', client)
        self.assertEqual(len(client.calls), 1)

    def test_invalid_input_makes_no_request(self):
        for content, run_id, drive_id in [(b'', '123', 'fake_drive_12345'),
                                          (b'a', '../', 'fake_drive_12345'),
                                          (b'a', '123', '../drive'),
                                          (b'a' * (2 * 1024 * 1024 + 1), '123', 'fake_drive_12345')]:
            client = FakeDrive()
            with self.assertRaises(ValueError):
                store.store_and_verify(content, run_id, drive_id, client)
            self.assertEqual(client.calls, [])

    def test_new_names_each_time(self):
        a, b = FakeDrive(), FakeDrive()
        for client in (a, b):
            store.store_and_verify(b'original', '123', 'fake_drive_12345', client)
        self.assertNotEqual(a.metadata['name'], b.metadata['name'])


if __name__ == '__main__':
    unittest.main()
