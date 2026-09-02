<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Investor Category</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/investor_category" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
            <?php endif; ?>

            <?php echo form_open(base_url().'admin/investor_category/add', ['class' => 'form-horizontal']); ?>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category Name *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="category_name" required maxlength="255">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">URL Slug</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="category_slug" maxlength="255" placeholder="auto-generated if blank">
                                <p class="help-block">Used in frontend URLs, e.g. investor-relations/documents/<strong>annual-reports</strong></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sort Order *</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="sort_order" min="0" step="1" required value="<?php echo (int) ($next_sort_order ?? 1); ?>">
                                <p class="help-block">Lower numbers appear first in menu and frontend pages.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Parent Category</label>
                            <div class="col-sm-4">
                                <select name="parent_id" class="form-control">
                                    <option value="">None (Top-level category)</option>
                                    <?php foreach ($parent_categories as $parent): ?>
                                        <option value="<?php echo (int) $parent['id']; ?>"><?php echo esc($parent['category_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block">Optional. Use a parent to group related sub-categories.</p>
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
                                <button type="submit" class="btn btn-success" name="form1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
