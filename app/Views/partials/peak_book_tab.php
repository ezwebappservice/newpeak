<?php
$hero = peak_home_hero($page_home ?? [], $page_home_lang_independent ?? []);
$tabText = trim((string) ($hero['tab_text'] ?? '')) ?: 'Book ₹599 Session';
$tabUrl = peak_enquiry_url();
?>
<a href="<?= cms_attr($tabUrl) ?>" class="hero-book-tab" aria-label="<?= cms_attr($tabText) ?>">
  <span class="phone-icon">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.12.9.35 1.78.68 2.61a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.47-1.27a2 2 0 012.11-.45c.83.33 1.71.56 2.61.68A2 2 0 0122 16.92z"/></svg>
  </span>
  <span class="tab-text"><?= cms_text($tabText) ?></span>
</a>
