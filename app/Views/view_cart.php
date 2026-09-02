<div class="ecom-page-banner">
    <div class="container">
        <h1>Shopping Cart</h1>
        <p>Review your items before checkout</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li class="active">Cart</li>
        </ol>
    </div>
</div>
<div class="ecom-cart-page">
    <div class="container">
        <?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?php echo session()->getFlashdata('success'); ?></div><?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div><?php endif; ?>
        <?php if(empty($cart_items)): ?>
        <div class="ecom-cart-empty">
            <i class="fa fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added anything yet.</p>
            <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">Start Shopping</a>
        </div>
        <?php else: ?>
        <?php echo form_open(base_url().'cart/update'); ?>
        <div class="table-responsive ecom-cart-table">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($cart_items as $item): $p = $item['product']; ?>
                <tr>
                    <td>
                        <div class="ecom-cart-product">
                            <img src="<?php echo base_url(); ?>public/uploads/<?php echo $p['featured_image']; ?>" alt="<?php echo esc($p['product_name']); ?>">
                            <span><?php echo esc($p['product_name']); ?></span>
                        </div>
                    </td>
                    <td>$<?php echo number_format($p['price'], 2); ?></td>
                    <td><input type="number" name="quantity[<?php echo $p['product_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" max="<?php echo $p['stock_quantity']; ?>" class="form-control" style="width:80px;"></td>
                    <td><strong>$<?php echo number_format($item['line_total'], 2); ?></strong></td>
                    <td><a href="<?php echo base_url(); ?>cart/remove/<?php echo $p['product_id']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="ecom-cart-footer">
            <div class="ecom-cart-total">Total: <span>$<?php echo number_format($cart_total, 2); ?></span></div>
            <div class="ecom-cart-actions">
                <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn ecom-btn-secondary">Continue Shopping</a>
                <button type="submit" class="btn ecom-btn">Update Cart</button>
                <a href="<?php echo base_url(); ?>checkout" class="btn ecom-btn ecom-btn-accent"><i class="fa fa-lock"></i> Proceed to Checkout</a>
                <a href="<?php echo base_url(); ?>cart/clear" class="btn btn-default" onclick="return confirm('Clear cart?');">Clear Cart</a>
            </div>
        </div>
        <?php echo form_close(); ?>
        <?php endif; ?>
    </div>
</div>
