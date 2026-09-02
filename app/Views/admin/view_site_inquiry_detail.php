<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$row = $inquiry ?? [];
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Inquiry Details</h1>
    </div>
    <div class="content-header-right">
        <a href="<?= base_url('admin/site_inquiry') ?>" class="btn btn-primary btn-sm">Back to List</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr><th width="180">Submitted</th><td><?= esc($row['created_at'] ?? '') ?></td></tr>
                        <tr><th>Source</th><td><?= ($row['form_source'] ?? '') === 'home' ? 'Home Page Inquiry Form' : 'Contact Page Form' ?></td></tr>
                        <tr><th>Name</th><td><?= esc(trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?></td></tr>
                        <tr><th>Email</th><td><a href="mailto:<?= esc($row['email'] ?? '', 'attr') ?>"><?= esc($row['email'] ?? '') ?></a></td></tr>
                        <tr><th>Phone</th><td><?= esc($row['phone'] ?? '—') ?></td></tr>
                        <tr><th>Subject</th><td><?= esc($row['subject'] ?? '—') ?></td></tr>
                        <tr><th>Status</th><td><?= esc($row['status'] ?? 'New') ?></td></tr>
                        <tr><th>Message</th><td><?= nl2br(esc($row['message'] ?? '')) ?></td></tr>
                    </table>
                    <a href="<?= base_url('admin/site_inquiry/delete/' . ($row['id'] ?? 0)) ?>" class="btn btn-danger" onclick="return confirm('Delete this inquiry?');">Delete</a>
                </div>
            </div>
        </div>
    </div>
</section>
