<?php if(!$this->session->userdata('id')) { redirect(base_url().'admin'); } ?>
<section class="content-header"><div class="content-header-left"><h1>Add Product</h1></div><div class="content-header-right"><a href="<?php echo base_url(); ?>admin/shop_product" class="btn btn-primary btn-sm">View All</a></div></section>
<section class="content"><div class="row"><div class="col-md-12">
<?php if(session()->getFlashdata('error')): ?><div class="callout callout-danger"><p><?php echo session()->getFlashdata('error'); ?></p></div><?php endif; ?>
<?php echo form_open_multipart(base_url().'admin/shop_product/add',array('class'=>'form-horizontal')); ?>
<div class="box box-info"><div class="box-body">
<div class="form-group"><label class="col-sm-2 control-label">Product Name <span>*</span></label><div class="col-sm-6"><input type="text" class="form-control" name="product_name"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Slug</label><div class="col-sm-6"><input type="text" class="form-control" name="product_slug" placeholder="Auto if blank"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Price <span>*</span></label><div class="col-sm-2"><input type="text" class="form-control" name="price"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Stock Quantity</label><div class="col-sm-2"><input type="number" class="form-control" name="stock_quantity" value="0"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Parent Category</label><div class="col-sm-4"><select name="parent_category_id" id="parent_category_id" class="form-control select2"><option value="">Select</option><?php foreach($parent_categories as $row): ?><option value="<?php echo $row['parent_category_id']; ?>"><?php echo $row['category_name']; ?></option><?php endforeach; ?></select></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Sub Category</label><div class="col-sm-4"><select name="sub_category_id" id="sub_category_id" class="form-control select2"><option value="">Select</option><?php foreach($sub_categories as $row): ?><option value="<?php echo $row['sub_category_id']; ?>" data-parent="<?php echo $row['parent_category_id']; ?>"><?php echo $row['category_name']; ?></option><?php endforeach; ?></select></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Short Description <span>*</span></label><div class="col-sm-9"><textarea class="form-control" name="short_description" style="height:80px;"></textarea></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Full Description</label><div class="col-sm-9"><textarea class="form-control editor" name="full_description"></textarea></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Featured Image <span>*</span></label><div class="col-sm-9"><input type="file" name="featured_image"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Gallery Images</label><div class="col-sm-9"><input type="file" name="photos[]" multiple></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Sort Order</label><div class="col-sm-2"><input type="number" class="form-control" name="sort_order" value="0"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Status</label><div class="col-sm-2"><select name="status" class="form-control"><option value="1">Enabled</option><option value="0">Disabled</option></select></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Meta Title</label><div class="col-sm-9"><input type="text" class="form-control" name="meta_title"></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Meta Keywords</label><div class="col-sm-9"><textarea class="form-control" name="meta_keyword" style="height:80px;"></textarea></div></div>
<div class="form-group"><label class="col-sm-2 control-label">Meta Description</label><div class="col-sm-9"><textarea class="form-control" name="meta_description" style="height:80px;"></textarea></div></div>
<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-6"><button type="submit" class="btn btn-success" name="form1">Submit</button></div></div>
</div></div><?php echo form_close(); ?></div></div></section>
<script>
document.getElementById('parent_category_id').addEventListener('change', function(){
  var pid = this.value; var sub = document.getElementById('sub_category_id');
  for(var i=0;i<sub.options.length;i++){ var o=sub.options[i]; if(!o.value){o.style.display='block';continue;} o.style.display = (o.getAttribute('data-parent')==pid)?'block':'none'; }
  sub.value='';
});
</script>
