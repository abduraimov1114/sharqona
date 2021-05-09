<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
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
	<title>Bu Yerda Title</title>
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
<!-- Shu yerdan asosiy conternt -->

	<?php $storage_number = 3 ?>

	<select id="pr_name" name="product[__i__][name]" class="form-control bold input-md pr-name item-select select2">
		<option value="">- TANLANG! -</option>
		<?php
		$query = "SELECT * FROM products WHERE product_id in (SELECT product_id FROM master_storage WHERE product_quantity > 0 AND storage_id = '$storage_number')";
		$proquery = mysqli_query($connection, $query);
		if (!$proquery) {
		die ("Mahsulot ismini zaprosida xatolik");
		}
		while ($row = mysqli_fetch_assoc($proquery)) {
		$barcode = $row['product_barcode'];
		$maxsulot_id = $row['product_id'];
		$maxsulot_ismi = $row['product_name'];
		$maxsulot_sotish_narxi = $row['product_prise_out'];
		$maxsulot_sotish_narxi = $maxsulot_sotish_narxi * $sum;
		$maxsulot_sotish_narxi = round($maxsulot_sotish_narxi, -2);
		$soniuchun = "SELECT product_quantity FROM master_storage WHERE product_id = '$maxsulot_id' AND storage_id = '$storage_number'";
		$soniuchun_query = mysqli_query($connection, $soniuchun);
		$soni = mysqli_fetch_array($soniuchun_query);
		$maxsulot_skladdagi_soni = $soni['product_quantity'];
		?>
		<option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
		<?php } ?>
	</select>
	<script>
		jQuery(document).ready(function($)
		{
			$('#pr_name').val('182');
		  });
	</script>

<!-- /Shu yerdan asosiy conternt -->
<!-- Footercha -->
		<br />
		<footer class="main">
			&copy; 2021 <strong>Karmana Sharqona Invest Group</strong> All Rights Reserved
		</footer>
	</div>
</div>
<!-- /Footercha -->
<!-- Bu yerda xam skriptlar -->
	
<!-- /Bu yerda xam skriptlar -->
</body>
</html>