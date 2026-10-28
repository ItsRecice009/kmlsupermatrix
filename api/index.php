<?php

$targetDb = '/tmp/database.sqlite';

if (!file_exists($targetDb) || filesize($targetDb) === 0) {
    $sourceDb = __DIR__ . '/../database/database.sqlite';
    $base64File = __DIR__ . '/../database/db_base64.php';

    if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
        copy($sourceDb, $targetDb);
    } elseif (file_exists($base64File)) {
        $data = require $base64File;
        file_put_contents($targetDb, base64_decode($data));
    } else {
        touch($targetDb);
    }

    if (file_exists($targetDb)) {
        chmod($targetDb, 0777);
    }
}

// Forward Vercel requests to Laravel's index.php
require __DIR__ . '/../public/index.php';
