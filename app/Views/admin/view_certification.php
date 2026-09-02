<?php
if(!$this->session->userdata('id')) {
	redirect(base_url().'admin');
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Home Certifications</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin/certification/add" class="btn btn-primary btn-sm">Add New</a>
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
								<th>Description</th>
								<th>Icon</th>
								<th>Order</th><th width="140">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; foreach ($certification as $row): $i++; ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo esc($row['name']); ?></td>
								<td><?php echo esc($row['description']); ?></td>
								<td><i class="<?php echo esc($row['icon']); ?>" style="font-size:30px;"></i></td>
								<td><?php echo (int) $row['sort_order']; ?></td><td>
									<a href="<?php echo base_url(); ?>admin/certification/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
									<a href="<?php echo base_url(); ?>admin/certification/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
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
