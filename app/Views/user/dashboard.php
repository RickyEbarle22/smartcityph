<?php
ob_start();
$session = session();
$first = $session->get('user_first_name');
?>
<section class="page-hero" style="padding-bottom:24px;">
  <div class="container">
    <span class="kicker">Citizen Portal</span>
    <h1>Magandang araw, <span class="gradient-flag"><?= esc($first ?? 'Citizen') ?></span>!</h1>
    <p class="lead">Manage your reports, track requests, and update your profile in one place.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="grid grid-4 mb-4">
      <div class="glass-card" style="padding:24px;"><div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">My Reports</div><div style="font-family:var(--font-head);font-weight:800;font-size:1.9rem;color:var(--gold);"><?= (int) ($totalReports ?? 0) ?></div></div>
      <div class="glass-card" style="padding:24px;"><div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">Pending</div><div style="font-family:var(--font-head);font-weight:800;font-size:1.9rem;color:var(--cyan);"><?= (int) ($pending ?? 0) ?></div></div>
      <div class="glass-card" style="padding:24px;"><div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">Resolved</div><div style="font-family:var(--font-head);font-weight:800;font-size:1.9rem;color:var(--green);"><?= (int) ($resolved ?? 0) ?></div></div>
      <div class="glass-card" style="padding:24px;"><div style="color:var(--text-muted);font-size:0.74rem;letter-spacing:0.08em;text-transform:uppercase;">Reviews</div><div style="font-family:var(--font-head);font-weight:800;font-size:1.9rem;color:var(--primary-light);"><?= (int) ($feedbackCount ?? 0) ?></div></div>
    </div>

    <div class="detail-grid">
      <div class="glass-card" style="padding:32px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
          <h3 style="margin:0;">Recent Reports</h3>
          <a href="<?= base_url('user/reports') ?>" style="color:var(--cyan);font-size:0.9rem;">View all →</a>
        </div>
        <?php if (! empty($reports)): ?>
          <table class="data" style="width:100%;border-collapse:collapse;">
            <thead><tr><th>Reference</th><th>Category</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($reports as $r): ?>
              <tr>
                <td><a href="<?= base_url('track?ref=' . urlencode($r['reference'])) ?>" style="color:var(--gold);font-weight:600;font-family:var(--font-head);"><?= esc($r['reference']) ?></a></td>
                <td><?= esc($r['category']) ?></td>
                <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
                <td style="color:var(--text-muted);font-size:0.85rem;"><?= esc(date('M j', strtotime($r['created_at']))) ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="color:var(--text-muted);">You haven't filed any reports yet.</p>
        <?php endif; ?>
      </div>
      <aside>
        <div class="glass-card" style="padding:28px;margin-bottom:18px;">
          <h4 class="mb-2">Quick Actions</h4>
          <a class="btn btn-primary btn-block mb-2" href="<?= base_url('reports') ?>"><i class="fa-solid fa-flag"></i> File a Report</a>
          <a class="btn btn-outline btn-block mb-2" href="<?= base_url('track') ?>"><i class="fa-solid fa-magnifying-glass"></i> Track Report</a>
          <a class="btn btn-ghost btn-block" href="<?= base_url('user/profile') ?>"><i class="fa-solid fa-user-pen"></i> Edit Profile</a>
        </div>
        <div class="glass-card" style="padding:28px;">
          <h4 class="mb-2">Browse Services</h4>
          <p style="color:var(--text-secondary);font-size:0.9rem;">Discover government services by region or category.</p>
          <a class="btn btn-outline btn-block mt-2" href="<?= base_url('services') ?>">Open Services</a>
        </div>
      </aside>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
