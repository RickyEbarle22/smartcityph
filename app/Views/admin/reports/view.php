<?php
ob_start();
$statusOrder = ['pending', 'reviewing', 'in_progress', 'resolved'];
$activeIndex = $report['status'] === 'rejected' ? -1 : array_search($report['status'], $statusOrder, true);
$updatedAt   = $report['updated_at'] ?? $report['created_at'];
?>
<div class="admin-topbar">
  <div><h1>Report <span style="color:var(--gold);"><?= esc($report['reference']) ?></span></h1><p style="color:var(--text-muted);font-size:0.92rem;"><?= esc(date('F j, Y g:i A', strtotime($report['created_at']))) ?></p></div>
  <a class="btn btn-ghost" href="<?= base_url('admin/reports') ?>"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<?php if ($report['status'] === 'rejected'): ?>
  <div class="glass-card" style="padding:18px 22px;margin-bottom:18px;border-left:4px solid var(--red-light);background:var(--red-dim);">
    <strong style="color:var(--red-light);"><i class="fa-solid fa-circle-xmark"></i> Report rejected</strong>
    <span style="color:var(--text-muted);margin-left:8px;font-size:0.9rem;">This report is closed and excluded from the active pipeline.</span>
  </div>
<?php else: ?>
  <div class="timeline mb-4">
    <?php foreach ($statusOrder as $i => $st):
      $cls = '';
      if ($activeIndex !== false && $i < $activeIndex) $cls = 'done';
      elseif ($i === $activeIndex) $cls = 'active';
    ?>
      <div class="timeline-step <?= $cls ?>">
        <div class="dot">
          <i class="fa-solid <?= ['fa-paper-plane', 'fa-eye', 'fa-gear', 'fa-circle-check'][$i] ?>"></i>
        </div>
        <div class="lbl"><?= ucfirst(str_replace('_', ' ', $st)) ?></div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

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

    <div style="display:grid;grid-template-columns:auto 1fr;gap:8px 14px;font-size:0.88rem;margin-bottom:18px;padding:14px 16px;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:var(--radius-md);">
      <span style="color:var(--text-muted);">Current status</span>
      <span><span class="badge badge-<?= esc($report['status']) ?>"><?= esc($report['status']) ?></span></span>
      <span style="color:var(--text-muted);">Last updated</span>
      <span style="color:var(--text-secondary);"><i class="fa-regular fa-clock" style="margin-right:6px;color:var(--text-muted);"></i><?= esc(date('M j, Y g:i A', strtotime($updatedAt))) ?></span>
      <?php if (! empty($report['resolved_at'])): ?>
        <span style="color:var(--text-muted);">Resolved at</span>
        <span style="color:var(--green);"><i class="fa-solid fa-circle-check" style="margin-right:6px;"></i><?= esc(date('M j, Y g:i A', strtotime($report['resolved_at']))) ?></span>
      <?php endif; ?>
      <?php if (! empty($report['assigned_to'])): ?>
        <span style="color:var(--text-muted);">Assigned to</span>
        <span style="color:var(--cyan);"><i class="fa-solid fa-user-shield" style="margin-right:6px;"></i><?= esc($report['assigned_to']) ?></span>
      <?php endif; ?>
    </div>

    <form method="post" action="<?= base_url('admin/reports/update-status/' . $report['id']) ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="return_to" value="view">
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
        <input class="form-control" type="text" name="assigned_to" value="<?= esc($report['assigned_to']) ?>" placeholder="Officer or department (e.g. DPWH NCR — Engr. Reyes)">
      </div>
      <div class="form-group">
        <label class="form-label">Admin Notes <span style="color:var(--text-muted);font-weight:400;font-size:0.8rem;">(visible to citizen)</span></label>
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
