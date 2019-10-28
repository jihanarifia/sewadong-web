	<!DOCTYPE html>
	<html>
	<head>
		<?php 
		header('X-Content-Type-Options:nosniff');
		header('X-XSS-Protection: 1; mode=block');
		header('Cache-Control: no-cache, no-store, private');
		header('Pragma: no-cache');
		header('X-Frame-Options: sameorigin');
		?>
		<link rel="shortcut icon" href="<?=base_img()."logo.png.ico"?>">
		<title><?=$title?> | Admin</title>


		<link href="<?php echo base_url()."assets/back/css/bootstrap.min.css"?>" rel="stylesheet">
		<link href="<?php echo base_url()."assets/back/css/bootstrap-combobox.css"?>" rel="stylesheet">
		<link href="<?php echo base_url()."assets/back/css/line-icons.css"?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()."assets/back/css/owl.carousel.css"?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()."assets/back/css/bootstrap-theme.css"?>" rel="stylesheet">
		<link href="<?php echo base_url()."assets/front/css/font-awesome/css/font-awesome.css"?>" rel="stylesheet" />

		<link href="<?php echo base_url()."assets/back/css/elegant-icons-style.css"?>" rel="stylesheet" />
		<link href="<?php echo base_url()."assets/back/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css"?>" rel="stylesheet" />
		<link href="<?php echo base_url()."assets/back/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css"?>" rel="stylesheet" type="text/css" media="screen"/>

		<link href="<?php echo base_url()."assets/back/css/style.css"?>" rel="stylesheet">
		<link href="<?php echo base_url()."assets/back/css/style-responsive.css"?>" rel="stylesheet" />
		<script src="<?php echo base_url().'assets/back/js/jquery-2.2.3.min.js" type="text/javascript'?>"></script>
        <script src="<?php echo base_url().'assets/back/js/jquery-validation/jquery.validate.min.js" type="text/javascript'?>"></script>
        <script src="<?php echo base_url().'assets/back/js/jquery-validation/additional-methods.js" type="text/javascript'?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'assets/back/assets/ckeditor/ckeditor.js'?>"></script>
        <!-- sweetalert dyhaz -->
        <script type="text/javascript" src="<?php echo base_url().'assets/back/js/sweetalert.min.js'?>"></script>
		
		<!-- data tablee dhanti -->
		<link rel="stylesheet" href="<?php echo base_url().'assets/back/datatable/css/dataTables.bootstrap.css'?>">

		<link href="<?php echo base_url()."assets/back/css/jquery.multiselect.css"?>" rel="stylesheet" type="text/css">
		
		<!-- tagsinput and typehead -->
		<script src="<?php echo base_url().'assets/back/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript'?>"></script>
		<link rel="stylesheet" href="<?php echo base_url()."assets/back/bootstrap-tagsinput/bootstrap-tagsinput.css"?>" />
		<script src="<?php echo base_url()."assets/back/bootstrap-tagsinput/bootstrap-tagsinput.js"?>"></script> 
		
		<style>
			.success{color:#2ECC40;}
			.error{color:#FF4136;}
			.warning{color:#FF851B;}
		</style>
	</head>

	<body> 