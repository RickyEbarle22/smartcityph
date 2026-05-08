<?php
ob_start();
$statusOrder = ['pending', 'reviewing', 'in_progress', 'resolved'];
$activeIndex = $report ? array_search($report['status'], $statusOrder, true) : -1;
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
    <?php elseif (! empty($report) && $report['status'] !== 'rejected'): ?>
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
            <?php if (! empty($report['resolved_at'])): ?><dt style="color:var(--text-muted);">Resolved</dt><dd><?= esc(date('F j, Y g:i A', strtotime($report['resolved_at']))) ?></dd><?php endif; ?>
          </dl>
        </div>
        <div class="glass-card" style="padding:32px;">
          <h4 class="mb-2">Issue Details</h4>
          <p style="color:var(--text-muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;">Location</p>
          <p style="color:var(--text-secondary);margin-bottom:12px;"><?= esc($report['location']) ?></p>
          <p style="color:var(--text-muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;">Description</p>
          <p style="color:var(--text-secondary);margin-bottom:12px;"><?= nl2br(esc($report['description'])) ?></p>
          <?php if (! empty($report['admin_notes'])): ?>
            <p style="color:var(--text-muted);font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;">Admin Notes</p>
            <p style="color:var(--gold);"><?= nl2br(esc($report['admin_notes'])) ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php elseif (! empty($report)): ?>
      <div class="glass-card" style="padding:40px;text-align:center;">
        <i class="fa-solid fa-circle-xmark" style="font-size:3rem;color:var(--red-light);margin-bottom:14px;"></i>
        <h3>Report rejected</h3>
        <p style="color:var(--text-secondary);"><?= esc($report['admin_notes'] ?: 'This report did not meet the criteria for action.') ?></p>
      </div>
    <?php else: ?>
      <div class="empty"><i class="fa-solid fa-magnifying-glass"></i><h3>Enter a reference number</h3><p>Use the form above to track a previously submitted report.</p></div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
