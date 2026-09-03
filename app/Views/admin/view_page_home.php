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
        'title'  => 'About',
        'field'  => 'home_welcome_status',
        'form'   => 'form_home_welcome',
        'hint'   => 'About copy and vision/mission are edited under Edit.',
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
