<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$n_title = array(
    'label' => 'Tên news',
    'name' => 'n_title',
    'id' => 'n_title',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $news->n_title,
);

$n_image = array(
    'label' => 'Link ảnh minh họa',
    'name' => 'n_image',
    'id' => 'n_image',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $news->n_image,
);

?>

<h1 class="text-center"><?php echo $title;?></h1>
<hr/>
<?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
<div class="form-group">
    <label for="n_active" class="col-md-2 control-label">Kích hoạt :</label>
    <div class="col-md-10">
       <input name="n_active" class="form_control" type="checkbox" <?php if($news->n_active == 1){echo 'checked="true"';}?> />
    </div>
</div>
<div class="form-group">
    <label for="<?php echo $n_title['id'];?>" class="col-md-2 control-label"><?php echo form_label($n_title['label'], $n_title['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($n_title); ?>
    </div>
</div>


<div class="form-group">
    <label for="n_image" class="col-md-2 control-label"><?php echo form_label($n_image['label'], $n_image['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($n_image); ?>
    </div>
</div>

<div class="form-group">
    <label for="n_nc_id" class="col-md-2 control-label"><?php echo form_label('Loại news', 'n_nc_id'); ?>:</label>
    <div class="col-md-10">
        <select name="n_nc_id" class="form-control">
            <?php print_r($categories); foreach($categories AS $category) { ?>
                <option value="<?php echo $category->nc_id;?>" <?php if(($category->nc_id == $news->n_nc_id)) {echo 'selected';}?>>
                    <?php echo $category->nc_title;?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="n_description" class="col-md-2 control-label"><?php echo form_label('Tóm tắt (nên để 300 kí tự)', 'n_description'); ?></label>
    <div class="col-md-10">
        <textarea name="n_description" class="ckeditor" id="editor0"><?php echo  $news->n_description;?></textarea>
    </div>
</div>
<div class="form-group">
    <label for="n_nc_id" class="col-md-2 control-label"><?php echo form_label('Nội dung', 'n_content'); ?></label>
    <div class="col-md-10">
        <textarea name="n_content" class="ckeditor" id="editor1"><?php echo  $news->n_content;?></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
    </div>
</div>
<?php echo form_close();?>
