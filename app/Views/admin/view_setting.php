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
					<li><a href="#tab_top_bar" data-toggle="tab">Top Bar</a></li>
					<li><a href="#tab_email" data-toggle="tab">Email</a></li>
					<li><a href="#tab_banner" data-toggle="tab">Page Banners</a></li>
					<li><a href="#tab_general" data-toggle="tab">General</a></li>
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

					<div class="tab-pane" id="tab_top_bar">
						<?php echo form_open(base_url().'admin/setting/update',array('class' => 'form-horizontal')); ?>
						<div class="box box-info">
							<div class="box-body">
								<p class="text-muted" style="padding:0 15px 10px;">Shown in the site header bar (phone and email).</p>
								<div class="form-group">
									<label class="col-sm-3 control-label">Top Bar Email</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="top_bar_email" value="<?php echo esc($setting['top_bar_email']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Top Bar Phone</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="top_bar_phone" value="<?php echo esc($setting['top_bar_phone']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-success pull-left" name="form_top_bar">Update</button>
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

					<div class="tab-pane" id="tab_banner">
						<div class="box box-info">
							<div class="box-body">
								<p class="text-muted">Hero banners for module pages. Dynamic pages use their own banner from Admin → Dynamic Pages.</p>
								<table class="table table-bordered">
									<tr>
										<?php echo form_open_multipart(base_url().'admin/setting/update',array('class' => '')); ?>
										<td style="width:50%">
											<h4>Contact Page (/connect)</h4>
											<p><img src="<?php echo base_url().'public/uploads/'.$setting['banner_contact']; ?>" alt="" style="width:100%;height:auto;"></p>
										</td>
										<td style="width:50%">
											<h4>Change Banner</h4>
											<input type="file" name="photo">
											<input type="submit" class="btn btn-primary btn-xs" value="Update" style="margin-top:10px;" name="form_banner_contact">
										</td>
										<?php echo form_close(); ?>
									</tr>
									<tr>
										<?php echo form_open_multipart(base_url().'admin/setting/update',array('class' => '')); ?>
										<td style="width:50%">
											<h4>Leadership Page (/leadership-at-srl)</h4>
											<p><img src="<?php echo base_url().'public/uploads/'.$setting['banner_team']; ?>" alt="" style="width:100%;height:auto;"></p>
										</td>
										<td style="width:50%">
											<h4>Change Banner</h4>
											<input type="file" name="photo">
											<input type="submit" class="btn btn-primary btn-xs" value="Update" style="margin-top:10px;" name="form_banner_team">
										</td>
										<?php echo form_close(); ?>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="tab_general">
						<?php echo form_open(base_url().'admin/setting/update',array('class' => 'form-horizontal')); ?>
						<div class="box box-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Website Name</label>
									<div class="col-sm-4">
										<input type="text" name="website_name" class="form-control" value="<?php echo esc($setting['website_name']); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Preloader</label>
									<div class="col-sm-4">
										<select name="preloader_status" class="form-control select2">
											<option value="On" <?php if($setting['preloader_status'] == 'On') {echo 'selected';} ?>>On</option>
											<option value="Off" <?php if($setting['preloader_status'] == 'Off') {echo 'selected';} ?>>Off</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Live Chat Code</label>
									<div class="col-sm-6">
										<textarea name="tawk_live_chat_code" class="form-control" cols="30" rows="6"><?php echo esc($setting['tawk_live_chat_code']); ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Live Chat Status</label>
									<div class="col-sm-4">
										<select name="tawk_live_chat_status" class="form-control select2">
											<option value="On" <?php if($setting['tawk_live_chat_status'] == 'On') {echo 'selected';} ?>>On</option>
											<option value="Off" <?php if($setting['tawk_live_chat_status'] == 'Off') {echo 'selected';} ?>>Off</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-success pull-left" name="form_other">Update</button>
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
