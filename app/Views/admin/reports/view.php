<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Report <span style="color:var(--gold);"><?= esc($report['reference']) ?></span></h1><p style="color:var(--text-muted);font-size:0.92rem;"><?= esc(date('F j, Y g:i A', strtotime($report['created_at']))) ?></p></div>
  <a class="btn btn-ghost" href="<?= base_url('admin/reports') ?>"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<div class="grid grid-2">
  <div class="glass-card" style="padding:32px;">
    <h3 class="mb-2">Citizen Information</h3>
    <dl style="display:grid;grid-template-columns:auto 1fr;gap:10px 16px;">
      <dt style="color:var(--text-muted);">Name</dt><dd><?= esc($report['full_name']) ?></dd>
      <dt style="color:var(--text-muted);">Email</dt><dd><?= esc($report['email']) ?></dd>
      <dt style="color:var(--text-muted);">Phone</dt><dd><?= esc($report['phone'] ?? '—') ?></dd>
      <dt style="color:var(--text-muted);">Region</dt><dd><?= esc($report['region_name'] ?? '—') ?></dd>
    </dl>

    <hr style="border:0;border-top:1px solid var(--border);margin:18px 0;">

    <h3 class="mb-2">Issue Details</h3>
    <p style="color:var(--text-muted);font-size:0.85rem;">Category</p>
    <p style="margin-bottom:12px;"><?= esc($report['category']) ?></p>
    <p style="color:var(--text-muted);font-size:0.85rem;">Location</p>
    <p style="margin-bottom:12px;"><?= esc($report['location']) ?></p>
    <p style="color:var(--text-muted);font-size:0.85rem;">Description</p>
    <p style="color:var(--text-secondary);"><?= nl2br(esc($report['description'])) ?></p>

    <?php if (! empty($report['image'])): ?>
      <img src="<?= base_url('uploads/reports/' . $report['image']) ?>" alt="Report photo" style="margin-top:14px;width:100%;border-radius:var(--radius-md);">
    <?php endif; ?>

    <?php if (! empty($report['latitude']) && ! empty($report['longitude'])): ?>
      <div id="report-map-view" style="margin-top:18px;height:280px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--glass-border);"></div>
      <script>
      (function(){
        if (typeof L === "undefined") return;
        var lat = <?= json_encode((float) $report['latitude']) ?>;
        var lng = <?= json_encode((float) $report['longitude']) ?>;
        var map = L.map("report-map-view").setView([lat, lng], 15);
        L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png", { maxZoom: 18, attribution: "&copy; CARTO" }).addTo(map);
        L.circleMarker([lat, lng], { radius: 10, color: "#EF4444", fillColor: "#FCD116", fillOpacity: 0.9, weight: 3 }).addTo(map);
      })();
      </script>
    <?php endif; ?>
  </div>

  <div class="glass-card" style="padding:32px;">
    <h3 class="mb-2">Status & Notes</h3>
    <form method="post" action="<?= base_url('admin/reports/update-status/' . $report['id']) ?>">
      <?= csrf_field() ?>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" required>
          <?php foreach (['pending', 'reviewing', 'in_progress', 'resolved', 'rejected'] as $st): ?>
            <option value="<?= $st ?>" <?= $report['status'] === $st ? 'selected' : '' ?>><?= esc(ucfirst(str_replace('_', ' ', $st))) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Priority</label>
        <select class="form-select" name="priority">
          <?php foreach (['low', 'medium', 'high', 'urgent'] as $p): ?>
            <option value="<?= $p ?>" <?= $report['priority'] === $p ? 'selected' : '' ?>><?= esc(ucfirst($p)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Assigned To</label>
        <input class="form-control" type="text" name="assigned_to" value="<?= esc($report['assigned_to']) ?>" placeholder="Officer or department">
      </div>
      <div class="form-group">
        <label class="form-label">Admin Notes</label>
        <textarea class="form-textarea" name="admin_notes" rows="5" placeholder="Notes visible to the citizen..."><?= esc($report['admin_notes']) ?></textarea>
      </div>
      <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-save"></i> Update Report</button>
    </form>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
