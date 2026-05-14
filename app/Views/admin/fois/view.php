<?php
ob_start();
?>
<div class="admin-topbar">
  <div>
    <h1>FOI <span style="color:var(--gold);"><?= esc($foi['reference']) ?></span></h1>
    <p style="color:var(--text-muted);font-size:0.92rem;">Filed <?= esc(date('M j, Y g:i A', strtotime($foi['created_at']))) ?></p>
  </div>
  <a class="btn btn-ghost" href="<?= base_url('admin/fois') ?>"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;align-items:flex-start;">
  <div class="glass-card" style="padding:28px;">
    <h2 style="font-family:var(--font-head);font-size:1.2rem;margin-bottom:12px;"><?= esc($foi['request_title']) ?></h2>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
      <div><div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;">Requester</div><div style="color:var(--text-primary);"><?= esc($foi['full_name']) ?></div></div>
      <div><div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;">Email</div><div style="color:var(--text-primary);"><?= esc($foi['email']) ?></div></div>
      <div><div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;">Phone</div><div style="color:var(--text-primary);"><?= esc($foi['phone'] ?: '—') ?></div></div>
      <div><div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;">Target Agency</div><div style="color:var(--text-primary);"><?= esc($foi['agency_full_name'] ?: ($foi['agency_name'] ?: '—')) ?></div></div>
    </div>

    <div style="margin-bottom:14px;">
      <div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px;">Description</div>
      <div style="color:var(--text-secondary);line-height:1.7;white-space:pre-wrap;"><?= esc($foi['description']) ?></div>
    </div>

    <?php if (! empty($foi['purpose'])): ?>
      <div>
        <div style="color:var(--text-muted);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px;">Purpose</div>
        <div style="color:var(--text-secondary);"><?= esc($foi['purpose']) ?></div>
      </div>
    <?php endif; ?>
  </div>

  <aside class="glass-card" style="padding:24px;position:sticky;top:24px;">
    <h3 style="font-family:var(--font-head);font-size:1.05rem;margin-bottom:14px;">Respond</h3>
    <form method="post" action="<?= base_url('admin/fois/respond/' . $foi['id']) ?>">
      <?= csrf_field() ?>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" required>
          <?php foreach (['pending', 'processing', 'fulfilled', 'denied'] as $s): ?>
            <option value="<?= $s ?>" <?= $foi['status'] === $s ? 'selected' : '' ?>><?= esc(ucfirst($s)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Official Response</label>
        <textarea class="form-control" name="response" rows="6" placeholder="Provide the response or reason for denial..."><?= esc($foi['response'] ?? '') ?></textarea>
      </div>
      <?php if (! empty($foi['responded_at'])): ?>
        <p style="color:var(--text-muted);font-size:0.8rem;margin-bottom:14px;">Last responded: <?= esc(date('M j, Y g:i A', strtotime($foi['responded_at']))) ?></p>
      <?php endif; ?>
      <button class="btn btn-primary" type="submit" style="width:100%;justify-content:center;"><i class="fa-solid fa-paper-plane"></i> Save Response</button>
    </form>
  </aside>
</div>
<?php
$content = ob_get_clean();
echo view('layouts/admin', ['title' => $title ?? null, 'content' => $content]);
