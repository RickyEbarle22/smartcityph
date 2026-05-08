<?php
ob_start();
?>
<div class="admin-topbar"><h1>Edit Service</h1></div>
<?= view('admin/services/_form', ['service' => $service, 'regions' => $regions ?? []]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
