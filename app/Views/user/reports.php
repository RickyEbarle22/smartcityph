<?php
ob_start();
?>
<section class="page-hero" style="padding-bottom:24px;">
  <div class="container">
    <span class="kicker">My Reports</span>
    <h1>Reports I've <span class="gradient-text">filed</span></h1>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="table-wrap">
      <table class="data">
        <thead><tr><th>Reference</th><th>Category</th><th>Location</th><th>Status</th><th>Priority</th><th>Date</th><th></th></tr></thead>
        <tbody>
        <?php if (! empty($reports)): foreach ($reports as $r): ?>
          <tr>
            <td><span style="color:var(--gold);font-weight:600;font-family:var(--font-head);"><?= esc($r['reference']) ?></span></td>
            <td><?= esc($r['category']) ?></td>
            <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-secondary);"><?= esc($r['location']) ?></td>
            <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
            <td><span class="badge badge-<?= esc($r['priority']) ?>"><?= esc($r['priority']) ?></span></td>
            <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($r['created_at']))) ?></td>
            <td class="table-actions"><a href="<?= base_url('track?ref=' . urlencode($r['reference'])) ?>">Track</a></td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">You haven't filed any reports yet. <a href="<?= base_url('reports') ?>" style="color:var(--cyan);">File one now</a>.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
