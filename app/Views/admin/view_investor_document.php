<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$filters = $filters ?? [];
$query = http_build_query(array_filter([
    'keyword' => $filters['keyword'] ?? '',
    'category_id' => $filters['category_id'] ?? '',
    'year' => $filters['year'] ?? '',
    'document_type' => $filters['document_type'] ?? '',
    'status' => $filters['status'] ?? '',
]));
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Investor Documents</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/investor_document/add" class="btn btn-primary btn-sm">Upload Document</a>
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
                    <form method="get" action="<?php echo base_url(); ?>admin/investor_document" class="form-inline" style="margin-bottom:15px;">
                        <div class="form-group" style="margin-right:8px;">
                            <input type="text" name="keyword" class="form-control" placeholder="Search title..." value="<?php echo esc($filters['keyword'] ?? ''); ?>">
                        </div>
                        <div class="form-group" style="margin-right:8px;">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo (string)($filters['category_id'] ?? '') === (string)$cat['id'] ? 'selected' : ''; ?>><?php echo esc($cat['category_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-right:8px;">
                            <select name="year" class="form-control">
                                <option value="">All Years</option>
                                <?php foreach (investor_flat_year_list() as $year): ?>
                                    <option value="<?php echo esc($year); ?>" <?php echo ($filters['year'] ?? '') === $year ? 'selected' : ''; ?>><?php echo esc($year); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-right:8px;">
                            <select name="document_type" class="form-control">
                                <option value="">All Types</option>
                                <?php foreach ($document_types as $type): ?>
                                    <option value="<?php echo esc($type); ?>" <?php echo ($filters['document_type'] ?? '') === $type ? 'selected' : ''; ?>><?php echo esc($type); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-right:8px;">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="Active" <?php echo ($filters['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo ($filters['status'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default btn-sm">Filter</button>
                        <?php if($query): ?>
                            <a href="<?php echo base_url(); ?>admin/investor_document" class="btn btn-link btn-sm">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Title Type</th>
                                <th>Category</th>
                                <th>Year</th>
                                <th>Type</th>
                                <th>File</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Uploaded</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach ($investor_documents as $row): $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo esc($row['file_title']); ?></td>
                                    <td><?php echo esc($row['title_type'] ?: '-'); ?></td>
                                    <td><?php echo esc($row['category_name']); ?></td>
                                    <td><?php echo esc($row['year']); ?></td>
                                    <td><?php echo esc($row['document_type'] ?: '-'); ?></td>
                                    <td><?php echo esc($row['original_file_name']); ?></td>
                                    <td><?php echo esc(investor_format_file_size((int)$row['file_size'])); ?></td>
                                    <td>
                                        <?php if(($row['status'] ?? 'Active') === 'Active'): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-default">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo esc($row['created_at'] ?? ''); ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>admin/investor_document/download/<?php echo $row['id']; ?>" class="btn btn-info btn-xs">Download</a>
                                        <a href="<?php echo base_url(); ?>admin/investor_document/toggle_status/<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">Toggle Status</a>
                                        <a href="<?php echo base_url(); ?>admin/investor_document/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="<?php echo base_url(); ?>admin/investor_document/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this document?');">Delete</a>
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
