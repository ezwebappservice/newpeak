<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$footerRow = $footer_setting_row ?? [];
$footerId = (int) ($footerRow['id'] ?? 0);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Footer Settings</h1>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
                <div class="callout callout-success"><p><?php echo session()->getFlashdata('success'); ?></p></div>
            <?php endif; ?>

            <div class="box box-info">
                <div class="box-body">
                    <p class="text-muted">Controls the newsletter block and recent news links shown in the site footer.</p>

                    <?php echo form_open(base_url().'admin/footer-setting/update', array('class' => 'form-horizontal')); ?>
                    <input type="hidden" name="footer_id" value="<?php echo $footerId; ?>">

                    <h3 class="sec_title" style="margin-top:0;">Newsletter</h3>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Newsletter Text</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="newsletter_text" rows="4"><?php echo esc($footerRow['newsletter_text'] ?? ''); ?></textarea>
                            <p class="help-block">Shown in the footer about section and newsletter signup area.</p>
                        </div>
                    </div>

                    <h3 class="sec_title">Recent News</h3>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">News Items to Show</label>
                        <div class="col-sm-2">
                            <input type="number" min="1" max="10" name="footer_recent_news_item" class="form-control" value="<?php echo esc($footer_setting_lang_independent['footer_recent_news_item'] ?? 5); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success" name="form_footer_settings">Save Footer Settings</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
