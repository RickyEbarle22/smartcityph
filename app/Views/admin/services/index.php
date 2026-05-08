<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Services</h1><p style="color:var(--text-muted);font-size:0.92rem;">Manage all government services. Toggle Active/Featured to control public visibility.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/services/create') ?>"><i class="fa-solid fa-plus"></i> New Service</a>
</div>
<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Service</th><th>Category</th><th>Region</th><th>Featured</th><th>Active</th><th>Rating</th><th>Actions</th></tr></thead>
    <tbody>
      <?php if (! empty($services)): foreach ($services as $s): ?>
        <tr>
          <td><strong><?= esc($s['name']) ?></strong><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($s['agency']) ?></span></td>
          <td><?= esc($s['category']) ?></td>
          <td><?= esc($s['region_name'] ?? ($s['is_nationwide'] ? 'Nationwide' : '—')) ?></td>
          <td>
            <form method="post" action="<?= base_url('admin/services/toggle-featured/' . $s['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" title="<?= $s['is_featured'] ? 'Remove from homepage' : 'Add to homepage Featured' ?>" style="background:none;border:0;cursor:pointer;font-size:1.1rem;color:<?= $s['is_featured'] ? 'var(--gold)' : 'var(--text-muted)' ?>;">
                <i class="fa-<?= $s['is_featured'] ? 'solid' : 'regular' ?> fa-star"></i>
              </button>
            </form>
          </td>
          <td>
            <form method="post" action="<?= base_url('admin/services/toggle-active/' . $s['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" data-confirm="<?= $s['is_active'] ? 'Hide this service from the public site?' : 'Make this service visible on the public site?' ?>" title="<?= $s['is_active'] ? 'Hide from /services' : 'Show on /services' ?>" style="background:none;border:0;cursor:pointer;">
                <span class="badge badge-<?= $s['is_active'] ? 'completed' : 'cancelled' ?>"><?= $s['is_active'] ? 'Active' : 'Inactive' ?></span>
              </button>
            </form>
          </td>
          <td style="color:var(--gold);"><?= number_format((float) $s['avg_rating'], 1) ?> · <?= (int) $s['total_ratings'] ?></td>
          <td class="table-actions">
            <a href="<?= base_url('services/' . $s['slug']) ?>" target="_blank" rel="noopener" title="View on site"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            <a href="<?= base_url('admin/services/edit/' . $s['id']) ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/services/delete/' . $s['id']) ?>" data-confirm="Delete this service? It will be soft-deleted." title="Delete"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No services yet. <a href="<?= base_url('admin/services/create') ?>" style="color:var(--cyan);">Create the first one</a>.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
