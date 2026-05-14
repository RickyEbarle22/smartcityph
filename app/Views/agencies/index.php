<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Government Directory</span>
    <h1>Government <span class="gradient-flag">Agencies</span></h1>
    <p class="lead">Browse <?= (int) ($total ?? 0) ?> Philippine government agencies, GOCCs, and constitutional bodies. Find contacts, services, and official websites.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form method="get" action="<?= base_url('agencies') ?>" class="glass-card" style="padding:18px;display:grid;grid-template-columns:1fr 1.6fr auto auto;gap:10px;">
      <select name="category" class="form-select" aria-label="Category">
        <option value="">All Categories</option>
        <?php foreach (($categories ?? []) as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($selCategory ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
      <input class="form-control" type="text" name="q" placeholder="Search by name or acronym..." value="<?= esc($q ?? '') ?>">
      <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      <a class="btn btn-ghost" href="<?= base_url('agencies') ?>"><i class="fa-solid fa-rotate"></i></a>
    </form>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <?php if (! empty($agencies)): ?>
      <div class="svc-grid">
        <?php foreach ($agencies as $a): ?>
          <a class="svc-card float-card" href="<?= base_url('agencies/' . esc($a['slug'])) ?>">
            <div class="svc-icon" style="background:linear-gradient(135deg,var(--primary-2),var(--cyan));">
              <?php if (! empty($a['logo']) && is_file(FCPATH . 'uploads/agencies/' . $a['logo'])): ?>
                <img src="<?= base_url('uploads/agencies/' . esc($a['logo'])) ?>" alt="<?= esc($a['acronym'] ?: $a['name']) ?>" style="width:46px;height:46px;object-fit:contain;border-radius:8px;">
              <?php else: ?>
                <strong style="font-family:var(--font-head);font-size:1rem;color:#fff;letter-spacing:0.05em;"><?= esc($a['acronym'] ?: strtoupper(mb_substr($a['name'], 0, 3))) ?></strong>
              <?php endif; ?>
            </div>
            <?php if (! empty($a['category'])): ?>
              <span class="tag"><?= esc($a['category']) ?></span>
            <?php endif; ?>
            <h3><?= esc($a['name']) ?></h3>
            <p><?= esc(character_limiter($a['description'] ?? '', 110)) ?></p>
            <div class="meta">
              <?php if (! empty($a['head_name'])): ?>
                <span style="color:var(--text-muted);font-size:0.78rem;"><i class="fa-solid fa-user-tie"></i> <?= esc($a['head_name']) ?></span>
              <?php endif; ?>
              <?php if (! empty($a['website'])): ?>
                <span class="nationwide" style="background:rgba(6,182,212,0.1);color:var(--cyan);border-color:rgba(6,182,212,0.25);"><i class="fa-solid fa-globe"></i> Website</span>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty">
        <i class="fa-solid fa-landmark"></i>
        <h3>No agencies found</h3>
        <p>Try a different category or search keyword.</p>
        <a class="btn btn-outline mt-3" href="<?= base_url('agencies') ?>">Reset Filters</a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
