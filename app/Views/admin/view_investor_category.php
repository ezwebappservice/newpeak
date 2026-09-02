<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Investor Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/investor_category/add" class="btn btn-primary btn-sm">Add Category</a>
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
                <div class="box-body">
                    <form method="get" action="<?php echo base_url(); ?>admin/investor_category" class="form-inline" style="margin-bottom:15px;">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search category..." value="<?php echo esc($search ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-default btn-sm">Search</button>
                        <?php if(!empty($search)): ?>
                            <a href="<?php echo base_url(); ?>admin/investor_category" class="btn btn-link btn-sm">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Position</th>
                                <th>Category Name</th>
                                <th>Parent Category</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach ($investor_categories as $row): $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo (int) ($row['sort_order'] ?? 0); ?></td>
                                    <td><?php echo esc($row['category_name']); ?></td>
                                    <td><?php echo esc($row['parent_name'] ?? '—'); ?></td>
                                    <td>
                                        <?php if(($row['status'] ?? 'Active') === 'Active'): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-default">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo esc($row['created_at'] ?? ''); ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>admin/investor_category/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="<?php echo base_url(); ?>admin/investor_category/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this category?');">Delete</a>
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
