<?php $s = $service ?? []; $isEdit = ! empty($s); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/services/update/' . $s['id']) : base_url('admin/services/store') ?>" enctype="multipart/form-data" class="glass-card" style="padding:32px;">
  <?= csrf_field() ?>
  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Name *</label><input class="form-control" type="text" name="name" value="<?= esc($s['name'] ?? '') ?>" required></div>
    <div class="form-group"><label class="form-label">Category *</label>
      <select class="form-select" name="category" required>
        <?php foreach (['Health', 'Business', 'Civil Registry', 'Education', 'Social Welfare', 'Transportation', 'Housing', 'Agriculture'] as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($s['category'] ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group"><label class="form-label">Short Description</label><input class="form-control" type="text" name="short_desc" value="<?= esc($s['short_desc'] ?? '') ?>"></div>
  <div class="form-group"><label class="form-label">Full Description (HTML allowed)</label><textarea class="form-textarea" name="description" rows="4"><?= esc($s['description'] ?? '') ?></textarea></div>
  <div class="grid grid-3">
    <div class="form-group"><label class="form-label">Icon (Font Awesome class)</label><input class="form-control" type="text" name="icon" value="<?= esc($s['icon'] ?? 'fa-cog') ?>" placeholder="fa-heartbeat"></div>
    <div class="form-group"><label class="form-label">Fee</label><input class="form-control" type="text" name="fee" value="<?= esc($s['fee'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Processing Time</label><input class="form-control" type="text" name="processing_time" value="<?= esc($s['processing_time'] ?? '') ?>"></div>
  </div>
  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Office</label><input class="form-control" type="text" name="office" value="<?= esc($s['office'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Agency</label><input class="form-control" type="text" name="agency" value="<?= esc($s['agency'] ?? '') ?>"></div>
  </div>
  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Contact Number</label><input class="form-control" type="text" name="contact" value="<?= esc($s['contact'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Website</label><input class="form-control" type="text" name="website" value="<?= esc($s['website'] ?? '') ?>"></div>
  </div>
  <div class="form-group">
    <label class="form-label">Region</label>
    <select class="form-select" name="region_id">
      <option value="">— None / Nationwide —</option>
      <?php foreach (($regions ?? []) as $r): ?>
        <option value="<?= (int) $r['id'] ?>" <?= (int) ($s['region_id'] ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group"><label class="form-label">Requirements (one per line)</label><textarea class="form-textarea" name="requirements" rows="4"><?= esc($s['requirements'] ?? '') ?></textarea></div>
  <div class="form-group"><label class="form-label">Steps (one per line)</label><textarea class="form-textarea" name="steps" rows="4"><?= esc($s['steps'] ?? '') ?></textarea></div>
  <div class="form-group"><label class="form-label">Image (max 2MB)</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <?php if (! empty($s['image'])): ?><p class="form-help">Current: <?= esc($s['image']) ?></p><?php endif; ?>
  </div>
  <div class="grid grid-3">
    <div>
      <label class="checkbox-row"><input type="checkbox" name="is_nationwide" value="1" <?= ! empty($s['is_nationwide']) ? 'checked' : '' ?>> Nationwide</label>
      <p class="form-help">Available in all 17 regions.</p>
    </div>
    <div>
      <label class="checkbox-row"><input type="checkbox" name="is_featured" value="1" <?= ! empty($s['is_featured']) ? 'checked' : '' ?>> Featured</label>
      <p class="form-help">Shown in the homepage Featured grid.</p>
    </div>
    <div>
      <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" <?= empty($s) || ! empty($s['is_active']) ? 'checked' : '' ?>> Active</label>
      <p class="form-help">Visible at /services. Uncheck to hide from public.</p>
    </div>
  </div>
  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?> Service</button>
    <a class="btn btn-ghost" href="<?= base_url('admin/services') ?>">Cancel</a>
  </div>
</form>
