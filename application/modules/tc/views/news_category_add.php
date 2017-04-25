<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$nc_title = array(
    'label' => 'Tên Loại news',
    'name' => 'nc_title',
    'id' => 'nc_title',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
);

$nc_image = array(
    'label' => 'Link ảnh minh họa',
    'name' => 'nc_image',
    'id' => 'nc_image',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
);

?>

<h1 class="text-center"><?php echo $title;?></h1>
<hr/>
<?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
<div class="form-group">
    <label for="nc_title" class="col-md-2 control-label"><?php echo form_label($nc_title['label'], $nc_title['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($nc_title); ?>
    </div>
</div>
<div class="form-group">
    <label for="nc_image" class="col-md-2 control-label"><?php echo form_label($nc_image['label'], $nc_image['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($nc_image); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
    </div>
</div>
<?php echo form_close();?>
