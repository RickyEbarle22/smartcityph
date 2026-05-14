<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker"><i class="fa-solid fa-landmark"></i> Agency Profile</span>
    <h1>
      <?php if (! empty($agency['acronym'])): ?>
        <span class="gradient-flag"><?= esc($agency['acronym']) ?></span> &mdash;
      <?php endif; ?>
      <?= esc($agency['name']) ?>
    </h1>
    <?php if (! empty($agency['category'])): ?>
      <p class="lead" style="margin-top:6px;"><span class="tag" style="background:var(--gold-dim);color:var(--gold);border-color:var(--gold-border);"><?= esc($agency['category']) ?></span></p>
    <?php endif; ?>
  </div>
</section>

<section class="section-sm">
  <div class="container" style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:flex-start;">
    <div class="glass-card" style="padding:28px;">
      <h2 style="font-family:var(--font-head);font-size:1.4rem;margin-bottom:14px;">Mandate</h2>
      <p style="color:var(--text-secondary);line-height:1.75;">
        <?= esc($agency['description'] ?: 'Official Philippine government agency. Visit the website for full mandate and current programs.') ?>
      </p>

      <?php if (! empty($services)): ?>
        <h2 style="font-family:var(--font-head);font-size:1.3rem;margin:26px 0 12px;">Services Offered</h2>
        <div class="svc-grid" style="grid-template-columns:repeat(auto-fill,minmax(220px,1fr));">
          <?php foreach ($services as $s): ?>
            <a class="svc-card float-card" href="<?= base_url('services/' . esc($s['slug'])) ?>" style="padding:16px;">
              <div class="svc-icon" style="width:42px;height:42px;font-size:1rem;"><i class="fa-solid <?= esc($s['icon'] ?: 'fa-cog') ?>"></i></div>
              <span class="tag" style="font-size:0.65rem;"><?= esc($s['category']) ?></span>
              <h3 style="font-size:1rem;margin:6px 0 4px;"><?= esc($s['name']) ?></h3>
              <p style="font-size:0.82rem;"><?= esc(character_limiter($s['short_desc'] ?? '', 80)) ?></p>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <h2 style="font-family:var(--font-head);font-size:1.3rem;margin:26px 0 12px;">Services Offered</h2>
        <p style="color:var(--text-muted);">No services linked yet. Browse the full <a href="<?= base_url('services') ?>" style="color:var(--cyan);">services directory</a>.</p>
      <?php endif; ?>
    </div>

    <aside class="glass-card" style="padding:24px;position:sticky;top:100px;">
      <h3 style="font-family:var(--font-head);font-size:1.05rem;margin-bottom:14px;color:var(--gold);">Contact</h3>
      <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
        <?php if (! empty($agency['head_name'])): ?>
          <li style="color:var(--text-secondary);font-size:0.9rem;">
            <i class="fa-solid fa-user-tie" style="color:var(--gold);width:18px;"></i>
            <strong style="color:var(--text-primary);"><?= esc($agency['head_name']) ?></strong>
            <?php if (! empty($agency['head_title'])): ?><br><span style="margin-left:26px;font-size:0.8rem;color:var(--text-muted);"><?= esc($agency['head_title']) ?></span><?php endif; ?>
          </li>
        <?php endif; ?>
        <?php if (! empty($agency['address'])): ?>
          <li style="color:var(--text-secondary);font-size:0.9rem;"><i class="fa-solid fa-location-dot" style="color:var(--gold);width:18px;"></i> <?= esc($agency['address']) ?></li>
        <?php endif; ?>
        <?php if (! empty($agency['phone'])): ?>
          <li style="color:var(--text-secondary);font-size:0.9rem;"><i class="fa-solid fa-phone" style="color:var(--gold);width:18px;"></i> <?= esc($agency['phone']) ?></li>
        <?php endif; ?>
        <?php if (! empty($agency['email'])): ?>
          <li style="color:var(--text-secondary);font-size:0.9rem;word-break:break-all;"><i class="fa-solid fa-envelope" style="color:var(--gold);width:18px;"></i> <a href="mailto:<?= esc($agency['email']) ?>" style="color:var(--text-secondary);"><?= esc($agency['email']) ?></a></li>
        <?php endif; ?>
        <?php if (! empty($agency['website'])): ?>
          <li>
            <a class="btn btn-primary" href="<?= esc($agency['website']) ?>" target="_blank" rel="noopener" style="width:100%;justify-content:center;"><i class="fa-solid fa-globe"></i> Visit Website</a>
          </li>
        <?php endif; ?>
        <li>
          <a class="btn btn-outline" href="<?= base_url('foi') ?>" style="width:100%;justify-content:center;"><i class="fa-solid fa-folder-open"></i> File an FOI Request</a>
        </li>
      </ul>
    </aside>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
