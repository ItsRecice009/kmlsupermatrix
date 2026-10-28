<?php

$targetDb = '/tmp/database.sqlite';
$versionFile = '/tmp/db_version.txt';
$currentVersion = 'v3_full_data';

if (!file_exists($targetDb) || !file_exists($versionFile) || file_get_contents($versionFile) !== $currentVersion) {
    $sourceDb = __DIR__ . '/../database/database.sqlite';
    $base64File = __DIR__ . '/../database/db_base64.php';

    if (file_exists($base64File)) {
        $data = require $base64File;
        file_put_contents($targetDb, base64_decode($data));
    } elseif (file_exists($sourceDb) && filesize($sourceDb) > 0) {
        copy($sourceDb, $targetDb);
    } else {
        touch($targetDb);
    }

    if (file_exists($targetDb)) {
        chmod($targetDb, 0777);
    }
    file_put_contents($versionFile, $currentVersion);
}

// Fix Vercel script path & HTTPS so Laravel router matches /api routes correctly
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['HTTPS'] = 'on';

// Forward Vercel requests to Laravel's index.php
require __DIR__ . '/../public/index.php';
