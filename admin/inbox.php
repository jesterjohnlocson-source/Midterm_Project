<?php
require __DIR__ . '/../core/bootstrap.php';
requireAdmin();
require __DIR__ . '/layout.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $id = (int)post('id');
    $action = post('action');
    if ($action === 'delete') run($db, 'DELETE FROM messages WHERE id = ?', [$id]);
    elseif (in_array($action, ['read','unread'], true)) run($db, 'UPDATE messages SET is_read = ? WHERE id = ?', [$action === 'read' ? 1 : 0, $id]);
    else { http_response_code(400); exit; }
    go('inbox.php');
}
$messages = run($db, 'SELECT * FROM messages ORDER BY id DESC')->fetchAll();
studioHeader('Inbox');
?>
<?php if (!$messages): ?><section class="panel">No messages yet.</section><?php endif; ?>
<?php foreach ($messages as $message): ?><article class="panel message"><span class="eyebrow"><?= $message['is_read'] ? 'READ' : 'UNREAD' ?> · <?= h($message['created_at']) ?></span><h2><?= h($message['subject']) ?></h2><p><?= h($message['name']) ?> · <?= h($message['email']) ?></p><p class="message-body"><?= h($message['message']) ?></p><form method="post" class="actions"><?= csrfInput() ?><input type="hidden" name="id" value="<?= (int)$message['id'] ?>"><button name="action" value="<?= $message['is_read'] ? 'unread' : 'read' ?>" class="secondary">Mark <?= $message['is_read'] ? 'unread' : 'read' ?></button><button name="action" value="delete" class="danger" onclick="return confirm('Delete message?')">Delete</button></form></article><?php endforeach; ?>
<?php studioFooter(); ?>
