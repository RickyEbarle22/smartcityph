<?php
ob_start();
$total = array_sum($statusCounts ?? []);
?>
<div class="admin-topbar">
  <div><h1>FOI Requests</h1><p style="color:var(--text-muted);font-size:0.92rem;">Freedom of Information requests submitted via /foi.</p></div>
</div>

<div class="pills">
  <a class="pill <?= empty($selStatus) ? 'active' : '' ?>" href="<?= base_url('admin/fois') ?>">All <span style="color:var(--text-muted);">· <?= (int) $total ?></span></a>
  <?php foreach (['pending' => 'Pending', 'processing' => 'Processing', 'fulfilled' => 'Fulfilled', 'denied' => 'Denied'] as $st => $lbl): ?>
    <a class="pill <?= ($selStatus ?? '') === $st ? 'active' : '' ?>" href="<?= base_url('admin/fois?status=' . $st) ?>"><?= esc($lbl) ?> <span style="color:var(--text-muted);">· <?= (int) ($statusCounts[$st] ?? 0) ?></span></a>
  <?php endforeach; ?>
</div>

<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Reference</th><th>Requester</th><th>Agency</th><th>Title</th><th>Status</th><th>Date</th><th></th></tr></thead>
    <tbody>
      <?php if (! empty($fois)): foreach ($fois as $f): ?>
        <tr>
          <td><a href="<?= base_url('admin/fois/view/' . $f['id']) ?>" style="color:var(--gold);font-weight:600;"><?= esc($f['reference']) ?></a></td>
          <td><?= esc($f['full_name']) ?><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($f['email']) ?></span></td>
          <td style="font-size:0.85rem;"><?= esc($f['agency_acronym'] ?: ($f['agency_full_name'] ?: $f['agency_name'] ?: '—')) ?></td>
          <td style="max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= esc($f['request_title']) ?></td>
          <td><span class="badge badge-<?= esc($f['status']) ?>"><?= esc($f['status']) ?></span></td>
          <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($f['created_at']))) ?></td>
          <td class="table-actions"><a href="<?= base_url('admin/fois/view/' . $f['id']) ?>"><i class="fa-solid fa-eye"></i> View</a></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No FOI requests yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
