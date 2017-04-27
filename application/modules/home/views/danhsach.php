<?php 
function cmp($a, $b){
	$ae = $a[count($a)-1]->h_stop_time;
	$be = $b[count($b)-1]->h_stop_time;
	if ($ae == $be) {
		return 0;
	}
	return ($ae < $be) ? -1 : 1;
}
?>
	<div class="hr"></div>
<div id="main" class="c-section text-center danhsach_acc">
	<div class="container">

	<?php 	$ds_thue = array();
			$ds_cho = array();
			if(!empty($accs_dangthue)){ ?>
			<div class="" id="dangthue">
			<div class="dangthue_content">
			<?php $dem_acc_thue = 0; 
			
			foreach($accs_dangthue AS $acc){
				if($acc->h_stt == 'DANGTHUE' || $acc->h_stt == 'DANGCHO') {
					$dem_acc_thue++;
					if($acc->h_stt == 'DANGTHUE'){
						$ds_thue[] = $acc->acc_id;
					}
					if($acc->h_stt == 'DANGCHO'){
						$ds_cho[] = $acc->acc_id;
					}
				}
			}
			if($dem_acc_thue > 0){
				$dem_acc_thue = 0;
				//echo '<h2 class="c-items__title u-text-gradient">Tài khoản của bạn</h2><div style="color: #FFF!important; font-size: 20px">';
				foreach($accs_dangthue AS $acc){
				if($acc->h_stt == 'DANGTHUE') {
					$dem_acc_thue++;
					$tgian_het = $acc->h_stop_time;
					if($acc->h_start_time <= time()){
						//echo 'Tài khoản <a class="scrollto" href="#acc_'.($this->gm_model->int_to_string($acc->acc_id)).'">'.($this->gm_model->int_to_string($acc->acc_id)).' (click vào đây để tới tài khoản)</a>. Thời gian: '.date("H:i d/m", $acc->h_start_time).' đến '.date("H:i d/m", $acc->h_stop_time).'.<br/>Auth Key: <strong style="color: #FFF">'.$acc->h_key.'</strong><br>';
					} else {
						//echo 'Tài khoản <a class="scrollto" href="#acc_'.($this->gm_model->int_to_string($acc->acc_id)).'">'.($this->gm_model->int_to_string($acc->acc_id)).' (click vào đây để tới tài khoản)</a>. Đã đặt trước, sẽ có lúc '.date("H:i d/m/Y", $acc->h_start_time).'.<br/></center>';
					}
				
				} elseif($acc->h_stt == 'DANGCHO'){
					$dem_acc_thue++;
					//echo 'Tài khoản <a class="scrollto" href="#acc_'.($this->gm_model->int_to_string($acc->acc_id)).'">'.($this->gm_model->int_to_string($acc->acc_id)).' (click vào đây để tới tài khoản)</a>. Đã đặt trước, sẽ có lúc '.date("H:i d/m/Y", $acc->h_start_time).'.<br/>';
				}
			
			}
			//echo '</div><br/>'.$cf->authnote.'';
			
			}
			echo '</div>
		</div>';
		}
		
		?>
		
	<?php
	if($this->session->userdata('user_id') == 1){
		echo count($ready_accs);
		echo ' sẵn sàng - ';
		echo count($accs);
		echo ' đang thuê. Tổng ';
		echo count($ready_accs)+count($accs);
		echo '.<br/>';
	}
        if($this->session->userdata('user_id') == 2){
		echo count($ready_accs);
		echo ' sẵn sàng - ';
		echo count($accs);
		echo ' đang thuê. Tổng ';
		echo count($ready_accs)+count($accs);
		echo '.<br/>';
	}
		
	if(count($ready_accs) > 0){
		
		echo '<span style="color:#fff;font-size:30px;"><br/>Tài khoản Sẵn Sàng </span>';
		$i = 0;
		foreach($ready_accs AS $acc){
			
			$i++;
			if($i%4 == 1){
				echo '<div class="row">';
			}
			echo '<div class="col-sm-3" id="acc_'.($this->gm_model->int_to_string($acc->acc_id)).'"><div class="acc_border "><div class="acc_inline acc_ready">';


$hour = date("H", max($acc->acc_time_ready, time()));
if($hour == 22 OR $hour == 23 OR ($hour >= 0 AND $hour < 4)){
echo '<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>';
}
if($hour >= 4  AND $hour < 10){
echo '<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+1 Giờ chơi sáng</div>';
}





			echo '<strong>Tài khoản '.($this->gm_model->int_to_string($acc->acc_id)).'</strong>';
			
			echo '<div class="acc_stt">';
			if($acc->acc_time_ready == 0 || $acc->acc_time_ready <= time()){
				echo '<div class="ready_acc">Chơi được luôn</div>';
				echo "<div class='acc_stt'>Khung giờ: $acc->time_lv </div>";
			} else {
				echo 'Chờ đổi key: <span class="countdown_time">'.date("m/d/Y H:i:s", $acc->acc_time_ready).'</span>';
                               
			}
			echo '</div>';
			
			?>
			<?php
			echo form_open('home/thuengay_new', 'class="ajax_form"');?>
			<input type="hidden" name="goi_id" value="<?= $acc->pack_id ?>">
			<input type="hidden" name="acc_id" value="<?php echo $acc->acc_id;?>" />
			<select name="goi" class="my_select" required>
				<option value="<?=$acc->price?>"> <?=$acc->price?> </option>
			</select>
			<?php
			if($acc->acc_time_ready == 0 || $acc->acc_time_ready <= time()){
				echo '<button type="submit" class="my_button">Thuê Ngay</button>';
			} else {
				echo '<button type="submit" class="my_button">Đặt trước</button>';
			}
			?>
			

			<?php 
			echo form_close();
			echo '</div></div></div>';
			if($i%4 == 0 || $i == min(count($ready_accs), 12)){
				echo '</div>';
			}
			
		}
		echo '<div class="clearfix"></div>';
	}
	if(count($accs) > 0) {
		usort($accs, 'cmp');
		echo '<span style="color:#fff;font-size:30px;"><br/>Tài khoản đang được sử dụng </span>';
		echo '<span style="color:#fff;font-size:16px;"><br/>( Ấn "Đặt trước" - khi tới giờ thì nhận key trong mục "Đã thuê" )</span>';
		$i = 0;
		$previos_stop_time = 0;
		foreach($accs AS $acc){
			
			$trangthai = '';
			if(in_array($acc[0]->acc_id, $ds_thue)){$trangthai = 'Của bạn';}
			if(in_array($acc[0]->acc_id, $ds_cho)){$trangthai = 'Đang chờ';}

			$stop_time = 0;
			foreach($acc AS $amd){
				if($amd->h_stop_time > $stop_time){
					$stop_time = $amd->h_stop_time;
				}
			}
			
			$i++;
			if($i%4 == 1){
				echo '<div class="row">';
			}

			
			//Màu mè rõ hơn với acc đang đặt

			if($trangthai != ''){
				echo '<div class="col-sm-3" id="acc_'.($this->gm_model->int_to_string($acc[0]->acc_id)).'"><div class="acc_border"><div class="acc_inline" style="background: #084808">';
			} else {
				echo '<div class="col-sm-3" id="acc_'.($this->gm_model->int_to_string($acc[0]->acc_id)).'"><div class="acc_border"><div class="acc_inline">';
			}

			

if($trangthai != ''){	
                  	echo '<div class="pull-left trangthai">'.$trangthai.'</div>';
			}
$hour = date("H", $acc[count($acc)-1]->h_stop_time+AFTER_TIME*60);
if($hour == 22 OR $hour == 23 OR ($hour >= 0 AND $hour < 4)){
/* echo '<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+2 Giờ chơi đêm</div>'; */
}
if($hour >= 4  AND $hour < 10){
/* echo '<div class="pull-right trangthai" style="right:1px; left: auto; font-size: 10.3px">+1 Giờ chơi sáng</div>'; */
}

			
			echo '<span style="color:#ffa31a;font-size:18px;"><strong>Tài khoản '.($this->gm_model->int_to_string($acc[0]->acc_id)).'</strong></span>';
				
				echo '<div class="acc_stt">';
				
				if($trangthai == ""){
                                 
					echo 'Còn lại: <span class="countdown_time">'.date("m/d/Y H:i:s", $acc[count($acc)-1]->h_stop_time).'</span> <br/>+'.(AFTER_TIME).'phút chờ đổi key<br/>';
					echo 'Thuê đc lúc '.date("H:i d/m", $acc[count($acc)-1]->h_stop_time+AFTER_TIME*60).'<br/>';			
				} else {
				echo '<a href="'.site_url('home/dathue').'">Click vào đây để xem chi tiết thời gian Bắt đầu và Kết thúc.</a>';
				}
echo '</div>';
				
				?> 
				<?php
				if(!isset($acc[1])){
				if(in_array($acc[0]->acc_id, $ds_thue) && $acc[0]->h_stop_time == $stop_time && $acc[0]->h_stop_time > time() - (BEFORE_TIME+5)*60 ) {
					echo form_open('home/giahan', 'class="ajax_form"');
					echo '<input type="hidden" name="h_id" value="'.$acc[count($acc)-1]->h_id.'" />';
				} else {
					echo form_open('home/thuengay_new', 'class="ajax_form"');
				}
				?>
				<input type="hidden" name="acc_id" value="<?php echo $acc[0]->acc_id;?>" />
				<input type="hidden" name="tgian" value="<?php echo $stop_time;?>" />
				<select name="goi" class="my_select" required>
				<?php foreach($cacgois_dattrc AS $k => $goi) { ?>
					<option value="<?php echo $k;?>">
						<?php echo number_format($goi['gia']); echo 'đ/'; echo $goi['ten'];?> &nbsp;&nbsp;
					</option>
				<?php } ?>
				</select>
				
					<button type="submit" class="my_button"><?php if(in_array($acc[0]->acc_id, $ds_thue) && $acc[0]->h_stop_time == $stop_time && $acc[0]->h_stop_time > time() - (BEFORE_TIME+5)*60 ){echo 'Gia hạn';} else {echo 'Đặt trước';}?></button>
			
				
				<?php 
				echo form_close();
				} else {
					echo '<button class="my_button">Đã có người đặt</button>';
				}
				if($trangthai == "Của bạn" AND $acc[0]->h_start_time <= time()){
					echo '<input class="my_button" value="'.$acc[0]->h_key.'" onClick="this.select();" />';
				}
				
				echo '</div></div></div>';
				if($i%4 == 0 || $i == count($accs)){
					echo '</div>'; 
				}
				$previos_stop_time = $stop_time;
			
		}
	}
	?> 

	<div class="clearfix"></div>
	<p class="text-justify" id="hwid_la_gi" style="margin-top: 40px"><?php echo $cf->hwid;?></p>
	</div>
</div>
 </div>
 
<script type="text/javascript">
$(document).ready(function(){
	$(".ajax_form").each(function(){
		var frm = $(this);
		frm.submit(function (ev) {
			
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				dataType: 'json',
				success: function (e) {
				   swal({title: e.title, text: e.mess, type: e.stt, html:true},function(){ 
					   window.location.href = '<?php echo site_url('home/dathue');?>';
				   }
				   );
				}
			});
			ev.preventDefault();
		});
		
	});
	
	$("#hwid").click(function() {
	event.preventDefault();
	 $('body').animate({
		scrollTop: $("#hwid_la_gi").offset().top - 80
	 }, 500);
	});
});
</script>
