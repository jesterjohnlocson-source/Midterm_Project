<?php
function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function post($key) {
    return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : '';
}
function go($url) {
    header('Location: ' . $url, true, 303);
    exit;
}
function csrfInput() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return '<input type="hidden" name="csrf" value="' . h($_SESSION['csrf']) . '">';
}
function checkCsrf() {
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], post('csrf'))) {
        http_response_code(403);
        exit('Invalid form token. Reload the page and try again.');
    }
}
function run($db, $sql, $params = []) {
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement;
}
function tableName($name) {
    $fields = require __DIR__ . '/fields.php';
    if (!isset($fields[$name])) throw new InvalidArgumentException('Unknown module');
    return '`' . $name . '`';
}
function rows($db, $table) {
    return run($db, 'SELECT * FROM ' . tableName($table) . ' ORDER BY id')->fetchAll();
}
function record($db, $table, $id) {
    return run($db, 'SELECT * FROM ' . tableName($table) . ' WHERE id = ?', [$id])->fetch();
}
function saveRecord($db, $table, $data, $id) {
    $fields = require __DIR__ . '/fields.php';
    $columns = array_keys($fields[$table]);
    if (array_keys($data) !== $columns) throw new InvalidArgumentException('Invalid fields');
    $quoted = array_map(function ($key) { return '`' . $key . '`'; }, $columns);
    $values = array_values($data);
    if ($id) {
        $set = implode(', ', array_map(function ($key) { return $key . ' = ?'; }, $quoted));
        $values[] = $id;
        run($db, 'UPDATE ' . tableName($table) . ' SET ' . $set . ' WHERE id = ?', $values);
    } else {
        run($db, 'INSERT INTO ' . tableName($table) . ' (' . implode(', ', $quoted) . ') VALUES (' . implode(', ', array_fill(0, count($columns), '?')) . ')', $values);
    }
}
function limitRequest($db, $type, $max, $seconds) {
    $bucket = hash('sha256', $type . '|' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    $now = time();
    $db->beginTransaction();
    try {
        run($db, 'INSERT IGNORE INTO request_limits (bucket,hits,expires_at) VALUES (?,0,?)', [$bucket, $now + $seconds]);
        $row = run($db, 'SELECT hits, expires_at FROM request_limits WHERE bucket = ? FOR UPDATE', [$bucket])->fetch();
        $expired = (int)$row['expires_at'] <= $now;
        $hits = $expired ? 1 : (int)$row['hits'] + 1;
        run($db, 'UPDATE request_limits SET hits = ?, expires_at = ? WHERE bucket = ?', [min($hits, $max + 1), $expired ? $now + $seconds : $row['expires_at'], $bucket]);
        $db->commit();
        return $hits <= $max;
    } catch (Throwable $error) {
        $db->rollBack();
        throw $error;
    }
}
function socialUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) && parse_url($url, PHP_URL_SCHEME) === 'https' ? $url : '#';
}
function imageUrl($path) {
    if (preg_match('/^[a-f0-9]{32}\.jpg$/D', $path)) return 'media.php?file=' . $path;
    if (preg_match('~^images/[a-zA-Z0-9_.-]+\.(?:jpg|jpeg|png|webp)$~iD', $path) && is_file(__DIR__ . '/../' . $path)) return $path;
    return 'placeholder.svg';
}
function uploadImage($field, $old = '') {
    $file = $_FILES[$field] ?? null;
    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) return $old;
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024 || !is_uploaded_file($file['tmp_name'])) throw new InvalidArgumentException('Image upload failed or exceeded 5 MB.');
    $info = @getimagesize($file['tmp_name']);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!$info || !in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true) || $info['mime'] !== $mime || $info[0] > 4096 || $info[1] > 4096 || $info[0] * $info[1] > 12000000) throw new InvalidArgumentException('Use a genuine JPG, PNG or WebP image within the size limits.');
    if (!function_exists('imagecreatefromstring')) throw new InvalidArgumentException('Enable PHP GD before uploading images.');
    $image = @imagecreatefromstring(file_get_contents($file['tmp_name']));
    if (!$image) throw new InvalidArgumentException('Invalid image content.');
    $canvas = imagecreatetruecolor(imagesx($image), imagesy($image));
    imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));
    imagecopy($canvas, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    $name = bin2hex(random_bytes(16)) . '.jpg';
    $path = __DIR__ . '/../storage/' . $name;
    if (!imagejpeg($canvas, $path, 88)) throw new InvalidArgumentException('Could not save the image.');
    return $name;
}
function requireAdmin() {
    if (empty($_SESSION['admin_id']) || time() - ($_SESSION['last_seen'] ?? 0) > 1800) {
        unset($_SESSION['admin_id'], $_SESSION['last_seen']);
        go('login.php');
    }
    $_SESSION['last_seen'] = time();
}

function removeUploadedImage($name) {
    if (preg_match('/^[a-f0-9]{32}\.jpg$/D', $name)) {
        $path = __DIR__ . '/../storage/' . $name;
        if (is_file($path)) unlink($path);
    }
}
