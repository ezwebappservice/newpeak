<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Site Settings</h1>
	</div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
	<div class="row">
		<div class="col-md-12">
			<?php if(session()->getFlashdata('error')): ?>
				<div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div>
			<?php endif; ?>
			<?php if(session()->getFlashdata('success')): ?>
				<div class="callout callout-success"><p><?php echo session()->getFlashdata('success'); ?></p></div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_logo" data-toggle="tab">Logo</a></li>
					<li><a href="#tab_favicon" data-toggle="tab">Favicon</a></li>
					<li><a href="#tab_email" data-toggle="tab">Email</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="tab_logo">
						<?php echo form_open_multipart(base_url().'admin/setting/update',array('class' => 'form-horizontal')); ?>
						<div class="box box-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Current Logo</label>
									<div class="col-sm-6" style="padding-top:6px;">
										<img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['logo']; ?>" class="existing-photo" style="height:80px;">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Upload New Logo</label>
									<div class="col-sm-6" style="padding-top:6px;">
										<input type="file" name="photo_logo">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-success pull-left" name="form_logo">Update Logo</button>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>

					<div class="tab-pane" id="tab_favicon">
						<?php echo form_open_multipart(base_url().'admin/setting/update',array('class' => 'form-horizontal')); ?>
						<div class="box box-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Current Favicon</label>
									<div class="col-sm-6" style="padding-top:6px;">
										<img src="<?php echo base_url(); ?>public/uploads/<?php echo $setting['favicon']; ?>" class="existing-photo" style="height:40px;">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Upload New Favicon</label>
									<div class="col-sm-6" style="padding-top:6px;">
										<input type="file" name="photo_favicon">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-success pull-left" name="form_favicon">Update Favicon</button>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>

					

					<div class="tab-pane" id="tab_email">
						<?php echo form_open(base_url().'admin/setting/update',array('class' => 'form-horizontal')); ?>
						<div class="box box-info">
							<div class="box-body">
								<p class="text-muted" style="padding:0 15px 10px;">Used for contact form, newsletter, and other site emails.</p>
								<div class="form-group">
									<label class="col-sm-3 control-label">Send Email From *</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="send_email_from" maxlength="255" autocomplete="off" value="<?php echo esc($setting['send_email_from']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Receive Email To *</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="receive_email_to" maxlength="255" autocomplete="off" value="<?php echo esc($setting['receive_email_to']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Host</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="smtp_host" maxlength="255" autocomplete="off" value="<?php echo esc($setting['smtp_host']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Port</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="smtp_port" maxlength="255" autocomplete="off" value="<?php echo esc($setting['smtp_port']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Username</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="smtp_username" maxlength="255" autocomplete="off" value="<?php echo esc($setting['smtp_username']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">SMTP Password</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="smtp_password" maxlength="255" autocomplete="off" value="<?php echo esc($setting['smtp_password']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-success pull-left" name="form_email">Update</button>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>

					

				</div>
			</div>
		</div>
	</div>
</section>
