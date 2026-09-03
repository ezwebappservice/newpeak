<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="navbar-brand d-flex align-items-center logo-footer" href="<?= base_url() ?>">
          <img class="brand-logo" src="<?= esc($logo_url) ?>" alt="Peak Potential Academy logo">
        </a>
        <p>Unlock. Empower. Thrive.</p>
        <div class="social-links">
          <a href="<?= esc($instagram_url) ?>" aria-label="Instagram"<?= $instagram_url !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
            <img src="<?= peak_img('instagram.png') ?>" alt="">
          </a>
          <a href="<?= esc($linkedin_url) ?>" aria-label="LinkedIn"<?= $linkedin_url !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
            <img src="<?= peak_img('linkedin-logo.png') ?>" alt="">
          </a>
          <a href="<?= esc($youtube_url) ?>" aria-label="YouTube"<?= $youtube_url !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
            <img src="<?= peak_img('youtube.png') ?>" alt="">
          </a>
          <a href="<?= esc($facebook_url) ?>" aria-label="Facebook"<?= $facebook_url !== '#' ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
            <img src="<?= peak_img('facebook-app-symbol.png') ?>" alt="">
          </a>
        </div>
      </div>
      <div class="footer-links">
        <h3>Programs</h3>
        <a href="<?= base_url('for-students') ?>">For Students</a>
        <a href="<?= base_url('for-parents') ?>">For Parents</a>
        <a href="<?= base_url('for-school') ?>">For Schools</a>
        <a href="<?= base_url('for-corporate') ?>">For Corporates</a>
      </div>
      <div class="footer-links">
        <h3>Quick Links</h3>
        <a href="<?= base_url('our-story') ?>">About Us</a>
        <a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a>
        <a href="<?= base_url('terms-and-conditions') ?>">Terms &amp; Conditions</a>
        <a href="<?= base_url('contact-us') ?>">Contact Us</a>
      </div>
      <div class="footer-contact">
        <h3>Get in Touch</h3>
        <?php if ($site_email !== ''): ?>
        <a href="mailto:<?= esc($site_email) ?>">✉ &nbsp;<?= esc($site_email) ?></a>
        <?php endif; ?>
        <?php if ($site_phone !== ''): ?>
        <a href="tel:<?= esc($site_phone_href) ?>">⌕ &nbsp;<?= esc($site_phone) ?></a>
        <?php endif; ?>
        <a href="<?= peak_enquiry_url() ?>" class="footer-cta">Book a Demo</a>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> Peak Potential Academy. All Rights Reserved.</span>
      <span><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a><i>|</i><a href="<?= base_url('terms-and-conditions') ?>">Terms &amp; Conditions</a></span>
    </div>
  </div>
</footer>

<?php
$toastSuccess = session()->getFlashdata('success');
$toastError = session()->getFlashdata('error');
$showToast = ($toastSuccess && ! is_array($toastSuccess)) || ($toastError && ! is_array($toastError));
?>
<?php if ($showToast): ?>
<div class="flash-toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
  <?php if ($toastSuccess && ! is_array($toastSuccess)): ?>
  <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
    <?= esc($toastSuccess) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>
  <?php if ($toastError && ! is_array($toastError)): ?>
  <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
    <?= esc($toastError) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="<?= theme_asset('js/peak.js') ?>"></script>

<?php if (($setting['tawk_live_chat_status'] ?? 'Off') === 'On'): ?>
<?= $setting['tawk_live_chat_code'] ?? '' ?>
<?php endif; ?>
</body>
</html>
