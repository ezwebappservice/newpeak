<div class="ecom-topbar">
  <div class="container">
    <div class="ecom-topbar-inner">
      <div class="ecom-topbar-promo">
        <i class="fa fa-industry"></i>
        <span><?= esc($setting['top_bar_phone'] ?? '') ?><?php if (! empty($setting['top_bar_email'])): ?> &nbsp;|&nbsp; <?= esc($setting['top_bar_email']) ?><?php endif; ?></span>
      </div>
      <div class="ecom-topbar-actions">
        <a href="<?= base_url('shop') ?>" class="ecom-topbar-link"><i class="fa fa-shopping-bag"></i> Shop</a>
        <a href="<?= base_url('cart') ?>" class="ecom-cart-btn">
          <i class="fa fa-shopping-cart"></i>
          <span>Cart</span>
          <?php if ($ecom_cart_count > 0): ?>
          <span class="ecom-cart-count"><?= $ecom_cart_count ?></span>
          <?php endif; ?>
        </a>
        <?php if (session()->get('shop_customer_id')): ?>
        <a href="<?= base_url('checkout') ?>" class="ecom-topbar-link"><i class="fa fa-user"></i> <?= esc(session()->get('shop_customer_name')) ?></a>
        <?php else: ?>
        <a href="<?= base_url('login') ?>" class="ecom-topbar-link"><i class="fa fa-sign-in"></i> Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
