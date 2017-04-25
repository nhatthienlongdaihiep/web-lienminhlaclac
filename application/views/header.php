<!DOCTYPE html>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php if(isset($title)) {echo $title;} else {echo SITE_NAME;}?></title>

		<!-- Bootstrap -->
		<link href="<?php echo ''.STYLE.'/css/bootstrap.min.css';?>" rel="stylesheet">

		<link href="<?php echo ''.STYLE.'/css/custom.css';?>" rel="stylesheet">
		<script src="<?php echo ''.STYLE.'/js/list.min.js';?>"></script>
		<script src="<?php echo ''.STYLE.'/js/list.pagination.min.js';?>"></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
		<script src="<?php echo ''.STYLE.'/js/Chart.min.js';?>"></script>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
