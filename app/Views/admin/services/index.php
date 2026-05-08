<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Services</h1><p style="color:var(--text-muted);font-size:0.92rem;">Manage all government services.</p></div>
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
          <td><?= $s['is_featured'] ? '<span class="badge badge-completed">Yes</span>' : '<span class="badge badge-planned">No</span>' ?></td>
          <td><?= $s['is_active'] ? '<span class="badge badge-completed">Active</span>' : '<span class="badge badge-cancelled">Inactive</span>' ?></td>
          <td style="color:var(--gold);"><?= number_format((float) $s['avg_rating'], 1) ?> · <?= (int) $s['total_ratings'] ?></td>
          <td class="table-actions">
            <a href="<?= base_url('admin/services/edit/' . $s['id']) ?>"><i class="fa-solid fa-pen"></i> Edit</a>
            <a class="danger" href="<?= base_url('admin/services/delete/' . $s['id']) ?>" data-confirm="Delete this service?"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No services yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
