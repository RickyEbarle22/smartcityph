<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Admin — SmartCity PH') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>?v=2">
</head>
<body>
<?php $current = strtolower(trim(uri_string() ?: '/')); ?>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <div class="brand">
      <span class="logo-mark">PH</span>
      <span style="font-family:var(--font-head);font-weight:800;font-size:1rem;">SmartCity <span class="gradient-flag">PH</span></span>
    </div>
    <nav>
      <a href="<?= base_url('admin') ?>" class="<?= $current === 'admin' || $current === 'admin/dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
      <div class="group-label">Content</div>
      <a href="<?= base_url('admin/services') ?>" class="<?= str_starts_with($current, 'admin/services') ? 'active' : '' ?>"><i class="fa-solid fa-list-check"></i> Services</a>
      <a href="<?= base_url('admin/news') ?>" class="<?= str_starts_with($current, 'admin/news') ? 'active' : '' ?>"><i class="fa-solid fa-newspaper"></i> News</a>
      <div class="group-label">Citizens</div>
      <a href="<?= base_url('admin/reports') ?>" class="<?= str_starts_with($current, 'admin/reports') ? 'active' : '' ?>"><i class="fa-solid fa-flag"></i> Reports</a>
      <a href="<?= base_url('admin/users') ?>" class="<?= str_starts_with($current, 'admin/users') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Users</a>
      <div class="group-label">System</div>
      <a href="<?= base_url('admin/regions') ?>" class="<?= str_starts_with($current, 'admin/regions') ? 'active' : '' ?>"><i class="fa-solid fa-map-location-dot"></i> Regions</a>
      <a href="<?= base_url('/') ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Site</a>
      <a href="<?= base_url('admin-logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </nav>
  </aside>
  <main class="admin-main">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="form-success flash-dismiss"><i class="fa-solid fa-circle-check"></i> <?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="form-error flash-dismiss"><i class="fa-solid fa-triangle-exclamation"></i> <?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?= $content ?? '' ?>
  </main>
</div>
<script src="<?= base_url('js/main.js') ?>?v=2"></script>
</body>
</html>
