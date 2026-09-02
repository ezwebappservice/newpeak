<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Navigation Menu</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/menu/add" class="btn btn-primary btn-sm">Add Menu Item</a>
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
                                <th>Menu Label</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th width="160">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $map = [];
                            foreach ($nav_menu as $r) { $map[(int)$r['id']] = $r; }
                            $i = 0;
                            foreach ($nav_menu as $row):
                                $i++;
                                $depth = 0;
                                $p = (int)($row['parent_id'] ?? 0);
                                while ($p > 0 && isset($map[$p]) && $depth < 10) {
                                    $depth++;
                                    $p = (int)($map[$p]['parent_id'] ?? 0);
                                }
                                $prefix = str_repeat('— ', $depth);
                                $link = ($row['link_type'] ?? '') === 'url'
                                    ? ($row['custom_url'] ?? '')
                                    : (($row['link_type'] ?? '') === 'none' ? '#' : ($row['slug'] ?? ''));
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo esc($prefix . $row['label']); ?></td>
                                <td><code><?php echo esc($link); ?></code></td>
                                <td><?php echo (int) $row['sort_order']; ?></td>
                                <td><?php echo esc($row['menu_status']); ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/menu/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                    <a href="<?php echo base_url(); ?>admin/menu/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this menu item?');">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="text-muted">Manage header navigation structure, links, and SEO meta tags. Page content meta can also be edited under <strong>Dynamic Pages</strong>.</p>
        </div>
    </div>
</section>
