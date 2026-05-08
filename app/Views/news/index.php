<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">News & Announcements</span>
    <h1>Government <span class="gradient-text">News</span></h1>
    <p class="lead">Latest updates and announcements from the Philippine government.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="pills">
      <a class="pill <?= empty($selCategory) ? 'active' : '' ?>" href="<?= base_url('news') ?>">All</a>
      <?php foreach (($categories ?? []) as $c): ?>
        <a class="pill <?= ($selCategory ?? '') === $c ? 'active' : '' ?>" href="<?= base_url('news?category=' . urlencode($c)) ?>"><?= esc($c) ?></a>
      <?php endforeach; ?>
    </div>

    <?php if (! empty($featured) && empty($selCategory)): ?>
      <a class="news-featured" href="<?= base_url('news/' . $featured['slug']) ?>">
        <div class="news-img"><?php if (! empty($featured['image'])): ?><img src="<?= base_url('uploads/news/' . $featured['image']) ?>" alt="<?= esc($featured['title']) ?>"><?php endif; ?></div>
        <div class="news-body">
          <span class="tag" style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:0.72rem;font-weight:600;background:var(--gold-dim);color:var(--gold);border:1px solid var(--gold-border);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">Featured · <?= esc($featured['category']) ?></span>
          <h2><?= esc($featured['title']) ?></h2>
          <p style="color:var(--text-secondary);"><?= esc(character_limiter($featured['excerpt'] ?? '', 220)) ?></p>
          <div class="news-meta mt-3"><span><i class="fa-regular fa-calendar"></i> <?= esc(date('F j, Y', strtotime($featured['published_at'] ?? $featured['created_at']))) ?></span><span><i class="fa-regular fa-eye"></i> <?= number_format((int) $featured['views']) ?></span></div>
        </div>
      </a>
    <?php endif; ?>

    <?php if (! empty($items)): ?>
      <div class="news-grid">
        <?php foreach ($items as $n): ?>
          <a class="news-card" href="<?= base_url('news/' . $n['slug']) ?>">
            <div class="news-img"><?php if (! empty($n['image'])): ?><img src="<?= base_url('uploads/news/' . $n['image']) ?>" alt="<?= esc($n['title']) ?>"><?php endif; ?></div>
            <div class="news-body">
              <span class="tag" style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:0.72rem;font-weight:600;background:var(--gold-dim);color:var(--gold);border:1px solid var(--gold-border);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:10px;"><?= esc($n['category']) ?></span>
              <h3><?= esc($n['title']) ?></h3>
              <p><?= esc(character_limiter($n['excerpt'] ?? '', 130)) ?></p>
              <div class="news-meta">
                <span><i class="fa-regular fa-calendar"></i> <?= esc(date('M j, Y', strtotime($n['published_at'] ?? $n['created_at']))) ?></span>
                <span><i class="fa-regular fa-eye"></i> <?= number_format((int) $n['views']) ?></span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
    <?php else: ?>
      <div class="empty"><i class="fa-solid fa-newspaper"></i><h3>No news yet</h3><p>Check back soon for updates.</p></div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
