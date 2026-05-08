<?php
ob_start();
?>
<div class="admin-topbar"><div><h1>Citizens</h1><p style="color:var(--text-muted);font-size:0.92rem;">Manage registered SmartCity PH citizens.</p></div></div>
<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Name</th><th>Email</th><th>Region</th><th>Reports</th><th>Last Login</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php if (! empty($users)): foreach ($users as $u): ?>
        <tr>
          <td><strong><?= esc($u['first_name'] . ' ' . $u['last_name']) ?></strong></td>
          <td><?= esc($u['email']) ?></td>
          <td><?= esc($u['region_name'] ?? '—') ?></td>
          <td><?= (int) ($counts[$u['id']] ?? 0) ?></td>
          <td style="color:var(--text-muted);font-size:0.85rem;"><?= ! empty($u['last_login']) ? esc(date('M j, Y', strtotime($u['last_login']))) : '—' ?></td>
          <td><?= $u['is_active'] ? '<span class="badge badge-completed">Active</span>' : '<span class="badge badge-cancelled">Inactive</span>' ?></td>
          <td class="table-actions">
            <a href="<?= base_url('admin/users/view/' . $u['id']) ?>"><i class="fa-solid fa-eye"></i></a>
            <form method="post" action="<?= base_url('admin/users/toggle/' . $u['id']) ?>" style="display:inline;">
              <?= csrf_field() ?>
              <button type="submit" data-confirm="Toggle account status?" style="background:none;border:0;color:<?= $u['is_active'] ? 'var(--red-light)' : 'var(--green)' ?>;cursor:pointer;font-size:0.85rem;"><i class="fa-solid fa-power-off"></i></button>
            </form>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No citizens registered yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
