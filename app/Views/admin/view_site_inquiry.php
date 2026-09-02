<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Form Inquiries <?php if(($new_count ?? 0) > 0): ?><small class="label label-warning"><?= (int) $new_count ?> new</small><?php endif; ?></h1>
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

            <div class="box box-info" style="padding:10px 15px;">
                <form method="get" class="form-inline">
                    <label>Source:</label>
                    <select name="source" class="form-control" style="width:auto;margin:0 10px;">
                        <option value="">All</option>
                        <option value="home" <?= ($filter_source ?? '') === 'home' ? 'selected' : '' ?>>Home Page</option>
                        <option value="contact" <?= ($filter_source ?? '') === 'contact' ? 'selected' : '' ?>>Contact Page</option>
                    </select>
                    <label>Status:</label>
                    <select name="status" class="form-control" style="width:auto;margin:0 10px;">
                        <option value="">All</option>
                        <option value="New" <?= ($filter_status ?? '') === 'New' ? 'selected' : '' ?>>New</option>
                        <option value="Read" <?= ($filter_status ?? '') === 'Read' ? 'selected' : '' ?>>Read</option>
                    </select>
                    <button type="submit" class="btn btn-default btn-sm">Filter</button>
                    <a href="<?= base_url('admin/site_inquiry') ?>" class="btn btn-link btn-sm">Reset</a>
                </form>
            </div>

            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach (($inquiries ?? []) as $row): $i++; ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= esc($row['created_at'] ?? '') ?></td>
                                    <td><?= ($row['form_source'] ?? '') === 'home' ? 'Home Page' : 'Contact Page' ?></td>
                                    <td><?= esc(trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?></td>
                                    <td><a href="mailto:<?= esc($row['email'] ?? '', 'attr') ?>"><?= esc($row['email'] ?? '') ?></a></td>
                                    <td><?= esc($row['subject'] ?? '—') ?></td>
                                    <td>
                                        <?php if(($row['status'] ?? '') === 'New'): ?>
                                            <span class="label label-warning">New</span>
                                        <?php else: ?>
                                            <span class="label label-success">Read</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/site_inquiry/view/' . $row['id']) ?>" class="btn btn-primary btn-xs">View</a>
                                        <a href="<?= base_url('admin/site_inquiry/delete/' . $row['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this inquiry?');">Delete</a>
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
