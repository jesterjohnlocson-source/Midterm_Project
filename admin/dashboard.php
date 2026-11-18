<?php
require __DIR__ . '/../core/bootstrap.php';
requireAdmin();
require __DIR__ . '/layout.php';
$counts = [
    'Projects' => ['projects','edit.php?section=projects'],
    'Skills' => ['skills','edit.php?section=skills'],
    'Experience' => ['experience','edit.php?section=experience'],
    'Achievements' => ['achievements','edit.php?section=achievements'],
    'Education' => ['education','edit.php?section=education'],
    'Messages' => ['messages','inbox.php']
];
$admin = run($db, 'SELECT username FROM admins WHERE id = ?', [$_SESSION['admin_id']])->fetch();
studioHeader('Overview');
?>
<p>Signed in as <strong><?= h($admin['username'] ?? 'Administrator') ?></strong>. Choose a module to manage website content.</p><div class="stats">
<?php foreach ($counts as $label => $info): ?>
<a class="stat" href="<?= h($info[1]) ?>"><span><?= h($label) ?></span><strong><?= (int)run($db, 'SELECT COUNT(*) FROM `' . $info[0] . '`')->fetchColumn() ?></strong><small>Manage records →</small></a>
<?php endforeach; ?></div><section class="panel"><h2>Inbox</h2><p><?= (int)run($db, 'SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn() ?> unread messages.</p><a href="inbox.php">Open inbox →</a></section>
<?php studioFooter(); ?>
