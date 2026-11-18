<?php
$file = $_GET['file'] ?? '';
if (!is_string($file) || !preg_match('/^[a-f0-9]{32}\.jpg$/D', $file)) { http_response_code(404); exit; }
$path = __DIR__ . '/storage/' . $file;
if (!is_file($path)) { http_response_code(404); exit; }
header('Content-Type: image/jpeg');
header('X-Content-Type-Options: nosniff');
header('Content-Length: ' . filesize($path));
readfile($path);
