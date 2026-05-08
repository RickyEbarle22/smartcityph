<?php
ob_start();
?>
<div class="admin-topbar"><h1>New Region</h1></div>
<?= view('admin/regions/_form', ['parents' => $parents ?? []]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
