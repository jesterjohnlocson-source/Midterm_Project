<?php
require __DIR__ . '/../core/bootstrap.php';
requireAdmin();
require __DIR__ . '/layout.php';
$allFields = require __DIR__ . '/../core/fields.php';
$section = $_GET['section'] ?? 'projects';
if (!is_string($section) || !isset($allFields[$section])) { http_response_code(404); exit('Module not found.'); }
$fields = $allFields[$section];
$single = in_array($section, ['profile','settings'], true);
$base = 'edit.php?section=' . $section;
$id = $single ? 1 : max(0, (int)($_GET['id'] ?? 0));
$current = $id ? record($db, $section, $id) : [];
if ($id && !$current) { http_response_code(404); exit('Record not found.'); }
$error = '';
$choices = [
    'accent' => ['blue','violet','green'], 'theme' => ['light','dark'],
    'category' => ['web','mobile','design','animation','other'],
    'icon' => ['fab fa-html5','fab fa-js','fab fa-git-alt','fas fa-pen-nib','fas fa-code','fas fa-laptop','fas fa-network-wired']
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $action = post('action');
    if ($action === 'delete' && !$single && $id) {
        run($db, 'DELETE FROM ' . tableName($section) . ' WHERE id = ?', [$id]);
        foreach ($fields as $key => $definition) { if ($definition[1] === 'image') removeUploadedImage($current[$key] ?? ''); }
        go($base . '&saved=1');
    }
    if ($action !== 'save') { http_response_code(400); exit('Invalid operation.'); }
    try {
        $data = [];
        foreach ($fields as $key => $definition) {
            [$label,$type] = $definition;
            if ($type === 'image') { $data[$key] = $current[$key] ?? ''; continue; }
            $value = post($key);
            if (strlen($value) > ($type === 'area' ? 5000 : 500)) throw new InvalidArgumentException($label . ' is too long.');
            if (!in_array($type, ['optional','url'], true) && $value === '') throw new InvalidArgumentException($label . ' is required.');
            if ($type === 'number' && (!ctype_digit($value) || (int)$value > 100)) throw new InvalidArgumentException('Level must be 0–100.');
            if ($type === 'email' && (strlen($value) > 254 || !filter_var($value, FILTER_VALIDATE_EMAIL))) throw new InvalidArgumentException('Enter a valid email.');
            if ($type === 'url' && $value !== '' && socialUrl($value) === '#') throw new InvalidArgumentException('Use a valid HTTPS URL.');
            if (isset($choices[$type]) && !in_array($value, $choices[$type], true)) throw new InvalidArgumentException('Choose a valid ' . $label . '.');
            $data[$key] = $value;
        }
        foreach ($fields as $key => $definition) {
            if ($definition[1] === 'image') $data[$key] = uploadImage($key, post('remove_' . $key) === '1' ? '' : $data[$key]);
        }
        saveRecord($db, $section, $data, $id);
        foreach ($fields as $key => $definition) {
            if ($definition[1] === 'image' && ($current[$key] ?? '') !== $data[$key]) removeUploadedImage($current[$key] ?? '');
        }
        go($base . '&saved=1');
    } catch (InvalidArgumentException $problem) { $error = $problem->getMessage(); }
}
studioHeader(ucfirst($section));
?>
<?php if (isset($_GET['saved'])): ?><p class="alert">Changes saved. Refresh the public page to see them.</p><?php endif; ?>
<?php if ($error): ?><p class="alert error"><?= h($error) ?></p><?php endif; ?>
<?php if (!$single): ?>
<section class="panel"><div class="panel-heading"><h2>Existing records</h2><a class="button" href="<?= h($base) ?>">+ New record</a></div><div class="record-list">
<?php foreach (rows($db, $section) as $item): ?><div class="record"><strong><?= h($item['title']) ?></strong><span><?= h($item['category'] ?? $item['period'] ?? '') ?></span><a href="<?= h($base . '&id=' . $item['id']) ?>">Edit / delete</a></div><?php endforeach; ?>
</div></section>
<?php endif; ?>
<section class="panel"><h2><?= $single ? 'Update information' : ($id ? 'Edit record' : 'Add record') ?></h2><form method="post" enctype="multipart/form-data" action="<?= h($base . ($id && !$single ? '&id=' . $id : '')) ?>"><?= csrfInput() ?><input type="hidden" name="action" value="save">
<?php foreach ($fields as $key => $definition): [$label,$type] = $definition; $value = $current[$key] ?? ''; if ($error && $type !== 'image') $value = post($key); ?>
<label><?= h($label) ?>
<?php if ($type === 'image'): ?>
<?php if ($value): ?><img class="preview" src="../<?= h(imageUrl($value)) ?>" alt="Current image"><?php endif; ?><input type="file" name="<?= h($key) ?>" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG or WebP; maximum 5 MB and 4096 px per side.</small><?php if ($value): ?><span><input type="checkbox" name="remove_<?= h($key) ?>" value="1"> Remove image</span><?php endif; ?>
<?php elseif ($type === 'area'): ?><textarea name="<?= h($key) ?>" rows="4" maxlength="5000" required><?= h($value) ?></textarea>
<?php elseif (isset($choices[$type])): ?><select name="<?= h($key) ?>"><?php foreach ($choices[$type] as $option): ?><option value="<?= h($option) ?>" <?= $option === $value ? 'selected' : '' ?>><?= h($option) ?></option><?php endforeach; ?></select>
<?php else: ?><input type="<?= $type === 'number' ? 'number' : ($type === 'email' ? 'email' : ($type === 'url' ? 'url' : 'text')) ?>" name="<?= h($key) ?>" value="<?= h($value) ?>" maxlength="500" <?= $type === 'number' ? 'min="0" max="100"' : '' ?> <?= in_array($type, ['optional','url'], true) ? '' : 'required' ?>>
<?php endif; ?></label>
<?php endforeach; ?><button>Save changes</button></form>
<?php if (!$single && $id): ?><form class="delete-form" method="post" onsubmit="return confirm('Delete this record permanently?')"><?= csrfInput() ?><input type="hidden" name="action" value="delete"><button class="danger">Delete this record</button></form><?php endif; ?>
</section><?php studioFooter(); ?>
