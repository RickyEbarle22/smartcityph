<?php
ob_start();
?>
<div class="admin-topbar">
  <div>
    <h1>Dashboard</h1>
    <p style="color:var(--text-muted);font-size:0.92rem;">Overview of SmartCity PH activity.</p>
  </div>
  <div style="color:var(--text-secondary);font-size:0.9rem;"><i class="fa-regular fa-user"></i> <?= esc(session()->get('admin_full_name')) ?></div>
</div>

<div class="admin-stats">
  <div class="admin-stat"><i class="fa-solid fa-list-check ico"></i><div class="lbl">Services</div><div class="num"><?= (int) $totalServices ?></div></div>
  <div class="admin-stat"><i class="fa-solid fa-newspaper ico"></i><div class="lbl">News</div><div class="num"><?= (int) $totalNews ?></div></div>
  <div class="admin-stat"><i class="fa-solid fa-flag ico"></i><div class="lbl">Pending Reports</div><div class="num" style="color:var(--gold);"><?= (int) $pendingReports ?></div></div>
  <div class="admin-stat"><i class="fa-solid fa-flag-checkered ico"></i><div class="lbl">Total Reports</div><div class="num"><?= (int) $totalReports ?></div></div>
  <div class="admin-stat"><i class="fa-solid fa-users ico"></i><div class="lbl">Citizens</div><div class="num"><?= (int) $totalCitizens ?></div></div>
  <div class="admin-stat"><i class="fa-solid fa-building-columns ico"></i><div class="lbl">Projects</div><div class="num"><?= (int) $totalProjects ?></div></div>
</div>

<div class="grid grid-2">
  <div class="glass-card" style="padding:28px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
      <h3 style="margin:0;">Recent Reports</h3>
      <a href="<?= base_url('admin/reports') ?>" style="color:var(--cyan);font-size:0.85rem;">View all</a>
    </div>
    <table class="data">
      <thead><tr><th>Reference</th><th>Citizen</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (! empty($recentReports)): foreach ($recentReports as $r): ?>
          <tr>
            <td><a href="<?= base_url('admin/reports/view/' . $r['id']) ?>" style="color:var(--gold);"><?= esc($r['reference']) ?></a></td>
            <td><?= esc($r['full_name']) ?></td>
            <td><span class="badge badge-<?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="3" style="text-align:center;color:var(--text-muted);">No reports yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="glass-card" style="padding:28px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
      <h3 style="margin:0;">Recent News</h3>
      <a href="<?= base_url('admin/news') ?>" style="color:var(--cyan);font-size:0.85rem;">View all</a>
    </div>
    <table class="data">
      <thead><tr><th>Title</th><th>Category</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (! empty($recentNews)): foreach ($recentNews as $n): ?>
          <tr>
            <td><a href="<?= base_url('admin/news/edit/' . $n['id']) ?>" style="color:var(--text-primary);"><?= esc(character_limiter($n['title'], 50)) ?></a></td>
            <td><?= esc($n['category']) ?></td>
            <td><span class="badge badge-<?= $n['is_published'] ? 'completed' : 'planned' ?>"><?= $n['is_published'] ? 'Published' : 'Draft' ?></span></td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="3" style="text-align:center;color:var(--text-muted);">No articles yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
