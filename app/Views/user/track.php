<?php
ob_start();
$statusOrder = ['pending', 'reviewing', 'in_progress', 'resolved'];
$activeIndex = $report ? array_search($report['status'], $statusOrder, true) : -1;
$updatedAt   = $report['updated_at'] ?? ($report['created_at'] ?? null);
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker">Track Your Report</span>
    <h1>Track <span class="gradient-text">Report</span></h1>
    <p class="lead">Enter your reference number to see real-time progress.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form class="glass-card" method="post" action="<?= base_url('track/lookup') ?>" style="padding:18px;display:grid;grid-template-columns:1fr auto;gap:10px;max-width:560px;margin:0 auto;">
      <?= csrf_field() ?>
      <input class="form-control" type="text" name="reference" placeholder="Enter reference (e.g. RPT-A1B2C3D4)" value="<?= esc($ref ?? '') ?>" required>
      <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Track</button>
    </form>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (! empty($ref) && empty($report)): ?>
      <div class="empty"><i class="fa-solid fa-circle-question"></i><h3>Report not found</h3><p>Double-check your reference number and try again.</p></div>
    <?php elseif (! empty($report)): ?>

      <?php if ($report['status'] === 'resolved'): ?>
        <div class="status-banner banner-resolved">
          <div class="banner-icon"><i class="fa-solid fa-circle-check"></i></div>
          <div>
            <h3 style="margin:0;">Issue Resolved</h3>
            <p style="margin:4px 0 0;color:var(--text-secondary);">
              Marked resolved on <strong style="color:var(--green);"><?= esc(date('F j, Y g:i A', strtotime($report['resolved_at'] ?? $updatedAt))) ?></strong>.
              Thank you for helping improve your community.
            </p>
          </div>
        </div>
      <?php elseif ($report['status'] === 'rejected'): ?>
        <div class="status-banner banner-rejected">
          <div class="banner-icon"><i class="fa-solid fa-circle-xmark"></i></div>
          <div>
            <h3 style="margin:0;">Report Rejected</h3>
            <p style="margin:4px 0 0;color:var(--text-secondary);">
              <?= esc($report['admin_notes'] ?: 'This report did not meet the criteria for action.') ?>
            </p>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($report['status'] !== 'rejected'): ?>
        <div class="timeline mb-4">
          <?php foreach ($statusOrder as $i => $st):
            $cls = '';
            if ($i < $activeIndex) $cls = 'done';
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
          <span class="kicker">Reference</span>
          <h2 style="font-family:var(--font-head);color:var(--gold);"><?= esc($report['reference']) ?></h2>
          <hr style="border:0;border-top:1px solid var(--border);margin:18px 0;">
          <dl style="display:grid;grid-template-columns:auto 1fr;gap:10px 16px;">
            <dt style="color:var(--text-muted);">Status</dt><dd><span class="badge badge-<?= esc($report['status']) ?>"><?= esc($report['status']) ?></span></dd>
            <dt style="color:var(--text-muted);">Priority</dt><dd><span class="badge badge-<?= esc($report['priority']) ?>"><?= esc($report['priority']) ?></span></dd>
            <dt style="color:var(--text-muted);">Category</dt><dd><?= esc($report['category']) ?></dd>
            <dt style="color:var(--text-muted);">Region</dt><dd><?= esc($report['region_name'] ?? '—') ?></dd>
            <dt style="color:var(--text-muted);">Reported</dt><dd><?= esc(date('F j, Y g:i A', strtotime($report['created_at']))) ?></dd>
            <?php if (! empty($updatedAt)): ?>
              <dt style="color:var(--text-muted);">Last updated</dt>
              <dd style="color:var(--cyan);"><i class="fa-regular fa-clock" style="margin-right:6px;"></i><?= esc(date('F j, Y g:i A', strtotime($updatedAt))) ?></dd>
            <?php endif; ?>
            <?php if (! empty($report['resolved_at'])): ?>
              <dt style="color:var(--text-muted);">Resolved</dt>
              <dd style="color:var(--green);"><?= esc(date('F j, Y g:i A', strtotime($report['resolved_at']))) ?></dd>
            <?php endif; ?>
          </dl>
        </div>
        <div class="glass-card" style="padding:32px;">
          <h4 class="mb-2">Issue Details</h4>
          <p style="color:var(--text-muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;">Location</p>
          <p style="color:var(--text-secondary);margin-bottom:12px;"><?= esc($report['location']) ?></p>
          <p style="color:var(--text-muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;">Description</p>
          <p style="color:var(--text-secondary);margin-bottom:12px;"><?= nl2br(esc($report['description'])) ?></p>
        </div>
      </div>

      <?php if (! empty($report['admin_notes'])): ?>
        <div class="official-response mt-3">
          <div class="or-header">
            <i class="fa-solid fa-landmark"></i>
            <div>
              <span class="or-kicker">Official Government Response</span>
              <span class="or-meta">Updated <?= esc(date('F j, Y g:i A', strtotime($updatedAt))) ?></span>
            </div>
          </div>
          <p class="or-body"><?= nl2br(esc($report['admin_notes'])) ?></p>
          <?php if (! empty($report['assigned_to'])): ?>
            <p class="or-assigned"><i class="fa-solid fa-user-shield"></i> Handled by <strong><?= esc($report['assigned_to']) ?></strong></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <div class="empty"><i class="fa-solid fa-magnifying-glass"></i><h3>Enter a reference number</h3><p>Use the form above to track a previously submitted report.</p></div>
    <?php endif; ?>
  </div>
