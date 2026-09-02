<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$row = $investor_document ?? [];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Investor Document</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/investor_document" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
            <?php endif; ?>

            <?php echo form_open_multipart(base_url().'admin/investor_document/edit/'.$row['id'], ['class' => 'form-horizontal']); ?>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Investor Category *</label>
                            <div class="col-sm-4">
                                <?= view('admin/includes/investor_category_select', [
                                    'categories' => $categories,
                                    'selected'   => $row['category_id'] ?? null,
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Year *</label>
                            <div class="col-sm-4">
                                <select name="year" class="form-control" required>
                                    <?php foreach ($year_options as $groupLabel => $years): ?>
                                        <optgroup label="<?php echo esc($groupLabel); ?>">
                                            <?php foreach ($years as $year): ?>
                                                <option value="<?php echo esc($year); ?>" <?php echo ($row['year'] ?? '') === $year ? 'selected' : ''; ?>><?php echo esc($year); ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">File Title *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="file_title" required maxlength="255" value="<?php echo esc($row['file_title'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Type</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title_type" maxlength="255" placeholder="Optional" value="<?php echo esc($row['title_type'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Document Type</label>
                            <div class="col-sm-3">
                                <select name="document_type" class="form-control">
                                    <option value="">Optional</option>
                                    <?php foreach ($document_types as $type): ?>
                                        <option value="<?php echo esc($type); ?>" <?php echo ($row['document_type'] ?? '') === $type ? 'selected' : ''; ?>><?php echo esc($type); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Current File</label>
                            <div class="col-sm-6">
                                <p><?php echo esc($row['original_file_name'] ?? ''); ?> (<?php echo esc(investor_format_file_size((int)($row['file_size'] ?? 0))); ?>)</p>
                                <a href="<?php echo base_url(); ?>admin/investor_document/download/<?php echo $row['id']; ?>" class="btn btn-info btn-xs">Download</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Replace File</label>
                            <div class="col-sm-6" style="margin-top:5px;">
                                <input type="file" name="upload_file">
                                <p class="help-block">Leave empty to keep current file.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status *</label>
                            <div class="col-sm-3">
                                <select name="status" class="form-control">
                                    <option value="Active" <?php echo ($row['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo ($row['status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
