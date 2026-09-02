<div class="ecom-page-banner">
    <div class="container">
        <h1><?php echo esc($category['category_name']); ?></h1>
        <p><a href="<?php echo base_url(); ?>shop/category/<?php echo $category['parent_slug']; ?>"><?php echo esc($category['parent_name']); ?></a></p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li><a href="<?php echo base_url(); ?>shop/category/<?php echo $category['parent_slug']; ?>"><?php echo esc($category['parent_name']); ?></a></li>
            <li class="active"><?php echo esc($category['category_name']); ?></li>
        </ol>
    </div>
</div>
<div class="ecom-section">
    <div class="container">
        <div class="row ecom-grid">
            <?php if(empty($products)): ?>
            <div class="col-12 ecom-empty">
                <i class="fa fa-shopping-bag"></i>
                <p>No products found.</p>
                <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">Back to Shop</a>
            </div>
            <?php else: foreach($products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
