<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
	<title>Quản trị</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="<?php echo site_url();?>admin_style/css/style.css">

	<script src="<?php echo site_url();?>admin_style/js/jquery.min.js"></script>

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="brand clearfix">
		<a href="<?php echo site_url('tc');?>" class="logo"><img src="<?php echo site_url();?>admin_style/img/logo.jpg" class="img-responsive" alt="Home page"></a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		
		<?php if(!empty($this->session->userdata('user_id'))){ ?>
		<ul class="ts-profile-nav">
			<li class="ts-account">
				<a href="#"><img src="https://graph.facebook.com/<?php echo $this->session->userdata('user_fb_id');?>/picture?type=square" class="ts-avatar hidden-side" alt=""> <?php echo $this->session->userdata('user_name');?> <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="<?php echo site_url('home/dangxuat');?>">Đăng xuất</a></li>
				</ul>
			</li>
		</ul>
		<?php } ?>
	</div>

	<div class="ts-main-content">
		<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
				<li class="ts-label" style="color: #FFF">Tìm thành viên</li>
				<li>
				<?php echo form_open(site_url('tc/user_search'));?>
					<input type="number" name="user_id" class="ts-sidebar-search" placeholder="ID">
					<input type="text" name="user_name" class="ts-sidebar-search" placeholder="Hoặc tên chính xác...">
					<input type="submit" class="btn btn-default col-md-12" value="Tìm" />
				<?php echo form_close();?>
				<br/>
				<br/>
				</li>
				
				<li class="ts-label">Bảng quản trị</li>
				<li><a href="<?php echo site_url('tc');?>"><i class="fa fa-dashboard"></i> Trang chính</a></li>
				<li><a href="<?php echo site_url('tc/config');?>"><i class="fa fa-dashboard"></i> Cấu hình</a></li>				
				<!--<li><a href="<?php echo site_url('tc/champs');?>"><i class="fa fa-dashboard"></i> DS Tướng</a></li>
				<li><a href="<?php //echo site_url('tc/ass_category');?>"><i class="fa fa-dashboard"></i> Loại Assembly</a></li>
				-->
				<li><a href="<?php echo site_url('tc/time_lv');?>"><i class="fa fa-users"></i> Khung giờ</a></li>

				<li><a href="<?php echo site_url('tc/hired');?>"><i class="fa fa-users"></i> DS Cho thuê</a></li>
				<li><a href="<?php echo site_url('tc/acc');?>"><i class="fa fa-users"></i> Tài khoản</a></li>
				<li><a href="<?php echo site_url('tc/ass');?>"><i class="fa fa-dashboard"></i> Nick LM</a></li>
				<li><a href="<?php echo site_url('tc/n_category');?>"><i class="fa fa-dashboard"></i> Danh mục</a></li>
				<li><a href="<?php echo site_url('tc/news');?>"><i class="fa fa-dashboard"></i> Bài viết</a></li>
				<li><a href="<?php echo site_url();?>" target="_blank"> Ra trang chủ</a></li>
				<!-- Account from above -->
				<?php if(!empty($this->session->userdata('user_id'))){ ?>
				<ul class="ts-profile-nav">
					<li class="ts-account">
						<a href="#"><img src="https://graph.facebook.com/<?php echo $this->session->userdata('user_fb_id');?>/picture?type=square" class="ts-avatar hidden-side" alt=""> <?php echo $this->session->userdata('user_name');?> <i class="fa fa-angle-down hidden-side"></i></a>
						<ul>
							<li><a href="<?php echo site_url('home/dangxuat');?>">Đăng xuất</a></li>
						</ul>
					</li>
				</ul>
				<?php } ?>

			</ul>
		</nav>
		<div class="content-wrapper">
			<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-title">Quản trị</h1>	
				<p>Hôm nay, <?php echo date("H:i:s d/m/Y", time());?>		
				</div>
			</div>

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
<style>
body a:hover { cursor : url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; }
textarea { cursor: url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; } 
select { border-width: 2 2 2 2px; color: #000000; padding: 1 1 1 1px; cursor: url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; } 
option { cursor: url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; }
option:focus,option:hover { cursor: url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; }
input[type="submit"]:hover {cursor: url("http://thantienvxp.xtgem.com/img/cursor/link_1.png"), progress; }
           html { cursor: url("http://thantienvxp.xtgem.com/img/cursor/bt.png"), progress;}
</style>