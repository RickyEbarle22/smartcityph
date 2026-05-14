<?php
ob_start();
?>
<div class="admin-topbar"><h1>Edit Agency</h1></div>
<?= view('admin/agencies/_form', ['agency' => $agency]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
