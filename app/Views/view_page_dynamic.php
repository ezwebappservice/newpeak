<?php
$page = $page_dynamic_detail ?? [];
$banner = page_dynamic_banner($page['banner'] ?? '');
?>
<section class="inner-page-hero banner-slider" style="background-image: url(<?= cms_attr($banner) ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= esc($page['name'] ?? '') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="dynamic-page-content cms-content">
          <?= cms_page_content($page['content'] ?? '') ?>
        </div>
      </div>
    </div>
  </div>
</section>
