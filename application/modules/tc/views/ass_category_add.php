<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$cat_title = array(
    'label' => 'Tên Loại assembly',
    'name' => 'cat_title',
    'id' => 'cat_title',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
);

$cat_image = array(
    'label' => 'Link ảnh minh họa',
    'name' => 'cat_image',
    'id' => 'cat_image',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
);

?>

<h1 class="text-center"><?php echo $title;?></h1>
<hr/>
<?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
<div class="form-group">
    <label for="cat_title" class="col-md-2 control-label"><?php echo form_label($cat_title['label'], $cat_title['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($cat_title); ?>
    </div>
</div>
<div class="form-group">
    <label for="cat_image" class="col-md-2 control-label"><?php echo form_label($cat_image['label'], $cat_image['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($cat_image); ?>
    </div>
</div>

<div class="form-group">
    <label for="cat_cat_id" class="col-md-2 control-label"><?php echo form_label('Nội dung', 'cat_content'); ?>:</label>
    <div class="col-md-10">
        <textarea name="cat_content" class="ckeditor" id="editor1"></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
    </div>
</div>
<?php echo form_close();?>
