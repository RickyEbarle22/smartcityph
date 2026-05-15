<?php
$content = '';
ob_start();
?>
<!-- ── HERO ───────────────────────────────────────────── -->
<section class="hero">
  <div id="hero3d" class="hero-3d-container" aria-hidden="true"></div>
  <div class="container">
    <div class="hero-content">
      <span class="kicker"><i class="fa-solid fa-circle-check" style="margin-right:6px;"></i> Republic of the Philippines</span>
      <p class="typed" data-typewriter="Discover Government Services Across the Philippines|All 17 Regions, One Digital Hub|Faster, Smarter Public Services"></p>
      <h1>Welcome to <span class="gradient-flag">SmartCity PH</span></h1>
      <p class="hero-subtitle">Your digital gateway to <?= esc($totalServices) ?>+ government services across all 17 regions of the Philippines — discover, search, apply, and track in one beautiful place.</p>

      <div class="suggest-wrap" style="position:relative;">
        <form class="service-finder" action="<?= base_url('services/search') ?>" method="get" role="search" aria-label="Find a government service">
          <select id="finder-region" name="region" class="form-select" aria-label="Select region">
            <option value="">All Regions</option>
            <?php foreach (($regions ?? []) as $r): ?>
              <option value="<?= (int) $r['id'] ?>"><?= esc($r['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <input id="finder-q" name="q" type="text" class="form-control" placeholder="What service do you need? e.g. business permit, PhilHealth..." autocomplete="off">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        </form>
        <ul id="finder-suggest" class="suggest-list" role="listbox" aria-label="Suggestions"></ul>
      </div>

      <div class="hero-actions">
        <a class="btn btn-primary" href="<?= base_url('services') ?>"><i class="fa-solid fa-grip"></i> Browse All Services</a>
        <a class="btn btn-outline" href="<?= base_url('reports') ?>"><i class="fa-solid fa-flag"></i> Report an Issue</a>
      </div>

      <div class="hero-stats">
        <div class="stat"><div class="num"><span data-count="<?= (int) $totalRegions ?>">0</span></div><div class="lbl">Regions</div></div>
        <div class="stat"><div class="num"><span data-count="<?= (int) $totalServices ?>">0</span>+</div><div class="lbl">Services</div></div>
        <div class="stat"><div class="num"><span data-count="<?= (int) max(1000000, $totalCitizens * 1000) ?>">0</span>+</div><div class="lbl">Citizens</div></div>
        <div class="stat"><div class="num">24/7</div><div class="lbl">Access</div></div>
      </div>
    </div>
  </div>
</section>

<!-- ── CATEGORIES ────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Service Categories</span>
      <h2>Find services by what you need</h2>
      <p>Eight curated categories spanning health, business, civil registry, education, social welfare, and more.</p>
    </div>
    <div class="cat-strip">
      <?php
        $cats = [
          ['Health',          'health',     'fa-heartbeat',       'Health & Wellness'],
          ['Business',        'business',   'fa-briefcase',       'Business & Permits'],
          ['Civil Registry',  'civil',      'fa-id-card',         'Birth · Marriage · Death'],
          ['Education',       'education',  'fa-graduation-cap',  'Schools & Scholarships'],
          ['Social Welfare',  'welfare',    'fa-hand-holding-heart',  '4Ps · PWD · Senior'],
          ['Transportation',  'transport',  'fa-car',             'LTO Licenses & Registration'],
          ['Housing',         'housing',    'fa-house',           'NHA · Pag-IBIG'],
          ['Agriculture',     'agri',       'fa-seedling',        'DA · RSBSA · Farmers'],
        ];
        foreach ($cats as $c):
          $count = (int) ($categoryCounts[$c[0]] ?? 0);
      ?>
      <a class="cat-card <?= $c[1] ?>" href="<?= base_url('services?category=' . urlencode($c[0])) ?>">
        <div class="cat-ico"><i class="fa-solid <?= $c[2] ?>"></i></div>
        <h4><?= esc($c[0]) ?></h4>
        <p><?= esc($c[3]) ?></p>
        <p style="margin-top:10px;color:var(--cyan);font-size:0.78rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;"><?= $count ?> service<?= $count !== 1 ? 's' : '' ?> →</p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── FEATURED SERVICES ────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Featured</span>
      <h2>Most-used government services</h2>
      <p>Hand-picked services that thousands of Filipinos access every day.</p>
    </div>
    <?php if (! empty($featuredServices)): ?>
      <div class="svc-grid">
        <?php foreach ($featuredServices as $s): ?>
          <a class="svc-card float-card" href="<?= base_url('services/' . $s['slug']) ?>" data-tilt>
            <?php if (! empty($s['is_popular'])): ?><span class="popular-badge"><i class="fa-solid fa-fire"></i> Popular</span><?php endif; ?>
            <div class="svc-icon"><i class="fa-solid <?= esc($s['icon'] ?: 'fa-cog') ?>"></i></div>
            <span class="tag"><?= esc($s['category']) ?></span>
            <h3><?= esc($s['name']) ?></h3>
            <p><?= esc($s['short_desc']) ?></p>
            <div class="meta">
              <span class="agency"><?= esc($s['agency'] ?: 'Government of the Philippines') ?></span>
              <?php if ((int) $s['is_nationwide'] === 1): ?>
                <span class="nationwide"><i class="fa-solid fa-globe"></i> Nationwide</span>
              <?php elseif (! empty($s['region_name'])): ?>
                <span style="color:var(--text-muted);"><?= esc($s['region_name']) ?></span>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-4">
        <a class="btn btn-outline" href="<?= base_url('services') ?>">View All Services <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    <?php else: ?>
      <div class="empty"><i class="fa-solid fa-folder-open"></i><h3>No featured services yet</h3><p>Featured services will appear here.</p></div>
    <?php endif; ?>
  </div>
</section>

<!-- ── LATEST SERVICES (newly added) ──────────────────────── -->
<?php if (! empty($latestServices)): ?>
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Recently Added</span>
      <h2>Latest services</h2>
      <p>Newly published government services — added by SmartCity PH administrators.</p>
    </div>
    <div class="svc-grid">
      <?php foreach ($latestServices as $s): ?>
        <a class="svc-card float-card" href="<?= base_url('services/' . $s['slug']) ?>">
          <?php if (! empty($s['is_popular'])): ?><span class="popular-badge"><i class="fa-solid fa-fire"></i> Popular</span><?php endif; ?>
          <div class="svc-icon"><i class="fa-solid <?= esc($s['icon'] ?: 'fa-cog') ?>"></i></div>
          <span class="tag"><?= esc($s['category']) ?></span>
          <h3><?= esc($s['name']) ?></h3>
          <p><?= esc(character_limiter($s['short_desc'] ?? '', 110)) ?></p>
          <div class="meta">
            <span class="agency"><?= esc($s['agency'] ?: 'Gov.PH') ?></span>
            <?php if ((int) $s['is_nationwide'] === 1): ?>
              <span class="nationwide"><i class="fa-solid fa-globe"></i> Nationwide</span>
            <?php elseif (! empty($s['region_name'])): ?>
              <span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($s['region_name']) ?></span>
            <?php endif; ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a class="btn btn-outline" href="<?= base_url('services') ?>">Browse all services <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── INTERACTIVE MAP ─────────────────────────────────── -->
<section class="section map-section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Explore by Region</span>
      <h2>Government services across the Philippines</h2>
      <p>Click a region marker to discover available services in your area.</p>
    </div>
    <div class="map-frame">
      <div class="map-overlay">
        <h4><i class="fa-solid fa-map"></i> Philippine Regions Map</h4>
        <p>Tap a region to view services available there.</p>
      </div>
      <div id="ph-map" style="height:100%;width:100%;"></div>
    </div>
  </div>
</section>

<!-- ── HOW IT WORKS ───────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">How It Works</span>
      <h2>Four simple steps</h2>
      <p>From discovery to resolution — government services made simple.</p>
    </div>
    <div class="steps">
      <div class="step-card">
        <div class="num">1</div>
        <i class="fa-solid fa-magnifying-glass ico"></i>
        <h4>Search</h4>
        <p>Find services by region, category, or keyword.</p>
      </div>
      <div class="step-card">
        <div class="num">2</div>
        <i class="fa-solid fa-clipboard-list ico"></i>
        <h4>Learn</h4>
        <p>View requirements, fees, and processing time.</p>
      </div>
      <div class="step-card">
        <div class="num">3</div>
        <i class="fa-solid fa-paper-plane ico"></i>
        <h4>Apply</h4>
        <p>Submit requests or report issues online.</p>
      </div>
      <div class="step-card">
        <div class="num">4</div>
        <i class="fa-solid fa-circle-check ico"></i>
        <h4>Track</h4>
        <p>Monitor your request status in real-time.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── LATEST NEWS ────────────────────────────────────── -->
<?php if (! empty($latestNews)): ?>
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">News</span>
      <h2>Latest government updates</h2>
      <p>Stay informed with announcements from across the Philippines.</p>
    </div>
    <div class="news-grid">
      <?php foreach ($latestNews as $n): ?>
        <a class="news-card" href="<?= base_url('news/' . $n['slug']) ?>">
          <div class="news-img"><?php if (! empty($n['image'])): ?><img src="<?= base_url('uploads/news/' . $n['image']) ?>" alt="<?= esc($n['title']) ?>"><?php endif; ?></div>
          <div class="news-body">
            <span class="tag" style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:0.72rem;font-weight:600;background:var(--gold-dim);color:var(--gold);border:1px solid var(--gold-border);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:10px;"><?= esc($n['category']) ?></span>
            <h3><?= esc($n['title']) ?></h3>
            <p><?= esc(character_limiter($n['excerpt'], 120)) ?></p>
            <div class="news-meta">
              <span><i class="fa-regular fa-calendar"></i> <?= esc(date('M j, Y', strtotime($n['published_at'] ?? $n['created_at']))) ?></span>
              <span><i class="fa-regular fa-eye"></i> <?= number_format((int) $n['views']) ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a class="btn btn-outline" href="<?= base_url('news') ?>">View All News <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── RECENT COMMUNITY REPORTS ──────────────────────────── -->
<?php if (! empty($recentReports)): ?>
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Civic Activity</span>
      <h2>Recent community reports</h2>
      <p>Anonymized snapshot of issues filed by your fellow Filipinos and how they're being handled.</p>
    </div>
    <div class="glass-card" style="padding:18px;overflow:hidden;">
      <table class="data" style="width:100%;border-collapse:collapse;">
        <thead><tr><th>Reference</th><th>Category</th><th>Location</th><th>Region</th><th>Status</th><th>Priority</th><th>Date</th></tr></thead>
        <tbody>
          <?php foreach ($recentReports as $r): ?>
            <tr>
              <td><span style="font-family:var(--font-head);font-weight:700;color:var(--gold);"><?= esc($r['reference']) ?></span></td>
              <td><?= esc($r['category']) ?></td>
              <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-secondary);"><?= esc(character_limiter($r['location'], 50)) ?></td>
              <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc($r['region_name'] ?? '—') ?></td>
              <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
              <td><span class="badge badge-<?= esc($r['priority']) ?>"><?= esc($r['priority']) ?></span></td>
              <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j', strtotime($r['created_at']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="text-center mt-4">
      <a class="btn btn-outline" href="<?= base_url('community-reports') ?>">View all community reports <i class="fa-solid fa-arrow-right"></i></a>
      <a class="btn btn-primary" href="<?= base_url('reports') ?>" style="margin-left:8px;"><i class="fa-solid fa-flag"></i> File a Report</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── TRANSPARENCY PREVIEW ──────────────────────────────── -->
<?php if (! empty($featuredProjects)): ?>
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="kicker">Transparency</span>
      <h2>Where your taxes go</h2>
      <p>Track flagship Philippine government projects and their progress.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($featuredProjects as $p): ?>
        <div class="proj-card">
          <span class="agency-tag"><?= esc($p['agency']) ?></span>
          <h3><?= esc($p['title']) ?></h3>
          <div class="budget">₱<?= number_format((float) $p['budget'], 0) ?></div>
          <div class="progress-bar"><div class="fill" data-progress="<?= (int) $p['progress'] ?>" style="width:<?= (int) $p['progress'] ?>%;"></div></div>
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span class="badge badge-<?= esc($p['status']) ?>"><?= esc($p['status']) ?></span>
            <span style="color:var(--text-muted);font-size:0.85rem;"><?= (int) $p['progress'] ?>% complete</span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a class="btn btn-outline" href="<?= base_url('transparency') ?>">View Transparency Dashboard <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── EMERGENCY ────────────────────────────────────────── -->
<section class="section-sm">
  <div class="emergency-banner">
    <div class="container" style="position:relative;z-index:2;">
      <h2><i class="fa-solid fa-triangle-exclamation"></i> In Case of Emergency</h2>
      <p class="lead">Save these numbers — help is one call away.</p>
      <div class="hotline-grid">
        <?php
          $hot = [
            ['fa-shield-halved', '911',  'NDRRMC / National Emergency', 'Disaster, Police, Fire, Medical'],
            ['fa-user-shield',   '117',  'Philippine National Police',  'Crime & public safety'],
            ['fa-fire',          '160',  'Bureau of Fire Protection',   'Fire emergencies'],
            ['fa-truck-medical', '143',  'Philippine Red Cross',        'Ambulance & first aid'],
            ['fa-briefcase',    '1555', 'DOLE Hotline',                'Labor and employment'],
            ['fa-bullhorn',     '8888', 'Citizen Complaint Hotline',   'Government complaints'],
          ];
          foreach ($hot as $h):
        ?>
          <div class="hotline-card">
            <div class="ico"><i class="fa-solid <?= $h[0] ?>"></i></div>
            <div>
              <div class="num"><?= $h[1] ?></div>
              <div class="nm"><?= $h[2] ?></div>
              <div class="desc"><?= $h[3] ?></div>
            </div>
            <a class="call" href="tel:<?= $h[1] ?>">Call</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ─────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="glass-card float-card" style="padding:60px;text-align:center;">
      <span class="kicker">Get Started</span>
      <h2>Ready to access government services?</h2>
      <p style="color:var(--text-secondary);font-size:1.05rem;max-width:560px;margin:14px auto 28px;">Create your free SmartCity PH account to file reports, leave feedback, and track your requests.</p>
      <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
        <a class="btn btn-primary" href="<?= base_url('register') ?>"><i class="fa-solid fa-user-plus"></i> Create Account</a>
        <a class="btn btn-outline" href="<?= base_url('login') ?>"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
$with_hero3d = true;

// Build region geojson-like data for the map
$mapData = [];
foreach (($regions ?? []) as $r) {
    if (! empty($r['latitude']) && ! empty($r['longitude'])) {
        $mapData[] = [
            'name' => $r['name'],
            'slug' => $r['slug'],
            'lat'  => (float) $r['latitude'],
            'lng'  => (float) $r['longitude'],
            'pop'  => (int) ($r['population'] ?? 0),
            'id'   => (int) $r['id'],
        ];
    }
}

$extraJs = '<script>
(function(){
  if (typeof L === "undefined") return;
  var el = document.getElementById("ph-map");
  if (!el) return;
  var map = L.map("ph-map", { zoomControl: true, scrollWheelZoom: false }).setView([12.8797, 121.7740], 6);
  L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution: "&copy; OpenStreetMap &copy; CARTO"
  }).addTo(map);
  var data = ' . json_encode($mapData) . ';
  var base = ' . json_encode(rtrim(base_url(), '/')) . ';
  data.forEach(function(r){
    var marker = L.circleMarker([r.lat, r.lng], {
      radius: 9,
      color: "#06B6D4",
      fillColor: "#FCD116",
      fillOpacity: 0.85,
      weight: 2,
    }).addTo(map);
    marker.bindPopup("<strong>" + r.name + "</strong><br><a href=\"" + base + "/services?region=" + r.id + "\" style=\"color:#06B6D4;\">View services &rarr;</a>");
  });
})();
</script>';

echo view('layouts/main', ['title' => $title ?? null, 'content' => $content, 'with_hero3d' => $with_hero3d, 'extraJs' => $extraJs]);
