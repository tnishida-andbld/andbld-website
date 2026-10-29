"""Read one configured shared drive's metadata; never read or write files."""
import json
import os
import re
import sys
import urllib.error
import urllib.request


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None


def check(env, opener=None):
    expected = {
        "GITHUB_REPOSITORY_ID": "1294571559",
        "GITHUB_REPOSITORY_OWNER_ID": "232493821",
        "GITHUB_REF": "refs/heads/main",
        "GITHUB_EVENT_NAME": "workflow_dispatch",
    }
    if any(env.get(key) != value for key, value in expected.items()):
        return "execution_context_rejected", False
    drive_id = env.get("BACKUP_DRIVE_ID", "")
    token = env.get("DRIVE_ACCESS_TOKEN", "")
    if not re.fullmatch(r"[A-Za-z0-9_-]{10,128}", drive_id) or not token:
        return "configuration_missing_or_invalid", False
    request = urllib.request.Request(
        "https://www.googleapis.com/drive/v3/drives/" + drive_id
        + "?fields=id&useDomainAdminAccess=false",
        headers={"Authorization": "Bearer " + token}, method="GET",
    )
    try:
        client = opener or urllib.request.build_opener(NoRedirect())
        with client.open(request, timeout=20) as response:
            if response.status != 200:
                return "unexpected_http_status", False
            raw = response.read(65537)
        if len(raw) > 65536:
            return "response_too_large", False
        metadata = json.loads(raw)
        if not isinstance(metadata, dict) or metadata.get("id") != drive_id:
            return "drive_identity_mismatch", False
        return "shared_drive_connection_verified", True
    except urllib.error.HTTPError as error:
        # Never print the URL, response body, headers or exception text.
        return "http_" + str(error.code), False
    except Exception:
        return "request_or_response_failed", False


def main():
    status, success = check(os.environ)
    summary = (
        "## Backup Drive connection (read only)\n\n"
        + "- Result: `" + status + "`\n"
        + "- Request: shared-drive metadata only (GET).\n"
        + "- Article/file contents: not requested.\n"
        + "- Drive writes: none.\n"
        + "- Backup creation and restoration: not tested.\n"
    )
    print(summary)
    if os.environ.get("GITHUB_STEP_SUMMARY"):
        with open(os.environ["GITHUB_STEP_SUMMARY"], "a", encoding="utf-8") as output:
            output.write(summary)
    return 0 if success else 1


if __name__ == "__main__":
    sys.exit(main())
