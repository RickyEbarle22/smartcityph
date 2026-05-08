<?php $a = $article ?? []; $isEdit = ! empty($a); ?>
<form method="post" action="<?= $isEdit ? base_url('admin/news/update/' . $a['id']) : base_url('admin/news/store') ?>" enctype="multipart/form-data" class="glass-card" style="padding:32px;">
  <?= csrf_field() ?>
  <div class="form-group"><label class="form-label">Title *</label><input class="form-control" type="text" name="title" value="<?= esc($a['title'] ?? '') ?>" required></div>
  <div class="grid grid-2">
    <div class="form-group">
      <label class="form-label">Category *</label>
      <select class="form-select" name="category" required>
        <?php foreach (['Announcements', 'Health', 'Business', 'Education', 'Transportation', 'Social Welfare', 'Civic'] as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($a['category'] ?? '') === $c ? 'selected' : '' ?>><?= esc($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Author</label><input class="form-control" type="text" name="author" value="<?= esc($a['author'] ?? 'SmartCity PH Newsroom') ?>"></div>
  </div>
  <div class="form-group"><label class="form-label">Excerpt (max 400 chars)</label><textarea class="form-textarea" name="excerpt" rows="3" maxlength="400"><?= esc($a['excerpt'] ?? '') ?></textarea></div>
  <div class="form-group"><label class="form-label">Body (HTML allowed)</label><textarea class="form-textarea" name="body" rows="12"><?= esc($a['body'] ?? '') ?></textarea></div>
  <div class="form-group"><label class="form-label">Tags (comma-separated)</label><input class="form-control" type="text" name="tags" value="<?= esc($a['tags'] ?? '') ?>"></div>
  <div class="form-group"><label class="form-label">Cover Image (max 2MB)</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <?php if (! empty($a['image'])): ?><p class="form-help">Current: <?= esc($a['image']) ?></p><?php endif; ?>
  </div>
  <div class="grid grid-2">
    <div>
      <label class="checkbox-row"><input type="checkbox" name="is_featured" value="1" <?= ! empty($a['is_featured']) ? 'checked' : '' ?>> Featured</label>
      <p class="form-help">Featured on the /news page (large hero card).</p>
    </div>
    <div>
      <label class="checkbox-row"><input type="checkbox" name="is_published" value="1" <?= empty($a) || ! empty($a['is_published']) ? 'checked' : '' ?>> Published</label>
      <p class="form-help">Visible at /news. Uncheck to keep as a Draft.</p>
    </div>
  </div>
  <div style="display:flex;gap:10px;margin-top:24px;">
    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-save"></i> <?= $isEdit ? 'Update' : 'Create' ?> Article</button>
    <a class="btn btn-ghost" href="<?= base_url('admin/news') ?>">Cancel</a>
  </div>
</form>
