<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>News</h1><p style="color:var(--text-muted);font-size:0.92rem;">Articles, announcements, and updates.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/news/create') ?>"><i class="fa-solid fa-plus"></i> New Article</a>
</div>
<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Featured</th><th>Views</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
      <?php if (! empty($items)): foreach ($items as $n): ?>
        <tr>
          <td><strong><?= esc(character_limiter($n['title'], 60)) ?></strong></td>
          <td><?= esc($n['category']) ?></td>
          <td><?= $n['is_published'] ? '<span class="badge badge-completed">Published</span>' : '<span class="badge badge-planned">Draft</span>' ?></td>
          <td><?= $n['is_featured'] ? '<i class="fa-solid fa-star" style="color:var(--gold);"></i>' : '—' ?></td>
          <td><?= number_format((int) $n['views']) ?></td>
          <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($n['created_at']))) ?></td>
          <td class="table-actions">
            <a href="<?= base_url('admin/news/edit/' . $n['id']) ?>"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/news/delete/' . $n['id']) ?>" data-confirm="Delete this article?"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No articles yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
