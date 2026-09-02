<?php
if(!$this->session->userdata('id')) { redirect(base_url().'admin'); }
?>
<section class="content-header">
	<div class="content-header-left"><h1>Edit Parent Category</h1></div>
	<div class="content-header-right"><a href="<?php echo base_url(); ?>admin/shop_parent_category" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
	<div class="row"><div class="col-md-12">
		<?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div><?php endif; ?>
		<?php echo form_open_multipart(base_url().'admin/shop_parent_category/edit/'.$category['parent_category_id'],array('class' => 'form-horizontal')); ?>
		<div class="box box-info"><div class="box-body">
			<div class="form-group"><label class="col-sm-2 control-label">Category Name <span>*</span></label><div class="col-sm-4"><input type="text" class="form-control" name="category_name" value="<?php echo $category['category_name']; ?>"></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Slug</label><div class="col-sm-4"><input type="text" class="form-control" name="category_slug" value="<?php echo $category['category_slug']; ?>"></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Existing Image</label><div class="col-sm-9" style="padding-top:5px"><img src="<?php echo base_url(); ?>public/uploads/<?php echo $category['category_image']; ?>" style="width:180px;"></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Image</label><div class="col-sm-9" style="padding-top:5px"><input type="file" name="category_image">(Only jpg, jpeg, gif and png)</div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?php echo $category['sort_order']; ?>"></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="status" class="form-control"><option value="1" <?php if($category['status']==1) echo 'selected'; ?>>Enabled</option><option value="0" <?php if($category['status']==0) echo 'selected'; ?>>Disabled</option></select></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Meta Title</label><div class="col-sm-9"><input type="text" class="form-control" name="meta_title" value="<?php echo $category['meta_title']; ?>"></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Meta Keywords</label><div class="col-sm-9"><textarea class="form-control" name="meta_keyword" style="height:80px;"><?php echo $category['meta_keyword']; ?></textarea></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Meta Description</label><div class="col-sm-9"><textarea class="form-control" name="meta_description" style="height:80px;"><?php echo $category['meta_description']; ?></textarea></div></div>
<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success pull-left" name="form1">Update</button></div></div>
		</div></div>
		<?php echo form_close(); ?>
	</div></div>
</section>