<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}

$sectionToggles = [
    [
        'title'  => 'Hero',
        'field'  => 'home_hero_status',
        'form'   => 'form_home_hero',
        'hint'   => 'Hero copy, buttons, and portrait card: Edit Page Content. Portrait photo: Hero Image below.',
    ],
    [
        'title'  => 'Video Section',
        'field'  => 'home_welcome_status',
        'form'   => 'form_home_welcome',
        'hint'   => 'Video copy: Edit Page Content. YouTube URL can also be updated below.',
        'extra'  => 'video_url',
    ],
    [
        'title'  => 'Hero Stats Bar',
        'field'  => 'counter_status',
        'form'   => 'form_home_counter_text',
        'hint'   => 'Stat values and labels are edited under Edit Page Content.',
    ],
    [
        'title'  => 'News',
        'field'  => 'home_blog_status',
        'form'   => 'form_home_blog',
        'hint'   => 'News articles: Admin → News. Contact form always shows at page bottom.',
        'extra'  => 'blog_item',
    ],
];

$ph = $page_home_lang_independent ?? [];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Home Page Settings</h1>
    </div>
    <div class="content-header-right">
        <?php if (! empty($page_home[0]['id'])): ?>
        <a href="<?= base_url('admin/page-home/edit/' . (int) $page_home[0]['id']) ?>" class="btn btn-primary btn-sm">Edit Page Content</a>
        <?php endif; ?>
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

            <div class="callout callout-info">
                <p class="mb-0">Manage homepage section visibility here. Video URL, stats, and other copy are edited from <strong>Edit Page Content</strong>.</p>
            </div>

            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Section Visibility</h3></div>
                <div class="box-body">
                    

                    <div class="srl-home-section-panel">
                        <h4 class="sec_title">Hero Image</h4>
                        <p class="text-muted srl-home-section-hint">Portrait shown in the homepage hero. Copy and card text are edited under Edit Page Content.</p>
                        <?= form_open_multipart(base_url('admin/page-home/update'), ['class' => 'form-horizontal']) ?>
                        <?php if (! empty($ph['home_welcome_video_bg'])): ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Current image</label>
                            <div class="col-sm-6">
                                <img src="<?= base_url('public/uploads/' . esc($ph['home_welcome_video_bg'])) ?>" class="existing-photo" style="max-height:160px;border-radius:8px;" alt="">
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group mb-0">
                            <label class="col-sm-2 control-label">Upload image</label>
                            <div class="col-sm-4"><input type="file" name="home_welcome_video_bg" accept="image/*"></div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-success" name="form_home_welcome_video_bg">Update</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Page Meta &amp; Headings</h3></div>
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Page record</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach ($page_home as $row): $i++; ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= esc($row['title'] ?: 'Homepage content') ?></td>
                                <td>
                                    <a href="<?= base_url('admin/page-home/edit/' . (int) $row['id']) ?>" class="btn btn-primary btn-xs">Edit content</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
