<?php
if(!$this->session->userdata('id')) {
	redirect(base_url().'admin');
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Service</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin/service" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php
			if(session()->getFlashdata('error')) {
				?>
				<div class="callout callout-danger">
					<p><?php echo session()->getFlashdata('error'); ?></p>
				</div>
				<?php
			}
			if(session()->getFlashdata('success')) {
				?>
				<div class="callout callout-success">
					<p><?php echo session()->getFlashdata('success'); ?></p>
				</div>
				<?php
			}
			?>

			<?php echo form_open_multipart(base_url().'admin/service/add',array('class' => 'form-horizontal')); ?>
				<div class="box box-info">
					<div class="box-body">
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Name *</label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Short Description *</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="short_description" style="height:140px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Description *</label>
							<div class="col-sm-8">
								<textarea class="form-control editor" name="description"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Icon (Bootstrap)</label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="icon" value="" placeholder="bi bi-capsule">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Link URL / Text</label>
							<div class="col-sm-4">
								<input type="text" autocomplete="off" class="form-control" name="link_url" value="" placeholder="#products">
							</div>
							<div class="col-sm-4">
								<input type="text" autocomplete="off" class="form-control" name="link_text" value="" placeholder="Explore APIs">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo</label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Optional for home cards; jpg, jpeg, gif, png)
							</div>
						</div>
						<h3 class="seo-info">SEO Information</h3>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Title</label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="meta_title" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Keyword</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="meta_keyword" style="height:80px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Description</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="meta_description" style="height:80px;"></textarea>
							</div>
						</div>
<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>

					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>

</section>