<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}

function ecom_order_status_label($status) {
    $map = [
        'pending'    => 'label-warning',
        'processing' => 'label-info',
        'completed'  => 'label-success',
        'cancelled'  => 'label-danger',
    ];
    $class = $map[$status] ?? 'label-default';
    return '<span class="label ' . $class . '">' . ucfirst(esc($status)) . '</span>';
}

function ecom_payment_label($method) {
    return $method === 'bank' ? 'Bank Transfer' : 'Cash on Delivery';
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Order History</h1>
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

            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number"><?php echo $status_counts['pending']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-refresh"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Processing</span>
                            <span class="info-box-number"><?php echo $status_counts['processing']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Completed</span>
                            <span class="info-box-number"><?php echo $status_counts['completed']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-red">
                        <span class="info-box-icon"><i class="fa fa-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cancelled</span>
                            <span class="info-box-number"><?php echo $status_counts['cancelled']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">All Orders (<?php echo $status_counts['total']; ?>)</h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($orders)): ?>
                            <tr><td colspan="10" class="text-center">No orders found yet.</td></tr>
                        <?php else: $i = 0; foreach($orders as $row): $i++; ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><strong><?php echo esc($row['order_number']); ?></strong></td>
                                <td><?php echo esc($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                <td><?php echo esc($row['email']); ?></td>
                                <td><?php echo esc($row['phone']); ?></td>
                                <td>$<?php echo number_format($row['total'], 2); ?></td>
                                <td><?php echo ecom_payment_label($row['payment_method']); ?></td>
                                <td><?php echo ecom_order_status_label($row['order_status']); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/shop_order/view/<?php echo $row['order_id']; ?>" class="btn btn-primary btn-xs">View</a>
                                    <a href="<?php echo base_url(); ?>admin/shop_order/delete/<?php echo $row['order_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this order?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
