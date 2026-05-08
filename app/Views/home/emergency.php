<?php
ob_start();
$groups = [
    'National Emergency'  => [
        ['fa-shield-halved', '911',  'NDRRMC / National Emergency Hotline', 'Disaster, Police, Fire, Medical — single number for life-threatening emergencies.'],
    ],
    'Police & Safety'     => [
        ['fa-user-shield',   '117',  'Philippine National Police',  'Crime in progress, public safety, and law enforcement.'],
        ['fa-bullhorn',     '8888', 'Citizen Complaint Hotline',    'Government complaints and graft reports.'],
    ],
    'Fire & Rescue'       => [
        ['fa-fire',          '160',  'Bureau of Fire Protection',   'Fire emergencies and rescue operations.'],
        ['fa-truck-medical', '143',  'Philippine Red Cross',        'Ambulance, blood services, and first aid.'],
    ],
    'Health & Disaster'   => [
        ['fa-stethoscope',  '1555', 'DOH COVID-19 / Health Hotline','Health concerns and disease reporting.'],
        ['fa-cloud-bolt',   '8911-1406', 'NDRRMC Operations Center', 'Disaster response and updates.'],
    ],
    'Government Services' => [
        ['fa-briefcase',    '1555', 'DOLE Hotline',                 'Labor, employment, and OFW concerns.'],
        ['fa-passport',     '8737-1000', 'PSA Hotline',             'Civil registry and statistics.'],
    ],
];
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker"><i class="fa-solid fa-triangle-exclamation"></i> Emergency Directory</span>
    <h1>Emergency <span class="gradient-flag">Hotlines</span></h1>
    <p class="lead">Quick-access numbers for every Filipino citizen — save them, share them, use them when needed.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div style="background:linear-gradient(135deg,#CE1126,#EF4444);padding:24px 28px;border-radius:var(--radius);display:flex;align-items:center;gap:18px;">
      <i class="fa-solid fa-circle-exclamation" style="font-size:2rem;color:#fff;"></i>
      <div style="flex-grow:1;">
        <h3 style="color:#fff;margin:0;">Life-Threatening Emergency?</h3>
        <p style="color:rgba(255,255,255,0.9);margin:0;font-size:0.95rem;">Call <strong>911</strong> immediately — the official national emergency hotline of the Philippines.</p>
      </div>
      <a class="btn btn-gold" href="tel:911"><i class="fa-solid fa-phone"></i> Call 911</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($groups as $group => $items): ?>
      <h3 class="mb-3"><?= esc($group) ?></h3>
      <div class="grid grid-2 mb-4">
        <?php foreach ($items as $h): ?>
          <div class="glass-card float-card" style="padding:24px;display:flex;gap:18px;align-items:center;">
            <div style="width:60px;height:60px;border-radius:18px;background:linear-gradient(135deg,#CE1126,#EF4444);display:grid;place-items:center;color:#fff;font-size:1.4rem;flex-shrink:0;"><i class="fa-solid <?= $h[0] ?>"></i></div>
            <div style="flex-grow:1;">
              <div style="font-family:var(--font-head);font-weight:800;font-size:1.4rem;color:var(--gold);"><?= esc($h[1]) ?></div>
              <div style="color:var(--text-primary);font-weight:600;"><?= esc($h[2]) ?></div>
              <div style="color:var(--text-muted);font-size:0.85rem;"><?= esc($h[3]) ?></div>
            </div>
            <a class="btn btn-outline btn-sm" href="tel:<?= esc(preg_replace('/[^0-9+]/', '', $h[1])) ?>"><i class="fa-solid fa-phone"></i> Call</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
