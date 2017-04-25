<?php (defined('BASEPATH')) OR exit('No direct script access allowed');?>
<div class="col-md-11">
    <div class="main-content col-content radius bg-white dnmain" >
        <a href="ass_category_them" class="btn btn-success">Thêm Loại assembly</a>
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
                    <td><?php echo $cat->cat_id;?></td>
                    <td><?php echo $cat->cat_title;?></td>
                    <td><img src="<?php echo $cat->cat_image;?>" height="60px" /></td>
                    <td><?php echo anchor('tc/ass_category_edit/'.$cat->cat_id.'', 'Sửa');?>
                    </td>
                </tr>
            <?php  } ?>


            </tr>
        </table>
    </div>
</div>