<?php
$page_home = is_array($page_home ?? null) ? $page_home : [];
$page_home_lang_independent = is_array($page_home_lang_independent ?? null) ? $page_home_lang_independent : [];

if (($page_home_lang_independent['counter_status'] ?? 'Show') === 'Hide') {
    return;
}

$home_stats = peak_home_stats($page_home);
?>
  <div class="stats-bar">
    <div class="container">
      <div class="row gy-3">
        <?php foreach ($home_stats as $stat): ?>
        <div class="col-6 col-md-4 col-lg">
          <div class="stat-item">
            <span class="stat-icon">
              <img src="<?= peak_img($stat['icon']) ?>" alt="">
            </span>
            <span>
              <span class="stat-value"><?= cms_text($stat['value']) ?></span>
              <span class="stat-label"><?= cms_text($stat['label']) ?></span>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
