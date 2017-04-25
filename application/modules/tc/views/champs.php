<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<a href="<?php echo site_url('tc/ass_add');?>" class="btn btn-success">Thêm Assembly</a>
<h1><?php echo $title;?></h1>
<hr/>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Tên tướng</th>
        <th>Ảnh minh họa</th>
        <th>Assembly</th>
        <th>Thao tác</th>
    </tr>
    <?php foreach($champs AS $champ) { ;?>
        <tr class="text-left" id="champ_<?php echo $champ->champ_id;?>">
            <td><?php echo $champ->champ_id;?></td>
            <td><?php echo $champ->champ_name;?></td>
            <td><img src="<?php echo site_url().'style/img/assemblydb/'.$champ->champ_image;?>" height="60px" /></td>
            <td><a href="<?php echo site_url('tc/ass_edit/'.$champ->ass_id.'');?>" target="_blank"><?php echo $champ->ass_title;?></a></td>
            <td><?php echo anchor('tc/champ_edit/'.$champ->champ_id.'', 'Sửa tướng');?>
            </td>
        </tr>
    <?php  } ?>


    </tr>
</table>
