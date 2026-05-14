<?php
ob_start();
?>
<div class="admin-topbar"><h1>New FAQ</h1></div>
<?= view('admin/faqs/_form') ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
