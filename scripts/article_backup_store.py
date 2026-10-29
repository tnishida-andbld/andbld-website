"""Offline-testable Drive storage core. No CLI, credentials, SSH or WP access."""
import base64
import hashlib
import json
import re
import uuid
from datetime import datetime, timezone
from urllib.parse import urlencode


def make_backup(content, run_id):
    if not isinstance(content, bytes) or not 0 < len(content) <= 2 * 1024 * 1024:
        raise ValueError('invalid_content_size')
    if not re.fullmatch(r'[0-9]{1,30}', run_id):
        raise ValueError('invalid_run_id')
    return json.dumps({
        'format_version': 1, 'environment': 'development', 'post_id': 318,
        'post_type': 'blog', 'slug': 'claude-code-github-ai-development-workflow',
        'scope': 'post_content_only',
        'acquired_at_utc': datetime.now(timezone.utc).isoformat(),
        'run_id': run_id, 'content_bytes': len(content),
        'content_sha256': hashlib.sha256(content).hexdigest(),
        'content_base64': base64.b64encode(content).decode('ascii'),
    }, sort_keys=True, separators=(',', ':')).encode('utf-8')


def store_and_verify(content, run_id, drive_id, request):
    """request(method, URL, body, content_type) -> bytes.

    The future authenticated transport must reject redirects, enforce timeouts
    and response size limits, suppress raw errors, and never retry POST blindly.
    This core does not establish source identity: caller must verify it first.
    """
    if not re.fullmatch(r'[A-Za-z0-9_-]{10,128}', drive_id):
        raise ValueError('invalid_drive_id')
    package = make_backup(content, run_id)
    metadata = json.dumps({
        'name': 'development-post-318-' + run_id + '-' + uuid.uuid4().hex + '.json',
        'mimeType': 'application/json', 'parents': [drive_id],
    }).encode('utf-8')
    boundary = 'andbld_' + uuid.uuid4().hex
    multipart = (b'--' + boundary.encode() + b'\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n'
                 + metadata + b'\r\n--' + boundary.encode()
                 + b'\r\nContent-Type: application/json\r\n\r\n' + package
                 + b'\r\n--' + boundary.encode() + b'--\r\n')
    upload_url = 'https://www.googleapis.com/upload/drive/v3/files?' + urlencode({
        'uploadType': 'multipart', 'supportsAllDrives': 'true',
        'fields': 'id,driveId,parents',
    })
    try:
        created = json.loads(request('POST', upload_url, multipart,
                                     'multipart/related; boundary=' + boundary))
        if not isinstance(created, dict):
            raise ValueError()
        file_id = created.get('id', '')
        if not isinstance(file_id, str) or not re.fullmatch(r'[A-Za-z0-9_-]{10,128}', file_id):
            raise ValueError()
        if created.get('driveId') != drive_id or created.get('parents') != [drive_id]:
            raise ValueError()
        downloaded = request('GET', 'https://www.googleapis.com/drive/v3/files/' + file_id
                             + '?alt=media&supportsAllDrives=true', None, None)
        if downloaded != package:
            raise ValueError()
        restored_content = base64.b64decode(json.loads(downloaded)['content_base64'], validate=True)
        if restored_content != content:
            raise ValueError()
    except Exception:
        # A file may already exist. Do not retry, delete, or expose response data.
        raise RuntimeError('backup_not_verified_file_may_exist') from None
    return {'status': 'backup_bytes_verified', 'file_id': file_id,
            'content_bytes': len(content), 'content_sha256': hashlib.sha256(content).hexdigest(),
            'wordpress_restore': 'not_tested'}
