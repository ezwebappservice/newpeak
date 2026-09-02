<div class="ecom-page-banner ecom-page-banner-sm ecom-page-banner-success">
    <div class="container">
        <h1><i class="fa fa-check-circle"></i> Order Placed!</h1>
        <p>Thank you for shopping with us</p>
    </div>
</div>
<section class="ecom-checkout-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="ecom-success-card">
                    <?php if(!empty($order)): ?>
                    <div class="ecom-success-icon"><i class="fa fa-check"></i></div>
                    <h2>Your order has been received</h2>
                    <p class="ecom-success-order-num">Order #<strong><?php echo esc($order['order_number']); ?></strong></p>
                    <p>We've sent a confirmation to <strong><?php echo esc($order['email']); ?></strong>. We'll notify you when your order ships.</p>
                    <div class="ecom-success-details">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Shipping to</h4>
                                <p>
                                    <?php echo esc($order['first_name'] . ' ' . $order['last_name']); ?><br>
                                    <?php echo esc($order['address_line1']); ?><br>
                                    <?php if($order['address_line2']): ?><?php echo esc($order['address_line2']); ?><br><?php endif; ?>
                                    <?php echo esc($order['city'] . ', ' . $order['state'] . ' ' . $order['postal_code']); ?><br>
                                    <?php echo esc($order['country']); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h4>Order total</h4>
                                <p class="ecom-success-total">$<?php echo number_format($order['total'], 2); ?></p>
                                <p>Payment: <?php echo $order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Bank Transfer'; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($order_items)): ?>
                    <table class="table ecom-success-table">
                        <thead><tr><th>Product</th><th>Qty</th><th>Total</th></tr></thead>
                        <tbody>
                        <?php foreach($order_items as $oi): ?>
                        <tr>
                            <td><?php echo esc($oi['product_name']); ?></td>
                            <td><?php echo $oi['quantity']; ?></td>
                            <td>$<?php echo number_format($oi['line_total'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                    <?php else: ?>
                    <p>Order details are not available.</p>
                    <?php endif; ?>
                    <div class="ecom-success-actions">
                        <a href="<?php echo base_url(); ?>shop" class="btn ecom-btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
