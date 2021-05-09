<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>

<?php 

	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		header('Location: https://vosxod.uz/back_login.php');
		die();
	}

 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex, nofollow" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Compass Group" />
	<meta name="author" content="" />
	<link rel="icon" href="assets/images/favicon.ico">
	<title>Sharqona Group Shop</title>
	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">
	<script src="assets/js/jquery-1.11.3.min.js"></script>