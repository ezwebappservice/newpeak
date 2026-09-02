<main>
  <section class="inner-page-hero">
    <div class="container">
      <p class="inner-page-eyebrow">Peak Potential Academy</p>
      <h1><?= esc($page_privacy['privacy_heading'] ?? 'Privacy Policy') ?></h1>
      <p>How we collect, use and protect your information.</p>
    </div>
  </section>
  <section class="legal-content section-space">
    <div class="container">
      <div class="legal-paper">
        <?php if (! empty($page_privacy['privacy_content']) && stripos((string) $page_privacy['privacy_content'], 'Shivalik') === false): ?>
          <?= $page_privacy['privacy_content'] ?>
        <?php else: ?>
          <p class="legal-updated">Last updated: August 21, 2026</p>
          <h2>Your Privacy Matters</h2>
          <p>This policy explains how Peak Potential Academy handles personal information collected through this website and our services.</p>
          <h3>1. Information We Collect</h3>
          <p>We may collect contact details, enquiry information, booking details and information you choose to share with us.</p>
          <h3>2. How We Use Information</h3>
          <p>We use information to respond to enquiries, provide our programmes, and improve the experience of students, parents, schools and organisations we serve.</p>
          <h3>3. Cookies and Website Data</h3>
          <p>Cookies may help us understand how visitors use this site and keep forms working securely.</p>
          <h3>4. Sharing Your Information</h3>
          <p>We do not sell personal information. We only share data where necessary to provide services, comply with legal obligations or with your consent.</p>
          <h3>5. Data Security</h3>
          <p>We use reasonable measures to protect your information, although no online system can be completely secure.</p>
          <h3>6. Your Choices</h3>
          <p>You may ask to access, correct or delete your personal information, subject to applicable legal requirements.</p>
          <h3>7. Updates to This Policy</h3>
          <p>We may revise this policy occasionally and will post the latest version here.</p>
          <h3>8. Contact Us</h3>
          <p>For privacy questions or requests, please <a href="<?= base_url('contact-us') ?>">contact us</a>.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
