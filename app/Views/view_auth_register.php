<?php
$old = $old ?? [];
$val = static function ($key, $default = '') use ($old) {
    return esc($old[$key] ?? $default);
};
?>
<div class="ecom-page-banner ecom-page-banner-sm">
    <div class="container">
        <h1>Create Account</h1>
        <p>Register for faster checkout with saved details</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li class="active">Register</li>
        </ol>
    </div>
</div>
<section class="ecom-auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="ecom-auth-card">
                    <div class="ecom-auth-card-head">
                        <i class="fa fa-user-plus"></i>
                        <h2>Create Your Account</h2>
                        <p>Your browser can autofill these fields on future visits</p>
                    </div>
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php echo form_open(base_url('register'), ['class' => 'ecom-auth-form', 'autocomplete' => 'on']); ?>
                        <input type="hidden" name="redirect" value="<?php echo esc($redirect); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_first_name">First Name</label>
                                    <input type="text" id="reg_first_name" name="first_name" class="form-control"
                                        value="<?php echo $val('first_name'); ?>" required
                                        autocomplete="given-name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_last_name">Last Name</label>
                                    <input type="text" id="reg_last_name" name="last_name" class="form-control"
                                        value="<?php echo $val('last_name'); ?>" required
                                        autocomplete="family-name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_email">Email</label>
                                    <input type="email" id="reg_email" name="email" class="form-control"
                                        value="<?php echo $val('email'); ?>" required
                                        autocomplete="email" inputmode="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_phone">Phone</label>
                                    <input type="tel" id="reg_phone" name="phone" class="form-control"
                                        value="<?php echo $val('phone'); ?>"
                                        autocomplete="tel" inputmode="tel">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_password">Password</label>
                                    <input type="password" id="reg_password" name="password" class="form-control"
                                        required minlength="6" autocomplete="new-password"
                                        placeholder="Min. 6 characters">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ecom-form-group">
                                    <label for="reg_password_confirm">Confirm Password</label>
                                    <input type="password" id="reg_password_confirm" name="password_confirm"
                                        class="form-control" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <h3 class="ecom-form-section-title"><i class="fa fa-map-marker"></i> Shipping Address</h3>
                        <div class="ecom-form-group">
                            <label for="reg_address1">Street Address</label>
                            <input type="text" id="reg_address1" name="address_line1" class="form-control"
                                value="<?php echo $val('address_line1'); ?>"
                                autocomplete="street-address">
                        </div>
                        <div class="ecom-form-group">
                            <label for="reg_address2">Apartment, suite, etc. (optional)</label>
                            <input type="text" id="reg_address2" name="address_line2" class="form-control"
                                value="<?php echo $val('address_line2'); ?>"
                                autocomplete="address-line2">
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="ecom-form-group">
                                    <label for="reg_city">City</label>
                                    <input type="text" id="reg_city" name="city" class="form-control"
                                        value="<?php echo $val('city'); ?>"
                                        autocomplete="address-level2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ecom-form-group">
                                    <label for="reg_state">State</label>
                                    <input type="text" id="reg_state" name="state" class="form-control"
                                        value="<?php echo $val('state'); ?>"
                                        autocomplete="address-level1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="ecom-form-group">
                                    <label for="reg_postal">ZIP Code</label>
                                    <input type="text" id="reg_postal" name="postal_code" class="form-control"
                                        value="<?php echo $val('postal_code'); ?>"
                                        autocomplete="postal-code" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                        <div class="ecom-form-group">
                            <label for="reg_country">Country</label>
                            <input type="text" id="reg_country" name="country" class="form-control"
                                value="<?php echo $val('country', 'United States'); ?>"
                                autocomplete="country-name">
                        </div>
                        <button type="submit" class="btn ecom-btn ecom-btn-block">
                            <i class="fa fa-check"></i> Create Account
                        </button>
                    <?php echo form_close(); ?>
                    <p class="ecom-auth-switch mt-4 mb-0">
                        Already have an account?
                        <a href="<?php echo base_url('login?redirect=' . urlencode($redirect)); ?>">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
