<?php session_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php require_once '../DB/functions.php'; ?>
<?php
$func = new database_func();
if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
	header('Location: https://city-service.uz/back_login.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="assets/images/favicon.ico">

	<title>Shartnomalar</title>

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>
<body class="page-body" data-url="http://neon.dev">

<!--<div class="page-container">-->

<!--	--><?php //require_once 'addincludes/sidebar.php'; ?>
<!--	--><?php //require_once 'addincludes/userinfo.php'; ?>

	<?php include "addincludes/contract.php";?>

<!--</div>-->
<!--<br />-->
<!--<footer class="main">-->
<!--	--><?php //$footdate = date('Y'); ?>
<!--	&copy; --><?php //echo $footdate; ?><!-- <strong>sharqona Group</strong> All Rights Reserved-->
<!--</footer>-->

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/bootstrap-switch.min.js"></script>
<script src="assets/js/neon-chat.js"></script>
<script src="assets/js/contract.js"></script>

<!-- Imported scripts on this page -->
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/bootstrap-tagsinput.min.js"></script>
<script src="assets/js/typeahead.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/daterangepicker/daterangepicker.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/icheck/icheck.min.js"></script>

<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

</body>
</html>