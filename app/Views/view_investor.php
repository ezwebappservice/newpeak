<?php
$parents = $investor_parents ?? ($investor_groups['parents'] ?? []);
$groups = $investor_groups ?? [];
$categoryCount = (int) ($category_count ?? count($parents));
$totalDocuments = (int) ($total_documents ?? 0);

$hero_title = $hero_title ?? 'Investor Relations';
$hero_label = 'Shareholders & Investors';
$hero_lead = 'Access financial reports, governance disclosures, shareholder information and regulatory filings for Shivalik Rasayan Limited.';
$hero_stats = [
    ['value' => $categoryCount, 'label' => $categoryCount === 1 ? 'Category' : 'Categories'],
    ['value' => $totalDocuments, 'label' => $totalDocuments === 1 ? 'Document' : 'Documents'],
];
echo view('includes/investor_hero', get_defined_vars());
?>

<section class="section section-inner-content investor-relations-section investor-landing-page">
  <div class="container">
    <div class="investor-landing-highlights reveal" data-reveal>
      <div class="row g-3">
        <div class="col-md-4">
          <div class="investor-highlight-item">
            <span class="investor-highlight-icon"><i class="bi bi-file-earmark-text"></i></span>
            <div>
              <strong>Financial Reports</strong>
              <span>Annual reports, quarterly results and presentations</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="investor-highlight-item">
            <span class="investor-highlight-icon"><i class="bi bi-shield-check"></i></span>
            <div>
              <strong>Governance</strong>
              <span>Policies, board disclosures and compliance filings</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="investor-highlight-item">
            <span class="investor-highlight-icon"><i class="bi bi-people"></i></span>
            <div>
              <strong>Shareholder Info</strong>
              <span>Shareholding pattern, notices and announcements</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="investor-category-header reveal" data-reveal>
      <div class="row align-items-end g-4">
        <div class="col-lg-12">
          <span class="section-label">Investor Centre</span>
          <h2 class="section-title mb-2">Browse by Category</h2>
          <p class="section-subtitle mb-0">Choose a category below to explore downloadable documents and regulatory disclosures.</p>
        </div>
      </div>
    </div>

    <?php if ($parents === []): ?>
      <div class="investor-empty-state reveal" data-reveal>
        <div class="investor-empty-icon"><i class="bi bi-inbox"></i></div>
        <h3>No investor categories yet</h3>
        <p>Investor documents will appear here once categories are published in the admin panel.</p>
      </div>
    <?php else: ?>
      <div class="row g-4 investor-category-grid">
        <?php foreach ($parents as $index => $parent): ?>
          <?php
            $parentId = (int) $parent['id'];
            $children = $groups['children'][$parentId] ?? [];
            $cardUrl = $children !== []
              ? investor_category_url($parent)
              : investor_documents_url($parent);
            $icon = investor_category_icon($parent);
            $blurb = investor_category_blurb($parent);
            $badge = investor_parent_category_badge($parent);
            $cta = investor_parent_category_cta($parent);
          ?>
          <div class="col-md-6 col-lg-4 reveal" data-reveal<?= $index > 0 ? ' data-reveal-delay="' . min($index * 70, 350) . '"' : '' ?>>
            <a href="<?= cms_attr($cardUrl) ?>" class="investor-section-card h-100">
              <div class="investor-section-card-accent"></div>
              <div class="investor-section-card-top">
                <span class="investor-section-card-icon"><i class="bi <?= cms_attr($icon) ?>"></i></span>
                <span class="investor-section-card-badge"><?= cms_text($badge) ?></span>
              </div>
              <div class="investor-section-card-body">
                <h3><?= cms_text($parent['category_name']) ?></h3>
                <p><?= cms_text($blurb) ?></p>
              </div>
              <div class="investor-section-card-footer">
                <span class="investor-section-card-link"><?= cms_text($cta) ?> <i class="bi bi-arrow-right"></i></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
