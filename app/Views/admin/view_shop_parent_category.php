<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Parent Categories</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin/shop_parent_category/add" class="btn btn-primary btn-sm">Add New</a>
	</div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="callout callout-success"><p><?php echo session()->getFlashdata('success'); ?></p></div>
        <?php endif; ?>
      <div class="box box-info">
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>SL</th>
			        <th>Name</th>
                    <th>Slug</th>
                    <th>Image</th>
                    <th>Sort</th>
                    <th>Status</th><th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php $i=0; foreach ($categories as $row): $i++; ?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo esc($row['category_name']); ?></td>
	                    <td><?php echo esc($row['category_slug']); ?></td>
                        <td><img src="<?php echo base_url(); ?>public/uploads/<?php echo $row['category_image']; ?>" alt="" style="width:120px;"></td>
                        <td><?php echo $row['sort_order']; ?></td>
                        <td><?php echo $row['status'] ? 'Enabled' : 'Disabled'; ?></td><td>
	                        <a href="<?php echo base_url(); ?>admin/shop_parent_category/edit/<?php echo $row['parent_category_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
	                        <a href="<?php echo base_url(); ?>admin/shop_parent_category/delete/<?php echo $row['parent_category_id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
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
