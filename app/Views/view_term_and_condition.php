<main>
  <section class="inner-page-hero">
    <div class="container">
      <p class="inner-page-eyebrow">Peak Potential Academy</p>
      <h1><?= esc($page_term['term_heading'] ?? 'Terms & Conditions') ?></h1>
      <p>Please read these terms carefully before using our website or services.</p>
    </div>
  </section>
  <section class="legal-content section-space">
    <div class="container">
      <div class="legal-paper">
        <?php if (! empty($page_term['term_content']) && stripos((string) $page_term['term_content'], 'Shivalik') === false): ?>
          <?= $page_term['term_content'] ?>
        <?php else: ?>
          <p class="legal-updated">Last updated: August 21, 2026</p>
          <h2>Welcome to Peak Potential Academy</h2>
          <p>These terms apply to your use of this website and the programmes, sessions and resources offered by Peak Potential Academy.</p>
          <h3>1. Acceptance of Terms</h3>
          <p>By accessing or using this website, you agree to be bound by these terms and all applicable laws.</p>
          <h3>2. Our Services</h3>
          <p>Our programmes, sessions, resources and assessments are designed for education and personal development for students, parents, schools and organisations.</p>
          <h3>3. Bookings and Payments</h3>
          <p>Fees and booking details will be confirmed before a service begins. Please provide accurate information when you enquire or book.</p>
          <h3>4. Your Responsibilities</h3>
          <p>You agree to provide accurate information, use our materials respectfully, and not misuse the website or its content.</p>
          <h3>5. Intellectual Property</h3>
          <p>All website content, programme materials, branding and resources remain the property of Peak Potential Academy unless otherwise stated.</p>
          <h3>6. Limitation of Liability</h3>
          <p>To the extent permitted by law, we are not liable for indirect or consequential loss arising from the use of our services.</p>
          <h3>7. Changes to These Terms</h3>
          <p>We may update these terms from time to time. Continued use of the website after changes are published constitutes acceptance of the updated terms.</p>
          <h3>8. Contact Us</h3>
          <p>If you have questions about these terms, please <a href="<?= base_url('contact-us') ?>">contact us</a>.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
