<div id="main" class="c-section text-center" style="background: #000;">
	<h2 class="c-items__title u-text-gradient"><?php echo $title;?></h2>
	<div class="container">
	<?php if($this->session->flashdata('success')) { ?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $this->session->flashdata('success');?>
	</div>
	<?php } ?>

	<?php if($this->session->flashdata('warning')) { ?>
	<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $this->session->flashdata('warning');?>
	</div>
	<?php } ?>

	<?php if($this->session->flashdata('error')) { ?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('error');?>
	</div>
	<?php } ?>
	<table class="table">
	<thead>
		<tr>
			<th width="70px">Số TT</th>
			<th>ID</th>
			<th>Cộng/trừ</th>
			<th width="100px">Số tiền</th>
			<th>Nội dung</th>
			<th>Thời gian</th>
		</tr>
	</thead>
	<tbody>
		<?php $stt = 0; foreach($logs AS $l) : $stt++; ?>
			<tr>
				<td><?php echo $stt;?></td>
				<td><?php echo $l->c_id;?></td>
				<td><?php if($l->c_updown == 0) {echo '-';} else {echo '+';}?></td>
				<td><?php echo number_format($l->c_amount);?></td>
				<td><?php echo $l->c_notice;?></td>
				<td><?php echo date("d/m/Y H:i:s", $l->c_time);?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
	</table>
	</div>
</div>