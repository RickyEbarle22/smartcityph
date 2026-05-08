<?php
ob_start();
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">About Us</span>
    <h1>About <span class="gradient-flag">SmartCity PH</span></h1>
    <p class="lead">A unified digital gateway connecting Filipino citizens to government services across all 17 regions of the Philippines.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid-3">
      <div class="glass-card float-card" style="padding:30px;" data-aos="fade-up">
        <div style="width:60px;height:60px;border-radius:18px;background:linear-gradient(135deg,#2563EB,#06B6D4);display:grid;place-items:center;color:#fff;font-size:1.4rem;margin-bottom:18px;"><i class="fa-solid fa-bullseye"></i></div>
        <h3>Our Mission</h3>
        <p style="color:var(--text-secondary);">Make government services accessible, transparent, and efficient for every Filipino — regardless of region or background.</p>
      </div>
      <div class="glass-card float-card" style="padding:30px;" data-aos="fade-up" data-aos-delay="100">
        <div style="width:60px;height:60px;border-radius:18px;background:linear-gradient(135deg,#FCD116,#F59E0B);display:grid;place-items:center;color:#111;font-size:1.4rem;margin-bottom:18px;"><i class="fa-solid fa-eye"></i></div>
        <h3>Our Vision</h3>
        <p style="color:var(--text-secondary);">A digitally empowered Philippines where every citizen can reach their government in a single tap or click.</p>
      </div>
      <div class="glass-card float-card" style="padding:30px;" data-aos="fade-up" data-aos-delay="200">
        <div style="width:60px;height:60px;border-radius:18px;background:linear-gradient(135deg,#22C55E,#06B6D4);display:grid;place-items:center;color:#fff;font-size:1.4rem;margin-bottom:18px;"><i class="fa-solid fa-handshake"></i></div>
        <h3>Our Values</h3>
        <p style="color:var(--text-secondary);">Transparency, accessibility, accountability, and citizen empowerment — at the core of everything we build.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">By the Numbers</span>
      <h2>Public service at scale</h2>
      <p>The Philippines is a vast archipelago — these are the numbers we serve.</p>
    </div>
    <div class="grid grid-4">
      <div class="glass-card text-center" style="padding:32px 20px;"><div class="num" style="font-family:var(--font-head);font-weight:800;font-size:2.4rem;color:var(--gold);"><span data-count="17">0</span></div><div class="lbl" style="color:var(--text-muted);font-size:0.85rem;letter-spacing:0.08em;text-transform:uppercase;">Regions</div></div>
      <div class="glass-card text-center" style="padding:32px 20px;"><div class="num" style="font-family:var(--font-head);font-weight:800;font-size:2.4rem;color:var(--cyan);"><span data-count="81">0</span></div><div class="lbl" style="color:var(--text-muted);font-size:0.85rem;letter-spacing:0.08em;text-transform:uppercase;">Provinces</div></div>
      <div class="glass-card text-center" style="padding:32px 20px;"><div class="num" style="font-family:var(--font-head);font-weight:800;font-size:2.4rem;color:var(--primary-light);"><span data-count="146">0</span></div><div class="lbl" style="color:var(--text-muted);font-size:0.85rem;letter-spacing:0.08em;text-transform:uppercase;">Cities</div></div>
      <div class="glass-card text-center" style="padding:32px 20px;"><div class="num" style="font-family:var(--font-head);font-weight:800;font-size:2.4rem;color:var(--green);"><span data-count="1488">0</span></div><div class="lbl" style="color:var(--text-muted);font-size:0.85rem;letter-spacing:0.08em;text-transform:uppercase;">Municipalities</div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="glass-card" style="padding:40px;">
      <span class="kicker">The Developer</span>
      <h2 class="mb-2">Built with pride by a Filipino student</h2>
      <p style="color:var(--text-secondary);font-size:1rem;max-width:680px;">SmartCity PH is the capstone vision of <strong style="color:var(--gold);">Ricky G. Ebarle</strong> — a 3rd-year BSIT student at CPSC. Built with CodeIgniter 4, Three.js, GSAP, and a deep belief that Filipino citizens deserve world-class digital government services.</p>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
