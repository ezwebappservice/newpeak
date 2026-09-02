<?php
include APPPATH . 'Views/includes/nav_item.php';
$home_active = theme_is_home() ? ' active' : '';
$navTree = $navTree ?? (config(\Config\ShivalikPages::class)->navigation ?? []);
?>
<ul class="navbar-nav main-menu ms-auto align-items-lg-center" id="mainMenu">
  <li class="menu-item nav-item">
    <a class="nav-link<?= $home_active ?>" href="<?= base_url() ?>"><?= defined('HOME') ? HOME : 'Home' ?></a>
  </li>

  <?php foreach ($navTree as $item): ?>
    <?php render_nav_item($item, 0); ?>
  <?php endforeach; ?>

  <li class="menu-item nav-item nav-cta ms-lg-3">
    <a class="btn btn-primary btn-sm px-4 nav-btn-cta" href="<?= dynamic_page_url('connect') ?>">Get in Touch</a>
  </li>
</ul>
