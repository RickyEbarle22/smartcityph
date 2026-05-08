<?php
ob_start();
$loggedIn = (bool) session()->get('user_logged_in');
$rating = round((float) ($service['avg_rating'] ?? 0));
$totalRatings = (int) ($service['total_ratings'] ?? 0);
?>
<section class="page-hero" style="padding-top:140px;padding-bottom:30px;">
  <div class="container">
    <p class="breadcrumb"><a href="<?= base_url('/') ?>">Home</a> · <a href="<?= base_url('services') ?>">Services</a> · <span style="color:var(--text-secondary);"><?= esc($service['category']) ?></span></p>
    <span class="kicker mt-2"><?= esc($service['agency'] ?? 'Government of the Philippines') ?></span>
    <h1><?= esc($service['name']) ?></h1>
    <?php if ($totalRatings > 0): ?>
      <div style="margin-top:14px;color:var(--gold);">
        <?php for ($i = 1; $i <= 5; $i++): ?><i class="fa-<?= $i <= $rating ? 'solid' : 'regular' ?> fa-star"></i><?php endfor; ?>
        <span style="color:var(--text-secondary);font-size:0.9rem;margin-left:8px;"><?= number_format((float) $service['avg_rating'], 1) ?> · <?= $totalRatings ?> review<?= $totalRatings !== 1 ? 's' : '' ?></span>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="detail-grid">
      <div>
        <div class="glass-card" style="padding:32px;">
          <h3 class="mb-2">About this service</h3>
          <div style="color:var(--text-secondary);"><?= $service['description'] ?></div>
        </div>

        <h3 class="mt-4 mb-3">Requirements</h3>
        <div class="accordion">
          <details open>
            <summary><i class="fa-solid fa-list-check" style="color:var(--gold);"></i> What you need to bring</summary>
            <ul>
              <?php foreach (preg_split('/\r?\n/', (string) ($service['requirements'] ?? '')) as $req): if (trim($req) === '') continue; ?>
                <li style="margin-bottom:6px;"><?= esc(trim($req)) ?></li>
              <?php endforeach; ?>
            </ul>
          </details>
        </div>

        <h3 class="mt-4 mb-3">Process / Steps</h3>
        <div class="glass-card" style="padding:28px;">
          <ol style="padding-left:20px;color:var(--text-secondary);">
            <?php foreach (preg_split('/\r?\n/', (string) ($service['steps'] ?? '')) as $step): if (trim($step) === '') continue; ?>
              <li style="margin-bottom:10px;"><?= esc(trim($step)) ?></li>
            <?php endforeach; ?>
          </ol>
        </div>

        <h3 class="mt-4 mb-3">Citizen Reviews</h3>
        <div class="glass-card" style="padding:28px;">
          <?php if (! empty($reviews)): ?>
            <?php foreach ($reviews as $r): ?>
              <div class="review">
                <div class="reviewer">
                  <div class="avatar"><?= esc(strtoupper(substr((string) ($r['first_name'] ?? '?'), 0, 1) . substr((string) ($r['last_name'] ?? '?'), 0, 1))) ?></div>
                  <div>
                    <div style="font-weight:600;"><?= esc(($r['first_name'] ?? 'Citizen') . ' ' . ($r['last_name'] ?? '')) ?></div>
                    <div class="stars">
                      <?php for ($i = 1; $i <= 5; $i++): ?><i class="fa-<?= $i <= (int) $r['rating'] ? 'solid' : 'regular' ?> fa-star"></i><?php endfor; ?>
                    </div>
                  </div>
                </div>
                <p><?= esc($r['comment'] ?? '') ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="color:var(--text-muted);">No reviews yet. Be the first to share your experience.</p>
          <?php endif; ?>

          <?php if ($loggedIn): ?>
            <hr style="border:0;border-top:1px solid var(--border);margin:24px 0;">
            <h4 class="mb-2">Leave a review</h4>
            <form method="post" action="<?= base_url('user/feedback/submit') ?>">
              <?= csrf_field() ?>
              <input type="hidden" name="service_id" value="<?= (int) $service['id'] ?>">
              <div class="star-input mb-2">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                  <input type="radio" name="rating" id="r<?= $i ?>" value="<?= $i ?>" <?= $i === 5 ? 'checked' : '' ?>>
                  <label for="r<?= $i ?>"><i class="fa-solid fa-star"></i></label>
                <?php endfor; ?>
              </div>
              <div class="form-group">
                <textarea class="form-textarea" name="comment" rows="3" placeholder="Share your experience with this service..." maxlength="1000"></textarea>
              </div>
              <button class="btn btn-primary" type="submit"><i class="fa-solid fa-paper-plane"></i> Submit Review</button>
            </form>
          <?php else: ?>
            <p style="color:var(--text-muted);margin-top:18px;font-size:0.9rem;"><a href="<?= base_url('login') ?>">Sign in</a> to leave a review.</p>
          <?php endif; ?>
        </div>
      </div>

      <aside>
        <div class="info-sidebar">
          <h4 style="margin-bottom:6px;">Service Details</h4>
          <p style="color:var(--text-muted);font-size:0.88rem;">Quick reference for this service.</p>
          <dl>
            <?php if (! empty($service['fee'])): ?><dt>Fee</dt><dd><?= esc($service['fee']) ?></dd><?php endif; ?>
            <?php if (! empty($service['processing_time'])): ?><dt>Processing</dt><dd><?= esc($service['processing_time']) ?></dd><?php endif; ?>
            <?php if (! empty($service['office'])): ?><dt>Office</dt><dd><?= esc($service['office']) ?></dd><?php endif; ?>
            <?php if (! empty($service['contact'])): ?><dt>Contact</dt><dd><?= esc($service['contact']) ?></dd><?php endif; ?>
            <?php if (! empty($service['website'])): ?><dt>Website</dt><dd><a href="https://<?= esc(preg_replace('#^https?://#', '', $service['website'])) ?>" target="_blank" rel="noopener"><?= esc($service['website']) ?></a></dd><?php endif; ?>
            <dt>Coverage</dt>
            <dd>
              <?php if ((int) $service['is_nationwide'] === 1): ?>
                <span class="badge" style="background:var(--green-dim);color:var(--green);border:1px solid rgba(34,197,94,0.3);">Nationwide</span>
              <?php elseif (! empty($service['region_name'])): ?>
                <?= esc($service['region_name']) ?>
              <?php endif; ?>
            </dd>
          </dl>
          <hr style="border:0;border-top:1px solid var(--border);margin:18px 0;">
          <a class="btn btn-primary btn-block" href="<?= base_url('reports') ?>"><i class="fa-solid fa-flag"></i> Report an Issue</a>
        </div>
      </aside>
    </div>

    <?php if (! empty($related)): ?>
      <h3 class="mt-4 mb-3">Related services</h3>
      <div class="svc-grid">
        <?php foreach ($related as $r): ?>
          <a class="svc-card float-card" href="<?= base_url('services/' . $r['slug']) ?>">
            <div class="svc-icon"><i class="fa-solid <?= esc($r['icon'] ?: 'fa-cog') ?>"></i></div>
            <span class="tag"><?= esc($r['category']) ?></span>
            <h3><?= esc($r['name']) ?></h3>
            <p><?= esc(character_limiter($r['short_desc'] ?? '', 110)) ?></p>
            <div class="meta">
              <span class="agency"><?= esc($r['agency'] ?: 'Gov.PH') ?></span>
              <?php if ((int) $r['is_nationwide'] === 1): ?><span class="nationwide">Nationwide</span><?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
