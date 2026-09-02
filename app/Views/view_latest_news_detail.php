<?php
$item = $news_detail ?? [];
$banner = ! empty($item['banner']) ? theme_upload($item['banner']) : theme_asset('images/hero-bg.jpg');
?>
<section class="inner-page-hero banner-slider srl-news-detail-hero" style="background-image: url(<?= esc($banner, 'attr') ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <nav class="srl-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= base_url() ?>">Home</a>
        <span>/</span>
        <a href="<?= news_url() ?>">News</a>
      </nav>
      <h1><?= esc($item['news_title'] ?? '') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content srl-news-detail">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <article class="srl-news-article reveal" data-reveal>
          <div class="srl-news-meta">
            <?php if (! empty($item['category_name'])): ?>
            <span class="news-tag"><?= esc($item['category_name']) ?></span>
            <?php endif; ?>
            <?php if (! empty($item['news_date'])): ?>
            <span class="srl-news-meta-date"><i class="bi bi-calendar3"></i> Published <?= esc(news_format_date($item['news_date'])) ?></span>
            <?php endif; ?>
            <span class="srl-news-meta-author"><i class="bi bi-person"></i> Team SRL</span>
          </div>

          <?php if (! empty($item['photo'])): ?>
          <div class="srl-news-featured-image">
            <img src="<?= theme_upload($item['photo']) ?>" alt="<?= esc($item['news_title'] ?? '') ?>" class="img-fluid rounded-4 shadow">
          </div>
          <?php endif; ?>

          <div class="srl-news-content cms-content dynamic-page-content">
            <?= cms_html($item['news_content'] ?? '') ?>
          </div>

          <div class="srl-news-share">
            <h4>Share this article</h4>
            <?php $shareUrl = news_url($item['news_slug'] ?? ''); ?>
            <div class="srl-share-buttons">
              <a class="srl-share-btn facebook" target="_blank" rel="noopener"
                 href="https://www.facebook.com/sharer.php?u=<?= urlencode($shareUrl) ?>&t=<?= urlencode($item['news_title'] ?? '') ?>"
                 aria-label="Share on Facebook"><i class="bi bi-facebook"></i></a>
              <a class="srl-share-btn twitter" target="_blank" rel="noopener"
                 href="https://twitter.com/share?text=<?= urlencode($item['news_title'] ?? '') ?>&url=<?= urlencode($shareUrl) ?>"
                 aria-label="Share on Twitter"><i class="bi bi-twitter-x"></i></a>
              <a class="srl-share-btn linkedin" target="_blank" rel="noopener"
                 href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($shareUrl) ?>&title=<?= urlencode($item['news_title'] ?? '') ?>"
                 aria-label="Share on LinkedIn"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="mt-4">
            <a href="<?= news_url() ?>" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Back to News</a>
          </div>
        </article>
      </div>

      <div class="col-lg-4">
        <aside class="srl-news-sidebar reveal" data-reveal data-reveal-delay="100">
          <div class="srl-sidebar-card">
            <h4>Recent Updates</h4>
            <?php if (empty($recent_news)): ?>
            <p class="text-muted mb-0">No other articles yet.</p>
            <?php else: ?>
            <ul class="srl-recent-news-list">
              <?php foreach ($recent_news as $recent): ?>
              <li>
                <a href="<?= esc(news_url($recent['news_slug'] ?? ''), 'attr') ?>">
                  <span class="srl-recent-date"><?= esc(news_format_date($recent['news_date'] ?? '', 'M j, Y')) ?></span>
                  <span class="srl-recent-title"><?= esc($recent['news_title']) ?></span>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
