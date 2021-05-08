<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php include_once("../DB/functions.php"); $func = new database_func();?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
	}
	if (isset($_GET['storage'])) {
		$storage = $_GET['storage'];
		$storage_number = mysqli_real_escape_string($connection, $storage);
		if ($storage_number == 1) {
			$ombor = "Podval";
		}
		elseif ($storage_number == 3) {
			$ombor = "Laboratoriya";
		}
		else {
			$_SESSION['xabar'] = 'xato';
			header("Location: index.php");
		}
	}
	else {
		$_SESSION['xabar'] = 'xato';
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Compass Group Admin Panel" />
		<link rel="icon" href="assets/images/favicon.ico">
		<title>New order for accept</title>
		<!-- Bu yerda scriptlar -->
		<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		<link rel="stylesheet" href="assets/css/neon-core.css">
		<link rel="stylesheet" href="assets/css/neon-theme.css">
		<link rel="stylesheet" href="assets/css/neon-forms.css">
		<link rel="stylesheet" href="assets/css/custom.css">
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<!-- Bu yerda scriptlar -->
	</head>
	<body class="page-body">
		<div class="page-container">
			
			<?php require_once 'addincludes/sidebar.php'; ?>
			<?php require_once 'addincludes/userinfo.php'; ?>

			<?php 
				// if ($session_role !== 'Master') {
				// 	$_SESSION['xabar'] = 'xato';
				// 	header("Location: index.php");
				// }
			 ?>
			
			<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				var $table3 = jQuery("#table-3");
				
				var table3 = $table3.DataTable( {
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
				} );
				
				// Initalize Select Dropdown after DataTables is created
				$table3.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
					minimumResultsForSearch: -1
				});
			} );
			</script>