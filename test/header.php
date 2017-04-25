<!DOCTYPE html>
<html lang="vi">
<head>
	<!--Tac gia website Tran Thanh Cong https://www.facebook.com/tran.thanhcong.5855 -->
	<?php
	$imagesDir = 'style/img/splash/';
	$images = glob($imagesDir . '*.{jpg}', GLOB_BRACE);
	$randomImage = $images[array_rand($images)];
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Tool theo giờ giá rẻ và nhiều chức năng hỗ trợ bạn chiến thằng một trận Liên Minh dễ dàng. Trở thành cao thủ chỉ với 5k."
	<link rel="icon" href="<?php echo site_url();?>/img/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo site_url();?>/img/favicon.ico" type="image/x-icon" />
	<meta http-equiv="refresh" content="300">
	<meta property="fb:app_id" content="<?php echo FB_APP_ID;?>" />
	<meta property="og:title" content="<?php if(isset($title)){echo $title; echo ' - '; echo SITENAME;}?>"/>
	<meta property="og:url" content="<?php echo site_url().$this->uri->uri_string();?>"/>
	<?php if(isset($ogimage)) { ?>
		<meta property="og:image" content="<?php {echo $ogimage;}?>"/>
	<?php }?>
	
	<meta property="og:image" content="<?php echo site_url().$randomImage;?>"/>
	<meta property="og:site_name" content="ChoThueSub.Com"/>
	<meta property="og:description" content="<?php if(isset($ogdescription)){echo $ogdescription;} else {echo "Website cho thuê Sub Tool Liên Minh theo giờ với các gói rẻ và phù hợp với yêu cầu của bạn. Thuê Sub Tool ngay nào!";}?>"/>
		
	
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title><?php if(isset($title)){echo $title; echo ' - '; echo SITENAME;}?></title>

	<!-- Bootstrap -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>style/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo base_url();?>style/css/bootstrap-theme.min.css">
	<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>style/css/sweetalert.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>style/css/custom.css">
	
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo base_url();?>style/jquery.min.js"></script>
	<script src="<?php echo base_url();?>style/jquery.form.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="<?php echo base_url();?>style/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>style/js/sweetalert.min.js"></script>
	<script src="<?php echo base_url();?>style/js/jquery.countdown.min.js"></script>
	<script src="<?php echo base_url();?>style/js/plugins/jquery.cookie.js"></script>
	
	<script src="<?php echo base_url();?>style/custom.js"></script>


		
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	
	.c-hero {
	margin-top: 50px;
    background: url("<?php echo site_url(); echo $randomImage;?>") #000 top right no-repeat!important;
	background-size: cover!important;
	</style>
	<script>
		$(document).ready(function() {
			var ua = navigator.userAgent.toLowerCase();
			var isWinXP = ua.indexOf('windows nt 5.1') > 0;   
			if(isWinXP){
				swal("Hình như bạn đang truy cập từ Win XP. Tool thì dùng được cho Win 7 trở lên thôi bạn ạ!");
			}
			$('.btn_naptien').click(function(){
				$('#naptien').css("display", "block");
				$('#form_thue').css("display", "none");
				
			});
			 // nap the
			$("#fnapthe").ajaxForm({
				dataType : 'json',
				url: '<?php echo site_url('home/napthe');?>',
				beforeSubmit : function() {
					$("#loading_napthe").show();
				},
				success: function(data) {
					if(data.code == 0) {
						$("#fnapthe").resetForm();
						$("#msg_success_napthe").html(data.msg);
						$("#msg_err_napthe").html('');
						$("#user_credit").html(data.user_credit);
						var delay = 3000; //Your delay in milliseconds
						setTimeout(function(){ window.location = '<?php echo site_url();?>' }, delay);
					}
					else {
						$("#msg_err_napthe").html(data.msg);
						$("#msg_success_napthe").html('');
					}
					$("#loading_napthe").hide();
					$("#captcha").attr('src', '<?php echo site_url();?>captcha/CaptchaSecurityImages.php?' + Math.random());
				}
			});
		});
	</script>

<?php 
$cf = $this->iconfig->get();
?>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=<?php echo FB_APP_ID;?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php if($cf->popup_title != ""){ ?>
<script>
	$(document).ready(function(){
		if ($.cookie('doi') != '1') {
			swal({   title: "<?php echo $cf->popup_title;?>",   text: "<?php echo $cf->popup_content;?>",html: true,   imageUrl: "<?php echo site_url();?>style/img/pentakill.png" });
			var date = new Date();
			date.setTime(date.getTime() + (<?php echo $cf->popup_time;?>*60*1000));
			$.cookie('doi', '1', { expires: date }); 
		 }
	});
</script>
<?php } ?>
<div id="top"></div>

<header class="navbar navbar-fixed-top bs-docs-nav" id="top" role="banner">
<section class="o-container">
      <div class="navbar-header">
         <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
         <span class="sr-only">Toggle navigation</span> <span class="glyphicon glyphicon-th-list"></button> 
		 <a href="<?php echo site_url();?>" title="Trang chủ" class="navbar-brand"><img src="<?php echo site_url();?>style/img/logo.png" alt="logo"/></a>
      </div>
      <nav id="bs-navbar" class="collapse navbar-collapse">
         <ul class="nav navbar-nav">
				<li> <a href="#top" class="btn_naptien">Nạp thẻ</a> </li>
				<li> <a href="<?php echo site_url('home/huongdan');?>" style="color: #e00000;">Hướng dẫn</a> </li>
				<li> <a href="<?php echo site_url('home/dathue');?>">TK đã thuê</a> </li>
<li> <a href="http://www.mediafire.com/file/etw10m23lwmyftt/chothuetool.rar">T&#7843;i Tool</a> </li>
		<li> <a href="https://www.facebook.com/profile.php?id=100010986735903" target="_blank">FB Admin</a> </li>
				<li> <a href="<?php echo site_url('home/nicklm');?>" style="color: #d79922;">Mua NickLM</a> </li>
         </ul>
         <ul class="nav navbar-nav navbar-right">
            <?php if(empty($this->session->userdata('user_id'))){ ?>
					<li><a href="<?php echo site_url('home/dangnhap');?>">Đăng nhập/đăng ký</a></li>
				<?php } else { ?> 
				<li id="user-menu" class="dropdown">
					<a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php echo '['.$this->session->userdata('user_id').'] '; echo $this->session->userdata('user_name'); 
						echo '. '.number_format($this->session->userdata('user_credit')).' VNĐ';
						?>
						<span class="caret"></span> 
					</a> 
					<ul class="dropdown-menu" aria-labelledby="drop3">
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('home/taikhoan#main');?>">Lịch sử giao dịch</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('home/dangxuat');?>">Thoát</a></li>
					</ul>
				 </li>
				<?php }?>
         </ul>
      </nav>
   </section>
</header>

	
	<div class="o-wrap" id="content" role="main">
	  <div class="o-aspect-ratio o-aspect-ratio--hero">
		<div class="c-hero">
		  <div class="c-hero__text"> 
			<h1 class="c-hero__title u-text-gradient"> <?php echo $title;?></h1>
			<div  class="intro" ><?php echo $cf->thongbao;?>
			</div>
			<?php if(isset($notice)){ ?>
			<p style="font-size: 20px; display: block; margin: 0 auto; color: #FFF; padding: 5px 0; background: #D79922"><?php echo $notice;?></p>
			<?php }?>
			<?php if(!empty($this->session->flashdata('thongbao'))){ ?>
				<p style="font-size: 20px; display: block; margin: 0 auto; color: red; padding: 5px 0; background: #D79922"><?php echo $this->session->flashdata('thongbao');?></p>
			<?php } ?>
			<?php 
			if(empty($this->session->userdata('user_id'))){	?>
				<a title="Đăng nhập" class="my_button" href="<?php echo site_url('home/dangnhap');?>">
				Bạn cần đăng nhập trước tiên
				</a>
			<div id="thaotac">
			<?php } else { ?>
			<div id="naptien" <?php if($this->session->userdata('user_credit') >= '5000'){echo 'style="display: none"';}?> >
			<strong>Nên mua thẻ Gate các bạn nhé.</strong></br>
			<?php //$text = file_get_contents('http://sv.gamebank.vn/trang-thai-he-thong-2');
			// $stts = json_decode($text, true);
			// foreach($stts[0] AS $key => $stt){
				// if($stt == 0){
					// echo '<strong>Thẻ '.$key.' đang bảo trì, bạn vui lòng chọn loại thẻ khác!</strong></br>';
				// }
			// }
			
			
				echo form_open('home/napnapnap', 'id="fnapthe"');?>
				<select name="telcoCode" class="my_select no_padding" required>
				<?php if($cf->napthe == "gamebank"){ ?>
					<option>Chọn loại thẻ &nbsp;</option>
					<option value="4">Gate(FPT)</option>
					<option value="1">Thẻ Vietel</option>
					<option value="2">Thẻ Mobifone</option>
					<option value="3">Thẻ Vinaphone</option>
					<option value="5">VTC - Vcoin</option>
					<option value="6">VN-Mobile</option>
					<option value="7">Zing</option>
				<?php } elseif($cf->napthe == "mega") { ?>
					<option value="0">Chọn loại thẻ &nbsp;</option>
					<option value="VTT">Thẻ Vietel</option>
					<option value="VMS">Thẻ Mobifone</option>
					<option value="VNP">Thẻ Vinaphone</option>
					<option value="MGC">Thẻ Megacard</option>
					<option value="FPT">Thẻ Gate</option>
					<option value="ZING">Thẻ ZING</option> 
					<option value="ONC">Thẻ Oncash</option> 
				<?php } else { ?>
					<option value="VIETEL">Viettel</option>
					<option value="MOBI">Mobifone</option>
					<option value="VINA">Vinaphone</option>
					<option value="GATE">Gate</option>
					<option value="VTC">VTC</option>
				<?php }?>
				</select>
				<input name="cardSerial" class="my_select no_padding" placeholder="Số seri của thẻ" style="max-width: 140px" required/>
				<input name="cardPin" class="my_select no_padding" placeholder="Mã số thẻ cào" style="max-width: 140px" required/>
				<input name="ma_bao_mat" class="my_select no_padding" placeholder="Nhập mã bên cạnh" style="max-width: 140px" required/> 
				<img class="my_select" style="margin-top: 10px; padding: 0" src="<?php echo site_url();?>/captcha/CaptchaSecurityImages.php?height=28" id="captcha"/>
				<button class="my_button">Ok</button>
				<?php echo form_close();?>
				<br/>
				<div class="label label-success" id="msg_success_napthe"></div>
				<div class="label label-danger" id="msg_err_napthe"></div>
				<div id="loading_napthe" style="display: none;"><img src="<?php echo site_url();?>img/loading.gif"/> &nbsp;Xin mời chờ...</div>
			</div>			

			<?php } ?>
	
			</div>
		  </div>
			<!-- video
			<video autoplay="" class="c-hero__video js-hero-video" loop="" poster="">
			<source src="<?php echo base_url();?>assets/hero-video.webm" type="video/webm">
			<source src="<?php echo base_url();?>assets/hero-video.mp4" type="video/mp4">
			<img class="u-img-full" src="<?php //echo base_url();?>/assets/bg-hero.jpg" alt="sub tool lol">
			</video>
			-->
		</div>
		<!-- /.c-hero --> 
	  </div> 
	  </div>
	  
	<div class="container">
	<?php if($cf->stream != ''){ ?>
		<div class="row" style="padding: 20px 0;">
		
		
		<div class="col-md-8">
			<iframe scrolling="no" src="http://talktv.vn/streaming/play/embed/<?php echo $cf->stream;?>" height="500px" width="100%"></iframe>
		</div>
		
		<div class="col-md-4">
			<iframe scrolling="no" src="http://talktv.vn/streaming/chat/embed/<?php echo $cf->stream;?>" height="500px" width="100%"></iframe>
		</div>
		
		</div>
	<?php  } ?>
	</div>
<div id="stream"></div>