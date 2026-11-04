<?php
// Health-only candidate for a forced command. Never reads WordPress or a DB.
// Not deployed; this does not enforce SSH transport restrictions itself.
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit(64);
}

// No trimming or shell interpretation: every other request is denied.
if ($argc !== 1 || getenv('SSH_ORIGINAL_COMMAND') !== 'andbld-export-health-v1') {
    fwrite(STDOUT, "ANDBLD_EXPORT_DENIED_V1\n");
    exit(64);
}

fwrite(STDOUT, "ANDBLD_EXPORT_HEALTH_V1\n");
exit(0);
