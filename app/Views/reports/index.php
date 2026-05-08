<?php
ob_start();
$errs = session()->getFlashdata('errors') ?? [];
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker"><i class="fa-solid fa-flag"></i> Citizen Report</span>
    <h1>Report an <span class="gradient-flag">Issue</span></h1>
    <p class="lead">Help your community by reporting potholes, garbage, flooding, broken streetlights, and other concerns.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="detail-grid">
      <div class="glass-card" style="padding:36px;">
        <h3 class="mb-2">Submit a report</h3>
        <p style="color:var(--text-secondary);font-size:0.92rem;margin-bottom:24px;">All reports are reviewed by our admin team and forwarded to the relevant agency.</p>
        <?php if (! empty($errs)): ?><div class="form-error"><?php foreach ($errs as $e) echo '<div>' . esc($e) . '</div>'; ?></div><?php endif; ?>
        <form method="post" action="<?= base_url('reports/submit') ?>" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="full_name">Full Name *</label>
              <input class="form-control" type="text" name="full_name" id="full_name" value="<?= esc(old('full_name', $prefill['full_name'] ?? '')) ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="email">Email *</label>
              <input class="form-control" type="email" name="email" id="email" value="<?= esc(old('email', $prefill['email'] ?? '')) ?>" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="phone">Phone</label>
              <input class="form-control" type="text" name="phone" id="phone" value="<?= esc(old('phone', $prefill['phone'] ?? '')) ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="region_id">Region *</label>
              <select class="form-select" name="region_id" id="region_id" required>
                <option value="">— Select region —</option>
                <?php foreach (($regions ?? []) as $r): ?>
                  <option value="<?= (int) $r['id'] ?>" <?= (string) old('region_id') === (string) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="category">Category *</label>
              <select class="form-select" name="category" id="category" required>
                <?php foreach (['Road', 'Garbage', 'Flooding', 'Streetlight', 'Noise', 'Safety', 'Utilities', 'Other'] as $cat): ?>
                  <option value="<?= esc($cat) ?>" <?= old('category') === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" for="priority">Priority</label>
              <select class="form-select" name="priority" id="priority">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="location">Location / Address *</label>
            <input class="form-control" type="text" name="location" id="location" value="<?= esc(old('location')) ?>" required placeholder="Street, barangay, landmark">
          </div>
          <div class="form-group">
            <label class="form-label">Pin location on map (optional)</label>
            <div id="report-map" style="height:300px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--glass-border);"></div>
            <input type="hidden" name="latitude" id="lat">
            <input type="hidden" name="longitude" id="lng">
            <p class="form-help">Click on the map to mark the location of the issue.</p>
          </div>
          <div class="form-group">
            <label class="form-label" for="description">Description *</label>
            <textarea class="form-textarea" name="description" id="description" rows="5" required placeholder="Describe the issue in detail..."><?= esc(old('description')) ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="image">Photo (optional, max 2MB)</label>
            <input class="form-control" type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp">
          </div>
          <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-paper-plane"></i> Submit Report</button>
        </form>
      </div>

      <aside>
        <div class="glass-card" style="padding:28px;margin-bottom:18px;">
          <h4 class="mb-2"><i class="fa-solid fa-circle-info" style="color:var(--cyan);"></i> How it works</h4>
          <ol style="padding-left:20px;color:var(--text-secondary);font-size:0.9rem;">
            <li style="margin-bottom:8px;">Submit your report with as much detail as possible.</li>
            <li style="margin-bottom:8px;">Receive a unique reference code (RPT-XXXXXXXX).</li>
            <li style="margin-bottom:8px;">Our admin team reviews and forwards to the agency.</li>
            <li>Track progress via the reference code on the <a href="<?= base_url('track') ?>">Track Report</a> page.</li>
          </ol>
        </div>
        <div style="background:linear-gradient(135deg,#CE1126,#EF4444);border-radius:var(--radius);padding:24px;color:#fff;">
          <h4 style="margin-bottom:8px;"><i class="fa-solid fa-triangle-exclamation"></i> Emergency?</h4>
          <p style="color:rgba(255,255,255,0.9);font-size:0.9rem;margin-bottom:14px;">For life-threatening situations, do NOT submit a report — call <strong>911</strong> immediately.</p>
          <a class="btn btn-gold btn-sm" href="tel:911"><i class="fa-solid fa-phone"></i> Call 911</a>
        </div>
      </aside>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
$extraJs = '<script>
(function(){
  if (typeof L === "undefined") return;
  var el = document.getElementById("report-map");
  if (!el) return;
  var map = L.map("report-map").setView([12.8797, 121.7740], 6);
  L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png", { attribution: "&copy; CARTO", maxZoom: 18 }).addTo(map);
  var marker = null;
  map.on("click", function(e){
    if (marker) map.removeLayer(marker);
    marker = L.circleMarker(e.latlng, { radius: 9, color: "#EF4444", fillColor: "#FCD116", fillOpacity: 0.9, weight: 3 }).addTo(map);
    document.getElementById("lat").value = e.latlng.lat.toFixed(7);
    document.getElementById("lng").value = e.latlng.lng.toFixed(7);
  });
})();
</script>';
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content, 'extraJs' => $extraJs]);
