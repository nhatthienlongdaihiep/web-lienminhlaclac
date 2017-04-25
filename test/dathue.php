<div class="container">
<br><br>
<?php 	$ds_thue = array();
			$ds_cho = array();
			if(!empty($accs_dangthue)){ ?>
			<div class="dangthue" id="dangthue">
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
				echo '<table class="table">';
				echo '<tr><th>Tài khoản</th><th>Bắt đầu</th><th>Kết thúc</th><th>AuthKey</th></tr>';
				foreach($accs_dangthue AS $acc){
				
				if($acc->h_stt == 'DANGTHUE') {
					$dem_acc_thue++;
					$tgian_het = $acc->h_stop_time;
					if($acc->h_start_time <= time()){
						echo '<tr><td>Tài khoản '.($this->gm_model->int_to_string($acc->acc_id)).'</td>
						<td>'.date("H:i d/m", $acc->h_start_time).'</td>
						<td>'.date("H:i d/m", $acc->h_stop_time).'</td>
						<td>'.$acc->h_key.'</td>
						</tr>';
					} else {
						echo '<tr><td>Tài khoản '.($this->gm_model->int_to_string($acc->acc_id)).'</td>
						<td>'.date("H:i d/m", $acc->h_start_time).'</td>
						<td>'.date("H:i d/m", $acc->h_stop_time).'</td>
						<td>Chưa tới giờ nhận AuthKey</td>
						</tr>';
					}
				
				} elseif($acc->h_stt == 'DANGCHO'){
					$dem_acc_thue++;
					echo '<tr><td>Tài khoản '.($this->gm_model->int_to_string($acc->acc_id)).'</td>
						<td>'.date("H:i d/m", $acc->h_start_time).'</td>
						<td>'.date("H:i d/m", $acc->h_stop_time).'</td>
						<td>Chưa tới giờ nhận AuthKey</td>
						</tr>';
				}
			
			}
			echo '</table></div><br/>';
			
			}
			echo '</div>
		</div>';
		} else {
			echo 'Hiện tại không có tài khoản nào thuộc về bạn.';
		}
		
		?>
</div>