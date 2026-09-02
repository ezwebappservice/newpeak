<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$basePath = $base_path ?? 'admin/api_product_oncology';
$moduleTitle = $module_title ?? 'API Products';
$row = $product ?? [];
?>
<section class="content-header">
    <div class="content-header-left"><h1>Edit <?= esc($moduleTitle) ?></h1></div>
    <div class="content-header-right"><a href="<?= base_url($basePath) ?>" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
    <div class="row"><div class="col-md-12">
        <?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?= session()->getFlashdata('error') ?></p></div><?php endif; ?>
        <?= form_open(base_url($basePath . '/edit/' . ($row['id'] ?? 0)), ['class' => 'form-horizontal']) ?>
        <div class="box box-info"><div class="box-body">
            <div class="form-group"><label class="col-sm-2 control-label">Product Name *</label><div class="col-sm-8"><input type="text" class="form-control" name="product_name" required maxlength="255" value="<?= esc($row['product_name'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Therapeutic Category</label><div class="col-sm-4"><input type="text" class="form-control" name="therapeutic_category" maxlength="255" value="<?= esc($row['therapeutic_category'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">US DMF</label><div class="col-sm-4"><input type="text" class="form-control" name="us_dmf" maxlength="255" value="<?= esc($row['us_dmf'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">EU Status / CEP</label><div class="col-sm-4"><input type="text" class="form-control" name="eu_status" maxlength="255" value="<?= esc($row['eu_status'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Patent Status</label><div class="col-sm-4"><input type="text" class="form-control" name="patent_status" maxlength="255" value="<?= esc($row['patent_status'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Remarks</label><div class="col-sm-2"><input type="text" class="form-control" name="remarks" maxlength="50" value="<?= esc($row['remarks'] ?? '') ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?= (int) ($row['sort_order'] ?? 0) ?>"></div></div>
            <div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="status" class="form-control"><option value="Active" <?= ($row['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option><option value="Inactive" <?= ($row['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option></select></div></div>
<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Update</button></div></div>
        </div></div>
        <?= form_close() ?>
    </div></div>
</section>
