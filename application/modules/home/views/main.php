<!--<div class="c-section  text-center" style="background: #000;">
	<h2 class="c-items__title u-text-gradient">Alan Walker - Faded</h2>
	<div style="padding: 10px 0 5px 0">
	<audio controls autoplay loop>
	<source src="<?php //echo base_url();?>/assets/thongbao.mp3" type="audio/mpeg">
	</audio>
	</div>
</div> -->
<div class="daigia">
<div class="container">
	<div class="col-md-8" >
	<h2 class="c-items__title u-text-gradient text-center" style="margin-top: 200px;">Top đại gia Tháng 12</h2>
	<div class= "text-center" style="text-shadow: 1px 0px 5px #000;">Top 10 người thuê nhiều nhất sẽ được cộng tiền tài khoản vào 10h ngày đầu tháng, 2 bạn cuối danh sách cố gắng thêm nhé. <br>Top 1 + 150K, Top 2 + 100K, Top 3 + 80K, Top 4 +50K, Top 5 +30K, Top 6-10 + 20K.</div>
<div class="container">

	<div class="text-center"><?php echo $cf->duatop;?></div>
	<br>
	<div class="col-md-4" style="color:#ffff00">
	<?php for($i = 1; $i<=6; $i++){ ?>
	<div style="height: 50px; line-height: 40px; padding: 5px;">
		<div style="border-radius: 100%; width: 40px; height: 40px; background: rgba(243, 5, 5, <?php echo 1.06-$i*0.0001;?>); font-size: 22px; padding-left: 12px; float: left; margin-right: 5px;">
			<?php echo $i;?>
		</div> <?php echo $tops[$i-1]->user_name .' - '. $tops[$i-1]->user_sogio;?> giờ.
	</div>
	<?php } ?>
	</div>
	
	<div class="col-md-4" style="color:#ffff00">
	<?php for($i=7; $i<=12; $i++){ ?>
	<div style="height: 50px; line-height: 40px; padding: 5px;">
		<div style="border-radius: 100%; width: 40px; height: 40px; background: rgba(243, 5, 5, <?php echo 1.06-$i*0.0001;?>); font-size: 22px; padding-left: <?php echo 12-(strlen($i)-1)*6;?>px; float: left; margin-right: 5px;">
			<?php echo $i;?>
		</div> <?php echo $tops[$i-1]->user_name .' - '. $tops[$i-1]->user_sogio;?> giờ.
	</div>
	<?php } ?>
	</div>
</div>
</div>
