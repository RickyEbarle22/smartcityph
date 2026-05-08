<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>News</h1><p style="color:var(--text-muted);font-size:0.92rem;">Articles, announcements, and updates. Toggle Publish to control public visibility on /news.</p></div>
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
          <td>
            <form method="post" action="<?= base_url('admin/news/toggle-publish/' . $n['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" data-confirm="<?= $n['is_published'] ? 'Unpublish this article?' : 'Publish this article to /news now?' ?>" title="<?= $n['is_published'] ? 'Unpublish (hide from /news)' : 'Publish to /news' ?>" style="background:none;border:0;cursor:pointer;">
                <span class="badge badge-<?= $n['is_published'] ? 'completed' : 'planned' ?>"><?= $n['is_published'] ? 'Published' : 'Draft' ?></span>
              </button>
            </form>
          </td>
          <td><?= $n['is_featured'] ? '<i class="fa-solid fa-star" style="color:var(--gold);"></i>' : '—' ?></td>
          <td><?= number_format((int) $n['views']) ?></td>
          <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($n['created_at']))) ?></td>
          <td class="table-actions">
            <?php if ($n['is_published']): ?>
              <a href="<?= base_url('news/' . $n['slug']) ?>" target="_blank" rel="noopener" title="View on site"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <?php endif; ?>
            <a href="<?= base_url('admin/news/edit/' . $n['id']) ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/news/delete/' . $n['id']) ?>" data-confirm="Delete this article? It will be soft-deleted." title="Delete"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No articles yet. <a href="<?= base_url('admin/news/create') ?>" style="color:var(--cyan);">Write your first one</a>.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
