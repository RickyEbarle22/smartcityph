<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Services Directory</span>
    <h1>Government <span class="gradient-flag">Services</span></h1>
    <p class="lead">Browse and search across <?= count($items ?? []) ?>+ active government services nationwide.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form method="get" action="<?= base_url('services') ?>" class="glass-card" style="padding:18px;display:grid;grid-template-columns:1.2fr 1fr 1.6fr auto auto;gap:10px;">
      <select name="region" class="form-select" aria-label="Region">
        <option value="">All Regions</option>
        <?php foreach (($regions ?? []) as $r): ?>
          <option value="<?= (int) $r['id'] ?>" <?= (int) ($selRegion ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="category" class="form-select" aria-label="Category">
        <option value="">All Categories</option>
        <?php foreach (($categories ?? []) as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($selCategory ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
      <input class="form-control" type="text" name="q" placeholder="Search services or agencies..." value="<?= esc($selQuery ?? '') ?>">
      <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      <a class="btn btn-ghost" href="<?= base_url('services') ?>"><i class="fa-solid fa-rotate"></i></a>
    </form>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <?php if (! empty($items)): ?>
      <div class="svc-grid">
        <?php foreach ($items as $s): ?>
          <a class="svc-card float-card" href="<?= base_url('services/' . $s['slug']) ?>">
            <div class="svc-icon"><i class="fa-solid <?= esc($s['icon'] ?: 'fa-cog') ?>"></i></div>
            <span class="tag"><?= esc($s['category']) ?></span>
            <h3><?= esc($s['name']) ?></h3>
            <p><?= esc(character_limiter($s['short_desc'] ?? '', 110)) ?></p>
            <div class="meta">
              <span class="agency"><?= esc($s['agency'] ?: 'Gov.PH') ?></span>
              <?php if ((int) $s['is_nationwide'] === 1): ?>
                <span class="nationwide"><i class="fa-solid fa-globe"></i> Nationwide</span>
              <?php elseif (! empty($s['region_name'])): ?>
                <span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($s['region_name']) ?></span>
              <?php endif; ?>
            </div>
            <?php if ((int) ($s['total_ratings'] ?? 0) > 0): ?>
              <div class="stars" style="margin-top:8px;">
                <?php $rating = round((float) ($s['avg_rating'] ?? 0)); for ($i = 1; $i <= 5; $i++): ?>
                  <i class="fa-<?= $i <= $rating ? 'solid' : 'regular' ?> fa-star"></i>
                <?php endfor; ?>
                <span style="color:var(--text-muted);font-size:0.78rem;margin-left:6px;">(<?= (int) $s['total_ratings'] ?>)</span>
              </div>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
      <?php if (! empty($pager)): ?>
        <div class="pager-wrap"><?= $pager->links() ?></div>
      <?php endif; ?>
    <?php else: ?>
      <div class="empty">
        <i class="fa-solid fa-folder-open"></i>
        <h3>No services found</h3>
        <p>Try a different region, category, or search keyword.</p>
        <a class="btn btn-outline mt-3" href="<?= base_url('services') ?>">Reset Filters</a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
