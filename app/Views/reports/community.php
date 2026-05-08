<?php
ob_start();
$total = array_sum($statusCounts ?? []);
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Civic Activity</span>
    <h1>Community <span class="gradient-text">Reports</span></h1>
    <p class="lead">Anonymized snapshot of all citizen reports filed across the Philippines — and how they're being handled by your government.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="grid grid-3 mb-4">
      <div class="glass-card" style="padding:24px;text-align:center;">
        <div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">Total Reports</div>
        <div style="font-family:var(--font-head);font-weight:800;font-size:2rem;color:var(--gold);"><?= number_format((int) $total) ?></div>
      </div>
      <div class="glass-card" style="padding:24px;text-align:center;">
        <div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">In Progress</div>
        <div style="font-family:var(--font-head);font-weight:800;font-size:2rem;color:var(--cyan);"><?= number_format((int) ($statusCounts['in_progress'] ?? 0) + (int) ($statusCounts['reviewing'] ?? 0)) ?></div>
      </div>
      <div class="glass-card" style="padding:24px;text-align:center;">
        <div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">Resolved</div>
        <div style="font-family:var(--font-head);font-weight:800;font-size:2rem;color:var(--green);"><?= number_format((int) ($statusCounts['resolved'] ?? 0)) ?></div>
      </div>
    </div>

    <div class="pills">
      <a class="pill <?= empty($selStatus) ? 'active' : '' ?>" href="<?= base_url('community-reports') ?>">All <span style="color:var(--text-muted);">· <?= (int) $total ?></span></a>
      <?php foreach (['pending' => 'Pending', 'reviewing' => 'Reviewing', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'rejected' => 'Rejected'] as $st => $lbl):
        $url = base_url('community-reports?status=' . $st);
      ?>
        <a class="pill <?= ($selStatus ?? '') === $st ? 'active' : '' ?>" href="<?= esc($url) ?>"><?= esc($lbl) ?> <span style="color:var(--text-muted);">· <?= (int) ($statusCounts[$st] ?? 0) ?></span></a>
      <?php endforeach; ?>
    </div>

    <form method="get" action="<?= base_url('community-reports') ?>" class="glass-card mb-4" style="padding:18px;display:grid;grid-template-columns:1fr 1fr 1fr auto auto;gap:10px;">
      <select name="region" class="form-select" aria-label="Region">
        <option value="">All Regions</option>
        <?php foreach (($regions ?? []) as $r): ?>
          <option value="<?= (int) $r['id'] ?>" <?= (int) ($selRegion ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="category" class="form-select" aria-label="Category">
        <option value="">All Categories</option>
        <?php foreach (['Road', 'Garbage', 'Flooding', 'Streetlight', 'Noise', 'Safety', 'Utilities', 'Other'] as $cat): ?>
          <option value="<?= esc($cat) ?>" <?= ($selCategory ?? '') === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
        <?php endforeach; ?>
      </select>
      <?php if (! empty($selStatus)): ?><input type="hidden" name="status" value="<?= esc($selStatus) ?>"><?php endif; ?>
      <span></span>
      <button class="btn btn-primary" type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
      <a class="btn btn-ghost" href="<?= base_url('community-reports') ?>"><i class="fa-solid fa-rotate"></i></a>
    </form>

    <div class="table-wrap">
      <table class="data">
        <thead><tr><th>Reference</th><th>Category</th><th>Location</th><th>Region</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
          <?php if (! empty($items)): foreach ($items as $r): ?>
            <tr>
              <td><span style="font-family:var(--font-head);font-weight:700;color:var(--gold);"><?= esc($r['reference']) ?></span></td>
              <td><?= esc($r['category']) ?></td>
              <td style="max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-secondary);"><?= esc(character_limiter($r['location'], 60)) ?></td>
              <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc($r['region_name'] ?? '—') ?></td>
              <td><span class="badge badge-<?= esc($r['priority']) ?>"><?= esc($r['priority']) ?></span></td>
              <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
              <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j, Y', strtotime($r['created_at']))) ?></td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No reports match your filter. <a href="<?= base_url('reports') ?>" style="color:var(--cyan);">File the first one</a>.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>

    <p style="color:var(--text-muted);font-size:0.85rem;margin-top:20px;text-align:center;">
      <i class="fa-solid fa-shield-halved"></i> Citizen names and contact details are never shown publicly. Only category, location, and status are visible.
    </p>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
