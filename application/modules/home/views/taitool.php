<div class="c-section c-section--no-padding c-section--no-gradient c-section--bg-updates" style="padding-bottom: 18px; margin-bottom: -1px"  id="huongdan">
<section class="text-center">
<div class="container">
<h2 class="c-items__title u-text-gradient"><?php echo $cf->title_cn;?></h2>
<div class="row">
	<div class="col-md-6">
		<div class="video-container">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $cf->video_cn;?>?modestbranding=1&autohide=1&showinfo=0" frameborder="0" allowfullscreen></iframe>
		</div>
		<div style="text-align: justify">
		<h3 class="c-items__title u-text-gradient">Lưu ý Đặc biệt khi dùng tool :</h3>
		<?php echo $cf->tuanthang;?>
		</div>
	</div>
	<div class="col-md-6"> 
	<div class="c-updates__text" style="text-align: left;">	
	<?php echo $cf->chucnang;?>
	</div>
	
</div>
</div>
</section>
<!-- /.c-updates --> 
</div>

<div class="c-section">
	<div class="container">
	<div class="col-md-6 text-justify">
		<header class="c-section__header">
			<h2 class="c-section__title u-text-gradient text-center"><?php echo $cf->title_hd;?></h2>
		</header>
		
		<!--Link cũ ngày 24/6 https://docs.google.com/uc?id=0B3sWOTPbz0INQUloQ2p6VmliczQ&export=download-->
		<div class="huongdann" style="padding-left: 0">
			<?php echo $cf->huongdan;?>
		
		</div>	
	</div>
	<div class="col-md-6">
		<header class="c-section__header">
			<h2 class="c-section__title u-text-gradient text-center" ><?php echo $cf->title_video;?></h2>
		</header>
		<div class="video-container">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $cf->hd_youtube;?>?modestbranding=1&autohide=1&showinfo=0" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	</div>
</div> 
