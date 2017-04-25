<div id="main" class="c-section text-center" style="background: #000; font-size: 9px;">
<h2 class="c-items__title u-text-gradient">Tài khoản dành cho bạn</h2>
<div class="text-center">
	<span><div class="timeline time_dangthue" style="width: 200px; float: none; font-size: 14px;">Đã có người thuê</div></span>
	<span><div class="timeline time_free" style="width: 200px; float: none;  font-size: 14px;">Có thể thuê, click để chọn</div></span>
	<div class="clearfix"></div>
</div>
<div class="container text-left">
<?php 
$t = time();
$end = $t+43200;
$w = 96/43200;
$dead = 30*60*$w;

//ready acc
foreach($ready_accs AS $acc){
	echo '<div class="timeline_item clearfix">';
	echo '<div style="float: left; width: 2%; font-size: 14px">'.$acc->acc_id.'</div>';
	echo '<span class="timeline time_free" style="width: 96%" data-time="'.date("Y-m-d\TH:i", $t).'"></span>';
	echo '</div>';
}

ksort($accs);
foreach($accs AS $key => $acc){
echo '<div class="timeline_item clearfix">';
echo '<div style="float: left; width: 2%; font-size: 14px">'.$key.'</div>';
if($acc[0]->h_start_time > $t){
	$width = ($acc[0]->h_start_time - $t)*$w;
	if($width <= 180*60*$w+$dead){$class = 'time_chet';} else {$class = 'time_free';}
	echo '<span class="timeline '.$class.'" style="width: '.$width.'%" data-time="'.date("Y-m-d\TH:i", $t).'"></span>';
}

foreach($acc AS $k => $a){
	$width = (min($end, $a->h_stop_time) - max($a->h_start_time, $t))*$w;
	$class = 'time_dangthue';
	echo '<span class="timeline '.$class.'" style="width: '.$width.'%">
	<div class="pull-left text-left">'.date("H:i", max($a->h_start_time, $t)).'</div>
	<div class="pull-right  text-right">'.date("H:i", $a->h_stop_time).'</div>
	</span>';
	if(isset($acc[$k+1])){
		$width = ($acc[$k+1]->h_start_time - $acc[$k]->h_stop_time)*$w;
		if($width <= 180*60){$class = 'time_chet';} else {$class = 'time_free';}
		echo '<span class="timeline '.$class.'" style="width: '.$width.'%" data-time="'.date("Y-m-d\TH:i", $acc[$k+1]->h_stop_time+31*60).'"></span>';
		
	} else {
		$width = min((max($end-$a->h_stop_time, 0))*$w, $dead); 
		echo '<span class="timeline time_chet" style="width: '.$width.'%"></span>';
	}
}

if($acc[count($acc)-1]->h_stop_time < $end - 30*60){
	$width = ($end - $acc[count($acc)-1]->h_stop_time)*$w-$dead;
	$class = 'time_free';
	echo '<span class="timeline '.$class.'" style="width: '.$width.'%" data-time="'.date("Y-m-d\TH:i", $acc[count($acc)-1]->h_stop_time+31*60).'">
	<div class="pull-left text-left">'.date("H:i", $acc[count($acc)-1]->h_stop_time+30*60).'</div>
	<div class="pull-right  text-right">'.date("H:i", $end).'</div>
	</span>';
}
echo '</div>';
}
?>
</div>
</div>