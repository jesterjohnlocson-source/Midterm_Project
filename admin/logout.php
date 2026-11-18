<?php
require __DIR__ . '/../core/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
checkCsrf();
$_SESSION = [];
$cookie = session_get_cookie_params();
setcookie(session_name(), '', time() - 3600, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
session_destroy();
go('login.php');
