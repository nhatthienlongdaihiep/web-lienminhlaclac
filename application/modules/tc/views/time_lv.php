<h1><?php echo $title;?> <a href="<?php echo site_url('tc/time_add');?>" class="btn btn-success">Thêm khung giờ</a></h1>
<hr>

<?php if($time_lv){?>

<table class="table">
<tr>
	<th>Id</th>
	<th>Khung giờ</th>
	<th>Trạng thái</th>
	<th>Bắt đầu</th>
	<th>Kết thúc</th>
	<th>Ngày tạo</th>
	<th>Thao tác</th>
</tr>

<?php foreach($time_lv AS $time){ ?>
	<tr>
		<td><?php echo $time->id;?></td>
		<td><?php echo $time->time_name;?></td>
		<td><?php echo $time->status;?></td>
		<td><?php echo $time->time_start;?></td>
		<td><?php echo $time->time_end;?></td>
		<td><?php echo $time->created;?></td>
		<td><a href="<?php echo site_url('tc/time_edit/'.$time->id.'');?>">Sửa</a>
		| <a href="<?php echo site_url('tc/time_del/'.$time->id.'');?>"  onclick="return  confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
		</td>
	</tr>
<?php } ?>
</table>

<?php }else echo "<h3>Chưa có nội dung</h3>";?>