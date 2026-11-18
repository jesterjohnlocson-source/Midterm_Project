<?php
require __DIR__ . '/../core/bootstrap.php';
if (!empty($_SESSION['admin_id']) && time() - ($_SESSION['last_seen'] ?? 0) <= 1800) go('dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    if (!limitRequest($db, 'login', 5, 600)) $error = 'Too many login attempts. Try again in 10 minutes.';
    else {
        $username = post('username');
        $password = $_POST['password'] ?? '';
        $admin = run($db, 'SELECT * FROM admins WHERE username = ?', [$username])->fetch();
        if ($admin && is_string($password) && strlen($password) <= 72 && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION = ['admin_id' => $admin['id'], 'last_seen' => time()];
            go('dashboard.php');
        }
        $error = 'Invalid username or password.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Jester | Portfolio Studio</title><link rel="stylesheet" href="studio.css"></head>
<body class="login-page"><main class="login-card"><span class="eyebrow">JESTER / PORTFOLIO STUDIO</span><h1>Welcome back</h1><p>Sign in to edit your portfolio.</p><?php if ($error): ?><p class="alert error"><?= h($error) ?></p><?php endif; ?><form method="post"><?= csrfInput() ?><label>Username<input name="username" required maxlength="80" autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button>Sign in</button></form><p><a href="../index.php">Return to portfolio</a></p></main></body></html>
