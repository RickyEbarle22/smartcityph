<?php $r = $region ?? []; $isEdit = ! empty($r); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/regions/update/' . $r['id']) : base_url('admin/regions/store') ?>" class="glass-card" style="padding:32px;">
  <?= csrf_field() ?>
  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Name *</label><input class="form-control" type="text" name="name" value="<?= esc($r['name'] ?? '') ?>" required></div>
    <div class="form-group"><label class="form-label">Slug (auto if empty)</label><input class="form-control" type="text" name="slug" value="<?= esc($r['slug'] ?? '') ?>"></div>
  </div>
  <div class="grid grid-3">
    <div class="form-group"><label class="form-label">Code</label><input class="form-control" type="text" name="code" value="<?= esc($r['code'] ?? '') ?>"></div>
    <div class="form-group">
      <label class="form-label">Type *</label>
      <select class="form-select" name="type" required>
        <?php foreach (['region', 'province', 'city', 'municipality'] as $t): ?>
          <option value="<?= $t ?>" <?= ($r['type'] ?? 'region') === $t ? 'selected' : '' ?>><?= esc(ucfirst($t)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Parent</label>
      <select class="form-select" name="parent_id">
        <option value="">— None —</option>
        <?php foreach (($parents ?? []) as $p): ?>
          <option value="<?= (int) $p['id'] ?>" <?= (int) ($r['parent_id'] ?? 0) === (int) $p['id'] ? 'selected' : '' ?>><?= esc($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="grid grid-3">
    <div class="form-group"><label class="form-label">Latitude</label><input class="form-control" type="text" name="latitude" value="<?= esc($r['latitude'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Longitude</label><input class="form-control" type="text" name="longitude" value="<?= esc($r['longitude'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Population</label><input class="form-control" type="number" name="population" value="<?= esc($r['population'] ?? '') ?>"></div>
  </div>
  <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" <?= empty($r) || ! empty($r['is_active']) ? 'checked' : '' ?>> Active</label>
  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?></button>
    <a class="btn btn-ghost" href="<?= base_url('admin/regions') ?>">Cancel</a>
  </div>
</form>
