<?php
helper('form_ui');
$pc = $page_contact ?? [];
$phone = trim($pc['contact_phone'] ?? '');
$email = trim($pc['contact_email'] ?? '');
$website = trim($pc['contact_website'] ?? '');
?>
<section class="inner-page-hero banner-slider srl-contact-hero" style="background-image: url(<?= theme_upload($setting['banner_contact'] ?? '', theme_asset('images/hero-bg.jpg')) ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= esc($pc['contact_heading'] ?? 'Contact Us') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content srl-connect-section">
  <div class="container">
    <div class="srl-page-intro text-center reveal" data-reveal>
      <?php if (! empty($pc['contact_subtitle'])): ?>
      <h2 class="srl-page-title"><?= esc($pc['contact_subtitle']) ?></h2>
      <?php endif; ?>
      <?php if (! empty($pc['contact_intro'])): ?>
      <p class="srl-lead"><?= esc($pc['contact_intro']) ?></p>
      <?php endif; ?>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-lg-6 reveal" data-reveal>
        <div class="srl-contact-card h-100">
          <h3><i class="bi bi-building"></i> Corporate Office</h3>
          <ul class="srl-contact-details">
            <?php if (! empty($pc['contact_address'])): ?>
            <li>
              <i class="bi bi-geo-alt-fill"></i>
              <span><?= cms_multiline($pc['contact_address']) ?></span>
            </li>
            <?php endif; ?>
            <?php if ($phone !== ''): ?>
            <li>
              <i class="bi bi-telephone-fill"></i>
              <a href="tel:<?= esc(preg_replace('/\s+/', '', $phone), 'attr') ?>"><?= esc($phone) ?></a>
            </li>
            <?php endif; ?>
            <?php if ($email !== ''): ?>
            <li>
              <i class="bi bi-envelope-fill"></i>
              <a href="mailto:<?= esc($email, 'attr') ?>"><?= esc($email) ?></a>
            </li>
            <?php endif; ?>
            <?php if ($website !== ''): ?>
            <li>
              <i class="bi bi-globe2"></i>
              <a href="https://<?= esc(ltrim($website, '/'), 'attr') ?>" target="_blank" rel="noopener"><?= esc($website) ?></a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="col-lg-6 reveal" data-reveal data-reveal-delay="100">
        <div class="srl-contact-card h-100">
          <h3><i class="bi bi-question-circle"></i> Have a Question</h3>
          <?php if (! empty($pc['contact_hours'])): ?>
          <div class="srl-contact-hours"><?= cms_multiline($pc['contact_hours']) ?></div>
          <?php else: ?>
          <p>For any queries, please connect on mail or phone.</p>
          <?php if ($phone !== ''): ?>
          <p><strong>Phone:</strong> <a href="tel:<?= esc(preg_replace('/\s+/', '', $phone), 'attr') ?>"><?= esc($phone) ?></a></p>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php if (! empty($locations)): ?>
    <div class="srl-contact-facilities reveal" data-reveal>
      <h3 class="srl-section-heading text-center">Works, Shivalik Rasayan Limited</h3>
      <div class="row g-4">
        <?php foreach ($locations as $loc): ?>
        <div class="col-md-4">
          <div class="srl-facility-card h-100">
            <h4><?= esc($loc['title']) ?></h4>
            <p><?= cms_multiline($loc['address']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="row g-5 mt-2">
      <div class="col-lg-8 reveal" data-reveal>
        <div class="contact-form-wrap srl-connect-form-wrap">
          <h3 class="mb-4">Reach Us</h3>
          <?= view('includes/form_flash_alerts', ['flash_key' => 'connect_form_error', 'success_key' => 'connect_form_success']) ?>
          <p class="form-required-note small text-muted mb-3"><span class="text-danger">*</span> Required fields</p>
          <?= form_open(base_url('contact/send_email'), ['class' => 'contact-form needs-validation', 'id' => 'connectForm', 'data-server-form' => '1', 'novalidate' => 'novalidate']) ?>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="connect_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="connect_first_name" name="first_name" value="<?= esc(form_old_value('first_name')) ?>" required maxlength="80" autocomplete="given-name">
              <div class="invalid-feedback">First name is required.</div>
            </div>
            <div class="col-md-6">
              <label for="connect_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="connect_last_name" name="last_name" value="<?= esc(form_old_value('last_name')) ?>" required maxlength="80" autocomplete="family-name">
              <div class="invalid-feedback">Last name is required.</div>
            </div>
            <div class="col-12">
              <label for="connect_email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="connect_email" name="email" value="<?= esc(form_old_value('email')) ?>" required maxlength="255" autocomplete="email">
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="col-12">
              <label for="connect_message" class="form-label">Comment or Message <span class="text-danger">*</span></label>
              <textarea class="form-control" id="connect_message" name="message" rows="5" required maxlength="5000"><?= esc(form_old_value('message')) ?></textarea>
              <div class="invalid-feedback">Message is required.</div>
            </div>

            <div class="col-12">
              <?= view('includes/form_antispam_fields', ['form_key' => 'contact_inquiry']) ?>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-lg" name="form_contact">Submit</button>
            </div>
          </div>
          <?= form_close() ?>
        </div>
      </div>

      <div class="col-lg-4 reveal" data-reveal data-reveal-delay="100">
        <aside class="srl-sidebar-card srl-connect-news">
          <h4>Latest News</h4>
          <?php if (empty($latest_news)): ?>
          <p class="text-muted mb-0">No news articles yet.</p>
          <?php else: ?>
          <ul class="srl-recent-news-list">
            <?php foreach ($latest_news as $news): ?>
            <li>
              <a href="<?= esc(news_url($news['news_slug'] ?? ''), 'attr') ?>">
                <span class="srl-recent-title"><?= esc($news['news_title']) ?></span>
                <?php if (! empty($news['news_date'])): ?>
                <span class="srl-recent-date"><?= esc(news_format_date($news['news_date'], 'F j, Y')) ?></span>
                <?php endif; ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
          <a href="<?= news_url() ?>" class="btn btn-outline-primary btn-sm mt-3 w-100">View All News</a>
          <?php endif; ?>
        </aside>
      </div>
    </div>

    <?php if (! empty($pc['contact_map'])): ?>
    <div class="srl-contact-map mt-5 reveal" data-reveal>
      <?= $pc['contact_map'] ?>
    </div>
    <?php endif; ?>
  </div>
</section>
