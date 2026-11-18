<?php
require __DIR__ . '/../core/bootstrap.php';
requireAdmin();
require __DIR__ . '/layout.php';
$admin = run($db, 'SELECT * FROM admins WHERE id = ?', [$_SESSION['admin_id']])->fetch();
if (!$admin) go('login.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $password = $_POST['old_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $username = post('username');
    if (!is_string($password) || !password_verify($password, $admin['password_hash'])) $error = 'Current password is incorrect.';
    elseif (!preg_match('/^[a-zA-Z0-9_.-]{3,80}$/D', $username)) $error = 'Use 3–80 letters, numbers, dots, hyphens or underscores.';
    elseif (!is_string($new) || ($new !== '' && (strlen($new) < 12 || strlen($new) > 72))) $error = 'New password must be 12–72 bytes.';
    elseif (run($db, 'SELECT id FROM admins WHERE username = ? AND id <> ?', [$username,$admin['id']])->fetch()) $error = 'Username is already taken.';
    else {
        $hash = $new === '' ? $admin['password_hash'] : password_hash($new, PASSWORD_DEFAULT);
        run($db, 'UPDATE admins SET username = ?, password_hash = ? WHERE id = ?', [$username,$hash,$admin['id']]);
        session_regenerate_id(true);
        go('account.php?saved=1');
    }
}
studioHeader('Admin account');
?>
<section class="panel"><?php if (isset($_GET['saved'])): ?><p class="alert">Account updated.</p><?php endif; ?><?php if ($error): ?><p class="alert error"><?= h($error) ?></p><?php endif; ?><form method="post"><?= csrfInput() ?><label>Username<input name="username" value="<?= h($admin['username']) ?>" required></label><label>Current password<input type="password" name="old_password" required autocomplete="current-password"></label><label>New password (leave empty to keep current)<input type="password" name="new_password" autocomplete="new-password"></label><button>Update account</button></form></section><?php studioFooter(); ?>
