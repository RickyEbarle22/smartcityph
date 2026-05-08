<?php
ob_start();
$totalBudget = (float) ($totalBudget ?? 0);
$counts = $statusCounts ?? [];
$max = max(array_values($counts) ?: [1]);
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Government Transparency</span>
    <h1>Where your <span class="gradient-flag">taxes go</span></h1>
    <p class="lead">Real-time visibility into Philippine government infrastructure and services projects.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="grid grid-3">
      <div class="glass-card" style="padding:32px;text-align:center;">
        <div style="color:var(--text-muted);font-size:0.78rem;letter-spacing:0.1em;text-transform:uppercase;">Total Budget Tracked</div>
        <div style="font-family:var(--font-head);font-weight:800;font-size:2.2rem;color:var(--gold);margin-top:6px;">₱<span data-count="<?= (int) round($totalBudget / 1000000) ?>">0</span>M</div>
        <div style="color:var(--text-secondary);font-size:0.85rem;">Across all flagship projects</div>
      </div>
      <div class="glass-card" style="padding:32px;">
        <div style="color:var(--text-muted);font-size:0.78rem;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:14px;">Project Status Distribution</div>
        <?php foreach (['ongoing' => 'Ongoing', 'completed' => 'Completed', 'planned' => 'Planned', 'cancelled' => 'Cancelled'] as $k => $lbl):
          $val = (int) ($counts[$k] ?? 0);
          $w = $max > 0 ? ($val / $max * 100) : 0;
        ?>
          <div style="margin-bottom:10px;">
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:4px;"><span style="color:var(--text-secondary);"><?= esc($lbl) ?></span><span style="color:var(--text-primary);font-weight:700;"><?= $val ?></span></div>
            <div class="progress-bar"><div class="fill" data-progress="<?= round($w) ?>" style="width:<?= round($w) ?>%;"></div></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="glass-card" style="padding:32px;">
        <div style="color:var(--text-muted);font-size:0.78rem;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:14px;">Filter Projects</div>
        <form method="get" action="<?= base_url('transparency') ?>">
          <select name="region" class="form-select mb-2">
            <option value="">All Regions</option>
            <?php foreach (($regions ?? []) as $r): ?>
              <option value="<?= (int) $r['id'] ?>" <?= (int) ($selRegion ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <select name="status" class="form-select mb-2">
            <option value="">All Statuses</option>
            <?php foreach (['planned', 'ongoing', 'completed', 'cancelled'] as $st): ?>
              <option value="<?= esc($st) ?>" <?= ($selStatus ?? '') === $st ? 'selected' : '' ?>><?= esc(ucfirst($st)) ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn btn-primary btn-block btn-sm" type="submit">Apply Filters</button>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="mb-3">Active and Upcoming Projects</h2>
    <?php if (! empty($projects)): ?>
      <div class="grid grid-2">
        <?php foreach ($projects as $p): ?>
          <div class="proj-card">
            <span class="agency-tag"><?= esc($p['agency']) ?></span>
            <h3><?= esc($p['title']) ?></h3>
            <p style="color:var(--text-secondary);font-size:0.9rem;"><?= esc(character_limiter($p['description'] ?? '', 160)) ?></p>
            <div class="budget">₱<?= number_format((float) $p['budget'], 0) ?></div>
            <div class="progress-bar"><div class="fill" data-progress="<?= (int) $p['progress'] ?>" style="width:<?= (int) $p['progress'] ?>%;"></div></div>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.85rem;color:var(--text-muted);">
              <span class="badge badge-<?= esc($p['status']) ?>"><?= esc($p['status']) ?></span>
              <span><?= (int) $p['progress'] ?>% complete</span>
              <span><?= esc($p['region_name'] ?? 'Nationwide') ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty"><i class="fa-solid fa-folder-open"></i><h3>No projects found</h3><p>Try adjusting your filters.</p></div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
