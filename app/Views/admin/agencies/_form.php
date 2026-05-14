<?php $a = $agency ?? []; $isEdit = ! empty($a); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/agencies/update/' . $a['id']) : base_url('admin/agencies/store') ?>" class="glass-card" style="padding:32px;" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Agency Name *</label><input class="form-control" type="text" name="name" value="<?= esc($a['name'] ?? '') ?>" required></div>
    <div class="form-group"><label class="form-label">Acronym</label><input class="form-control" type="text" name="acronym" value="<?= esc($a['acronym'] ?? '') ?>" maxlength="20"></div>
  </div>
  <div class="grid grid-2">
    <div class="form-group">
      <label class="form-label">Category</label>
      <select class="form-select" name="category">
        <?php $cur = $a['category'] ?? ''; ?>
        <option value="">— Select —</option>
        <?php foreach (['Executive', 'Legislative', 'Judicial', 'Constitutional Body', 'Attached Agency', 'GOCC', 'LGU', 'Department'] as $c): ?>
          <option value="<?= $c ?>" <?= $cur === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Website</label><input class="form-control" type="url" name="website" value="<?= esc($a['website'] ?? '') ?>" placeholder="https://"></div>
  </div>
  <div class="form-group"><label class="form-label">Mandate / Description</label><textarea class="form-control" name="description" rows="4"><?= esc($a['description'] ?? '') ?></textarea></div>

  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Head Name</label><input class="form-control" type="text" name="head_name" value="<?= esc($a['head_name'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Head Title</label><input class="form-control" type="text" name="head_title" value="<?= esc($a['head_title'] ?? '') ?>" placeholder="e.g. Secretary, Director"></div>
  </div>

  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= esc($a['email'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">Phone</label><input class="form-control" type="text" name="phone" value="<?= esc($a['phone'] ?? '') ?>"></div>
  </div>

  <div class="form-group"><label class="form-label">Address</label><textarea class="form-control" name="address" rows="2"><?= esc($a['address'] ?? '') ?></textarea></div>

  <div class="form-group">
    <label class="form-label">Logo (jpg/png/webp/svg, max 2MB)</label>
    <input class="form-control" type="file" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg">
    <?php if (! empty($a['logo']) && is_file(FCPATH . 'uploads/agencies/' . $a['logo'])): ?>
      <div style="margin-top:8px;"><img src="<?= base_url('uploads/agencies/' . esc($a['logo'])) ?>" alt="" style="max-width:80px;border-radius:8px;background:rgba(255,255,255,0.05);padding:6px;"></div>
    <?php endif; ?>
  </div>

  <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" <?= empty($a) || ! empty($a['is_active']) ? 'checked' : '' ?>> Active (visible on /agencies)</label>

  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?></button>
    <a class="btn btn-ghost" href="<?= base_url('admin/agencies') ?>">Cancel</a>
  </div>
</form>
