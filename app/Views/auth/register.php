<?php
ob_start();
$errs = session()->getFlashdata('errors') ?? [];
?>
<div class="auth-split">
  <aside class="auth-brand" aria-hidden="true">
    <div class="auth-brand-inner">
      <a href="<?= base_url('/') ?>" class="navbar-brand mb-3" style="display:inline-flex;color:#fff;">
        <span class="logo-mark">PH</span>
        <span style="color:#fff;">SmartCity <span class="gradient-flag">PH</span></span>
      </a>
      <h2>Join <span class="gradient-flag">SmartCity PH</span>.</h2>
      <p style="color:var(--text-secondary);margin-top:14px;">Be among the first Filipinos to access government services through a single, beautiful digital portal.</p>
      <ul style="list-style:none;margin-top:24px;color:var(--text-secondary);">
        <li style="margin-bottom:10px;"><i class="fa-solid fa-circle-check" style="color:var(--green);margin-right:10px;"></i> Free forever — no hidden fees</li>
        <li style="margin-bottom:10px;"><i class="fa-solid fa-circle-check" style="color:var(--green);margin-right:10px;"></i> Track reports in real-time</li>
        <li style="margin-bottom:10px;"><i class="fa-solid fa-circle-check" style="color:var(--green);margin-right:10px;"></i> Rate and review services</li>
        <li><i class="fa-solid fa-circle-check" style="color:var(--green);margin-right:10px;"></i> Available 24/7 across all 17 regions</li>
      </ul>
    </div>
  </aside>
  <section class="auth-form-wrap">
    <div class="auth-card">
      <h2>Create your account</h2>
      <p class="subtitle">Quick, free, and only takes a minute.</p>
      <?php if (! empty($errs)): ?><div class="form-error"><?php foreach ($errs as $e) echo '<div>' . esc($e) . '</div>'; ?></div><?php endif; ?>
      <form method="post" action="<?= base_url('register/create') ?>">
        <?= csrf_field() ?>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="first_name">First Name</label>
            <input class="form-control" type="text" name="first_name" id="first_name" value="<?= esc(old('first_name')) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="last_name">Last Name</label>
            <input class="form-control" type="text" name="last_name" id="last_name" value="<?= esc(old('last_name')) ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="r-email">Email</label>
          <input class="form-control" type="email" name="email" id="r-email" value="<?= esc(old('email')) ?>" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="phone">Phone (optional)</label>
            <input class="form-control" type="text" name="phone" id="phone" value="<?= esc(old('phone')) ?>" placeholder="+639XXXXXXXXX">
          </div>
          <div class="form-group">
            <label class="form-label" for="region_id">Region (optional)</label>
            <select class="form-select" name="region_id" id="region_id">
              <option value="">— Select your region —</option>
              <?php foreach (($regions ?? []) as $r): ?>
                <option value="<?= (int) $r['id'] ?>" <?= (string) old('region_id') === (string) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" name="password" id="password" required minlength="6">
          <div class="pwd-bar"><div class="fill" id="pwd-bar-fill"></div></div>
          <p class="pwd-text" id="pwd-text">Use 8+ characters with letters, numbers, and symbols</p>
        </div>
        <div class="form-group">
          <label class="form-label" for="confirm_password">Confirm Password</label>
          <input class="form-control" type="password" name="confirm_password" id="confirm_password" required minlength="6">
        </div>
        <div class="checkbox-row mb-3">
          <input type="checkbox" id="terms" name="terms" value="1" required>
          <label for="terms" style="color:var(--text-secondary);font-size:0.85rem;">I agree to the <a href="<?= base_url('about') ?>">Terms of Service</a> and <a href="<?= base_url('about') ?>">Privacy Policy</a>.</label>
        </div>
        <button class="btn btn-success btn-block" type="submit"><i class="fa-solid fa-user-plus"></i> Create Account</button>
        <p style="text-align:center;margin-top:20px;font-size:0.9rem;color:var(--text-muted);">
          Already have an account? <a href="<?= base_url('login') ?>">Sign in</a>
        </p>
      </form>
    </div>
  </section>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
