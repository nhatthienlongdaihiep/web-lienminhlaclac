<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<div class="col-md-11">
    <div class="main-content col-content radius bg-white dnmain" >
        <a href="n_category_add" class="btn btn-success">Thêm Loại news</a>
        <h1><?php echo $title;?></h1>
        <hr/>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Ảnh minh họa</th>
                <th>Thao tác</th>
            </tr>
            <?php foreach($categories AS $cat) { ;?>
                <tr class="text-left">
                    <td><?php echo $cat->nc_id;?></td>
                    <td><?php echo $cat->nc_title;?></td>
                    <td><img src="<?php echo $cat->nc_image;?>" height="60px" /></td>
                    <td><?php echo anchor('tc/n_category_edit/'.$cat->nc_id.'', 'Sửa');?>
                    </td>
                </tr>
            <?php  } ?>


            </tr>
        </table>
    </div>
</div>