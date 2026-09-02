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
        <h1>Order Details</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/shop_order" class="btn btn-primary btn-sm">Back to Orders</a>
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

            <div class="row">
                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Order #<?php echo esc($order['order_number']); ?></h3>
                            <div class="box-tools"><?php echo ecom_order_status_label($order['order_status']); ?></div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4><i class="fa fa-user"></i> Customer</h4>
                                    <p>
                                        <strong><?php echo esc($order['first_name'] . ' ' . $order['last_name']); ?></strong><br>
                                        <?php echo esc($order['email']); ?><br>
                                        <?php echo esc($order['phone']); ?>
                                    </p>
                                    <?php if($order['customer_id']): ?>
                                    <p><small class="text-muted">Registered customer (ID: <?php echo (int) $order['customer_id']; ?>)</small></p>
                                    <?php else: ?>
                                    <p><small class="text-muted">Guest checkout</small></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-6">
                                    <h4><i class="fa fa-map-marker"></i> Shipping Address</h4>
                                    <p>
                                        <?php echo esc($order['address_line1']); ?><br>
                                        <?php if($order['address_line2']): ?><?php echo esc($order['address_line2']); ?><br><?php endif; ?>
                                        <?php echo esc($order['city'] . ', ' . $order['state'] . ' ' . $order['postal_code']); ?><br>
                                        <?php echo esc($order['country']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if(!empty($order['order_notes'])): ?>
                            <hr>
                            <h4><i class="fa fa-sticky-note"></i> Order Notes</h4>
                            <p><?php echo nl2br(esc($order['order_notes'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border"><h3 class="box-title">Order Items</h3></div>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($order_items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <?php if(!empty($item['featured_image'])): ?>
                                            <span class="pull-left" style="margin-right:10px;">
                                                <img src="<?php echo base_url(); ?>public/uploads/<?php echo esc($item['featured_image']); ?>" style="width:48px;height:48px;object-fit:cover;border-radius:4px;">
                                            </span>
                                            <?php endif; ?>
                                            <div class="media-body">
                                                <strong><?php echo esc($item['product_name']); ?></strong>
                                                <br><small>Product ID: <?php echo (int) $item['product_id']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo (int) $item['quantity']; ?></td>
                                    <td><strong>$<?php echo number_format($item['line_total'], 2); ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Order Total</th>
                                        <th>$<?php echo number_format($order['total'], 2); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border"><h3 class="box-title">Order Summary</h3></div>
                        <div class="box-body">
                            <p><strong>Order Date:</strong><br><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></p>
                            <p><strong>Payment Method:</strong><br><?php echo ecom_payment_label($order['payment_method']); ?></p>
                            <p><strong>Subtotal:</strong> $<?php echo number_format($order['subtotal'], 2); ?></p>
                            <p><strong>Total:</strong> <span style="font-size:20px;color:#4172a5;">$<?php echo number_format($order['total'], 2); ?></span></p>
                        </div>
                    </div>

                    <div class="box box-warning">
                        <div class="box-header with-border"><h3 class="box-title">Update Status</h3></div>
                        <div class="box-body">
                            <?php echo form_open(base_url('admin/shop_order/update_status/' . $order['order_id'])); ?>
                            <div class="form-group">
                                <label>Order Status</label>
                                <select name="order_status" class="form-control">
                                    <?php foreach($allowed_statuses as $st): ?>
                                    <option value="<?php echo $st; ?>" <?php echo $order['order_status'] === $st ? 'selected' : ''; ?>><?php echo ucfirst($st); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Update Status</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <a href="<?php echo base_url(); ?>admin/shop_order/delete/<?php echo $order['order_id']; ?>" class="btn btn-danger btn-block" onclick="return confirm('Delete this order permanently?');">
                        <i class="fa fa-trash"></i> Delete Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
