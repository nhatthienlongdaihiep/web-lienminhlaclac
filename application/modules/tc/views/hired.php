<h1><?php echo $title;?> <a href="<?php echo site_url('tc/hired_add');?>" class="btn btn-success">Thêm khung giờ và acc cho thuê</a></h1>
<hr>

<?php if($hired){?>

<table class="table">
<tr>
	<th>Id</th>
	<th>Khung giờ</th>
	<th>Acc</th>
	<th>Giá cho thuê</th>
	<th>Ngày tạo</th>
	<th>Thao tác</th>
</tr>

<?php foreach($hired AS $hired){ ?>
	<tr>
		<td><?php echo $hired->id;?></td>
		<td><?php echo $hired->time_name;?></td>
		<td><?php echo $hired->acc_name;?></td>
		<td><?php echo $hired->price;?></td>
		<td><?php echo $hired->created;?></td>
		<td><a href="<?php echo site_url('tc/hired_edit/'.$hired->id.'');?>">Sửa</a>
		| <a href="<?php echo site_url('tc/hired_del/'.$hired->id.'');?>"  onclick="return  confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
		</td>
	</tr>
<?php } ?>
</table>

<?php }else echo "<h3>Chưa có nội dung</h3>";?>