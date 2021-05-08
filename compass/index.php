<?php require_once 'addincludes/head.php' ?>

</head>
<body class="page-body skin-black" data-url="http://neon.dev">
<div class="page-container">
	
<?php require_once 'addincludes/sidebar.php'; ?>
<?php require_once 'addincludes/userinfo.php'; ?>

<div class="row">


	<?php if ($session_role == 'Superadmin' OR $session_role == 'Direktor'): ?>
		
	
	
	<div class="col-sm-6">
	<?php 
		$totalprofit = 0;
		$query = "SELECT * FROM products WHERE product_count > 0";
		$product_query = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_assoc($product_query)) {
			$product_count = $row['product_count'];
			$product_price_in = $row['product_prise_in'];
			$totalprofit += $product_price_in * $product_count;
		}
	 ?>

		<div class="tile-stats tile-green">
			<div class="icon"><i class="entypo-gauge"></i></div>
			<div class="num"><?php echo number_format($totalprofit); ?> $</div>
			
			<h3>Tovarlar summasi</h3>
			<p>Dollar valyutasi ko'rinishida </p>
		</div>
		
	</div>

	<div class="col-sm-6">

		<div class="tile-stats tile-blue">
			<div class="icon"><i class="entypo-cc-nc"></i></div>
			<?php $sumda = $totalprofit * $sum; ?>
			<div class="num"><?php echo number_format($sumda); ?> Sum</div>
			
			<h3>Tovarlar summasi</h3>
			<p>Milliy valyuta ko'rinishida </p>
		</div>
		
	</div>

	<div class="col-sm-6">
	<?php 
		$totalqarz = 0;
		$queryfq = "SELECT * FROM buyers WHERE buyers_budget < 0";
		$qarz_query = mysqli_query($connection, $queryfq);
		while ($row = mysqli_fetch_assoc($qarz_query)) {
			$budget_minus = $row['buyers_budget'];
			$totalqarz += $budget_minus;
		}
	 ?>
		<div class="tile-stats tile-purple">
			<div class="icon"><i class="entypo-alert"></i></div>
			<div class="num"><a style="color:white;" href="qarzdorlar.php"><?php echo number_format($totalqarz); ?> Sum</a></div>
			
			<h3>Qarzdorlik. Tashkilotlar</h3>
			<p>Tashkilotlarning Compassdan qarzdorlik ko'rsatgichi </p>
		</div>
		
	</div>
	
	<div class="col-sm-6">
	<?php 
		$totalweqarz = 0;
		$querywq = "SELECT * FROM buyers WHERE buyers_budget > 0";
		$weqarz_query = mysqli_query($connection, $querywq);
		while ($row = mysqli_fetch_assoc($weqarz_query)) {
			$wqbudget_minus = $row['buyers_budget'];
			$totalweqarz += $wqbudget_minus;
		}
	 ?>
		<div class="tile-stats tile-orange">
			<div class="icon"><i class="entypo-alert"></i></div>
			<div class="num"><a style="color:white;" href="plusbudgets.php"><?php echo number_format($totalweqarz); ?> Sum</a></div>
			
			<h3>Qarzdorlik. Sharqona</h3>
			<p>Sharqonaning tashkilotlardan qarzdorlik ko'rsatgichi </p>
		</div>
	</div>
	
	<?php endif ?>

</div>
	<script src="assets/js/jquery-1.11.3.min.js"></script>
<!--	<script src="assets/js/select.js"></script>-->
<?php require_once 'addincludes/footer.php'; ?>
<?php require_once 'addincludes/scripts.php' ?>
<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

</body>
</html>