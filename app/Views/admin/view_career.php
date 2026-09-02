<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Careers</h1>
    </div>
    <div class="content-header-right">
        <a href="<?= base_url('admin/career/add') ?>" class="btn btn-primary btn-sm">Add Job Opening</a>
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
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Experience</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach (($careers ?? []) as $row): $i++; ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= esc($row['job_title']) ?></td>
                                    <td><?= esc($row['department'] ?? '—') ?></td>
                                    <td><?= esc($row['location'] ?? '—') ?></td>
                                    <td><?= esc($row['job_type'] ?? '—') ?></td>
                                    <td><?= esc($row['experience'] ?? '—') ?></td>
                                    <td><?= (int) ($row['sort_order'] ?? 0) ?></td>
                                    <td><?= esc($row['status'] ?? 'Active') ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/career/edit/' . $row['id']) ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="<?= base_url('admin/career/delete/' . $row['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this job opening?');">Delete</a>
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
