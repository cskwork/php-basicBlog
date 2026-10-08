<?php
// Diagnostics are opt-in for development and loopback requests only.
$diagnosticsAllowed = getenv('APP_ENV') === 'development'
    && getenv('BLOG_ENABLE_PHPINFO') === '1'
    && in_array($_SERVER['REMOTE_ADDR'] ?? '', array('127.0.0.1', '::1'), true);

if (!$diagnosticsAllowed) {
    http_response_code(403);
    exit('Diagnostics are disabled.');
}

phpinfo();
