<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<a href="<?php echo site_url('tc/ass_add');?>" class="btn btn-success">Thêm Nick</a>
<h1><?php echo $title;?></h1>
<hr/>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Ảnh minh họa</th>
        <th>Loại Nick</th>
        <th>Thao tác</th>
    </tr>
    <?php foreach($assemblies AS $ass) { ;?>
        <tr class="text-left">
            <td><?php echo $ass->ass_id;?></td>
            <td><?php echo $ass->ass_title;?></td>
            <td><img src="<?php echo $ass->ass_image;?>" height="60px" /></td>
            <td><?php echo $ass->cat_title;?></td>
            <td><?php echo anchor('tc/ass_edit/'.$ass->ass_id.'', 'Sửa');?> |
                <?php echo anchor('tc/ass_del/'.$ass->ass_id.'', 'Xóa', 'onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')"');?>
            </td>
        </tr>
    <?php  } ?>


    </tr>
</table>
