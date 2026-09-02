<?php
$category = $investor_category ?? [];
$parentName = $category['category_name'] ?? 'Investor Category';
$subCategories = $sub_categories ?? [];
$sectionCount = (int) ($section_count ?? count($subCategories));
$totalDocuments = (int) ($total_documents ?? 0);
$gridClass = count($subCategories) === 1 ? 'col-lg-8 col-xl-7' : 'col-md-6 col-lg-4';

$hero_title = $hero_title ?? $parentName;
$hero_label = 'Investor Relations';
$hero_lead = 'Browse regulatory disclosures, reports and downloadable documents for shareholders and investors.';
$hero_breadcrumb = [
    ['label' => 'Investor Relations', 'url' => base_url('investor-relations')],
    ['label' => $parentName],
];
$hero_stats = [
    ['value' => $sectionCount, 'label' => $sectionCount === 1 ? 'Section' : 'Sections'],
    ['value' => $totalDocuments, 'label' => $totalDocuments === 1 ? 'Document' : 'Documents'],
];
echo view('includes/investor_hero', get_defined_vars());
?>

<section class="section section-inner-content investor-relations-section investor-category-page">
  <div class="container">
    <div class="investor-category-header reveal" data-reveal>
      <div class="row align-items-end g-4">
        <div class="col-lg-12">
          <span class="section-label">Document Sections</span>
          <h2 class="section-title mb-2"><?= cms_text($parentName) ?></h2>
          <p class="section-subtitle mb-0">Select a section below to view and download related investor documents.</p>
        </div>
      </div>
    </div>

    <?php if ($subCategories === []): ?>
      <div class="investor-empty-state reveal" data-reveal>
        <div class="investor-empty-icon"><i class="bi bi-inbox"></i></div>
        <h3>No sections available yet</h3>
        <p>Documents for this category will appear here once they are published.</p>
        <a href="<?= base_url('investor-relations') ?>" class="btn btn-primary">Back to Investor Relations</a>
      </div>
    <?php else: ?>
      <div class="row g-4 investor-category-grid justify-content-center">
        <?php foreach ($subCategories as $index => $child): ?>
          <?php
            $docCount = (int) ($child['document_count'] ?? 0);
            $icon = investor_category_icon($child);
            $blurb = investor_category_blurb($child);
            $countLabel = investor_document_count_label($docCount);
          ?>
          <div class="<?= cms_attr($gridClass) ?> reveal" data-reveal<?= $index > 0 ? ' data-reveal-delay="' . min($index * 80, 320) . '"' : '' ?>>
            <a href="<?= cms_attr(investor_documents_url($child)) ?>" class="investor-section-card h-100">
              <div class="investor-section-card-accent"></div>
              <div class="investor-section-card-top">
                <span class="investor-section-card-icon"><i class="bi <?= cms_attr($icon) ?>"></i></span>
                <span class="investor-section-card-badge"><?= cms_text($countLabel) ?></span>
              </div>
              <div class="investor-section-card-body">
                <h3><?= cms_text($child['category_name']) ?></h3>
                <p><?= cms_text($blurb) ?></p>
              </div>
              <div class="investor-section-card-footer">
                <span class="investor-section-card-link">View Documents <i class="bi bi-arrow-right"></i></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="investor-category-back reveal" data-reveal>
      <a href="<?= base_url('investor-relations') ?>" class="investor-back-link">
        <i class="bi bi-arrow-left"></i> Back to all investor categories
      </a>
    </div>
  </div>
</section>
