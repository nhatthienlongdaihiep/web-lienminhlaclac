<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<a href="<?php echo site_url('tc/n_add');?>" class="btn btn-success">Thêm news</a>
<h1><?php echo $title;?></h1>
<hr/>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Tiêu đề (click để xem)</th>
        <th>Ảnh minh họa</th>
        <th>Loại news</th>
        <th>Thao tác</th>
    </tr>
    <?php foreach($news AS $ass) { ;?>
        <tr class="text-left">
            <td><?php echo $ass->n_id;?></td>
            <td><a href="<?php echo site_url('home/view/'.$ass->n_id.'');?>"><?php echo $ass->n_title;?></a></td>
            <td><img src="<?php echo $ass->n_image;?>" height="60px" /></td>
            <td><?php echo $ass->nc_title;?></td>
            <td><?php echo anchor('tc/n_edit/'.$ass->n_id.'', 'Sửa');?> |
                <?php echo anchor('tc/n_del/'.$ass->n_id.'', 'Xóa', 'onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')"');?>
            </td>
        </tr>
    <?php  } ?>


    </tr>
</table>
