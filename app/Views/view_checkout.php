<?php
$old = $old ?? $customer ?? [];
$val = static function ($key, $default = '') use ($old) {
    return esc($old[$key] ?? $default);
};
?>
<div class="ecom-page-banner ecom-page-banner-sm">
    <div class="container">
        <h1>Checkout</h1>
        <p>Complete your order — fields support browser autofill</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>cart">Cart</a></li>
            <li class="active">Checkout</li>
        </ol>
    </div>
</div>
<section class="ecom-checkout-section">
    <div class="container">
        <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-7">
                <?php if(!$is_logged_in): ?>
                <div class="ecom-checkout-auth-banner">
                    <div>
                        <strong><i class="fa fa-bolt"></i> Faster checkout</strong>
                        <p class="mb-0">Sign in to autofill your saved address and details.</p>
                    </div>
                    <div class="ecom-checkout-auth-links">
                        <a href="<?php echo base_url('login?redirect=checkout'); ?>" class="btn ecom-btn ecom-btn-sm">Login</a>
                        <a href="<?php echo base_url('register?redirect=checkout'); ?>" class="btn ecom-btn ecom-btn-secondary ecom-btn-sm">Register</a>
                    </div>
                </div>
                <?php else: ?>
                <div class="ecom-checkout-logged-in">
                    <i class="fa fa-check-circle"></i>
                    Signed in as <strong><?php echo esc(session()->get('shop_customer_name')); ?></strong>
                    <a href="<?php echo base_url('logout'); ?>" class="ecom-checkout-logout">Logout</a>
                </div>
                <?php endif; ?>

                <?php echo form_open(base_url('checkout'), ['class' => 'ecom-checkout-form', 'autocomplete' => 'on', 'id' => 'checkoutForm']); ?>
                <div class="ecom-checkout-card">
                    <h3 class="ecom-form-section-title"><i class="fa fa-user"></i> Contact Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ecom-form-group">
                                <label for="co_first_name">First Name *</label>
                                <input type="text" id="co_first_name" name="first_name" class="form-control"
                                    value="<?php echo $val('first_name'); ?>" required autocomplete="given-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ecom-form-group">
                                <label for="co_last_name">Last Name *</label>
                                <input type="text" id="co_last_name" name="last_name" class="form-control"
                                    value="<?php echo $val('last_name'); ?>" required autocomplete="family-name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ecom-form-group">
                                <label for="co_email">Email *</label>
                                <input type="email" id="co_email" name="email" class="form-control"
                                    value="<?php echo $val('email'); ?>" required
                                    autocomplete="email" inputmode="email"
                                    <?php echo $is_logged_in ? 'readonly' : ''; ?>>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ecom-form-group">
                                <label for="co_phone">Phone *</label>
                                <input type="tel" id="co_phone" name="phone" class="form-control"
                                    value="<?php echo $val('phone'); ?>" required
                                    autocomplete="tel" inputmode="tel">
                            </div>
                        </div>
                    </div>

                    <h3 class="ecom-form-section-title"><i class="fa fa-truck"></i> Shipping Address</h3>
                    <div class="ecom-form-group">
                        <label for="co_address1">Street Address *</label>
                        <input type="text" id="co_address1" name="address_line1" class="form-control"
                            value="<?php echo $val('address_line1'); ?>" required autocomplete="shipping street-address">
                    </div>
                    <div class="ecom-form-group">
                        <label for="co_address2">Apartment, suite, etc.</label>
                        <input type="text" id="co_address2" name="address_line2" class="form-control"
                            value="<?php echo $val('address_line2'); ?>" autocomplete="shipping address-line2">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="ecom-form-group">
                                <label for="co_city">City *</label>
                                <input type="text" id="co_city" name="city" class="form-control"
                                    value="<?php echo $val('city'); ?>" required autocomplete="shipping address-level2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="ecom-form-group">
                                <label for="co_state">State *</label>
                                <input type="text" id="co_state" name="state" class="form-control"
                                    value="<?php echo $val('state'); ?>" required autocomplete="shipping address-level1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ecom-form-group">
                                <label for="co_postal">ZIP *</label>
                                <input type="text" id="co_postal" name="postal_code" class="form-control"
                                    value="<?php echo $val('postal_code'); ?>" required
                                    autocomplete="shipping postal-code" inputmode="numeric">
                            </div>
                        </div>
                    </div>
                    <div class="ecom-form-group">
                        <label for="co_country">Country *</label>
                        <input type="text" id="co_country" name="country" class="form-control"
                            value="<?php echo $val('country', 'United States'); ?>" required autocomplete="shipping country">
                    </div>

                    <?php if($is_logged_in): ?>
                    <label class="ecom-checkbox">
                        <input type="checkbox" name="save_address" value="1" checked>
                        <span>Save address to my account for next time</span>
                    </label>
                    <?php endif; ?>

                    <h3 class="ecom-form-section-title"><i class="fa fa-credit-card"></i> Payment</h3>
                    <div class="ecom-payment-options">
                        <label class="ecom-payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span><i class="fa fa-money"></i> Cash on Delivery</span>
                        </label>
                        <label class="ecom-payment-option">
                            <input type="radio" name="payment_method" value="bank">
                            <span><i class="fa fa-university"></i> Bank Transfer</span>
                        </label>
                    </div>

                    <div class="ecom-form-group">
                        <label for="co_notes">Order Notes (optional)</label>
                        <textarea id="co_notes" name="order_notes" class="form-control" rows="3"
                            placeholder="Delivery instructions, gift message, etc."></textarea>
                    </div>

                    <button type="submit" class="btn ecom-btn ecom-btn-block ecom-btn-lg">
                        <i class="fa fa-lock"></i> Place Order — $<?php echo number_format($cart_total, 2); ?>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-lg-5">
                <div class="ecom-checkout-summary">
                    <h3>Order Summary</h3>
                    <ul class="ecom-checkout-items">
                        <?php foreach($cart_items as $item): $p = $item['product']; ?>
                        <li>
                            <img src="<?php echo base_url(); ?>public/uploads/<?php echo $p['featured_image']; ?>" alt="">
                            <div class="ecom-checkout-item-info">
                                <span class="name"><?php echo esc($p['product_name']); ?></span>
                                <span class="meta">Qty: <?php echo $item['quantity']; ?> × $<?php echo number_format($p['price'], 2); ?></span>
                            </div>
                            <span class="line">$<?php echo number_format($item['line_total'], 2); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="ecom-checkout-summary-total">
                        <span>Subtotal</span>
                        <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                    </div>
                    <div class="ecom-checkout-summary-total ecom-checkout-grand">
                        <span>Total</span>
                        <strong>$<?php echo number_format($cart_total, 2); ?></strong>
                    </div>
                    <a href="<?php echo base_url(); ?>cart" class="ecom-checkout-edit-cart"><i class="fa fa-pencil"></i> Edit cart</a>
                </div>
            </div>
        </div>
    </div>
</section>
