<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$row = $career ?? [];
$jobTypes = ['Full Time', 'Part Time', 'Contract', 'Internship'];
?>
<section class="content-header">
    <div class="content-header-left"><h1>Edit Job Opening</h1></div>
    <div class="content-header-right"><a href="<?= base_url('admin/career') ?>" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
    <div class="row"><div class="col-md-12">
        <?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?= session()->getFlashdata('error') ?></p></div><?php endif; ?>
        <?= form_open(base_url('admin/career/edit/' . ($row['id'] ?? 0)), ['class' => 'form-horizontal']) ?>
        <div class="box box-info"><div class="box-body">
            <div class="form-group"><label class="col-sm-2 control-label">Job Title *</label><div class="col-sm-8"><input type="text" class="form-control" name="job_title" required maxlength="255" value="<?= esc($row['job_title'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Department</label><div class="col-sm-4"><input type="text" class="form-control" name="department" maxlength="255" value="<?= esc($row['department'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Location</label><div class="col-sm-4"><input type="text" class="form-control" name="location" maxlength="255" value="<?= esc($row['location'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Job Type</label><div class="col-sm-4"><select name="job_type" class="form-control"><option value="">Select type</option><?php foreach ($jobTypes as $type): ?><option value="<?= esc($type) ?>" <?= ($row['job_type'] ?? '') === $type ? 'selected' : '' ?>><?= esc($type) ?></option><?php endforeach; ?></select></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Experience</label><div class="col-sm-4"><input type="text" class="form-control" name="experience" maxlength="100" value="<?= esc($row['experience'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Short Description</label><div class="col-sm-8"><textarea class="form-control" name="short_description" rows="3"><?= esc($row['short_description'] ?? '') ?></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Job Description *</label><div class="col-sm-8"><textarea class="form-control" name="job_description" rows="6" required><?= esc($row['job_description'] ?? '') ?></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Requirements</label><div class="col-sm-8"><textarea class="form-control" name="requirements" rows="5"><?= esc($row['requirements'] ?? '') ?></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Apply Email</label><div class="col-sm-4"><input type="email" class="form-control" name="apply_email" maxlength="255" value="<?= esc($row['apply_email'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?= (int) ($row['sort_order'] ?? 0) ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="status" class="form-control"><option value="Active" <?= ($row['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option><option value="Inactive" <?= ($row['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option></select></div></div>
            <div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Update</button></div></div>
        </div></div>
        <?= form_close() ?>
    </div></div>
</section>
