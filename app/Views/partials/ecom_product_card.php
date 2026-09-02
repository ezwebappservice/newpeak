<?php /** @var array $p */ ?>
<div class="col-lg-3 col-md-4 col-sm-6 ecom-grid-item">
    <div class="ecom-product-card h-100">
        <div class="ecom-product-image-wrap">
            <a href="<?php echo base_url(); ?>shop/product/<?php echo $p['product_slug']; ?>" class="ecom-product-image" style="background-image:url(<?php echo base_url(); ?>public/uploads/<?php echo $p['featured_image']; ?>)"></a>
            <?php if($p['stock_quantity'] <= 0): ?>
            <span class="ecom-badge ecom-badge-sold">Sold Out</span>
            <?php elseif($p['stock_quantity'] <= 5): ?>
            <span class="ecom-badge ecom-badge-low">Low Stock</span>
            <?php endif; ?>
        </div>
        <div class="ecom-product-body">
            <h3><a href="<?php echo base_url(); ?>shop/product/<?php echo $p['product_slug']; ?>"><?php echo esc($p['product_name']); ?></a></h3>
            <?php if(!empty($p['short_description'])): ?>
            <p class="ecom-short"><?php echo esc($p['short_description']); ?></p>
            <?php endif; ?>
            <div class="ecom-product-footer">
                <p class="ecom-price">$<?php echo number_format($p['price'], 2); ?></p>
                <?php if($p['stock_quantity'] > 0): ?>
                <?php echo form_open(base_url().'cart/add', ['class' => 'ecom-add-inline']); ?>
                    <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn ecom-btn ecom-btn-sm"><i class="fa fa-shopping-cart"></i> Add</button>
                <?php echo form_close(); ?>
                <?php else: ?>
                <span class="ecom-out-stock">Out of Stock</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
