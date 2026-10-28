<?php

$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (file_exists($sourceDb) && (!file_exists($targetDb) || filesize($targetDb) === 0)) {
    copy($sourceDb, $targetDb);
}

// Forward Vercel requests to Laravel's index.php
require __DIR__ . '/../public/index.php';
