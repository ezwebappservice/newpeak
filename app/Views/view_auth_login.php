<div class="ecom-page-banner ecom-page-banner-sm">
    <div class="container">
        <h1>Sign In</h1>
        <p>Access your account for faster checkout</p>
    </div>
</div>
<div class="ecom-breadcrumb">
    <div class="container">
        <ol>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
            <li class="active">Login</li>
        </ol>
    </div>
</div>
<section class="ecom-auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="ecom-auth-card">
                    <div class="ecom-auth-card-head">
                        <i class="fa fa-user-circle"></i>
                        <h2>Welcome Back</h2>
                        <p>Sign in to autofill your checkout details</p>
                    </div>
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?php echo session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php echo form_open(base_url('login'), ['class' => 'ecom-auth-form', 'autocomplete' => 'on']); ?>
                        <input type="hidden" name="redirect" value="<?php echo esc($redirect); ?>">
                        <div class="ecom-form-group">
                            <label for="login_email">Email Address</label>
                            <div class="ecom-input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" id="login_email" name="email" class="form-control"
                                    placeholder="you@example.com" required
                                    autocomplete="email" inputmode="email">
                            </div>
                        </div>
                        <div class="ecom-form-group">
                            <label for="login_password">Password</label>
                            <div class="ecom-input-icon">
                                <i class="fa fa-lock"></i>
                                <input type="password" id="login_password" name="password" class="form-control"
                                    placeholder="Your password" required
                                    autocomplete="current-password">
                            </div>
                        </div>
                        <button type="submit" class="btn ecom-btn ecom-btn-block">
                            <i class="fa fa-sign-in"></i> Sign In
                        </button>
                    <?php echo form_close(); ?>
                    <div class="ecom-auth-divider"><span>or</span></div>
                    <p class="ecom-auth-switch">
                        Don't have an account?
                        <a href="<?php echo base_url('register?redirect=' . urlencode($redirect)); ?>">Create one</a>
                    </p>
                    <p class="ecom-auth-switch mb-0">
                        <a href="<?php echo base_url('checkout'); ?>">Continue as guest</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
