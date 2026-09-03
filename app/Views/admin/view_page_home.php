<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}

$sectionToggles = [
    [
        'title'  => 'Hero',
        'field'  => 'home_hero_status',
        'form'   => 'form_home_hero',
        'hint'   => 'Hero text: Edit Page Content below. Background slides: Page Settings → Hero Background Slides.',
    ],
    [
        'title'  => 'Video Section',
        'field'  => 'home_welcome_status',
        'form'   => 'form_home_welcome',
        'hint'   => 'Video copy: Edit Page Content. YouTube URL can also be updated below.',
        'extra'  => 'video_url',
    ],
    [
        'title'  => 'Products',
        'field'  => 'home_service_status',
        'form'   => 'form_home_service',
        'hint'   => 'Product cards: Admin → Homepage Sections → Products.',
    ],
    [
        'title'  => 'Industries',
        'field'  => 'home_feature_status',
        'form'   => 'form_home_feature',
        'hint'   => 'Industry cards: Admin → Homepage Sections → Industries.',
    ],
    [
        'title'  => 'Why Choose Us',
        'field'  => 'home_why_choose_status',
        'form'   => 'form_home_why_choose',
        'hint'   => 'Why Choose items: Admin → Homepage Sections → Why Choose Us.',
    ],
    [
        'title'  => 'Hero Stats Bar',
        'field'  => 'counter_status',
        'form'   => 'form_home_counter_text',
        'hint'   => 'Stat values and labels are edited under Edit Page Content.',
    ],
    [
        'title'  => 'Certifications',
        'field'  => 'home_certification_status',
        'form'   => 'form_home_certification',
        'hint'   => 'Certification cards: Admin → Homepage Sections → Certifications.',
    ],
    [
        'title'  => 'Partners',
        'field'  => 'home_partners_status',
        'form'   => 'form_home_partners',
        'hint'   => 'Partner logos: Admin → Homepage Sections → Partners.',
    ],
    [
        'title'  => 'Testimonials',
        'field'  => 'home_testimonial_status',
        'form'   => 'form_home_testimonial',
        'hint'   => 'Testimonials: Admin → Homepage Sections → Testimonials.',
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
                    <?php foreach ($sectionToggles as $section): ?>
                    <div class="srl-home-section-panel">
                        <h4 class="sec_title"><?= esc($section['title']) ?></h4>
                        <?php if (! empty($section['hint'])): ?>
                        <p class="text-muted srl-home-section-hint"><?= esc($section['hint']) ?></p>
                        <?php endif; ?>
                        <?= form_open(base_url('admin/page-home/update'), ['class' => 'form-horizontal']) ?>
                        <div class="form-group mb-0">
                            <label class="col-sm-2 control-label">Show on home?</label>
                            <div class="col-sm-2">
                                <select name="<?= esc($section['field']) ?>" class="form-control" style="width:auto;">
                                    <option value="Show" <?= ($ph[$section['field']] ?? 'Show') === 'Show' ? 'selected' : '' ?>>Show</option>
                                    <option value="Hide" <?= ($ph[$section['field']] ?? 'Show') === 'Hide' ? 'selected' : '' ?>>Hide</option>
                                </select>
                            </div>
                            <?php if (($section['extra'] ?? '') === 'blog_item'): ?>
                            <label class="col-sm-2 control-label">Items to show</label>
                            <div class="col-sm-1">
                                <input type="number" min="1" max="12" name="home_blog_item" class="form-control" value="<?= (int) ($ph['home_blog_item'] ?? 3) ?>">
                            </div>
                            <?php endif; ?>
                            <?php if (($section['extra'] ?? '') === 'video_url'): ?>
                            <label class="col-sm-2 control-label">YouTube URL</label>
                            <div class="col-sm-4">
                                <input type="text" name="home_welcome_video" class="form-control" placeholder="https://www.youtube.com/watch?v=..." value="<?= esc($ph['home_welcome_video'] ?? '') ?>">
                            </div>
                            <?php endif; ?>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-success" name="<?= esc($section['form']) ?>">Update</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <?php endforeach; ?>

                    <div class="srl-home-section-panel">
                        <h4 class="sec_title">About Section Image</h4>
                        <p class="text-muted srl-home-section-hint">Image shown beside the About text on the homepage.</p>
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
