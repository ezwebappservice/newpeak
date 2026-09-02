<?php
if(!$this->session->userdata('id')) {
	redirect(base_url().'admin');
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Add Parent Category</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin/shop_parent_category" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if(session()->getFlashdata('error')): ?>
				<div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
			<?php endif; ?>
			<?php echo form_open_multipart(base_url().'admin/shop_parent_category/add',array('class' => 'form-horizontal')); ?>
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Category Name <span>*</span></label>
							<div class="col-sm-4"><input type="text" class="form-control" name="category_name"></div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Slug</label>
							<div class="col-sm-4"><input type="text" class="form-control" name="category_slug" placeholder="Leave blank for auto-generation"></div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Image <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px"><input type="file" name="category_image">(Only jpg, jpeg, gif and png are allowed)</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Sort Order</label>
							<div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="0"></div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-2">
								<select name="status" class="form-control"><option value="1">Enabled</option><option value="0">Disabled</option></select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Title </label>
							<div class="col-sm-9"><input type="text" class="form-control" name="meta_title"></div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Keywords </label>
							<div class="col-sm-9"><textarea class="form-control" name="meta_keyword" style="height:80px;"></textarea></div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Description </label>
							<div class="col-sm-9"><textarea class="form-control" name="meta_description" style="height:80px;"></textarea></div>
						</div>
<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6"><button type="submit" class="btn btn-success pull-left" name="form1">Submit</button></div>
						</div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section>
