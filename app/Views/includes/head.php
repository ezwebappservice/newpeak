<!DOCTYPE html>
<html lang="en">
<head>
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

<?php if (! empty($comment['code_body'])): ?>
<?= $comment['code_body'] ?>
<?php endif; ?>

<?= view('includes/header', get_defined_vars()) ?>
