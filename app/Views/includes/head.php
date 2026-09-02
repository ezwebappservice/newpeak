<!DOCTYPE html>
<html lang="en">
<head>
  <?= view('includes/meta', get_defined_vars()) ?>
  <?= csrf_meta() ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Manrope:wght@400;500;600;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
