<?php
ob_start();
?>
<div class="admin-topbar"><h1>New Service</h1></div>
<?= view('admin/services/_form', ['regions' => $regions ?? []]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