</section>

<style>
.status-banner {
  display: flex; gap: 18px; align-items: center;
  padding: 22px 26px; border-radius: var(--radius);
  margin-bottom: 22px;
  border: 1px solid;
}
.status-banner h3 { font-family: var(--font-head); }
.status-banner .banner-icon {
  width: 56px; height: 56px; border-radius: 50%;
  display: grid; place-items: center;
  font-size: 1.6rem; flex-shrink: 0;
}
.banner-resolved { background: var(--green-dim); border-color: rgba(34, 197, 94, 0.4); }
.banner-resolved .banner-icon { background: linear-gradient(135deg, #22C55E, #16A34A); color: #fff; box-shadow: 0 8px 24px rgba(34, 197, 94, 0.3); }
.banner-resolved h3 { color: var(--green); }
.banner-rejected { background: var(--red-dim); border-color: rgba(239, 68, 68, 0.4); }
.banner-rejected .banner-icon { background: linear-gradient(135deg, #EF4444, #CE1126); color: #fff; box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3); }
.banner-rejected h3 { color: var(--red-light); }

.official-response {
  background: linear-gradient(135deg, rgba(252, 209, 22, 0.06), rgba(245, 158, 11, 0.04));
  border: 1px solid var(--gold);
  border-left: 4px solid var(--gold);
  border-radius: var(--radius);
  padding: 26px 28px;
  box-shadow: 0 12px 32px rgba(252, 209, 22, 0.08);
}
.official-response .or-header { display: flex; gap: 14px; align-items: center; margin-bottom: 14px; }
.official-response .or-header i { font-size: 1.4rem; color: var(--gold); }
.official-response .or-kicker { display: block; font-family: var(--font-head); font-weight: 700; color: var(--gold); letter-spacing: 0.04em; text-transform: uppercase; font-size: 0.85rem; }
.official-response .or-meta { display: block; color: var(--text-muted); font-size: 0.78rem; margin-top: 2px; }
.official-response .or-body { color: var(--text-primary); font-size: 1rem; line-height: 1.65; margin: 0; }
.official-response .or-assigned { margin: 14px 0 0; padding-top: 14px; border-top: 1px dashed rgba(252, 209, 22, 0.2); color: var(--text-secondary); font-size: 0.88rem; }
.official-response .or-assigned i { color: var(--cyan); margin-right: 6px; }
</style>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
