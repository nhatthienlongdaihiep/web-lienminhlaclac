<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$champ_name = array(
    'label' => 'Tên tướng',
    'name' => 'champ_name',
    'id' => 'champ_name',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $champ->champ_name,
);

$champ_image = array(
    'label' => 'Link ảnh minh họa',
    'name' => 'champ_image',
    'id' => 'champ_image',
    'class' => 'form-control',
    'maxlength' => 255,
    'size' => 30,
    'value' => $champ->champ_image,
);

?>
<div class="col-md-11">
    <div class="main-content col-content radius bg-white">
        <h1 class="text-center"><?php echo $title;?></h1>
        <hr/>
        <?php echo form_open($this->uri->uri_string(), 'role="form" class="form-horizontal"'); ?>
        <div class="form-group">
            <label for="champ_name" class="col-md-2 control-label"><?php echo form_label($champ_name['label'], $champ_name['id']); ?>:</label>
            <div class="col-md-10">
                <?php echo form_input($champ_name); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="champ_image" class="col-md-2 control-label"><?php echo form_label($champ_image['label'], $champ_image['id']); ?>:</label>
            <div class="col-md-10">
                <?php echo form_input($champ_image); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="champ_ass_id" class="col-md-2 control-label">Assembly:</label>
            <div class="col-md-10">
                <select name="champ_ass_id" class="form-control">
                    <?php foreach($assemblies AS $ass) { ?>
                        <option value="<?php echo $ass->ass_id;?>" <?php if($champ->champ_ass_id == $ass->ass_id){echo 'selected="true"';}?> >
                            <?php echo $ass->ass_title;?>
                        </option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-10 col-md-offset-2">
                <?php echo form_submit('submit', 'Lưu', 'class="btn btn-danger"  style="width: 100%"'); ?>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>
