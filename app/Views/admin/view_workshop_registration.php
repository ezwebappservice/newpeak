<?php
if (! $this->session->userdata('id')) {
    redirect(base_url() . 'admin');
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Workshop Seats <?php if (($paid_count ?? 0) > 0): ?><small class="label label-success"><?= (int) $paid_count ?> paid</small><?php endif; ?></h1>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info" style="padding:10px 15px;">
                <form method="get" class="form-inline">
                    <label>Payment:</label>
                    <select name="status" class="form-control" style="width:auto;margin:0 10px;">
                        <option value="">All</option>
                        <option value="paid" <?= ($filter_status ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="pending" <?= ($filter_status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="failed" <?= ($filter_status ?? '') === 'failed' ? 'selected' : '' ?>>Failed</option>
                    </select>
                    <button type="submit" class="btn btn-default btn-sm">Filter</button>
                    <a href="<?= base_url('admin/workshop_registration') ?>" class="btn btn-link btn-sm">Reset</a>
                </form>
            </div>

            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>WhatsApp</th>
                                <th>Medium</th>
                                <th>Heard from</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Razorpay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($registrations)): ?>
                                <tr>
                                    <td colspan="10" class="text-center">No workshop registrations yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php $i = 0; foreach ($registrations as $row): $i++; ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= esc($row['created_at'] ?? '') ?></td>
                                    <td>
                                        <?= esc(trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?>
                                        <?php if (trim((string) ($row['topic'] ?? '')) !== ''): ?>
                                            <br><small><?= esc($row['topic']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="mailto:<?= esc($row['email'] ?? '', 'attr') ?>"><?= esc($row['email'] ?? '') ?></a></td>
                                    <td><?= esc($row['phone'] ?? '') ?></td>
                                    <td><?= esc($row['medium'] ?? '') ?></td>
                                    <td><?= esc($row['heard_from'] ?? '') ?></td>
                                    <td>₹<?= esc(number_format(((int) ($row['amount_paise'] ?? 0)) / 100)) ?></td>
                                    <td>
                                        <?php if (($row['payment_status'] ?? '') === 'paid'): ?>
                                            <span class="label label-success">Paid</span>
                                        <?php elseif (($row['payment_status'] ?? '') === 'pending'): ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php else: ?>
                                            <span class="label label-danger"><?= esc(ucfirst((string) ($row['payment_status'] ?? 'Failed'))) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($row['razorpay_payment_id'] ?? $row['razorpay_order_id'] ?? '—') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
