<?php
ob_start();
?>
<div class="admin-topbar">
  <div><h1>Regions</h1><p style="color:var(--text-muted);font-size:0.92rem;">Philippine regions, provinces, cities, and municipalities.</p></div>
  <a class="btn btn-primary" href="<?= base_url('admin/regions/create') ?>"><i class="fa-solid fa-plus"></i> New Region</a>
</div>
<div class="table-wrap">
  <table class="data">
    <thead><tr><th>Name</th><th>Code</th><th>Type</th><th>Coordinates</th><th>Services</th><th>Active</th><th></th></tr></thead>
    <tbody>
      <?php foreach (($regions ?? []) as $r): ?>
        <tr>
          <td><strong><?= esc($r['name']) ?></strong><br><span style="color:var(--text-muted);font-size:0.78rem;"><?= esc($r['slug']) ?></span></td>
          <td><?= esc($r['code'] ?? '—') ?></td>
          <td><span class="badge badge-planned"><?= esc($r['type']) ?></span></td>
          <td style="color:var(--text-muted);font-size:0.85rem;">
            <?= ! empty($r['latitude']) ? number_format((float) $r['latitude'], 4) . ', ' . number_format((float) $r['longitude'], 4) : '—' ?>
          </td>
          <td><?= (int) ($counts[$r['id']] ?? 0) ?></td>
          <td><?= $r['is_active'] ? '<span class="badge badge-completed">Active</span>' : '<span class="badge badge-cancelled">Inactive</span>' ?></td>
          <td class="table-actions"><a href="<?= base_url('admin/regions/edit/' . $r['id']) ?>"><i class="fa-solid fa-pen"></i></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
