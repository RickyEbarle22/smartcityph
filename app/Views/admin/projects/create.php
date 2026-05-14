<?php
ob_start();
?>
<div class="admin-topbar"><h1>New Project</h1></div>
<?= view('admin/projects/_form', ['regions' => $regions ?? [], 'agencies' => $agencies ?? []]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
