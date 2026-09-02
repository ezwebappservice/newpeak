<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
$linkType = $nav_menu['link_type'] ?? 'page';
?>
<section class="content-header">
    <div class="content-header-left"><h1>Edit Menu Item</h1></div>
    <div class="content-header-right"><a href="<?php echo base_url(); ?>admin/menu" class="btn btn-primary btn-sm">View All</a></div>
</section>
<section class="content">
<div class="row"><div class="col-md-12">
<?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div><?php endif; ?>
<?php echo form_open(base_url('admin/menu/edit/'.$nav_menu['id']), ['class' => 'form-horizontal']); ?>
<div class="box box-info"><div class="box-body">
    <div class="form-group"><label class="col-sm-2 control-label">Label *</label><div class="col-sm-8"><input type="text" class="form-control" name="label" value="<?php echo esc($nav_menu['label']); ?>" required></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Parent</label><div class="col-sm-8"><select name="parent_id" class="form-control select2"><?php foreach($parent_options as $opt): ?><option value="<?php echo $opt['id']; ?>" <?php if((int)$nav_menu['parent_id']===$opt['id']) echo 'selected'; ?>><?php echo esc($opt['label']); ?></option><?php endforeach; ?></select></div></div>
    <div class="form-group"><label class="col-sm-2 control-label">Link Type</label><div class="col-sm-3"><select name="link_type" class="form-control select2" id="linkType"><option value="page" <?php if($linkType==='page') echo 'selected'; ?>>Page / Slug</option><option value="url" <?php if($linkType==='url') echo 'selected'; ?>>Custom URL</option><option value="none" <?php if($linkType==='none') echo 'selected'; ?>>No Link (dropdown only)</option></select></div></div>
    <div class="form-group" id="slugGroup" style="<?php echo $linkType==='page' ? '' : 'display:none;'; ?>"><label class="col-sm-2 control-label">Page Slug</label><div class="col-sm-8"><select name="slug" class="form-control select2"><option value="">— Select page —</option><?php
    $lastGroup = '';
    foreach ($page_options as $opt):
        if ($lastGroup !== $opt['group']):
            if ($lastGroup !== '') echo '</optgroup>';
            echo '<optgroup label="' . esc($opt['group']) . '">';
            $lastGroup = $opt['group'];
        endif;
    ?><option value="<?php echo esc($opt['slug']); ?>" <?php if(($nav_menu['slug'] ?? '')===$opt['slug']) echo 'selected'; ?>><?php echo esc($opt['name']); ?> (<?php echo esc($opt['slug']); ?>)</option><?php endforeach; if ($lastGroup !== '') echo '</optgroup>'; ?></select></div></div>
    <div class="form-group" id="urlGroup" style="<?php echo $linkType==='url' ? '' : 'display:none;'; ?>"><label class="col-sm-2 control-label">Custom URL</label><div class="col-sm-8"><input type="text" class="form-control" name="custom_url" value="<?php echo esc($nav_menu['custom_url'] ?? ''); ?>"></div></div>
    <div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="<?php echo (int)($nav_menu['sort_order'] ?? 0); ?>"></div></div>
    <div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="menu_status" class="form-control select2"><option value="Show" <?php if(($nav_menu['menu_status'] ?? '')==='Show') echo 'selected'; ?>>Show</option><option value="Hide" <?php if(($nav_menu['menu_status'] ?? '')==='Hide') echo 'selected'; ?>>Hide</option></select></div></div>
    <h3 class="seo-info">SEO Meta Tags</h3>
    <div class="form-group"><label class="col-sm-2 control-label">Meta Title</label><div class="col-sm-8"><input type="text" class="form-control" name="meta_title" value="<?php echo esc($nav_menu['meta_title'] ?? ''); ?>"></div></div>
    <div class="form-group"><label class="col-sm-2 control-label">Meta Keyword</label><div class="col-sm-8"><textarea class="form-control" name="meta_keyword" style="height:70px;"><?php echo esc($nav_menu['meta_keyword'] ?? ''); ?></textarea></div></div>
    <div class="form-group"><label class="col-sm-2 control-label">Meta Description</label><div class="col-sm-8"><textarea class="form-control" name="meta_description" style="height:80px;"><?php echo esc($nav_menu['meta_description'] ?? ''); ?></textarea></div></div>
    <div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Update</button></div></div>
</div></div>
<?php echo form_close(); ?>
</div></div>
</section>
<script>
document.getElementById('linkType').addEventListener('change', function () {
  var t = this.value;
  document.getElementById('slugGroup').style.display = t === 'page' ? '' : 'none';
  document.getElementById('urlGroup').style.display = t === 'url' ? '' : 'none';
});
</script>
