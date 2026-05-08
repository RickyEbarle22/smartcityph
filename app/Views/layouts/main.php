<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#020617">
<title><?= esc($title ?? 'SmartCity PH — Government Services Portal') ?></title>
<meta name="description" content="SmartCity PH — your digital gateway to Philippine government services across all 17 regions.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>?v=3">
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>

<?php $session = session(); $loggedIn = (bool) $session->get('user_logged_in'); ?>
<?php $current = strtolower(trim(uri_string() ?: '/')); ?>

<nav class="navbar" aria-label="Primary">
  <a href="<?= base_url('/') ?>" class="navbar-brand">
    <span class="logo-mark">PH</span>
    <span>SmartCity <span class="gradient-flag">PH</span></span>
  </a>
  <ul class="navbar-menu">
    <li><a href="<?= base_url('/') ?>" class="<?= $current === '/' || $current === '' ? 'active' : '' ?>">Home</a></li>
    <li><a href="<?= base_url('services') ?>" class="<?= str_starts_with($current, 'services') ? 'active' : '' ?>">Services</a></li>
    <li><a href="<?= base_url('news') ?>" class="<?= str_starts_with($current, 'news') ? 'active' : '' ?>">News</a></li>
    <li><a href="<?= base_url('reports') ?>" class="<?= $current === 'reports' ? 'active' : '' ?>">Report</a></li>
    <li><a href="<?= base_url('community-reports') ?>" class="<?= str_starts_with($current, 'community-reports') ? 'active' : '' ?>">Community</a></li>
    <li><a href="<?= base_url('transparency') ?>" class="<?= str_starts_with($current, 'transparency') ? 'active' : '' ?>">Transparency</a></li>
    <li><a href="<?= base_url('emergency') ?>" class="<?= str_starts_with($current, 'emergency') ? 'active' : '' ?>">Emergency</a></li>
    <li><a href="<?= base_url('about') ?>" class="<?= str_starts_with($current, 'about') ? 'active' : '' ?>">About</a></li>
  </ul>
  <div class="navbar-actions">
    <?php if ($loggedIn): ?>
      <a class="btn btn-ghost btn-sm" href="<?= base_url('user/dashboard') ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
      <a class="btn btn-outline btn-sm" href="<?= base_url('logout') ?>">Sign Out</a>
    <?php else: ?>
      <a class="btn btn-ghost btn-sm" href="<?= base_url('login') ?>">Sign In</a>
      <a class="btn btn-primary btn-sm" href="<?= base_url('register') ?>">Get Started</a>
    <?php endif; ?>
  </div>
  <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
</nav>

<div class="mobile-menu" role="navigation" aria-label="Mobile">
  <a href="<?= base_url('/') ?>">Home</a>
  <a href="<?= base_url('services') ?>">Services</a>
  <a href="<?= base_url('news') ?>">News</a>
  <a href="<?= base_url('reports') ?>">Report an Issue</a>
  <a href="<?= base_url('community-reports') ?>">Community Reports</a>
  <a href="<?= base_url('track') ?>">Track Report</a>
  <a href="<?= base_url('transparency') ?>">Transparency</a>
  <a href="<?= base_url('emergency') ?>">Emergency</a>
  <a href="<?= base_url('about') ?>">About</a>
  <a href="<?= base_url('contact') ?>">Contact</a>
  <hr style="border:0;border-top:1px solid var(--border);margin:10px 0;">
  <?php if ($loggedIn): ?>
    <a href="<?= base_url('user/dashboard') ?>"><i class="fa-solid fa-gauge"></i> My Dashboard</a>
    <a href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
  <?php else: ?>
    <a href="<?= base_url('login') ?>"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
    <a href="<?= base_url('register') ?>"><i class="fa-solid fa-user-plus"></i> Create Account</a>
  <?php endif; ?>
</div>

<main id="main">
<?php if (session()->getFlashdata('success')): ?>
  <div class="container" style="padding-top:120px;">
    <div class="form-success flash-dismiss"><i class="fa-solid fa-circle-check"></i> <?= esc(session()->getFlashdata('success')) ?></div>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="container" style="padding-top:120px;">
    <div class="form-error flash-dismiss"><i class="fa-solid fa-triangle-exclamation"></i> <?= esc(session()->getFlashdata('error')) ?></div>
  </div>
<?php endif; ?>

<?= $content ?? '' ?>
</main>

<footer class="footer">
  <div class="container">
    <div class="footer-inner">
      <div class="footer-grid">
        <div>
          <a href="<?= base_url('/') ?>" class="navbar-brand mb-2" style="display:inline-flex;">
            <span class="logo-mark">PH</span>
            <span>SmartCity <span class="gradient-flag">PH</span></span>
          </a>
          <p style="color:var(--text-secondary);font-size:0.92rem;max-width:300px;margin-bottom:18px;">
            Your digital gateway to government services across all 17 regions of the Philippines.
          </p>
          <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>
        <div>
          <h5>Quick Links</h5>
          <ul>
            <li><a href="<?= base_url('services') ?>">All Services</a></li>
            <li><a href="<?= base_url('news') ?>">News</a></li>
            <li><a href="<?= base_url('reports') ?>">Report an Issue</a></li>
            <li><a href="<?= base_url('community-reports') ?>">Community Reports</a></li>
            <li><a href="<?= base_url('track') ?>">Track Report</a></li>
            <li><a href="<?= base_url('transparency') ?>">Transparency</a></li>
          </ul>
        </div>
        <div>
          <h5>Government</h5>
          <ul>
            <li><a href="<?= base_url('about') ?>">About SmartCity PH</a></li>
            <li><a href="<?= base_url('emergency') ?>">Emergency Hotlines</a></li>
            <li><a href="<?= base_url('contact') ?>">Contact</a></li>
            <li><a href="https://gov.ph" target="_blank" rel="noopener">Republic of the Philippines</a></li>
          </ul>
        </div>
        <div>
          <h5>Contact</h5>
          <ul>
            <li><i class="fa-solid fa-location-dot" style="color:var(--gold);"></i> &nbsp; New Executive Building, Manila</li>
            <li><i class="fa-solid fa-phone" style="color:var(--gold);"></i> &nbsp; +63 (2) 8736-1010</li>
            <li><i class="fa-solid fa-envelope" style="color:var(--gold);"></i> &nbsp; hello@smartcityph.gov.ph</li>
            <li><a href="<?= base_url('admin-login') ?>" style="font-size:0.82rem;color:var(--text-muted);">Admin Portal &rarr;</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© <?= date('Y') ?> SmartCity PH — Republic of the Philippines. All Rights Reserved.</span>
        <span style="display:flex;gap:14px;align-items:center;">
          <a href="#" style="color:var(--text-muted);">English</a>
          <span style="color:var(--text-muted);">|</span>
          <a href="#" style="color:var(--text-muted);">Filipino</a>
        </span>
      </div>
    </div>
  </div>
</footer>

<script>window.SCPH_BASE = '<?= rtrim(base_url(), '/') ?>';</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="<?= base_url('js/main.js') ?>?v=3"></script>
<script src="<?= base_url('js/search.js') ?>?v=3"></script>
<?php if (! empty($with_hero3d)): ?>
  <script src="<?= base_url('js/hero3d.js') ?>?v=3"></script>
<?php endif; ?>
<script src="<?= base_url('js/animations.js') ?>?v=3"></script>
<script>if (window.AOS) AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });</script>
<?= $extraJs ?? '' ?>
</body>
</html>
