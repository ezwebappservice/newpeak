<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$basePath = $base_path ?? 'admin/api_product_oncology';
$moduleTitle = $module_title ?? 'API Products';
?>
<section class="content-header">
    <div class="content-header-left">
        <h1><?= esc($moduleTitle) ?></h1>
    </div>
    <div class="content-header-right">
        <a href="<?= base_url($basePath . '/add') ?>" class="btn btn-primary btn-sm">Add Product</a>
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
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>US DMF</th>
                                <th>EU Status</th>
                                <th>Patent</th>
                                <th>Remarks</th>
                                <th>Order</th>
                                <th>Status</th><th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach (($products ?? []) as $row): $i++; ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= esc($row['product_name']) ?></td>
                                    <td><?= esc($row['therapeutic_category'] ?? '—') ?></td>
                                    <td><?= esc($row['us_dmf'] ?? '—') ?></td>
                                    <td><?= esc($row['eu_status'] ?? '—') ?></td>
                                    <td><?= esc($row['patent_status'] ?? '—') ?></td>
                                    <td><?= esc($row['remarks'] ?? '—') ?></td>
                                    <td><?= (int) ($row['sort_order'] ?? 0) ?></td>
                                    <td><?= esc($row['status'] ?? 'Active') ?></td><td>
                                        <a href="<?= base_url($basePath . '/edit/' . $row['id']) ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="<?= base_url($basePath . '/delete/' . $row['id']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this product?');">Delete</a>
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
