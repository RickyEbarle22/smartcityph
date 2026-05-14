<?php
ob_start();
$errors = session()->getFlashdata('errors') ?? [];
?>
<section class="page-hero">
  <div class="container">
    <span class="kicker"><i class="fa-solid fa-folder-open"></i> Executive Order No. 2 &middot; RA 12254</span>
    <h1>Freedom of <span class="gradient-flag">Information</span></h1>
    <p class="lead">Every Filipino has the right to request information held by Executive branch agencies. Submit your FOI request below — agencies have 15 working days to respond.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container" style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;align-items:flex-start;">
    <form method="post" action="<?= base_url('foi/submit') ?>" class="glass-card" style="padding:28px;">
      <?= csrf_field() ?>
      <h2 style="font-family:var(--font-head);font-size:1.4rem;margin-bottom:18px;">Submit FOI Request</h2>

      <?php if (! empty($errors)): ?>
        <div class="form-error" style="margin-bottom:16px;">
          <i class="fa-solid fa-triangle-exclamation"></i>
          <?php foreach ($errors as $e): ?>
            <div><?= esc($e) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div>
          <label class="form-label" for="full_name">Full Name *</label>
          <input class="form-control" type="text" id="full_name" name="full_name" required maxlength="100" value="<?= esc(old('full_name')) ?>">
        </div>
        <div>
          <label class="form-label" for="email">Email *</label>
          <input class="form-control" type="email" id="email" name="email" required maxlength="150" value="<?= esc(old('email')) ?>">
        </div>
        <div>
          <label class="form-label" for="phone">Phone</label>
          <input class="form-control" type="text" id="phone" name="phone" maxlength="25" value="<?= esc(old('phone')) ?>">
        </div>
        <div>
          <label class="form-label" for="agency_id">Target Agency</label>
          <select class="form-select" id="agency_id" name="agency_id">
            <option value="">— Select agency —</option>
            <?php foreach (($agencies ?? []) as $a): ?>
              <option value="<?= (int) $a['id'] ?>" <?= (int) old('agency_id') === (int) $a['id'] ? 'selected' : '' ?>>
                <?= esc($a['acronym'] ? $a['acronym'] . ' — ' . $a['name'] : $a['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div style="margin-top:14px;">
        <label class="form-label" for="request_title">Request Title *</label>
        <input class="form-control" type="text" id="request_title" name="request_title" required maxlength="255" placeholder="e.g. 2024 Annual Budget Allocation Records" value="<?= esc(old('request_title')) ?>">
      </div>

      <div style="margin-top:14px;">
        <label class="form-label" for="description">Description of Information Requested *</label>
        <textarea class="form-control" id="description" name="description" rows="5" required placeholder="Describe the specific records, documents, or data you are requesting..."><?= esc(old('description')) ?></textarea>
      </div>

      <div style="margin-top:14px;">
        <label class="form-label" for="purpose">Purpose</label>
        <input class="form-control" type="text" id="purpose" name="purpose" maxlength="255" placeholder="e.g. Academic research, journalism, public interest..." value="<?= esc(old('purpose')) ?>">
      </div>

      <label style="display:flex;align-items:flex-start;gap:10px;margin-top:18px;color:var(--text-secondary);font-size:0.88rem;line-height:1.5;cursor:pointer;">
        <input type="checkbox" name="consent" value="1" required style="margin-top:3px;">
        <span>I consent to the processing of my personal data per <strong>RA 10173 (Data Privacy Act)</strong> for the purpose of this FOI request.</span>
      </label>

      <button class="btn btn-primary mt-3" type="submit" style="width:100%;justify-content:center;"><i class="fa-solid fa-paper-plane"></i> Submit FOI Request</button>
    </form>

    <aside style="display:flex;flex-direction:column;gap:18px;">
      <div class="glass-card" style="padding:22px;">
        <h3 style="font-family:var(--font-head);font-size:1.05rem;color:var(--gold);margin-bottom:10px;"><i class="fa-solid fa-circle-info"></i> What is FOI?</h3>
        <p style="color:var(--text-secondary);font-size:0.9rem;line-height:1.6;">The Freedom of Information program was established by Executive Order No. 2 (2016). It grants every Filipino the right to request information from Executive branch agencies.</p>
      </div>

      <div class="glass-card" style="padding:22px;">
        <h3 style="font-family:var(--font-head);font-size:1.05rem;color:var(--cyan);margin-bottom:10px;"><i class="fa-solid fa-clock"></i> Response Time</h3>
        <p style="color:var(--text-secondary);font-size:0.9rem;line-height:1.6;">Agencies must respond within <strong style="color:var(--text-primary);">15 working days</strong> from receipt. Extensions may apply for voluminous or complex requests.</p>
      </div>

      <div class="glass-card" style="padding:22px;">
        <h3 style="font-family:var(--font-head);font-size:1.05rem;color:var(--text-primary);margin-bottom:10px;"><i class="fa-solid fa-lightbulb"></i> Common Requests</h3>
        <ul style="list-style:none;padding:0;margin:0;color:var(--text-secondary);font-size:0.85rem;line-height:1.9;">
          <li>&middot; Budget &amp; expenditure reports</li>
          <li>&middot; Public works project status</li>
          <li>&middot; Statistical &amp; demographic data</li>
          <li>&middot; Agency rules &amp; regulations</li>
          <li>&middot; Procurement &amp; contract records</li>
        </ul>
        <a href="https://www.foi.gov.ph" target="_blank" rel="noopener" style="color:var(--cyan);font-size:0.85rem;display:inline-block;margin-top:10px;">Visit foi.gov.ph &rarr;</a>
      </div>
    </aside>
  </div>
</section>
<?php
$content = ob_get_clean();
echo view('layouts/main', ['title' => $title ?? null, 'content' => $content]);
