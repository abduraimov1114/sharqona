<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
	}
	if (isset($_GET['invoicedt'])) {
		$number_invoice = $_GET['invoicedt'];
		$number_invoice = mysqli_real_escape_string($connection, $number_invoice);
		if ($number_invoice < 0 OR empty($number_invoice) OR !is_numeric($number_invoice)) {
			header("Location: organizations.php");
		}
		else {
			$companytmp = "SELECT customer_id, order_date FROM orders WHERE order_id = '$number_invoice'";
			$xozir = mysqli_query($connection, $companytmp);
			$compidtmp = mysqli_fetch_array($xozir);
			$compid = $compidtmp['customer_id'];
			$order_date_tmp = $compidtmp['order_date'];
			$order_date = date('d.m.Y', strtotime($order_date_tmp));
			
			$search_comptmp = "SELECT buyers_name, buyers_budget, buyers_id FROM buyers WHERE buyers_id = '$compid'";
			$search_compquery = mysqli_query($connection, $search_comptmp);
			$search_comp_result = mysqli_fetch_array($search_compquery);
			$company_id = $search_comp_result['buyers_id'];
			$company_name = $search_comp_result['buyers_name'];
			$company_budget = $search_comp_result['buyers_budget'];
		}
	}
	else {
		header("Location: organizations.php");
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
	<title><?php echo $company_name; ?> Invoice Details</title>
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
<di v class="page-container">
	
<?php require_once 'addincludes/sidebar.php'; ?>
	<div class="main-content">
		<ol class="breadcrumb hidden-print"> 
			<li> <a onclick='location.href="organizations.php";' href="#"> <i class="entypo-folder"></i>Tashkilotlar</a> </li> 
			<li> <a onclick='location.href="invoice_list.php?invoice=<?php echo $company_id; ?>";' href="#"><?php echo $company_name; ?> Invoice List</a></li>
			<li><a href="#" onclick="return false;">Invoice Details</a></li> 
		</ol>
		<br />
<!-- Shu yerdan asosiy conternt -->

<div class="invoice">

	<div class="row">
	
		<div class="col-sm-6 invoice-left">
		
			<a href="#">
				<img src="assets/images/logo@2x.png" width="185" alt="" />
			</a>
			
		</div>
		
		<div class="col-sm-6 invoice-right">
		
				<h3>INVOICE NO. # <?php echo $number_invoice; ?></h3>
				<span><?php echo $order_date; ?></span>
		</div>
		
	</div>
	
	
	<hr class="margin" />
	

	<div class="row">
	
		<div class="col-sm-3 invoice-left">
		
			<h4>Client</h4>
			<?php echo $company_name; ?>
			<br />
			
		</div>
	
		<div class="col-sm-3 invoice-left">

		</div>
		
		<div class="col-md-6 invoice-right">
		
			<h4>Bajaruvchi</h4>
			Sharqona Group
			<br />
			
		</div>
		
	</div>
	
	<div class="margin"></div>
	
	<table class="table table-bordered">
		<thead>
			<tr>
				<th class="text-center">#</th>
				<th width="50%">Maxsulot yoki xizmat</th>
				<th>Narxi</th>
				<th>Soni</th>
				<th>Umumiy Narxi</th>
				<th class="hidden-print">Qaytarilish</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$total = 0;
			$nomer = 1;
			$zappa = "SELECT * FROM ordered_products WHERE orders_id = '$number_invoice'";
			$yoppa = mysqli_query($connection, $zappa);
			if (!$yoppa) {
				die("Xatolik!");
			}
			else {
				while ($row = mysqli_fetch_assoc($yoppa)) {
					$is = $row['is_product'];
					$oneprice = $row['product_price'];
					$quantity = $row['product_quantity'];
					$product_id = $row['products_id'];
					$umum = $quantity * $oneprice;
					$total += $umum;
				?>
				<tr>
					<td class="text-center"><?php echo "$nomer"; ?></td>
					<td>
						<?php 
							if ($is == 1) {
								$buprotmp = "SELECT product_name FROM products WHERE product_id = '$product_id'";
								$buprorsl = mysqli_query($connection, $buprotmp);
								$bupro = mysqli_fetch_array($buprorsl);
								$proname = $bupro['product_name'];
								$details = 'product';
							}
							elseif ($is == 0) {
								$busrvtmp = "SELECT service_name FROM services WHERE service_id = '$product_id'";
								$busrvrsl = mysqli_query($connection, $busrvtmp);
								$buserv = mysqli_fetch_array($busrvrsl);
								$proname = $buserv['service_name'];
								$details = 'service';
							}
						 ?>
						 <?php echo $proname; ?>
					</td>
					<td><?php echo $oneprice; ?></td>
					<td class="text-right"><?php echo $quantity; ?></td>
					<td class="text-right"><?php echo $umum; ?></td>
					<td class="text-center hidden-print">
						<form action="returns_page.php" method="post">
						<input type="hidden" name="nimabu" value='<?php echo "$details"; ?>'>
						<input type="hidden" name="pro_id" value='<?php echo "$product_id";?>'>
						<input type="hidden" name="price_of_one" value='<?php echo "$oneprice";?>'>
						<input type="hidden" name="count_of_product" value='<?php echo "$quantity";?>'>
						<input type="hidden" name="comp_id" value='<?php echo "$company_id";?>'>
						<input type="hidden" name="maximum" value='<?php echo "$quantity";?>'>
						<input type="hidden" name="number_invoice" value='<?php echo "$number_invoice";?>'>
						<input type="hidden" name="date_order" value='<?php echo "$order_date_tmp";?>'>
						<button class="btn btn-danger" name="back" type="submit">Возврат</button>
						</form>
					</td>
				</tr>
				<?php $nomer++; ?>
				<?php
				}
			}

			 ?>
					
		</tbody>
	</table>
	
	<div class="margin"></div>

	<div class="row">
	
		<div class="col-sm-6">
		
			<div class="invoice-left">
			</div>
		
		</div>
		
		<div class="col-sm-6">
			
			<div class="invoice-right">
				
				<ul class="list-unstyled">
					<li>
						Discount: 
						-----
					</li>
					<li>
						Jami Narxi:
						<strong><?php echo number_format($total); ?> Sum</strong>
					</li>
				</ul>
				
				<br />
				
				<a href="javascript:window.print();" class="btn btn-primary btn-icon icon-left hidden-print">
					Qog'ozga chiqarish
					<i class="entypo-doc-text"></i>
				</a>
				
				&nbsp;
				
				<a href="#" class="btn btn-success btn-icon icon-left hidden-print">
					Send Invoice
					<i class="entypo-mail"></i>
				</a>
			</div>
			
		</div>
		
	</div>

</div>

<!-- /Shu yerdan asosiy conternt -->
<!-- Footercha -->
		<br />
		<footer class="main hidden-print">
			&copy; 2021 <strong>Sharqona Group</strong> All Rights Reserved
		</footer>
	</div>
</div>
<!-- /Footercha -->
<!-- Bu yerda xam skriptlar -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
<!-- /Bu yerda xam skriptlar -->
</body>
</html>