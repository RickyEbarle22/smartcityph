<?php
ob_start();
$errs = session()->getFlashdata('errors') ?? [];
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Contact</span>
    <h1>Get in <span class="gradient-text">touch</span></h1>
    <p class="lead">Questions, feedback, or partnership inquiries — we'd love to hear from you.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="detail-grid">
      <div class="glass-card" style="padding:36px;">
        <h3 class="mb-2">Send us a message</h3>
        <p style="color:var(--text-secondary);font-size:0.92rem;margin-bottom:24px;">We respond within 1-2 business days.</p>
        <?php if (! empty($errs)): ?><div class="form-error"><?php foreach ($errs as $e) echo '<div>' . esc($e) . '</div>'; ?></div><?php endif; ?>
        <form method="post" action="<?= base_url('contact/submit') ?>">
          <?= csrf_field() ?>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="c-name">Your Name</label>
              <input class="form-control" type="text" name="name" id="c-name" value="<?= esc(old('name')) ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="c-email">Email</label>
              <input class="form-control" type="email" name="email" id="c-email" value="<?= esc(old('email')) ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="c-subject">Subject</label>
            <input class="form-control" type="text" name="subject" id="c-subject" value="<?= esc(old('subject')) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="c-msg">Message</label>
            <textarea class="form-textarea" name="message" id="c-msg" rows="6" required><?= esc(old('message')) ?></textarea>
          </div>
          <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
        </form>
      </div>
      <aside>
        <div class="glass-card" style="padding:28px;margin-bottom:18px;">
          <h4 class="mb-2"><i class="fa-solid fa-location-dot" style="color:var(--gold);"></i> Office Address</h4>
          <p style="color:var(--text-secondary);">New Executive Building, Malacañang Compound, J.P. Laurel St., San Miguel, Manila 1005, Philippines</p>
        </div>
        <div class="glass-card" style="padding:28px;margin-bottom:18px;">
          <h4 class="mb-2"><i class="fa-solid fa-phone" style="color:var(--gold);"></i> Phone</h4>
          <p style="color:var(--text-secondary);">+63 (2) 8736-1010</p>
          <p style="color:var(--text-muted);font-size:0.85rem;">Mon–Fri · 8:00 AM – 5:00 PM PHT</p>
        </div>
        <div class="glass-card" style="padding:28px;">
          <h4 class="mb-2"><i class="fa-solid fa-envelope" style="color:var(--gold);"></i> Email</h4>
          <p style="color:var(--text-secondary);">hello@smartcityph.gov.ph</p>
        </div>
      </aside>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
