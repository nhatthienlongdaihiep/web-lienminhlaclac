<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$ass_title = array(
    'label' => 'Tên Assembly',
    'name' => 'ass_title',
    'id' => 'ass_title',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $assembly->ass_title,
);
$ass_github= array(
    'label' => 'Link gihub',
    'name' => 'ass_github',
    'id' => 'ass_github',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $assembly->ass_github,
);
$ass_image = array(
    'label' => 'Link ảnh minh họa',
    'name' => 'ass_image',
    'id' => 'ass_image',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $assembly->ass_image,
);

?>

<h1 class="text-center"><?php echo $title;?></h1>
<hr/>
<?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
<div class="form-group">
    <label for="ass_active" class="col-md-2 control-label">Kích hoạt :</label>
    <div class="col-md-10">
       <input name="ass_active" class="form-control" type="checkbox" <?php if($assembly->ass_active == 1){echo 'checked="true"';}?> />
    </div>
</div>
<div class="form-group">
    <label for="<?php echo $ass_title['id'];?>" class="col-md-2 control-label"><?php echo form_label($ass_title['label'], $ass_title['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($ass_title); ?>
    </div>
</div>

<div class="form-group">
    <label for="<?php echo $ass_github['id'];?>" class="col-md-2 control-label"><?php echo form_label($ass_github['label'], $ass_github['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($ass_github); ?>
    </div>
</div>

<div class="form-group">
    <label for="ass_image" class="col-md-2 control-label"><?php echo form_label($ass_image['label'], $ass_image['id']); ?>:</label>
    <div class="col-md-10">
        <?php echo form_input($ass_image); ?>
    </div>
</div>

<div class="form-group">
    <label for="ass_cat_id" class="col-md-2 control-label"><?php echo form_label('Loại assembly', 'ass_cat_id'); ?>:</label>
    <div class="col-md-10">
        <select name="ass_cat_id" class="form-control">
            <?php print_r($categories); foreach($categories AS $category) { ?>
                <option value="<?php echo $category->cat_id;?>" <?php if(($category->cat_id == $assembly->ass_cat_id)) {echo 'selected';}?>>
                    <?php echo $category->cat_title;?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="ass_description" class="col-md-2 control-label"><?php echo form_label('Tóm tắt (nên để 300 kí tự)', 'ass_description'); ?></label>
    <div class="col-md-10">
        <textarea name="ass_description" class="ckeditor" id="editor0"><?php echo  $assembly->ass_description;?></textarea>
    </div>
</div>
<div class="form-group">
    <label for="ass_cat_id" class="col-md-2 control-label"><?php echo form_label('Nội dung', 'ass_content'); ?></label>
    <div class="col-md-10">
        <textarea name="ass_content" class="ckeditor" id="editor1"><?php echo  $assembly->ass_content;?></textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
    </div>
</div>
<?php echo form_close();?>
