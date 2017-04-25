<!--<div class="c-section  text-center" style="background: #000;">
	<h2 class="c-items__title u-text-gradient">Alan Walker - Faded</h2>
	<div style="padding: 10px 0 5px 0">
	<audio controls autoplay loop>
	<source src="<?php //echo base_url();?>/assets/thongbao.mp3" type="audio/mpeg">
	</audio>
	</div>
</div> -->
<div style="background: #000; padding-bottom: 20px;">
<div class="container">
	<h2 class="c-items__title u-text-gradient text-center">Top đại gia Tháng</h2>
	<div class="text-center"><?php echo $cf->duatop;?></div>
	<br>
	<div class="col-md-4">
	<?php for($i = 1; $i<=4; $i++){ ?>
	<div style="height: 50px; line-height: 40px; padding: 5px;">
		<div style="border-radius: 50%; width: 40px; height: 40px; background: rgba(185, 22, 22, <?php echo 1.06-$i*0.05;?>); font-size: 22px; padding-left: 12px; float: left; margin-right: 5px;">
			<?php echo $i;?>
		</div> <?php echo $tops[$i-1]->user_name .' - '. $tops[$i-1]->user_sogio;?> giờ.
	</div>
	<?php } ?>
	</div>
	
	<div class="col-md-4">
	<?php for($i=5; $i<=8; $i++){ ?>
	<div style="height: 50px; line-height: 40px; padding: 5px;">
		<div style="border-radius: 50%; width: 40px; height: 40px; background: rgba(185, 22, 22, <?php echo 1.06-$i*0.05;?>); font-size: 22px; padding-left: <?php echo 12-(strlen($i)-1)*6;?>px; float: left; margin-right: 5px;">
			<?php echo $i;?>
		</div> <?php echo $tops[$i-1]->user_name .' - '. $tops[$i-1]->user_sogio;?> giờ.
	</div>
	<?php } ?>
	</div>

	<div class="col-md-4">
	<?php for($i=9; $i<=12; $i++){ ?>
	<div style="height: 50px; line-height: 40px; padding: 5px;">
		<div style="border-radius: 50%; width: 40px; height: 40px; background: rgba(185, 22, 22, <?php echo 1.06-$i*0.05;?>); font-size: 22px; padding-left: <?php echo 12-(strlen($i)-1)*6;?>px; float: left; margin-right: 5px;">
			<?php echo $i;?>
		</div> <?php echo $tops[$i-1]->user_name .' - '. $tops[$i-1]->user_sogio;?> giờ.
	</div>
	<?php } ?>
	</div>
	
</div>
</div>

