<?php
$errs = session()->getFlashdata('errors') ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Admin Sign In — SmartCity PH') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>?v=1">
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>
<main id="main" style="display:grid;place-items:center;min-height:100vh;padding:40px 20px;">
  <div style="width:100%;max-width:440px;">
    <div style="text-align:center;margin-bottom:28px;">
      <a href="<?= base_url('/') ?>" class="navbar-brand" style="display:inline-flex;color:#fff;">
        <span class="logo-mark">PH</span>
        <span>SmartCity <span class="gradient-flag">PH</span></span>
      </a>
      <p style="color:var(--text-muted);font-size:0.85rem;margin-top:8px;">Administrator Portal</p>
    </div>
    <div class="auth-card">
      <h2><i class="fa-solid fa-shield-halved" style="color:var(--cyan);"></i> Sign in</h2>
      <p class="subtitle">Authorized personnel only.</p>
      <?php if (session()->getFlashdata('error')): ?><div class="form-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
      <?php if (! empty($errs)): ?><div class="form-error"><?php foreach ($errs as $e) echo '<div>' . esc($e) . '</div>'; ?></div><?php endif; ?>
      <form method="post" action="<?= base_url('admin-login/authenticate') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Username</label>
          <input class="form-control" type="text" name="username" value="<?= esc(old('username')) ?>" required autofocus>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
        <p style="text-align:center;margin-top:18px;font-size:0.85rem;"><a href="<?= base_url('/') ?>" style="color:var(--text-muted);">← Back to site</a></p>
      </form>
    </div>
    <p style="text-align:center;color:var(--text-muted);font-size:0.78rem;margin-top:18px;">Default credentials: admin / admin123</p>
  </div>
</main>
</body>
</html>
