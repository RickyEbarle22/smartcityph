<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Agencies</h1><p style="color:var(--text-muted);font-size:0.92rem;">Government agency directory shown on /agencies.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/agencies/create') ?>"><i class="fa-solid fa-plus"></i> New Agency</a>
</div>

<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Agency</th><th>Category</th><th>Head</th><th>Website</th><th>Active</th><th>Actions</th></tr></thead>
    <tbody>
      <?php if (! empty($agencies)): foreach ($agencies as $a): ?>
        <tr>
          <td>
            <strong><?= esc($a['name']) ?></strong>
            <?php if (! empty($a['acronym'])): ?><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($a['acronym']) ?></span><?php endif; ?>
          </td>
          <td><?= esc($a['category'] ?: '—') ?></td>
          <td style="font-size:0.85rem;color:var(--text-secondary);">
            <?= esc($a['head_name'] ?: '—') ?>
            <?php if (! empty($a['head_title'])): ?><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($a['head_title']) ?></span><?php endif; ?>
          </td>
          <td>
            <?php if (! empty($a['website'])): ?>
              <a href="<?= esc($a['website']) ?>" target="_blank" rel="noopener" style="color:var(--cyan);font-size:0.85rem;"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <?php else: ?>
              <span style="color:var(--text-muted);">—</span>
            <?php endif; ?>
          </td>
          <td>
            <form method="post" action="<?= base_url('admin/agencies/toggle-active/' . $a['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" style="background:none;border:0;cursor:pointer;"><span class="badge badge-<?= $a['is_active'] ? 'completed' : 'cancelled' ?>"><?= $a['is_active'] ? 'Active' : 'Inactive' ?></span></button>
            </form>
          </td>
          <td class="table-actions">
            <a href="<?= base_url('agencies/' . $a['slug']) ?>" target="_blank" rel="noopener" title="View on site"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <a href="<?= base_url('admin/agencies/edit/' . $a['id']) ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/agencies/delete/' . $a['id']) ?>" data-confirm="Delete this agency?" title="Delete"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px;">No agencies yet. <a href="<?= base_url('admin/agencies/create') ?>" style="color:var(--cyan);">Add the first one</a>.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
