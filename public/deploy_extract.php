<?php
/**
 * Automated Deployment Extractor for Hostinger
 * This file is automatically invoked by GitHub Actions CI/CD.
 */

// Verify secret token to prevent unauthorized execution
$expectedToken = getenv('DEPLOY_TOKEN') ?: 'todo_list_deploy_secret_token_2026';
$providedToken = $_GET['token'] ?? $_POST['token'] ?? '';

if (!hash_equals($expectedToken, (string)$providedToken)) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$zipFile = __DIR__ . '/deploy_package.zip';

if (!file_exists($zipFile)) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Deployment package not found']);
    exit;
}

$zip = new ZipArchive();
$res = $zip->open($zipFile);

if ($res === true) {
    // Extract everything to the current folder
    $zip->extractTo(__DIR__);
    $zip->close();

    // Remove the zip file after extraction to keep the server clean
    @unlink($zipFile);

    // Clear Laravel caches if artisan exists
    if (file_exists(__DIR__ . '/artisan')) {
        @exec('php artisan config:clear 2>&1');
        @exec('php artisan route:clear 2>&1');
        @exec('php artisan view:clear 2>&1');
    }

    echo json_encode(['status' => 'success', 'message' => 'Application deployed and extracted in seconds!']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to open zip file']);
}

