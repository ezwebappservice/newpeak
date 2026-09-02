<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <?php if(!empty($category_mapping['parent_slug'])): ?>
            <li><a href="<?php echo base_url(); ?>shop/category/<?php echo $category_mapping['parent_slug']; ?>"><?php echo esc($category_mapping['parent_name']); ?></a></li>
            <?php endif; ?>
            <li class="active"><?php echo esc($product['product_name']); ?></li>
        </ol>
    </div>
</div>
<div class="ecom-detail-wrap">
    <div class="container">
        <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?php echo session()->getFlashdata('success'); ?></div><?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div><?php endif; ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="ecom-gallery-main" id="ecomMainImage" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $product['featured_image']; ?>)"></div>
                <?php if(!empty($product_images)): ?>
                <div class="ecom-gallery-thumbs">
                    <div class="ecom-thumb active" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $product['featured_image']; ?>)" onclick="ecomSetImage(this)"></div>
                    <?php foreach($product_images as $img): ?>
                    <div class="ecom-thumb" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $img['image_name']; ?>)" onclick="ecomSetImage(this)"></div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 ecom-detail-info">
                <h1 class="ecom-detail-title"><?php echo esc($product['product_name']); ?></h1>
                <p class="ecom-price ecom-detail-price">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="ecom-detail-desc"><?php echo esc($product['short_description']); ?></p>
                <?php if($product['stock_quantity'] > 0): ?>
                <span class="ecom-stock-badge ecom-stock-in"><i class="fa fa-check-circle"></i> <?php echo $product['stock_quantity']; ?> in stock</span>
                <?php else: ?>
                <span class="ecom-stock-badge ecom-stock-out"><i class="fa fa-times-circle"></i> Out of stock</span>
                <?php endif; ?>
                <?php if($product['stock_quantity'] > 0): ?>
                <?php echo form_open(base_url().'cart/add', ['class'=>'ecom-add-form']); ?>
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <div class="ecom-qty-row">
                        <label for="qty">Quantity</label>
                        <input type="number" id="qty" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn ecom-btn"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                <?php echo form_close(); ?>
                <?php endif; ?>
                <?php if(!empty($product['full_description'])): ?>
                <div class="ecom-full-desc"><?php echo $product['full_description']; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php if(!empty($related_products)): ?>
        <div class="ecom-section-header" style="margin-top:56px;">
            <div class="ecom-section-title">
                <h2>Related Products</h2>
                <p>You might also like</p>
            </div>
        </div>
        <div class="row ecom-grid">
            <?php foreach($related_products as $p): ?>
            <?php echo view('partials/ecom_product_card', ['p' => $p]); ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<script>
function ecomSetImage(el) {
    var main = document.getElementById('ecomMainImage');
    if (!main) return;
    main.style.backgroundImage = el.style.backgroundImage;
    document.querySelectorAll('.ecom-thumb').forEach(function(t){ t.classList.remove('active'); });
    el.classList.add('active');
}
</script>
