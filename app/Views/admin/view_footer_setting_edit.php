<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$footerRow = $footer_setting ?? [];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Footer Settings</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/footer-setting" class="btn btn-primary btn-sm">Back</a>
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
                    <?php echo form_open(base_url().'admin/footer-setting/edit/'.$footerRow['id'], array('class' => 'form-horizontal')); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Newsletter Text</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="newsletter_text" rows="4"><?php echo esc($footerRow['newsletter_text'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success" name="form1">Update</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
