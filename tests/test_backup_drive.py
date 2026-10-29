import importlib.util
import io
import json
from pathlib import Path
import unittest
from unittest.mock import Mock
import urllib.error

spec = importlib.util.spec_from_file_location(
    "check_backup_drive", Path(__file__).resolve().parents[1] / "scripts/check-backup-drive.py")
module = importlib.util.module_from_spec(spec)
spec.loader.exec_module(module)


class DriveConnectionTests(unittest.TestCase):
    def setUp(self):
        self.env = dict(GITHUB_REPOSITORY_ID="1294571559",
                        GITHUB_REPOSITORY_OWNER_ID="232493821",
                        GITHUB_REF="refs/heads/main", GITHUB_EVENT_NAME="workflow_dispatch",
                        BACKUP_DRIVE_ID="test_drive_12345", DRIVE_ACCESS_TOKEN="private-token")
        self.client = Mock()

    def response(self, data):
        response = io.BytesIO(data)
        response.status = 200
        self.client.open.return_value = response

    def test_success_requests_only_metadata(self):
        self.response(json.dumps({"id": self.env["BACKUP_DRIVE_ID"]}).encode())
        self.assertEqual(module.check(self.env, self.client), ("shared_drive_connection_verified", True))
        request = self.client.open.call_args.args[0]
        self.assertEqual(request.get_method(), "GET")
        self.assertIsNone(request.data)
        self.assertTrue(request.full_url.endswith("?fields=id&useDomainAdminAccess=false"))

    def test_context_rejected_before_network(self):
        for key in ("GITHUB_REF", "GITHUB_EVENT_NAME", "GITHUB_REPOSITORY_ID", "GITHUB_REPOSITORY_OWNER_ID"):
            env = dict(self.env, **{key: "unapproved"})
            self.assertFalse(module.check(env, self.client)[1])
        self.client.open.assert_not_called()

    def test_bad_config_before_network(self):
        for changes in ({"BACKUP_DRIVE_ID": "../other?x=1"}, {"DRIVE_ACCESS_TOKEN": ""}):
            self.assertFalse(module.check(dict(self.env, **changes), self.client)[1])
        self.client.open.assert_not_called()

    def test_wrong_drive(self):
        self.response(b'{"id":"different"}')
        self.assertEqual(module.check(self.env, self.client), ("drive_identity_mismatch", False))

    def test_invalid_response(self):
        for raw in (b'not json', b'[]', b'x' * 65537):
            self.response(raw)
            self.assertFalse(module.check(self.env, self.client)[1])

    def test_error_does_not_expose_secrets(self):
        self.client.open.side_effect = urllib.error.HTTPError("secret-url", 403, "private-token", {}, None)
        self.assertEqual(module.check(self.env, self.client), ("http_403", False))
        self.client.open.side_effect = RuntimeError("private-token")
        self.assertEqual(module.check(self.env, self.client), ("request_or_response_failed", False))

    def test_redirect_never_forwards_authorization(self):
        self.assertIsNone(module.NoRedirect().redirect_request(None, None, 302, "", {}, "https://other.example"))


if __name__ == "__main__":
    unittest.main()
