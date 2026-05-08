<?php
ob_start();
$total = array_sum($statusCounts ?? []);
?>
<div class="admin-topbar">
  <div><h1>Citizen Reports</h1><p style="color:var(--text-muted);font-size:0.92rem;">Manage and respond to citizen reports.</p></div>
</div>

<div class="pills">
  <a class="pill <?= empty($selStatus) ? 'active' : '' ?>" href="<?= base_url('admin/reports') ?>">All <span style="color:var(--text-muted);">· <?= (int) $total ?></span></a>
  <?php foreach (['pending' => 'Pending', 'reviewing' => 'Reviewing', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'rejected' => 'Rejected'] as $st => $lbl): ?>
    <a class="pill <?= ($selStatus ?? '') === $st ? 'active' : '' ?>" href="<?= base_url('admin/reports?status=' . $st) ?>"><?= esc($lbl) ?> <span style="color:var(--text-muted);">· <?= (int) ($statusCounts[$st] ?? 0) ?></span></a>
  <?php endforeach; ?>
</div>

<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Reference</th><th>Citizen</th><th>Category</th><th>Location</th><th>Priority</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php if (! empty($reports)): foreach ($reports as $r): ?>
        <tr>
          <td><a href="<?= base_url('admin/reports/view/' . $r['id']) ?>" style="color:var(--gold);font-weight:600;"><?= esc($r['reference']) ?></a></td>
          <td><?= esc($r['full_name']) ?><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($r['email']) ?></span></td>
          <td><?= esc($r['category']) ?></td>
          <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-secondary);"><?= esc($r['location']) ?></td>
          <td><span class="badge badge-<?= esc($r['priority']) ?>"><?= esc($r['priority']) ?></span></td>
          <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
          <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($r['created_at']))) ?></td>
          <td class="table-actions"><a href="<?= base_url('admin/reports/view/' . $r['id']) ?>"><i class="fa-solid fa-eye"></i> View</a></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;">No reports found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
