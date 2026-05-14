<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>FAQs</h1><p style="color:var(--text-muted);font-size:0.92rem;">Frequently asked questions shown on /faqs.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/faqs/create') ?>"><i class="fa-solid fa-plus"></i> New FAQ</a>
</div>

<div class="table-wrap">
  <table class="data">
    <thead><tr><th style="width:50%;">Question</th><th>Category</th><th>Sort</th><th>Active</th><th>Actions</th></tr></thead>
    <tbody>
      <?php if (! empty($faqs)): foreach ($faqs as $f): ?>
        <tr>
          <td><?= esc(character_limiter($f['question'], 120)) ?></td>
          <td><?= esc($f['category'] ?: '—') ?></td>
          <td><?= (int) $f['sort_order'] ?></td>
          <td>
            <form method="post" action="<?= base_url('admin/faqs/toggle-active/' . $f['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" style="background:none;border:0;cursor:pointer;"><span class="badge badge-<?= $f['is_active'] ? 'completed' : 'cancelled' ?>"><?= $f['is_active'] ? 'Active' : 'Hidden' ?></span></button>
            </form>
          </td>
          <td class="table-actions">
            <a href="<?= base_url('admin/faqs/edit/' . $f['id']) ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/faqs/delete/' . $f['id']) ?>" data-confirm="Delete this FAQ?" title="Delete"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px;">No FAQs yet. <a href="<?= base_url('admin/faqs/create') ?>" style="color:var(--cyan);">Add the first one</a>.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
