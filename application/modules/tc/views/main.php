<script src="<?php echo site_url();?>style/js/list.min.js"></script>
<script src="<?php echo site_url();?>style/js/list.pagination.min.js"></script>
		
		
<div id="danhsach">
<input class="search form-control" placeholder="Gõ một vài thông tin để tìm kiếm"/>

<table class="table">
<thead>
	<tr>
	        <th><button class="sort btn btn-default" data-sort="h_id">LS ID</button></th>
		<th><button class="sort btn btn-default" data-sort="h_c_id">Đơn hàng</button></th>
		<th><button class="sort btn btn-default" data-sort="h_user_id">User ID</button></th>
		<th><button class="sort btn btn-default" data-sort="user_name">User name</button></th>
		<th><button class="sort btn btn-default" data-sort="h_acc_id">Acc ID</button></th>
		<th><button class="sort btn btn-default" data-sort="acc_name">Tài khoản</button></th>
		<th><button class="sort btn btn-default" data-sort="acc_pass">Mật khẩu</button></th>
		<th><button class="sort btn btn-default" data-sort="h_start_time">Bắt đầu</button></th>
		<th><button class="sort btn btn-default" data-sort="h_stop_time">Kết thúc</button></th>
		<th><button class="sort btn btn-default" data-sort="h_price">Số tiền</button></th>
		<th><button class="sort btn btn-default" data-sort="h_time">Thanh toán lúc</button></th>
		<th><button class="sort btn btn-default" data-sort="h_stt">Trạng thái</button></th>
		<th><button class="sort btn btn-default" data-sort="h_key">Key ảo</button></th>
		<th><button class="sort btn btn-default" data-sort="h_stt">Thao tác</button></th>
	</tr>
</thead>

<tbody class="list">
	<?php foreach($his AS $hi) { ?>
		<tr>
		        
			<td class="h_id"><?php echo $hi->h_id;?></td> 
			<td class="h_c_id"><?php echo $hi->h_c_id;?></td> 
			<td class="h_user_id"><?php echo $hi->h_user_id;?></td>
			<td class="user_name"><?php if(strlen($hi->user_name) > 16){echo '<span style="font-size: '.(16/strlen($hi->user_name)*100).'%"> '.$hi->user_name.' </span>';} else {echo $hi->user_name;}?></td>
			<td class="h_acc_id"><a href="<?php echo site_url('tc/acc_edit/'.$hi->acc_id.'');?>">Acc<?php echo $hi->acc_id;?></a></td>
			<td class="acc_name"><a href="<?php echo site_url('tc/acc_edit/'.$hi->acc_id.'');?>"><?php echo $hi->acc_name;?></a></td>
			<td class="acc_pass"><?php echo $hi->acc_pass;?></td>
			<td class="h_start_time"><?php echo date("H:i:s d/m", $hi->h_start_time);?></td>
			<td class="h_stop_time"><?php echo date("H:i:s d/m", $hi->h_stop_time);?></td>
			<td class="h_price"><?php echo number_format($hi->h_price);?></td>
			<td class="h_time"><?php echo date("H:i:s d/m", $hi->h_time);?></td>
			<td class="h_stt"><?php echo $hi->h_stt;?></td>
			<td class="h_stt"><a href="<?php echo site_url('tc/acc_edit/'.$hi->acc_id.'');?>"><?php echo $hi->h_key;?></a></td>
			<td><?php if($hi->h_stt == 'DANGCHO'){ ?><a href="<?php echo site_url('tc/tralai/'.$hi->h_id.'');?>" onclick="return  confirm('Tiền sẽ được hoàn trả lại cho khách và tên bạn được lưu lại trong nội dung hoàn trả. Bạn chắc chắn muốn thực hiện thao tác này chứ?')">Trả lại</a><?php } ?></td>
                       
			
		</tr>
	<?php } ?>
</tbody> 
</table>
<ul class="pagination"></ul>
</div>
<script>
var options = {
  valueNames: ['h_id', 'h_c_id', 'h_user_id','user_name','h_acc_id','acc_name', 'acc_pass','h_start_time','h_stop_time','h_price','h_time','h_stt' ],

};

var userList = new List('danhsach', options);
</script>