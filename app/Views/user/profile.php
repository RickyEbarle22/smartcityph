<?php
ob_start();
?>
<section class="page-hero" style="padding-bottom:24px;">
  <div class="container">
    <span class="kicker">My Profile</span>
    <h1>Edit your <span class="gradient-text">profile</span></h1>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="grid grid-2">
      <div class="glass-card" style="padding:32px;">
        <h3 class="mb-3">Profile Information</h3>
        <form method="post" action="<?= base_url('user/profile/update') ?>" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="form-group" style="text-align:center;">
            <div style="width:96px;height:96px;border-radius:50%;background:linear-gradient(135deg,#2563EB,#06B6D4);display:grid;place-items:center;color:#fff;font-family:var(--font-head);font-weight:800;font-size:2rem;margin:0 auto 14px;overflow:hidden;">
              <?php if (! empty($user['avatar'])): ?>
                <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">
              <?php else: ?>
                <?= esc(strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1))) ?>
              <?php endif; ?>
            </div>
            <input class="form-control" type="file" name="avatar" accept="image/jpeg,image/png,image/webp">
            <p class="form-help">JPG/PNG/WebP, max 2MB</p>
          </div>
          <div class="form-row">
            <div class="form-group"><label class="form-label">First Name</label><input class="form-control" type="text" name="first_name" value="<?= esc($user['first_name']) ?>" required></div>
            <div class="form-group"><label class="form-label">Last Name</label><input class="form-control" type="text" name="last_name" value="<?= esc($user['last_name']) ?>" required></div>
          </div>
          <div class="form-group"><label class="form-label">Email</label><input class="form-control" type="email" value="<?= esc($user['email']) ?>" disabled></div>
          <div class="form-row">
            <div class="form-group"><label class="form-label">Phone</label><input class="form-control" type="text" name="phone" value="<?= esc($user['phone']) ?>"></div>
            <div class="form-group">
              <label class="form-label">Region</label>
              <select class="form-select" name="region_id">
                <option value="">— Select —</option>
                <?php foreach (($regions ?? []) as $r): ?>
                  <option value="<?= (int) $r['id'] ?>" <?= (int) ($user['region_id'] ?? 0) === (int) $r['id'] ? 'selected' : '' ?>><?= esc($r['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group"><label class="form-label">Address</label><textarea class="form-textarea" name="address" rows="3"><?= esc($user['address']) ?></textarea></div>
          <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-save"></i> Save Profile</button>
        </form>
      </div>

      <div class="glass-card" style="padding:32px;">
        <h3 class="mb-3">Change Password</h3>
        <form method="post" action="<?= base_url('user/profile/password') ?>">
          <?= csrf_field() ?>
          <div class="form-group"><label class="form-label">Current Password</label><input class="form-control" type="password" name="current_password" required></div>
          <div class="form-group">
            <label class="form-label">New Password</label>
            <input class="form-control" type="password" name="new_password" id="password" required minlength="6">
            <div class="pwd-bar"><div class="fill" id="pwd-bar-fill"></div></div>
            <p class="pwd-text" id="pwd-text">Use 8+ characters with letters, numbers, and symbols</p>
          </div>
          <div class="form-group"><label class="form-label">Confirm New Password</label><input class="form-control" type="password" name="confirm_password" required minlength="6"></div>
          <button class="btn btn-success btn-block" type="submit"><i class="fa-solid fa-key"></i> Update Password</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
