<?php
ob_start();
?>
<div class="admin-topbar"><h1>Edit Region</h1></div>
<?= view('admin/regions/_form', ['region' => $region, 'parents' => $parents ?? []]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
