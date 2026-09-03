<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Home Page Content</h1>
    </div>
    <div class="content-header-right">
        <a href="<?= base_url('admin/page-home') ?>" class="btn btn-primary btn-sm">Back to settings</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(session()->getFlashdata('error')): ?>
            <div class="callout callout-danger"><p><?= session()->getFlashdata('error') ?></p></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('success')): ?>
            <div class="callout callout-success"><p><?= session()->getFlashdata('success') ?></p></div>
            <?php endif; ?>

            <?= form_open_multipart(base_url('admin/page-home/edit/' . (int) $page_home['id']), ['class' => 'form-horizontal']) ?>
            <div class="box box-info" style="padding:0">
                <div class="box-body" style="padding-top:0">

                    

                    <?= view('admin/partials/page_home_edit_hero') ?>

                    <h3 class="sec_title">Video Section</h3>
                    <p class="col-sm-offset-2 col-sm-9 text-muted">Shown beside the homepage video. Paste a YouTube link (watch, share, or embed URL).</p>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Eyebrow</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="home_welcome_title" value="<?= esc($page_home['home_welcome_title']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Heading</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="home_welcome_subtitle" value="<?= esc($page_home['home_welcome_subtitle']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Body text</label>
                        <div class="col-sm-9">
                            <textarea class="form-control editor" name="home_welcome_text"><?= esc($page_home['home_welcome_text']) ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">YouTube URL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="home_welcome_video" placeholder="https://www.youtube.com/watch?v=..." value="<?= esc($page_home_lang_independent['home_welcome_video'] ?? '') ?>">
                        </div>
                    </div>
                    <input type="hidden" name="home_welcome_pbar1_text" value="<?= esc($page_home['home_welcome_pbar1_text'] ?? '') ?>">
                    <input type="hidden" name="home_welcome_pbar2_text" value="<?= esc($page_home['home_welcome_pbar2_text'] ?? '') ?>">

                    <?= view('admin/partials/page_home_edit_theme') ?>





                    <h3 class="sec_title">Hero Stats Bar</h3>
                    <p class="col-sm-offset-2 col-sm-9 text-muted">These five counts appear on the homepage and program pages. Value is the large number/text (for example 5000 or Top 100). Suffix is optional (for example +).</p>
                    <?php for ($c = 1; $c <= 5; $c++): ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Stat <?= $c ?> label</label>
                        <div class="col-sm-3">
                            <input type="text" name="counter_<?= $c ?>_title" class="form-control" value="<?= esc($page_home['counter_' . $c . '_title'] ?? '') ?>">
                        </div>
                        <label class="col-sm-1 control-label">Value</label>
                        <div class="col-sm-2">
                            <input type="text" name="counter_<?= $c ?>_value" class="form-control" value="<?= esc($page_home['counter_' . $c . '_value'] ?? '') ?>">
                        </div>
                        <label class="col-sm-1 control-label">Suffix</label>
                        <div class="col-sm-1">
                            <input type="text" name="counter_<?= $c ?>_suffix" class="form-control" value="<?= esc($page_home['counter_' . $c . '_suffix'] ?? '') ?>" placeholder="+">
                        </div>
                        <input type="hidden" name="counter_<?= $c ?>_icon" value="<?= esc($page_home['counter_' . $c . '_icon'] ?? '') ?>">
                    </div>
                    <?php endfor; ?>

                   

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success" name="form1">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</section>
