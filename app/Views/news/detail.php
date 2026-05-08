<?php
ob_start();
?>
<section class="page-hero" style="padding-top:140px;padding-bottom:30px;">
  <div class="container">
    <p class="breadcrumb"><a href="<?= base_url('/') ?>">Home</a> · <a href="<?= base_url('news') ?>">News</a></p>
    <span class="kicker mt-2"><?= esc($article['category']) ?></span>
    <h1 style="max-width:900px;margin:0 auto;"><?= esc($article['title']) ?></h1>
    <p class="lead mt-2" style="font-size:0.95rem;"><i class="fa-solid fa-user-pen"></i> <?= esc($article['author']) ?> · <i class="fa-regular fa-calendar"></i> <?= esc(date('F j, Y', strtotime($article['published_at'] ?? $article['created_at']))) ?> · <i class="fa-regular fa-eye"></i> <?= number_format((int) $article['views']) ?> views</p>
  </div>
</section>

<?php if (! empty($article['image'])): ?>
<section class="section-sm">
  <div class="container">
    <img src="<?= base_url('uploads/news/' . $article['image']) ?>" alt="<?= esc($article['title']) ?>" style="width:100%;border-radius:var(--radius);max-height:480px;object-fit:cover;">
  </div>
</section>
<?php endif; ?>

<section class="section-sm">
  <div class="container">
    <article class="glass-card" style="padding:48px;max-width:840px;margin:0 auto;font-size:1.02rem;color:var(--text-secondary);line-height:1.85;">
      <?= $article['body'] ?>
    </article>
  </div>
</section>

<?php if (! empty($related)): ?>
<section class="section">
  <div class="container">
    <h3 class="mb-3">Related articles</h3>
    <div class="news-grid">
      <?php foreach ($related as $n): ?>
        <a class="news-card" href="<?= base_url('news/' . $n['slug']) ?>">
          <div class="news-img"></div>
          <div class="news-body">
            <span class="tag" style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:0.72rem;font-weight:600;background:var(--gold-dim);color:var(--gold);border:1px solid var(--gold-border);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:10px;"><?= esc($n['category']) ?></span>
            <h3><?= esc($n['title']) ?></h3>
            <p><?= esc(character_limiter($n['excerpt'] ?? '', 100)) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
