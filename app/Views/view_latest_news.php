<section class="inner-page-hero banner-slider srl-news-hero" style="background-image: url(<?= theme_asset('images/hero-bg.jpg') ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= esc($page_title ?? 'News') ?></h1>
      <?php if (! empty($page_subtitle)): ?>
      <p class="srl-news-hero-sub"><?= esc($page_subtitle) ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section section-inner-content srl-news-listing">
  <div class="container">
    <?php if (empty($news_items)): ?>
    <div class="srl-news-empty reveal" data-reveal>
      <div class="srl-highlight-box text-center">
        <i class="bi bi-newspaper srl-news-empty-icon"></i>
        <h3>No news articles yet</h3>
        <p>Check back soon for the latest updates from Peak Potential.</p>
      </div>
    </div>
    <?php else: ?>
    <div class="row g-4">
      <?php
      $i = 0;
      foreach ($news_items as $item):
          $i++;
          $fallbacks = ['news-dahej.jpg', 'news-cep.jpg', 'news-usfda.jpg'];
          $fallback = $fallbacks[($i - 1) % count($fallbacks)];
          $url = news_url($item['news_slug'] ?? '');
      ?>
      <div class="col-md-6 col-lg-4 reveal" data-reveal<?= $i > 1 ? ' data-reveal-delay="' . min(($i - 1) * 80, 240) . '"' : '' ?>>
        <article class="news-card h-100">
          <a href="<?= esc($url, 'attr') ?>" class="news-card-link">
            <div class="news-image">
              <img src="<?= theme_upload($item['photo'] ?? '', 'images/' . $fallback) ?>"
                   alt="<?= esc($item['news_title']) ?>" width="600" height="375" loading="lazy">
              <?php if (! empty($item['news_date'])): ?>
              <span class="news-date"><?= esc(news_format_date($item['news_date'], 'M j, Y')) ?></span>
              <?php endif; ?>
            </div>
            <div class="news-body">
              <?php if (! empty($item['category_name'])): ?>
              <span class="news-tag"><?= esc($item['category_name']) ?></span>
              <?php endif; ?>
              <h3><?= esc($item['news_title']) ?></h3>
              <p><?= cms_excerpt($item['news_content_short'] ?? '', 260) ?></p>
              <span class="news-link"><?= defined('READ_MORE') ? READ_MORE : 'Read More' ?> <i class="bi bi-arrow-right"></i></span>
            </div>
          </a>
        </article>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
    <nav class="srl-news-pagination mt-5" aria-label="News pagination">
      <ul class="pagination justify-content-center">
        <?php
        $page = (int) ($pagination['page'] ?? 1);
        $totalPages = (int) ($pagination['total_pages'] ?? 1);
        $base = news_url();
        ?>
        <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="<?= esc($base . '?page=' . ($page - 1), 'attr') ?>"><i class="bi bi-chevron-left"></i></a>
        </li>
        <?php endif; ?>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <li class="page-item<?= $p === $page ? ' active' : '' ?>">
          <a class="page-link" href="<?= esc($base . ($p > 1 ? '?page=' . $p : ''), 'attr') ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link" href="<?= esc($base . '?page=' . ($page + 1), 'attr') ?>"><i class="bi bi-chevron-right"></i></a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
