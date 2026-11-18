<?php
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require __DIR__ . '/../core/bootstrap.php';
echo 'Administrator username: ';
$username = trim(fgets(STDIN));
echo 'Password (visible while typing; at least 12 characters): ';
$password = rtrim(fgets(STDIN), "\r\n");
if (!preg_match('/^[a-zA-Z0-9_.-]{3,80}$/D', $username) || strlen($password) < 12 || strlen($password) > 72) exit("Invalid username or password length.\n");
run($db, 'INSERT INTO admins (username,password_hash) VALUES (?,?)', [$username,password_hash($password, PASSWORD_DEFAULT)]);
echo "Administrator created.\n";
