<?php
if(!$this->session->userdata('id')) {
	redirect(base_url().'admin');
}
?>
<section class="content-header">
	<div class="content-header-left"><h1>Edit Certification</h1></div>
	<div class="content-header-right"><a href="<?php echo base_url(); ?>admin/certification" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
	<div class="row"><div class="col-md-12">
		<?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div><?php endif; ?>
		<?php echo form_open(base_url().'admin/certification/edit/'.$certification['id'], ['class' => 'form-horizontal']); ?>
		<div class="box box-info"><div class="box-body">
			<div class="form-group"><label class="col-sm-2 control-label">Name *</label><div class="col-sm-8"><input type="text" class="form-control" name="name" value="<?php echo esc($certification['name']); ?>" required></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Description *</label><div class="col-sm-8"><textarea class="form-control" name="description" style="height:120px;" required><?php echo esc($certification['description']); ?></textarea></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Icon *</label><div class="col-sm-8"><input type="text" class="form-control" name="icon" value="<?php echo esc($certification['icon']); ?>" required></div></div>
			<div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?php echo (int) $certification['sort_order']; ?>"></div></div>
<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Update</button></div></div>
		</div></div>
		<?php echo form_close(); ?>
	</div></div>
</section>
