<?php
helper('form_antispam');
$antispam = form_antispam_prepare($form_key ?? 'default');
$compact = ! empty($compact);
$footer = ! empty($footer);

if ($footer): ?>
<div class="srl-form-antispam-hp" aria-hidden="true">
  <label for="company_website_<?= esc($antispam['form_key'], 'attr') ?>">Company website</label>
  <input type="text" name="company_website" id="company_website_<?= esc($antispam['form_key'], 'attr') ?>" value="" tabindex="-1" autocomplete="off">
</div>
<div class="footer-captcha-block">
  <label class="form-label footer-field-label" for="antispam_captcha_<?= esc($antispam['form_key'], 'attr') ?>">Security check <span class="text-danger">*</span></label>
  <div class="input-group footer-captcha-group">
    <span class="input-group-text footer-captcha-eq" aria-hidden="true"><?= esc($antispam['captcha_prompt']) ?></span>
    <input type="text"
           name="antispam_captcha"
           id="antispam_captcha_<?= esc($antispam['form_key'], 'attr') ?>"
           class="form-control footer-captcha-answer"
           required
           inputmode="numeric"
           pattern="[0-9]*"
           maxlength="3"
           autocomplete="off"
           placeholder="Answer"
           aria-describedby="antispam_captcha_help_<?= esc($antispam['form_key'], 'attr') ?>">
  </div>
  <div class="invalid-feedback footer-field-error">Please answer the security question correctly.</div>
  <span id="antispam_captcha_help_<?= esc($antispam['form_key'], 'attr') ?>" class="visually-hidden">Enter the result of the math question.</span>
</div>
<?php return; endif; ?>

<div class="srl-form-antispam-hp" aria-hidden="true">
  <label for="company_website_<?= esc($antispam['form_key'], 'attr') ?>">Company website</label>
  <input type="text" name="company_website" id="company_website_<?= esc($antispam['form_key'], 'attr') ?>" value="" tabindex="-1" autocomplete="off">
</div>
<div class="<?= $compact ? 'srl-antispam-compact mt-2' : 'mb-3' ?>">
  <label class="form-label" for="antispam_captcha_<?= esc($antispam['form_key'], 'attr') ?>">Security check <span class="text-danger">*</span></label>
  <div class="d-flex flex-wrap align-items-start gap-2">
    <span class="srl-captcha-prompt"><?= esc($antispam['captcha_prompt']) ?></span>
    <div class="srl-field-wrap">
      <input type="text"
             name="antispam_captcha"
             id="antispam_captcha_<?= esc($antispam['form_key'], 'attr') ?>"
             class="form-control srl-captcha-input"
             required
             inputmode="numeric"
             pattern="[0-9]*"
             maxlength="3"
             autocomplete="off"
             aria-describedby="antispam_captcha_help_<?= esc($antispam['form_key'], 'attr') ?>">
      <div class="invalid-feedback">Please answer the security question correctly.</div>
    </div>
  </div>
  <div id="antispam_captcha_help_<?= esc($antispam['form_key'], 'attr') ?>" class="form-text">Solve the simple math question to verify you are not a robot.</div>
</div>
