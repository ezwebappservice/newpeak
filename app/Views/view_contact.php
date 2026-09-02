<?php
helper(['form', 'form_ui']);
$email = peak_site_email($setting ?? []);
$phone = peak_site_phone($setting ?? []);
$phoneHref = peak_site_phone_href($setting ?? []);
$pc = $page_contact ?? [];
$displayEmail = trim((string) ($pc['contact_email'] ?? '')) ?: $email;
$displayPhone = trim((string) ($pc['contact_phone'] ?? '')) ?: $phone;
$displayPhoneHref = preg_replace('/[^\d+]/', '', $displayPhone) ?: $phoneHref;
$interests = [
    'Student programme',
    'Parent programme',
    'School partnership',
    'Corporate partnership',
    'Other',
];
?>
<main>
  <section class="inner-page-hero">
    <div class="container">
      <p class="inner-page-eyebrow">Let’s start a conversation</p>
      <h1><?= esc($pc['contact_heading'] ?? 'Contact Us') ?></h1>
      <p><?= esc($pc['contact_intro'] ?? 'Tell us a little about your goals, and our team will be in touch.') ?></p>
    </div>
  </section>
  <section class="contact-section section-space">
    <div class="container">
      <div class="row g-4 g-lg-5 align-items-stretch">
        <div class="col-lg-5">
          <aside class="contact-details">
            <p class="inner-page-eyebrow">Get in touch</p>
            <h2>We’d love to hear from you.</h2>
            <p>Whether you are a student, parent, school or organisation, we can help you find the right next step.</p>
            <div class="contact-item">
              <strong>Email</strong>
              <a href="mailto:<?= esc($displayEmail) ?>"><?= esc($displayEmail) ?></a>
            </div>
            <div class="contact-item">
              <strong>Phone</strong>
              <a href="tel:<?= esc($displayPhoneHref) ?>"><?= esc($displayPhone) ?></a>
            </div>
            <div class="contact-item">
              <strong>Hours</strong>
              <span>Monday–Friday, 9:00 AM–6:00 PM</span>
            </div>
          </aside>
        </div>
        <div class="col-lg-7">
          <?= form_open(base_url('contact-us/send'), ['class' => 'contact-form', 'id' => 'contact-form']) ?>
            <h2>Send us a message</h2>
            <?= view('includes/form_flash_alerts', ['flash_key' => 'connect_form_error', 'success_key' => 'connect_form_success']) ?>
            <div class="contact-form-grid">
              <label>Full Name<input type="text" name="name" value="<?= esc(form_old_value('name')) ?>" required></label>
              <label>Email Address<input type="email" name="email" value="<?= esc(form_old_value('email')) ?>" required></label>
              <label>Phone Number<input type="tel" name="phone" value="<?= esc(form_old_value('phone')) ?>"></label>
              <label>I am interested in
                <select name="interest">
                  <option value="">Please select</option>
                  <?php foreach ($interests as $interest): ?>
                  <option value="<?= esc($interest) ?>"<?= form_old_value('interest') === $interest ? ' selected' : '' ?>><?= esc($interest) ?></option>
                  <?php endforeach; ?>
                </select>
              </label>
              <label class="contact-form-full">Message<textarea name="message" rows="5" required placeholder="How can we help?"><?= esc(form_old_value('message')) ?></textarea></label>
            </div>
            <?= view('includes/form_antispam_fields', ['form_key' => 'contact_inquiry', 'compact' => true]) ?>
            <button type="submit" class="contact-submit" name="form_contact" value="1">Send Message <span>&rarr;</span></button>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </section>
</main>
