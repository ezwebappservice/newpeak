<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$row = $investor_category ?? [];
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Investor Category</h1>
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

            <?php echo form_open(base_url().'admin/investor_category/edit/'.$row['id'], ['class' => 'form-horizontal']); ?>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category Name *</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="category_name" required maxlength="255" value="<?php echo esc($row['category_name'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">URL Slug</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="category_slug" maxlength="255" value="<?php echo esc($row['category_slug'] ?? ''); ?>">
                                <p class="help-block">Leave blank to regenerate from category name.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sort Order *</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="sort_order" min="0" step="1" required value="<?php echo (int) ($row['sort_order'] ?? 0); ?>">
                                <p class="help-block">Lower numbers appear first in menu and frontend pages.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Parent Category</label>
                            <div class="col-sm-4">
                                <select name="parent_id" class="form-control" <?php echo ! empty($has_children) ? 'disabled' : ''; ?>>
                                    <option value="">None (Top-level category)</option>
                                    <?php foreach ($parent_categories as $parent): ?>
                                        <option value="<?php echo (int) $parent['id']; ?>" <?php echo (string) ($row['parent_id'] ?? '') === (string) $parent['id'] ? 'selected' : ''; ?>>
                                            <?php echo esc($parent['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (! empty($has_children)): ?>
                                    <input type="hidden" name="parent_id" value="">
                                    <p class="help-block">Parent cannot be changed while sub-categories exist.</p>
                                <?php else: ?>
                                    <p class="help-block">Optional. Only top-level categories can be selected as parent.</p>
                                <?php endif; ?>
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
