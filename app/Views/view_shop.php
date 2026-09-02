<!-- Shop Page -->
<div class="ecom-page-banner">
    <div class="container">
        <h1>Our Store</h1>
        <p>Browse categories and discover products you'll love</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active">Shop</li>
        </ol>
    </div>
</div>
<div class="ecom-section">
    <div class="container">
        <div class="ecom-section-header">
            <div class="ecom-section-title">
                <h2>Shop Categories</h2>
                <p>Explore our collections</p>
            </div>
            <div class="ecom-search-bar">
                <?php echo form_open(base_url().'shop/search'); ?>
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search products...">
                    <button class="btn ecom-btn" type="submit"><i class="fa fa-search"></i></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="row ecom-grid">
            <?php foreach($parent_categories as $cat): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 ecom-grid-item">
                <a href="<?php echo base_url(); ?>shop/category/<?php echo $cat['category_slug']; ?>" class="ecom-category-card">
                    <div class="ecom-category-image" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $cat['category_image']; ?>)"></div>
                    <div class="ecom-category-title"><h3><?php echo esc($cat['category_name']); ?></h3></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if(!empty($featured_products)): ?>
        <div class="ecom-section-header" style="margin-top:48px;">
            <div class="ecom-section-title">
                <h2>All Products</h2>
                <p><?php echo count($featured_products); ?>+ items available</p>
            </div>
        </div>
        <div class="row ecom-grid">
            <?php foreach($featured_products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
