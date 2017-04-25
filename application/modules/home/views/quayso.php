<div id="main" class="c-section">
<div class="container text-center">
	<h1><?php echo $rand;?></h1>
	<?php if(!empty($trungs)){ ?> 
	<h3>Thành viên may mắn</h3>
	<table class="table">
		<thead>
			<th>Tên tài khoản</th>
			<th>Thời gian thuê</th>
			<th>Mã dự thưởng</th>
		</thead>
		<tbody>
			<?php foreach($trungs AS $trung){ ?>
				<tr>
					<td><?php echo $trung->user_login;?></td>
					<td><?php echo date("h:i d/m/Y", $trung->h_time);?></td>
					<td><?php echo $trung->h_time;?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<?php } else {
		echo '<h3>Không có ai có mã dự thưởng này</h3>';
	}?>
	<a href="<?php echo site_url().$this->uri->uri_string();?>" class="btn btn-success">Quay lại</a>
	
		<h3>Thể lệ</h3>
		- Những bạn thuê gói trên 10k sẽ có 1 mã dự thưởng<br/>
		- Một người thuê nhiều lần thì đc nhiều mã dự thưởng</br/>
		- Nhiều người có chung mã dự thưởng thì đc phần thưởng như nhau (không bị chia đôi thưởng)<br/>
</div>
</div>