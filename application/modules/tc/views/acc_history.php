<h1><?php echo $title;?></h1>
<hr>


<table class="table">
<tr>
	<th>Mã tài khoản</th>
	<th>Tên khoản</th>
	<th>ID người thuê</th>
	<th>Tên người thuê</th>
	<th>Số tiền</th>
	<th>Thuê lúc</th>
</tr>
<?php foreach($histories AS $h){ ?>
	<tr>
		<td><?php echo $h->h_acc_id;?></td>
		<td><?php echo $h->acc_name;?></td>
		<td><?php echo $h->user_id;?>
		<td><?php echo $h->user_name;?></td>
		<td><?php echo number_format($h->h_price);?></td>
		<td><?php echo date("H:i d/m/y",$h->h_time);?></td>
	</tr>
<?php } ?>
</table>