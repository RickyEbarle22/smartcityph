<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h1><p style="color:var(--text-muted);font-size:0.92rem;"><?= esc($user['email']) ?></p></div>
  <a class="btn btn-ghost" href="<?= base_url('admin/users') ?>"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<div class="grid grid-2">
  <div class="glass-card" style="padding:32px;">
    <h3 class="mb-2">Profile</h3>
    <dl style="display:grid;grid-template-columns:auto 1fr;gap:10px 16px;">
      <dt style="color:var(--text-muted);">Phone</dt><dd><?= esc($user['phone'] ?? '—') ?></dd>
      <dt style="color:var(--text-muted);">Region</dt><dd><?= esc($user['region_name'] ?? '—') ?></dd>
      <dt style="color:var(--text-muted);">Address</dt><dd><?= esc($user['address'] ?? '—') ?></dd>
      <dt style="color:var(--text-muted);">Joined</dt><dd><?= esc(date('F j, Y', strtotime($user['created_at']))) ?></dd>
      <dt style="color:var(--text-muted);">Last Login</dt><dd><?= ! empty($user['last_login']) ? esc(date('F j, Y g:i A', strtotime($user['last_login']))) : 'Never' ?></dd>
      <dt style="color:var(--text-muted);">Status</dt><dd><?= $user['is_active'] ? '<span class="badge badge-completed">Active</span>' : '<span class="badge badge-cancelled">Inactive</span>' ?></dd>
    </dl>
  </div>

  <div class="glass-card" style="padding:32px;">
    <h3 class="mb-2">Reports filed (<?= count($reports ?? []) ?>)</h3>
    <table class="data">
      <thead><tr><th>Reference</th><th>Category</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (! empty($reports)): foreach ($reports as $r): ?>
          <tr>
            <td><a href="<?= base_url('admin/reports/view/' . $r['id']) ?>" style="color:var(--gold);"><?= esc($r['reference']) ?></a></td>
            <td><?= esc($r['category']) ?></td>
            <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="3" style="text-align:center;color:var(--text-muted);">No reports filed yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
