<?php
require_once __DIR__ . '/bootstrap.php';
$profile = record($db, 'profile', 1);
$settings = record($db, 'settings', 1);
if (!$profile || !$settings) exit('Import the starter database first.');
