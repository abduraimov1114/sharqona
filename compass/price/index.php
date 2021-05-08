<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once "../../includes/db.php"; ?>
<?php require_once "../../includes/dollar.php"; ?>

<?php 

	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		header('Location: https://vosxod.uz/back_login.php');
		die();
	}

	$date = new DateTime();
	$role = $_SESSION['ses_user_role'];
	
 ?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Price List - COMPASS (<?php echo $date->format('d.m.Y'); ?>)</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.ico">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/vendor/themify-icons.css">
    <link rel="stylesheet" href="assets/css/vendor/cryptocurrency-icons.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Custom Style CSS Only For Demo Purpose -->


</head>

<body>
	<div class="main-wrapper">
		<div class="content-body">
			<div class="row">
				<!--Export Data Table Start-->
				<div class="col-12 mb-30">
					<div class="box">
						<div class="box-head">
							<h3 class="title">"COMPASS" Komyuterlarga xizmat ko'rsatish markazi mahsulotlar narx navosi</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered data-table data-table-export table-striped">
								<thead>
									<tr>
										<th>№</th>
										<th>Mahsulot Nomi</th>
										<th>Mahsulot Bo'limi</th>
										<?php if ($role == 'Admin' OR $role == 'Direktor'): ?>
										<th>Kelish Narxi</th>
										<?php endif ?>
										<th>Sotish Narxi (K)</th>
										<th>Sotish Narxi (T)</th>
										<th>Kafolat</th>
										<th>Holati</th>
									</tr>
								</thead>
								<tbody>
				<?php 
					$query = "SELECT product_id, product_name, product_category_id, product_prise_out, product_prise_in, product_count, product_guarantee, guarantee_length FROM products WHERE product_count > 0 ORDER BY product_prise_out";
					$product_query = mysqli_query($connection, $query);
					$n = 0;
					while ($row = mysqli_fetch_assoc($product_query)) {
						$product_id = $row['product_id'];
						$product_name = $row['product_name'];
						$product_category = $row['product_category_id'];
						$product_price_in = $row['product_prise_in'];
						$product_price_in = ($product_price_in * $sum) / 0.95;
				// 		$product_price_in = ceil($product_price_in);
						$product_price_in = ceil($product_price_in / 100) * 100;
						$product_price_out = $row['product_prise_out'];
						$product_price_outt = $row['product_prise_out'];
						$product_price_out = $product_price_out * $sum;
						$product_price_out = round($product_price_out, -2);
						$product_price_outt = ($product_price_outt * $sum) / 0.85;
						$product_price_outt = round($product_price_outt, -2);
						$product_count = $row['product_count'];
						$garanty = $row['product_guarantee'];
						$garanty_l = $row['guarantee_length'];
						if ($garanty == 0) {
							$garanty = "Kafolatsiz";
							$garanty_l = "";
						}
						$n++;
				?>
									<tr>
										<td width="5%"><?php echo $n; ?></td>
										<td><?php echo $product_name; ?></td>
				<?php 
				$query = "SELECT * FROM product_category WHERE pcat_id = '{$product_category}' ";
				$cat_query = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_assoc($cat_query)) {
					$product_kategoriyasi = $row['pcat_name'];
				}
				?>						
										<td><?php echo $product_kategoriyasi; ?></td>
										<?php if ($role == 'Admin' OR $role == 'Direktor'): ?>
										<td><?php echo $product_price_in; ?></td>
										<?php endif ?>
										<td><?php echo $product_price_out; ?></td>
										<td><?php echo $product_price_outt; ?></td>
										<td style="text-transform: capitalize;"><?php echo $garanty . " " . $garanty_l; ?></td>
										<td><?php echo $product_count; ?></td>
									</tr>
				<?php } ?>
								</tbody>
								<tfoot>
								<tr>
									<th>№</th>
									<th>Mahsulot Nomi</th>
									<th>Mahsulot Bo'limi</th>
									<?php if ($role == 'Admin' OR $role == 'Direktor'): ?>
									<th>Kelish Narxi</th>
									<?php endif ?>
									<th>Sotish Narxi (K)</th>
									<th>Sotish Narxi (T)</th>
									<th>Kafolat</th>
									<th>Holati</th>
								</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<!--Export Data Table End-->
				<!--How To Use End-->
			</div>
		</div>
			<!-- Content Body End -->
			<!-- Footer Section Start -->
			<div class="footer-section">
				<div class="container-fluid">
				    <?php $year = date('Y'); ?>
					<div class="footer-copyright text-center">
						<p class="text-body-light"><?php echo $year; ?> &copy; <a style="color:red;" href="#">Compass<span style="font-size: 15px;font-weight: bold;color: black;">24</span></a></p>
					</div>
				</div>
			</div>
	<!-- Footer Section End -->
	</div>
	<!-- JS
	============================================ -->
	<!-- Global Vendor, plugins & Activation JS -->
	<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
	<script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
	<script src="assets/js/vendor/popper.min.js"></script>
	<script src="assets/js/vendor/bootstrap.min.js"></script>
	<!--Plugins JS-->
	<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="assets/js/plugins/tippy4.min.js.js"></script>
	<!--Main JS-->
	<script src="assets/js/main.js"></script>
	<!-- Plugins & Activation JS For Only This Page -->
	<script src="assets/js/plugins/datatables/datatables.min.js"></script>
	<script src="assets/js/plugins/datatables/datatables.active.js"></script>
</body>

</html>