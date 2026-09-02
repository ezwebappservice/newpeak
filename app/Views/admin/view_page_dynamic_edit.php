<?php
if(!$this->session->userdata('id')) {
    redirect(base_url().'admin');
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Dynamic Page</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>admin/page-dynamic" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php
            if(session()->getFlashdata('error')) {
                ?>
                <div class="callout callout-danger">
                    <p><?php echo session()->getFlashdata('error'); ?></p>
                </div>
                <?php
            }
            if(session()->getFlashdata('success')) {
                ?>
                <div class="callout callout-success">
                    <p><?php echo session()->getFlashdata('success'); ?></p>
                </div>
                <?php
            }
            ?>

            <?php echo form_open_multipart(base_url().'admin/page-dynamic/edit/'.$page_dynamic['id'], array('class' => 'form-horizontal'));?>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Name * </label>
                            <div class="col-sm-9">
                                <input type="text" autocomplete="off" class="form-control" name="name" value="<?php echo $page_dynamic['name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Slug </label>
                            <div class="col-sm-9">
                                <input type="text" autocomplete="off" class="form-control" name="slug" value="<?php echo $page_dynamic['slug']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Content *</label>
                            <div class="col-sm-9">
                                <textarea class="form-control editor" name="content" style="height:140px;"><?php echo $page_dynamic['content']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Banner</label>
                            <div class="col-sm-6">
                                <?php
                                if($page_dynamic['banner'] == '') {
                                    echo 'No photo found';
                                } else {
                                    ?><img src="<?php echo base_url(); ?>public/uploads/<?php echo $page_dynamic['banner']; ?>" alt="<?php echo $page_dynamic['name']; ?>" style="width:300px;"><?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Change Banner </label>
                            <div class="col-sm-9" style="margin-top:5px;">
                                <input type="file" name="banner">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Meta Title </label>
                            <div class="col-sm-9">
                                <input type="text" autocomplete="off" class="form-control" name="meta_title" value="<?php echo $page_dynamic['meta_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Meta Description </label>
                            <div class="col-sm-9">
                               <textarea class="form-control h_100" name="meta_description"><?php echo $page_dynamic['meta_description']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Status </label>
                            <div class="col-sm-2">
                                <select name="status" class="form-control select2">
                                    <option value="Active" <?php if(($page_dynamic['status'] ?? 'Active') === 'Active') {echo 'selected';} ?>>Active (visible on website)</option>
                                    <option value="Inactive" <?php if(($page_dynamic['status'] ?? '') === 'Inactive') {echo 'selected';} ?>>Inactive (hidden)</option>
                                </select>
                            </div>
                        </div>
<div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>