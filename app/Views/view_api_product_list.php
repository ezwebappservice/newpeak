<?php
$page = $page_dynamic_detail ?? [];
$banner = page_dynamic_banner($page['banner'] ?? '');
$products = $api_products ?? [];
?>
<section class="inner-page-hero banner-slider" style="background-image: url(<?= cms_attr($banner) ?>)">
  <div class="bg"></div>
  <div class="bannder-table">
    <div class="banner-text">
      <h1><?= cms_text($page['name'] ?? 'API Products') ?></h1>
    </div>
  </div>
</section>

<section class="section section-inner-content">
  <div class="container">
    <div class="dynamic-page-content cms-content reveal" data-reveal>
      <?= cms_page_content($page['content'] ?? '') ?>
    </div>

    <?php if ($products !== []): ?>
      <div class="srl-api-product-table-wrap reveal mt-4" data-reveal>
        <div class="table-responsive">
          <table class="table table-bordered table-striped srl-api-product-table">
            <thead>
              <tr>
                <th>S.No.</th>
                <th>Product Name</th>
                <th>Therapeutic Category</th>
                <th>US DMF</th>
                <th>EU Status / CEP</th>
                <th>Patent Status</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $index => $product): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><strong><?= cms_text($product['product_name']) ?></strong></td>
                  <td><?= cms_text($product['therapeutic_category'] ?: '—') ?></td>
                  <td><?= cms_text($product['us_dmf'] ?: '—') ?></td>
                  <td><?= cms_text($product['eu_status'] ?: '—') ?></td>
                  <td><?= cms_text($product['patent_status'] ?: '—') ?></td>
                  <td><?= cms_text($product['remarks'] ?: '—') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-info mt-4 reveal" data-reveal>
        Product list will be published here soon. Please check back later.
      </div>
    <?php endif; ?>
  </div>
</section>
