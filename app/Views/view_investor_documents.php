<?php
$category = $investor_category ?? [];
$parent = $parent_category ?? null;
$categoryName = $category['category_name'] ?? 'Documents';
$docCount = (int) ($category['document_count'] ?? 0);
$defaultYear = (string) ($default_year ?? '');

$hero_breadcrumb = [
    ['label' => 'Investor Relations', 'url' => base_url('investor-relations')],
];
if ($parent) {
    $hero_breadcrumb[] = ['label' => $parent['category_name'], 'url' => investor_category_url($parent)];
}
$hero_breadcrumb[] = ['label' => $categoryName];

$hero_title = $hero_title ?? $categoryName;
$hero_label = 'Investor Documents';
$hero_lead = 'Filter by year and document type to find and download the files you need.';
$hero_stats = [
    ['value' => $docCount > 0 ? (string) $docCount : '—', 'label' => $docCount === 1 ? 'Document' : 'Documents'],
    ['value' => $defaultYear !== '' ? $defaultYear : 'Latest', 'label' => 'Default Year'],
];
echo view('includes/investor_hero', get_defined_vars());
?>

<section class="section section-inner-content investor-relations-section investor-documents-page">
  <div class="container">
    <?= view('includes/investor_documents_panel', get_defined_vars()) ?>
  </div>
</section>
