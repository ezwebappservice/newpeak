<div class="ecom-page-banner">
    <div class="container">
        <h1><?php echo esc($category['category_name']); ?></h1>
        <p>Browse products in this category</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li class="active"><?php echo esc($category['category_name']); ?></li>
        </ol>
    </div>
</div>
<div class="ecom-section">
    <div class="container">
        <?php if(!empty($sub_categories)): ?>
        <div class="ecom-subcat-row">
            <?php foreach($sub_categories as $sub): ?>
            <a href="<?php echo base_url(); ?>shop/subcategory/<?php echo $sub['category_slug']; ?>" class="ecom-subcat-chip">
                <img src="<?php echo base_url(); ?>public/uploads/<?php echo $sub['category_image']; ?>" alt="<?php echo esc($sub['category_name']); ?>">
                <span><?php echo esc($sub['category_name']); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="row ecom-grid">
            <?php if(empty($products)): ?>
            <div class="col-12 ecom-empty">
                <i class="fa fa-shopping-bag"></i>
                <p>No products found in this category.</p>
                <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">Back to Shop</a>
            </div>
            <?php else: foreach($products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
