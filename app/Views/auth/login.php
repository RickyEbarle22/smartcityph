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
      <h2>Welcome back, <span class="gradient-flag">Kababayan</span>.</h2>
      <p style="color:var(--text-secondary);margin-top:14px;">Sign in to file reports, track your requests, and rate the government services you use.</p>
      <div class="grid grid-2 mt-4" style="gap:14px;">
        <div class="glass-card" style="padding:18px;text-align:center;"><div style="font-family:var(--font-head);font-weight:800;font-size:1.6rem;color:var(--gold);">17</div><div style="color:var(--text-muted);font-size:0.78rem;letter-spacing:0.08em;text-transform:uppercase;">Regions</div></div>
        <div class="glass-card" style="padding:18px;text-align:center;"><div style="font-family:var(--font-head);font-weight:800;font-size:1.6rem;color:var(--cyan);">50+</div><div style="color:var(--text-muted);font-size:0.78rem;letter-spacing:0.08em;text-transform:uppercase;">Services</div></div>
      </div>
    </div>
  </aside>
  <section class="auth-form-wrap">
    <div class="auth-card">
      <h2>Sign in</h2>
      <p class="subtitle">Enter your credentials to access your dashboard.</p>
      <?php if (! empty($errs)): ?><div class="form-error"><?php foreach ($errs as $e) echo '<div>' . esc($e) . '</div>'; ?></div><?php endif; ?>
      <form method="post" action="<?= base_url('login/authenticate') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input class="form-control" type="email" name="email" id="email" value="<?= esc(old('email')) ?>" required autocomplete="email">
        </div>
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" name="password" id="password" required autocomplete="current-password">
        </div>
        <div class="checkbox-row mb-3">
          <input type="checkbox" id="remember" name="remember" value="1">
          <label for="remember" style="color:var(--text-secondary);font-size:0.9rem;">Keep me signed in</label>
        </div>
        <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
        <div class="divider">or</div>
        <a class="btn btn-ghost btn-block" href="<?= base_url('register') ?>"><i class="fa-solid fa-user-plus"></i> Create an Account</a>
        <p style="text-align:center;margin-top:20px;font-size:0.85rem;">
          <a href="<?= base_url('admin-login') ?>" style="color:var(--text-muted);">Admin Portal &rarr;</a>
        </p>
      </form>
    </div>
  </section>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
