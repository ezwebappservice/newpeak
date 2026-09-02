<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Upload Investor Document</h1>
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

            <?php echo form_open_multipart(base_url().'admin/investor_document/add', ['class' => 'form-horizontal']); ?>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Investor Category *</label>
                            <div class="col-sm-4">
                                <?= view('admin/includes/investor_category_select', [
                                    'categories' => $categories,
                                    'selected'   => null,
                                ]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Year *</label>
                            <div class="col-sm-4">
                                <select name="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    <?php foreach ($year_options as $groupLabel => $years): ?>
                                        <optgroup label="<?php echo esc($groupLabel); ?>">
                                            <?php foreach ($years as $year): ?>
                                                <option value="<?php echo esc($year); ?>"><?php echo esc($year); ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">File Title *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="file_title" required maxlength="255">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Type</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title_type" maxlength="255" placeholder="Optional">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Document Type</label>
                            <div class="col-sm-3">
                                <select name="document_type" class="form-control">
                                    <option value="">Optional</option>
                                    <?php foreach ($document_types as $type): ?>
                                        <option value="<?php echo esc($type); ?>"><?php echo esc($type); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Upload File *</label>
                            <div class="col-sm-6" style="margin-top:5px;">
                                <input type="file" name="upload_file" required>
                                <p class="help-block">Max size: <?php echo round(investor_config()->maxUploadSizeKb / 1024, 1); ?> MB. Allowed: PDF, DOC, DOCX, XLS, XLSX, CSV, HTML, TXT, ZIP.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status *</label>
                            <div class="col-sm-3">
                                <select name="status" class="form-control">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
