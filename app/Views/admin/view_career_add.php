<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$jobTypes = ['Full Time', 'Part Time', 'Contract', 'Internship'];
?>
<section class="content-header">
    <div class="content-header-left"><h1>Add Job Opening</h1></div>
    <div class="content-header-right"><a href="<?= base_url('admin/career') ?>" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
    <div class="row"><div class="col-md-12">
        <?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?= session()->getFlashdata('error') ?></p></div><?php endif; ?>
        <?= form_open(base_url('admin/career/add'), ['class' => 'form-horizontal']) ?>
        <div class="box box-info"><div class="box-body">
            <div class="form-group"><label class="col-sm-2 control-label">Job Title *</label><div class="col-sm-8"><input type="text" class="form-control" name="job_title" required maxlength="255"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Department</label><div class="col-sm-4"><input type="text" class="form-control" name="department" maxlength="255" placeholder="e.g. Production"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Location</label><div class="col-sm-4"><input type="text" class="form-control" name="location" maxlength="255" placeholder="e.g. Nalagarh, HP"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Job Type</label><div class="col-sm-4"><select name="job_type" class="form-control"><option value="">Select type</option><?php foreach ($jobTypes as $type): ?><option value="<?= esc($type) ?>"><?= esc($type) ?></option><?php endforeach; ?></select></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Experience</label><div class="col-sm-4"><input type="text" class="form-control" name="experience" maxlength="100" placeholder="e.g. 2-5 years"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Short Description</label><div class="col-sm-8"><textarea class="form-control" name="short_description" rows="3" placeholder="Brief summary shown in job listing"></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Job Description *</label><div class="col-sm-8"><textarea class="form-control" name="job_description" rows="6" required></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Requirements</label><div class="col-sm-8"><textarea class="form-control" name="requirements" rows="5" placeholder="Qualifications, skills, etc."></textarea></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Apply Email</label><div class="col-sm-4"><input type="email" class="form-control" name="apply_email" maxlength="255" placeholder="Leave blank to use site email"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?= (int) ($next_sort_order ?? 1) ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="status" class="form-control"><option value="Active">Active</option><option value="Inactive">Inactive</option></select></div></div>
            <div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Submit</button></div></div>
        </div></div>
        <?= form_close() ?>
    </div></div>
</section>
