<?php
ob_start();
$total = array_sum($statusCounts ?? []);

$quickActions = [
    'pending'     => [['next' => 'reviewing', 'label' => 'Review', 'icon' => 'fa-magnifying-glass', 'cls' => 'qa-blue']],
    'reviewing'   => [['next' => 'in_progress', 'label' => 'In Progress', 'icon' => 'fa-gear', 'cls' => 'qa-cyan']],
    'in_progress' => [['next' => 'resolved', 'label' => 'Resolve', 'icon' => 'fa-check', 'cls' => 'qa-green']],
];
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
    <thead><tr><th>Reference</th><th>Citizen</th><th>Category</th><th>Location</th><th>Priority</th><th>Status</th><th>Date</th><th style="min-width:280px;">Actions</th></tr></thead>
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
          <td>
            <div class="quick-actions">
              <?php
              $actions = $quickActions[$r['status']] ?? [];
              foreach ($actions as $a):
                $confirmMsg = 'Change status to ' . $a['label'] . '?';
              ?>
                <form method="post" action="<?= base_url('admin/reports/update-status/' . $r['id']) ?>" onsubmit="return confirm('<?= esc($confirmMsg, 'js') ?>');" style="display:inline;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="status" value="<?= esc($a['next']) ?>">
                  <button type="submit" class="qa-btn <?= esc($a['cls']) ?>" title="<?= esc($a['label']) ?>"><i class="fa-solid <?= esc($a['icon']) ?>"></i> <?= esc($a['label']) ?></button>
                </form>
              <?php endforeach; ?>

              <?php if (in_array($r['status'], ['pending', 'reviewing', 'in_progress'], true)): ?>
                <form method="post" action="<?= base_url('admin/reports/update-status/' . $r['id']) ?>" onsubmit="return confirm('Change status to Reject?');" style="display:inline;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="status" value="rejected">
                  <button type="submit" class="qa-btn qa-red" title="Reject"><i class="fa-solid fa-xmark"></i> Reject</button>
                </form>
              <?php endif; ?>

              <a class="qa-btn qa-ghost" href="<?= base_url('admin/reports/view/' . $r['id']) ?>" title="View"><i class="fa-solid fa-eye"></i> View</a>
            </div>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px;">No reports found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
.quick-actions { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
.qa-btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 6px 11px; border-radius: 8px;
  font-size: 0.78rem; font-weight: 600;
  border: 1px solid transparent; cursor: pointer;
  text-decoration: none; line-height: 1;
  transition: filter .15s ease, box-shadow .15s ease, background .15s ease, color .15s ease;
  white-space: nowrap;
}
.qa-btn i { font-size: 0.78rem; }
.qa-btn:hover { filter: brightness(1.12); }
.qa-blue  { background: rgba(37, 99, 235, 0.14);  color: #60A5FA; border-color: rgba(37, 99, 235, 0.35); }
.qa-cyan  { background: rgba(6, 182, 212, 0.14);  color: #22D3EE; border-color: rgba(6, 182, 212, 0.35); }
.qa-green { background: rgba(34, 197, 94, 0.14);  color: #4ADE80; border-color: rgba(34, 197, 94, 0.35); }
.qa-red   { background: rgba(239, 68, 68, 0.14);  color: #F87171; border-color: rgba(239, 68, 68, 0.35); }
.qa-ghost { background: rgba(255, 255, 255, 0.04); color: var(--text-secondary); border-color: var(--border-light); }
.qa-ghost:hover { color: #fff; background: rgba(255, 255, 255, 0.08); }
</style>

<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
