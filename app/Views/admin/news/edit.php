<?php
ob_start();
?>
<div class="admin-topbar"><h1>Edit Article</h1></div>
<?= view('admin/news/_form', ['article' => $article]) ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
