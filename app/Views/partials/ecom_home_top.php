<!-- E-Commerce Hero -->
<div class="ecom-hero">
    <div class="container">
        <div class="ecom-hero-content">
            <span class="ecom-hero-badge">New Season Collection</span>
            <h1>Discover Quality Products at Great Prices</h1>
            <p>Shop electronics, fashion, home essentials and more. Fast delivery, secure checkout, and easy returns.</p>
            <?php echo form_open(base_url().'shop/search', ['class' => 'ecom-hero-search']); ?>
                <input type="text" name="keyword" placeholder="What are you looking for?" required>
                <button type="submit"><i class="fa fa-search"></i> Search</button>
            <?php echo form_close(); ?>
            <div class="ecom-hero-cta">
                <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn ecom-btn-accent">Shop Now</a>
                <a href="<?php echo base_url(); ?>shop/category/electronics" class="btn ecom-btn ecom-btn-outline">Browse Electronics</a>
            </div>
            <div class="ecom-hero-trust">
                <span><i class="fa fa-truck"></i> Free Shipping $50+</span>
                <span><i class="fa fa-refresh"></i> 30-Day Returns</span>
                <span><i class="fa fa-lock"></i> Secure Shopping</span>
                <span><i class="fa fa-headphones"></i> 24/7 Support</span>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($shop_parent_categories)): ?>
<!-- Shop Categories & Products -->
<div class="ecom-section ecom-section-alt ecom-home-categories">
    <div class="container">
        <div class="ecom-section-header">
            <div class="ecom-section-title">
                <h2>Shop by Category</h2>
                <p>Find exactly what you need from our curated collections</p>
            </div>
            <a href="<?php echo base_url(); ?>shop" class="ecom-section-link">View all &rarr;</a>
        </div>
        <div class="row ecom-grid">
            <?php foreach($shop_parent_categories as $cat): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 ecom-grid-item">
                <a href="<?php echo base_url(); ?>shop/category/<?php echo $cat['category_slug']; ?>" class="ecom-category-card">
                    <div class="ecom-category-image" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $cat['category_image']; ?>)"></div>
                    <div class="ecom-category-title"><h3><?php echo esc($cat['category_name']); ?></h3></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if(!empty($shop_featured_products)): ?>
        <div class="ecom-section-header" style="margin-top:48px;">
            <div class="ecom-section-title">
                <h2>Featured Products</h2>
                <p>Hand-picked bestsellers for you</p>
            </div>
            <a href="<?php echo base_url(); ?>shop" class="ecom-section-link">See all products &rarr;</a>
        </div>
        <div class="row ecom-grid">
            <?php foreach($shop_featured_products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="text-center" style="margin-top:32px;">
            <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">View All Products</a>
        </div>
    </div>
</div>
<?php endif; ?>
