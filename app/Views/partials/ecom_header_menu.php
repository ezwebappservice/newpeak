<div class="col-lg-2 col-md-4 col-8">
    <div class="logo flex">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['logo']; ?>" alt="Logo"></a>
    </div>
</div>
<div class="col-lg-10 col-md-8 col-4 main-menu">
    <div class="main-menu-item">
        <?php echo form_open(base_url().'shop/search', ['class' => 'ecom-header-search']); ?>
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Search products...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <?php echo form_close(); ?>
        <ul class="nav-menu">
            <?php if(!empty($arr_menu[1]) && $arr_menu[1] == 'Show'): ?>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <?php endif; ?>
            <li class="menu-item-has-children nav-shop-highlight">
                <a href="<?php echo base_url(); ?>shop">Shop</a>
                <?php if(!empty($header_shop_categories)): ?>
                <ul>
                    <?php foreach($header_shop_categories as $hc): ?>
                    <li><a href="<?php echo base_url(); ?>shop/category/<?php echo $hc['category_slug']; ?>"><?php echo esc($hc['category_name']); ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="<?php echo base_url(); ?>shop"><strong>View All Products</strong></a></li>
                </ul>
                <?php endif; ?>
            </li>
            <?php if(!empty($arr_menu[2]) && $arr_menu[2] == 'Show'): ?>
            <li><a href="<?php echo base_url(); ?>about"><?php echo ABOUT; ?></a></li>
            <?php endif; ?>
            <?php if(!empty($arr_menu[12]) && $arr_menu[12] == 'Show'): ?>
            <li><a href="<?php echo base_url(); ?>contact"><?php echo CONTACT; ?></a></li>
            <?php endif; ?>
            <?php if(session()->get('shop_customer_id')): ?>
            <li><a href="<?php echo base_url(); ?>checkout"><i class="fa fa-user"></i> Account</a></li>
            <?php else: ?>
            <li><a href="<?php echo base_url(); ?>login">Login</a></li>
            <?php endif; ?>
        </ul>
        <div class="ecom-menu-actions">
            <a href="<?php echo base_url(); ?>cart" class="ecom-cart-btn ecom-cart-btn-menu">
                <i class="fa fa-shopping-cart"></i>
                <span>Cart</span>
                <?php if($ecom_cart_count > 0): ?>
                <span class="ecom-cart-count"><?php echo $ecom_cart_count; ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <div class="searchbar">
        <div class="search-button"><i class="fa fa-search"></i></div>
        <?php echo form_open(base_url().'shop/search'); ?>
            <div class="input-group input-search">
                <input type="text" class="form-control" placeholder="Search products..." name="keyword">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
