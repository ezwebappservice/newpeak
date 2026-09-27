<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TJFP3BPH');</script>
  <!-- End Google Tag Manager -->
  <?= view('includes/meta', get_defined_vars()) ?>
  <?= csrf_meta() ?>

  <link rel="preload" as="font" href="<?= base_url('assets/fonts/manrope-latin.woff2') ?>" type="font/woff2" crossorigin>
  <link rel="preload" as="font" href="<?= base_url('assets/fonts/cormorant-garamond-latin.woff2') ?>" type="font/woff2" crossorigin>
  <?php
  $heroPreloadUrl = '';
  if (theme_is_home()) {
      $heroPreloadUrl = peak_home_hero($page_home ?? [], $page_home_lang_independent ?? [])['photo'] ?? '';
  }
  ?>
  <?php if ($heroPreloadUrl !== ''): ?>
  <link rel="preload" as="image" href="<?= esc($heroPreloadUrl) ?>" fetchpriority="high">
  <?php endif; ?>

  <link rel="stylesheet" href="<?= theme_asset('css/fonts.css') ?>">
  <link rel="stylesheet" href="<?= theme_asset('vendor/bootstrap/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= theme_asset('css/peak.css') ?>">

  <?php if (! empty($setting['favicon'])): ?>
  <link rel="icon" type="image/png" href="<?= theme_upload($setting['favicon']) ?>">
  <?php else: ?>
  <link rel="icon" type="image/png" href="<?= peak_img('logo.png') ?>">
  <?php endif; ?>
</head>
<body class="page-<?= esc($current_page ?? $class_name) ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJFP3BPH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php if (! empty($comment['code_body'])): ?>
<?= $comment['code_body'] ?>
<?php endif; ?>

<?= view('includes/header', get_defined_vars()) ?>
