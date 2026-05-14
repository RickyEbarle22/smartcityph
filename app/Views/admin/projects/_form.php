<?php $p = $project ?? []; $isEdit = ! empty($p); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/projects/update/' . $p['id']) : base_url('admin/projects/store') ?>" class="glass-card" style="padding:32px;" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="form-group"><label class="form-label">Title *</label><input class="form-control" type="text" name="title" value="<?= esc($p['title'] ?? '') ?>" required maxlength="255"></div>
  <div class="form-group"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4"><?= esc($p['description'] ?? '') ?></textarea></div>

  <div class="grid grid-2">
    <div class="form-group">
      <label class="form-label">Agency (Acronym)</label>
      <input class="form-control" type="text" name="agency" value="<?= esc($p['agency'] ?? '') ?>" placeholder="e.g. DPWH, DOH">
    </div>
    <div class="form-group">
      <label class="form-label">Linked Agency Record</label>
      <select class="form-select" name="agency_id">
        <option value="">— None —</option>
        <?php foreach (($agencies ?? []) as $a): ?>
          <option value="<?= (int) $a['id'] ?>" <?= (int) ($p['agency_id'] ?? 0) === (int) $a['id'] ? 'selected' : '' ?>>
            <?= esc($a['acronym'] ? $a['acronym'] . ' — ' . $a['name'] : $a['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="grid grid-3">
    <div class="form-group">
      <label class="form-label">Status *</label>
      <select class="form-select" name="status" required>
        <?php $st = $p['status'] ?? 'planned'; foreach (['planned', 'ongoing', 'completed', 'cancelled'] as $s): ?>
          <option value="<?= $s ?>" <?= $st === $s ? 'selected' : '' ?>><?= esc(ucfirst($s)) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Region</label>
      <select class="form-select" name="region_id">
        <option value="">— Nationwide —</option>
        <?php foreach (($regions ?? []) as $r): ?>
          <option value="<?= (int) $r['id'] ?>" <?= (int) ($p['region_id'] ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Progress %</label><input class="form-control" type="number" name="progress" min="0" max="100" value="<?= (int) ($p['progress'] ?? 0) ?>"></div>
  </div>

  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Budget (&#8369;)</label><input class="form-control" type="number" step="0.01" name="budget" value="<?= esc($p['budget'] ?? 0) ?>"></div>
    <div class="form-group"><label class="form-label">Amount Released (&#8369;)</label><input class="form-control" type="number" step="0.01" name="amount_released" value="<?= esc($p['amount_released'] ?? 0) ?>"></div>
  </div>

  <div class="grid grid-2">
    <div class="form-group"><label class="form-label">Start Date</label><input class="form-control" type="date" name="start_date" value="<?= esc($p['start_date'] ?? '') ?>"></div>
    <div class="form-group"><label class="form-label">End Date</label><input class="form-control" type="date" name="end_date" value="<?= esc($p['end_date'] ?? '') ?>"></div>
  </div>

  <div class="form-group">
    <label class="form-label">Image (optional, max 2MB)</label>
    <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
    <?php if (! empty($p['image']) && is_file(FCPATH . 'uploads/projects/' . $p['image'])): ?>
      <div style="margin-top:8px;"><img src="<?= base_url('uploads/projects/' . esc($p['image'])) ?>" alt="" style="max-width:120px;border-radius:8px;"></div>
    <?php endif; ?>
  </div>

  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?></button>
    <a class="btn btn-ghost" href="<?= base_url('admin/projects') ?>">Cancel</a>
  </div>
</form>
