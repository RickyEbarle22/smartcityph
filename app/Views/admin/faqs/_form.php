<?php $f = $faq ?? []; $isEdit = ! empty($f); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/faqs/update/' . $f['id']) : base_url('admin/faqs/store') ?>" class="glass-card" style="padding:32px;">
  <?= csrf_field() ?>
  <div class="form-group"><label class="form-label">Question *</label><textarea class="form-control" name="question" rows="2" required><?= esc($f['question'] ?? '') ?></textarea></div>
  <div class="form-group"><label class="form-label">Answer *</label><textarea class="form-control" name="answer" rows="5" required><?= esc($f['answer'] ?? '') ?></textarea></div>
  <div class="grid grid-2">
    <div class="form-group">
      <label class="form-label">Category</label>
      <select class="form-select" name="category">
        <?php $cur = $f['category'] ?? ''; ?>
        <option value="">— None —</option>
        <?php foreach (['Services', 'Reports', 'Account', 'FOI', 'Technical', 'General'] as $c): ?>
          <option value="<?= $c ?>" <?= $cur === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Sort Order (lower = top)</label><input class="form-control" type="number" name="sort_order" value="<?= (int) ($f['sort_order'] ?? 0) ?>"></div>
  </div>
  <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" <?= empty($f) || ! empty($f['is_active']) ? 'checked' : '' ?>> Active (visible on /faqs)</label>
  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?></button>
    <a class="btn btn-ghost" href="<?= base_url('admin/faqs') ?>">Cancel</a>
  </div>
</form>
