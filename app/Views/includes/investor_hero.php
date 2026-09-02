<?php
$heroTitle = $hero_title ?? 'Investor Relations';
$heroLabel = $hero_label ?? 'Investor Relations';
$heroLead = $hero_lead ?? '';
$heroBreadcrumb = $hero_breadcrumb ?? [];
$heroStats = $hero_stats ?? [];
?>
<section class="inner-page-hero banner-slider investor-hero">
  <div class="investor-hero-bg" style="background-image: url(<?= theme_asset('images/hero-bg.jpg') ?>)"></div>
  <div class="investor-hero-overlay"></div>
  <div class="investor-hero-pattern" aria-hidden="true"></div>
  <div class="investor-hero-glow investor-hero-glow-1" aria-hidden="true"></div>
  <div class="investor-hero-glow investor-hero-glow-2" aria-hidden="true"></div>

  <div class="bannder-table">
    <div class="banner-text investor-hero-content">
      <?php if ($heroBreadcrumb !== []): ?>
        <nav aria-label="breadcrumb" class="investor-hero-breadcrumb">
          <ol class="breadcrumb">
            <?php foreach ($heroBreadcrumb as $index => $crumb): ?>
              <?php if (! empty($crumb['url']) && $index < count($heroBreadcrumb) - 1): ?>
                <li class="breadcrumb-item"><a href="<?= cms_attr($crumb['url']) ?>"><?= cms_text($crumb['label']) ?></a></li>
              <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page"><?= cms_text($crumb['label']) ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ol>
        </nav>
      <?php endif; ?>

      <span class="investor-hero-label"><?= cms_text($heroLabel) ?></span>
      <h1><?= cms_text($heroTitle) ?></h1>

      <?php if ($heroLead !== ''): ?>
        <p class="investor-hero-lead"><?= cms_text($heroLead) ?></p>
      <?php endif; ?>

      <?php if ($heroStats !== []): ?>
        <div class="investor-hero-stats">
          <?php foreach ($heroStats as $stat): ?>
            <div class="investor-hero-stat">
              <span class="investor-hero-stat-value"><?= cms_text((string) ($stat['value'] ?? '')) ?></span>
              <span class="investor-hero-stat-label"><?= cms_text($stat['label'] ?? '') ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="investor-hero-shape" aria-hidden="true"></div>
</section>
