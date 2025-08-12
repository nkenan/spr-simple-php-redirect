<?php
// Load configuration
$configFile = __DIR__ . '/spr-simple-php-redirect-config.json';
if (!file_exists($configFile)) {
    http_response_code(500);
    die('Configuration file not found');
}

$config = json_decode(file_get_contents($configFile), true);
if (!$config) {
    http_response_code(500);
    die('Invalid configuration');
}

// Get request information
$domain = $_SERVER['HTTP_HOST'] ?? '';
$path = $_SERVER['REQUEST_URI'] ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// Create GDPR-compliant browser information (no personal data)
$browserInfo = [
    'type' => getBrowserType($userAgent),
    'is_mobile' => isMobile($userAgent)
];

// Log the request
$logDir = __DIR__ . '/spr-logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

$logFile = $logDir . '/' . date('Ymd') . '-spr-log.json';
$logEntry = [
    'time' => date('c'),
    'domain' => $domain,
    'path' => $path,
    'browserInformation' => $browserInfo
];

// Append to log file
$logs = [];
if (file_exists($logFile)) {
    $existingLogs = file_get_contents($logFile);
    $logs = json_decode($existingLogs, true) ?: [];
}
$logs[] = $logEntry;
file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));

// Build redirect URL
$redirectUrl = rtrim($config['redirectDomain'], '/');

if (!empty($path) && !$config['dontIncludePaths']) {
    $redirectUrl .= $path;
}

// Determine redirect code
$redirectCode = $config['permanentRedirect'] ? 301 : 302;

// Perform redirect
header("Location: $redirectUrl", true, $redirectCode);
exit;

// Helper functions
function getBrowserType($userAgent) {
    if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (stripos($userAgent, 'Safari') !== false) return 'Safari';
    if (stripos($userAgent, 'Edge') !== false) return 'Edge';
    if (stripos($userAgent, 'Opera') !== false) return 'Opera';
    return 'Other';
}

function isMobile($userAgent) {
    return preg_match('/Mobile|Android|iPhone|iPad|iPod|Windows Phone/i', $userAgent) ? true : false;
}
