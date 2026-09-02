<?php if(!$this->session->userdata('id')) { redirect(base_url().'admin'); } ?>
<section class="content-header"><div class="content-header-left"><h1>Products</h1></div><div class="content-header-right"><a href="<?php echo base_url(); ?>admin/shop_product/add" class="btn btn-primary btn-sm">Add New</a></div></section>
<section class="content"><div class="row"><div class="col-md-12">
<?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div><?php endif; ?>
<?php if(session()->getFlashdata('success')): ?><div class="callout callout-success"><p><?php echo session()->getFlashdata('success'); ?></p></div><?php endif; ?>
<div class="box box-info"><div class="box-body table-responsive">
<table id="example1" class="table table-bordered table-striped">
<thead><tr><th>SL</th><th>Name</th><th>Slug</th><th>Price</th><th>Stock</th><th>Image</th><th>Status</th><th>Action</th></tr></thead>
<tbody><?php $i=0; foreach ($products as $row): $i++; ?>
<tr><td><?php echo $i; ?></td><td><?php echo esc($row['product_name']); ?></td><td><?php echo esc($row['product_slug']); ?></td><td><?php echo number_format($row['price'],2); ?></td><td><?php echo $row['stock_quantity']; ?></td>
<td><img src="<?php echo base_url(); ?>public/uploads/<?php echo $row['featured_image']; ?>" style="width:80px;"></td>
<td><?php echo $row['status']?'Enabled':'Disabled'; ?></td><td><a href="<?php echo base_url(); ?>admin/shop_product/edit/<?php echo $row['product_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
<a href="<?php echo base_url(); ?>admin/shop_product/delete/<?php echo $row['product_id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a></td></tr>
<?php endforeach; ?></tbody></table></div></div></div></div></section>
