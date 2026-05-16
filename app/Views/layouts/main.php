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
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>?v=4">
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
    <li><a href="<?= base_url('/') ?>" class="<?= $current === '/' || $current === '' ? 'active' : '' ?>" data-i18n-en="Home" data-i18n-fil="Tahanan">Home</a></li>
    <li><a href="<?= base_url('services') ?>" class="<?= str_starts_with($current, 'services') ? 'active' : '' ?>" data-i18n-en="Services" data-i18n-fil="Serbisyo">Services</a></li>
    <li><a href="<?= base_url('news') ?>" class="<?= str_starts_with($current, 'news') ? 'active' : '' ?>" data-i18n-en="News" data-i18n-fil="Balita">News</a></li>
    <li><a href="<?= base_url('agencies') ?>" class="<?= str_starts_with($current, 'agencies') ? 'active' : '' ?>" data-i18n-en="Agencies" data-i18n-fil="Ahensiya">Agencies</a></li>
    <li><a href="<?= base_url('reports') ?>" class="<?= $current === 'reports' ? 'active' : '' ?>" data-i18n-en="Report" data-i18n-fil="Mag-Ulat">Report</a></li>
    <li><a href="<?= base_url('transparency') ?>" class="<?= str_starts_with($current, 'transparency') ? 'active' : '' ?>" data-i18n-en="Transparency" data-i18n-fil="Transparensya">Transparency</a></li>
    <li><a href="<?= base_url('emergency') ?>" class="<?= str_starts_with($current, 'emergency') ? 'active' : '' ?>" data-i18n-en="Emergency" data-i18n-fil="Emergency">Emergency</a></li>
    <li><a href="<?= base_url('faqs') ?>" class="<?= str_starts_with($current, 'faqs') ? 'active' : '' ?>" data-i18n-en="FAQ" data-i18n-fil="Mga Tanong">FAQ</a></li>
  </ul>
  <div class="navbar-actions">
    <button type="button" class="lang-toggle" id="langToggle" aria-label="Toggle language" title="Switch language">
      <i class="fa-solid fa-globe"></i>
      <span class="lang-current">EN</span>
    </button>
    <?php if ($loggedIn): ?>
      <a class="btn btn-ghost btn-sm" href="<?= base_url('user/dashboard') ?>"><i class="fa-solid fa-gauge"></i> <span data-i18n-en="Dashboard" data-i18n-fil="Dashboard">Dashboard</span></a>
      <a class="btn btn-outline btn-sm" href="<?= base_url('logout') ?>" data-i18n-en="Sign Out" data-i18n-fil="Mag-Sign Out">Sign Out</a>
    <?php else: ?>
      <a class="btn btn-ghost btn-sm" href="<?= base_url('login') ?>" data-i18n-en="Sign In" data-i18n-fil="Mag-Sign In">Sign In</a>
      <a class="btn btn-primary btn-sm" href="<?= base_url('register') ?>" data-i18n-en="Get Started" data-i18n-fil="Magsimula">Get Started</a>
    <?php endif; ?>
  </div>
  <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
</nav>

<div class="mobile-menu" role="navigation" aria-label="Mobile">
  <a href="<?= base_url('/') ?>">Home</a>
  <a href="<?= base_url('services') ?>">Services</a>
  <a href="<?= base_url('news') ?>">News</a>
  <a href="<?= base_url('agencies') ?>">Agencies</a>
  <a href="<?= base_url('reports') ?>">Report an Issue</a>
  <a href="<?= base_url('community-reports') ?>">Community Reports</a>
  <a href="<?= base_url('track') ?>">Track Report</a>
  <a href="<?= base_url('transparency') ?>">Transparency</a>
  <a href="<?= base_url('foi') ?>">FOI Request</a>
  <a href="<?= base_url('faqs') ?>">FAQ</a>
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
            <li><a href="<?= base_url('agencies') ?>">Agency Directory</a></li>
            <li><a href="<?= base_url('foi') ?>">FOI Request</a></li>
            <li><a href="<?= base_url('faqs') ?>">FAQs</a></li>
            <li><a href="<?= base_url('emergency') ?>">Emergency Hotlines</a></li>
            <li><a href="<?= base_url('about') ?>">About SmartCity PH</a></li>
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
          <button type="button" class="lang-link" data-set-lang="en">English</button>
          <span style="color:var(--text-muted);">|</span>
          <button type="button" class="lang-link" data-set-lang="fil">Filipino</button>
        </span>
      </div>
    </div>
  </div>
</footer>

<div class="cookie-banner" id="cookieBanner" role="dialog" aria-live="polite" aria-label="Cookie consent">
  <div class="cookie-banner-inner">
    <div class="cookie-text">
      <i class="fa-solid fa-cookie-bite" style="color:var(--gold);"></i>
      <span><strong>We use cookies</strong> to keep you signed in and remember your preferences. By continuing, you agree to our use of cookies in accordance with the <a href="<?= base_url('about') ?>" style="color:var(--cyan);">Data Privacy Act of 2012 (RA 10173)</a>.</span>
    </div>
    <div class="cookie-actions">
      <button type="button" class="btn btn-ghost btn-sm" id="cookieDecline">Decline</button>
      <button type="button" class="btn btn-primary btn-sm" id="cookieAccept">Accept</button>
    </div>
  </div>
</div>

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
<script src="<?= base_url('js/live-updates.js') ?>?v=1" defer></script>
<script>if (window.AOS) AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });</script>
<script>
(function(){
  // ── Language toggle (EN / FIL) ─────────────────────────
  var KEY = 'scph_lang';
  function apply(lang){
    document.documentElement.setAttribute('lang', lang === 'fil' ? 'fil' : 'en');
    document.querySelectorAll('[data-i18n-en]').forEach(function(el){
      var txt = lang === 'fil' ? el.getAttribute('data-i18n-fil') : el.getAttribute('data-i18n-en');
      if (txt) el.textContent = txt;
    });
    var label = document.querySelector('#langToggle .lang-current');
    if (label) label.textContent = lang === 'fil' ? 'FIL' : 'EN';
  }
  function set(lang){ try { localStorage.setItem(KEY, lang); } catch(e){} apply(lang); }
  var saved = 'en';
  try { saved = localStorage.getItem(KEY) || 'en'; } catch(e){}
  apply(saved);
  var btn = document.getElementById('langToggle');
  if (btn) btn.addEventListener('click', function(){
    var current = (function(){ try { return localStorage.getItem(KEY) || 'en'; } catch(e){ return 'en'; } })();
    set(current === 'fil' ? 'en' : 'fil');
  });
  document.querySelectorAll('[data-set-lang]').forEach(function(el){
    el.addEventListener('click', function(){ set(el.getAttribute('data-set-lang')); });
  });

  // ── Cookie consent banner ──────────────────────────────
  var COOKIE = 'scph_cookie_consent';
  var banner = document.getElementById('cookieBanner');
  if (!banner) return;
  var seen = null;
  try { seen = localStorage.getItem(COOKIE); } catch(e){}
  if (!seen) {
    setTimeout(function(){ banner.classList.add('is-visible'); }, 600);
  }
  function dismiss(value){
    try { localStorage.setItem(COOKIE, value); } catch(e){}
    banner.classList.remove('is-visible');
  }
  var ok = document.getElementById('cookieAccept');
  var no = document.getElementById('cookieDecline');
  if (ok) ok.addEventListener('click', function(){ dismiss('accepted'); });
  if (no) no.addEventListener('click', function(){ dismiss('declined'); });
})();
</script>
<?= $extraJs ?? '' ?>
</body>
</html>
