<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Government Projects</h1><p style="color:var(--text-muted);font-size:0.92rem;">Transparency dashboard projects shown on /transparency.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/projects/create') ?>"><i class="fa-solid fa-plus"></i> New Project</a>
</div>

<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Title</th><th>Agency</th><th>Region</th><th>Budget</th><th>Progress</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php if (! empty($projects)): foreach ($projects as $p): ?>
        <tr>
          <td><strong><?= esc($p['title']) ?></strong></td>
          <td style="color:var(--text-secondary);font-size:0.88rem;"><?= esc($p['agency'] ?: '—') ?></td>
          <td style="color:var(--text-secondary);font-size:0.88rem;"><?= esc($p['region_name'] ?: '—') ?></td>
          <td style="color:var(--gold);font-weight:600;">&#8369;<?= number_format((float) $p['budget'], 0) ?></td>
          <td style="min-width:140px;">
            <div style="background:rgba(255,255,255,0.05);border-radius:8px;height:8px;overflow:hidden;">
              <div style="background:linear-gradient(90deg,var(--cyan),var(--primary-2));height:100%;width:<?= (int) $p['progress'] ?>%;"></div>
            </div>
            <span style="font-size:0.78rem;color:var(--text-muted);"><?= (int) $p['progress'] ?>%</span>
          </td>
          <td><span class="badge badge-<?= esc($p['status']) ?>"><?= esc($p['status']) ?></span></td>
          <td class="table-actions">
            <a href="<?= base_url('admin/projects/edit/' . $p['id']) ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
            <a class="danger" href="<?= base_url('admin/projects/delete/' . $p['id']) ?>" data-confirm="Delete this project?" title="Delete"><i class="fa-solid fa-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px;">No projects yet. <a href="<?= base_url('admin/projects/create') ?>" style="color:var(--cyan);">Add the first one</a>.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php if (! empty($pager)): ?><div class="pager-wrap"><?= $pager->links() ?></div><?php endif; ?>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
