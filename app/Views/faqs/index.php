<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker"><i class="fa-regular fa-circle-question"></i> Help Center</span>
    <h1>Frequently Asked <span class="gradient-flag">Questions</span></h1>
    <p class="lead">Quick answers about services, reports, accounts, FOI, and the SmartCity PH portal.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form method="get" action="<?= base_url('faqs') ?>" class="glass-card" style="padding:18px;display:grid;grid-template-columns:1fr 1.6fr auto auto;gap:10px;">
      <select name="category" class="form-select" aria-label="Category">
        <option value="">All Categories</option>
        <?php foreach (($categories ?? []) as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($selCategory ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
      <input class="form-control" type="text" name="q" placeholder="Search questions..." value="<?= esc($q ?? '') ?>">
      <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      <a class="btn btn-ghost" href="<?= base_url('faqs') ?>"><i class="fa-solid fa-rotate"></i></a>
    </form>
  </div>
</section>

<section class="section-sm">
  <div class="container" style="max-width:880px;">
    <?php if (! empty($faqs)): ?>
      <div class="faq-list" style="display:flex;flex-direction:column;gap:12px;">
        <?php foreach ($faqs as $i => $f): ?>
          <details class="glass-card faq-item" style="padding:0;overflow:hidden;">
            <summary style="padding:18px 22px;cursor:pointer;font-family:var(--font-head);font-weight:600;font-size:1.02rem;color:var(--text-primary);display:flex;justify-content:space-between;align-items:center;gap:14px;list-style:none;">
              <span><?= esc($f['question']) ?></span>
              <i class="fa-solid fa-plus" style="color:var(--cyan);font-size:0.9rem;flex-shrink:0;"></i>
            </summary>
            <div style="padding:0 22px 22px;color:var(--text-secondary);line-height:1.75;border-top:1px solid var(--border);padding-top:16px;">
              <?php if (! empty($f['category'])): ?>
                <span class="tag" style="margin-bottom:10px;display:inline-block;"><?= esc($f['category']) ?></span>
              <?php endif; ?>
              <p style="margin:0;"><?= nl2br(esc($f['answer'])) ?></p>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty">
        <i class="fa-regular fa-circle-question"></i>
        <h3>No questions found</h3>
        <p>Try a different category or search term — or <a href="<?= base_url('contact') ?>" style="color:var(--cyan);">contact us</a>.</p>
        <a class="btn btn-outline mt-3" href="<?= base_url('faqs') ?>">View All FAQs</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<style>
  details.faq-item summary::-webkit-details-marker { display:none; }
  details.faq-item[open] summary i.fa-plus { transform: rotate(45deg); transition: transform .25s ease; }
  details.faq-item summary i.fa-plus { transition: transform .25s ease; }
  details.faq-item[open] { box-shadow: 0 8px 32px rgba(6,182,212,0.08); border-color: rgba(6,182,212,0.18); }
</style>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
