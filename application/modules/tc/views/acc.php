<h1><?php echo $title;?> <a href="<?php echo site_url('tc/acc_add');?>" class="btn btn-success">Thêm tài khoản</a></h1>
<hr>

<table class="table">
<tr>
	<th>Mã tài khoản</th>
	<th>Tên khoản</th>
	<th>Auth key</th>
	<th>Thao tác</th>
</tr>

<?php foreach($accs AS $acc){ ?>
	<tr>
		<td><?php echo $acc->acc_id;?></td>
		<td><?php echo $acc->acc_name;?></td>
		<td><?php echo $acc->acc_pass;?></td>
		<td><a href="<?php echo site_url('tc/acc_edit/'.$acc->acc_id.'');?>">Sửa</a>
		| <a href="<?php echo site_url('tc/acc_delete/'.$acc->acc_id.'');?>"  onclick="return  confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
		| <a href="<?php echo site_url('tc/acc_history/'.$acc->acc_id.'');?>">Lịch sử</a>
		</td>
	</tr>
<?php } ?>
</table>