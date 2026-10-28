<?php

$targetDb = '/tmp/database.sqlite';
$versionFile = '/tmp/db_version.txt';
$currentVersion = 'v2_fixed_schema';

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

// Forward Vercel requests to Laravel's index.php
require __DIR__ . '/../public/index.php';
