<div class="ecom-page-banner">
    <div class="container">
        <h1>Search Results</h1>
        <p>Showing results for "<?php echo esc($keyword); ?>"</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li class="active">Search</li>
        </ol>
    </div>
</div>
<div class="ecom-section">
    <div class="container">
        <div class="ecom-search-bar mb-4">
            <?php echo form_open(base_url().'shop/search'); ?>
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" value="<?php echo esc($keyword); ?>" placeholder="Search products...">
                <button class="btn ecom-btn" type="submit"><i class="fa fa-search"></i> Search</button>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="row ecom-grid">
            <?php if(empty($products)): ?>
            <div class="col-12 ecom-empty">
                <i class="fa fa-search"></i>
                <p>No products found for your search.</p>
                <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">Browse All Products</a>
            </div>
            <?php else: foreach($products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
