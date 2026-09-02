<?php
if(!$this->session->userdata('id')) {
	redirect(base_url().'admin');
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Newsletter Subscribers</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>admin/subscriber/delete_pending" class="btn btn-default btn-sm" onClick="return confirm('Remove all pending (unverified) subscribers?');">Remove Pending</a>
		<a href="<?php echo base_url(); ?>admin/subscriber/export_csv" class="btn btn-primary btn-sm">Export CSV</a>
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
								<th>Email</th>
								<th>Subscribed On</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=0; foreach (($subscribers ?? []) as $row): $i++; ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><a href="mailto:<?php echo esc($row['subs_email'], 'attr'); ?>"><?php echo esc($row['subs_email']); ?></a></td>
									<td><?php echo esc($row['subs_date_time'] ?? $row['subs_date'] ?? ''); ?></td>
									<td>
										<?php if((int)($row['subs_active'] ?? 0) === 1): ?>
											<span class="label label-success">Active</span>
										<?php else: ?>
											<span class="label label-warning">Pending</span>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?php echo base_url(); ?>admin/subscriber/delete/<?php echo $row['subs_id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Delete this subscriber?');">Delete</a>
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
