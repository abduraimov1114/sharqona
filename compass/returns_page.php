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
	<title>Возврат товара</title>
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
	if (isset($_POST['back'])) {
		$nimaekan = $_POST['nimabu'];
		$recieved_pro_id = $_POST['pro_id'];
		$bitasini_narxi = $_POST['price_of_one'];
		$nechadona = $_POST['count_of_product'];
		$recieved_comp_id = $_POST['comp_id'];
		$recieved_maximum = $_POST['maximum'];
		$number_invoice = $_POST['number_invoice'];
		$date_order = $_POST['date_order'];
		// mahsulotmi yo xizmat?
		if ($nimaekan == "product") {
			$mahsulot = "mahsulot";
		}
		elseif ($nimaekan == "service") {
			$mahsulot = "xizmat";
		}
		else {
			header("Location: index.php");
		}
		// 
		// aniqlangan mahsulot yoki xizmatni bazadan topib olamiz
		if ($mahsulot == "mahsulot") {
			$query = "SELECT product_id, product_name, product_count FROM products WHERE product_id = '$recieved_pro_id'";
			$query_go = mysqli_query($connection, $query);
			$stroka_soni = mysqli_num_rows($query_go);
			if (!$query_go OR $stroka_soni !== 1) {
				die("Xatolik!");
			}
			else {
			$query_result = mysqli_fetch_array($query_go);
			$tovar_idsi = $query_result['product_id'];
			$maxsuID = $tovar_idsi;
			$tovar_ismi = $query_result['product_name'];
			$tovar_skladda_soni = $query_result['product_count'];
			}
		}
		elseif ($mahsulot == "xizmat") {
			$query = "SELECT service_id, service_name, service_pro_id FROM services WHERE service_id = '$recieved_pro_id'";
			$query_go = mysqli_query($connection, $query);
			$stroka_soni = mysqli_num_rows($query_go);
			if (!$query_go OR $stroka_soni !== 1) {
				die("Xatolik!");
			}
			else {
			$query_result = mysqli_fetch_array($query_go);
			$tovar_idsi = $query_result['service_id'];
			$tovar_ismi = $query_result['service_name'];
			$tovarga_ketadigan_mahsulot_idsi = $query_result['service_pro_id'];
		// Service ga ketadigan tovarni topib olamiz va bazada nechta ekanligini aniqlaymiz.
			if ($tovarga_ketadigan_mahsulot_idsi !== 0) {
				$zapros = "SELECT product_id, product_name, product_count FROM products WHERE product_id = '$tovarga_ketadigan_mahsulot_idsi'";
				$zapros_go = mysqli_query($connection, $zapros);
				if (!$zapros_go) {
					die("Tizimda xatolik");
				}
				$zapros_result = mysqli_fetch_array($zapros_go);
				$tovar_skladda_soni = $zapros_result['product_count'];
				$ketadigan_mahsulot_ismi = $zapros_result['product_name'];
				$ketadigan_mahsulot_idsi = $zapros_result['product_id'];
			}
			
			}
		}
		
		// Tashkilot haqida informatsiyani aniqlaymiz
		if ($recieved_comp_id !== '10') {
			$query_for_company = "SELECT buyers_id, buyers_name, buyers_budget FROM buyers WHERE buyers_id = '$recieved_comp_id'"; 
			$query_company_go = mysqli_query($connection, $query_for_company);
			if (!$query_company_go) {
				die("Xatolik");
			}
			else {
			$company_query_result = mysqli_fetch_array($query_company_go);
			$company_id = $company_query_result['buyers_id'];
			$company_name = $company_query_result['buyers_name'];
			$company_budget = $company_query_result['buyers_budget'];
			}
		}
		else {
			$company_id = 10;
			$company_budget = 0;
			$company_name = "Ko'chaga savdo";
		}

	} 
	else {
	    header("Location: /compass/organizations.php");
	}
	

	?>
<!-- Shu yerdan asosiy conternt -->
<ol class="breadcrumb">
	<li>
		<a href="index.php"><i class="fa-home"></i>Sharqona</a>
	</li>
	<li class="active">
		<strong>Возврат товара</strong>
	</li>
</ol>
<h2>Tanlangan <?php echo "$mahsulot"; ?>ni qaytarish</h2>
<br>
<form role="form" method="post" action="back_logic.php" class="form-horizontal form-groups-bordered">
	<div class="row">
		<div class="col-md-12">
			<div class="label label-primary">Tashkilot ismi</div>
			<div class="form-group">
				<div class="col-md-10">
					<div class="alert alert-info"><strong><?php echo $company_name; ?></strong></div>
				</div>
			</div>
			<div class="label label-primary">Qaytariladigan <?php echo "$mahsulot"; ?> ismi</div>
			<div class="form-group">
				<div class="col-md-10">
					<div class="alert alert-info"><strong><?php echo "$tovar_ismi"; ?></strong></div>
				</div>
			</div>
			
			<?php if ($mahsulot == "xizmat" AND $tovarga_ketadigan_mahsulot_idsi !== '0'): ?>
				<div class="label label-primary">Omborga qaytadigan mahsulot</div>
				<div class="form-group">
					<div class="col-md-10">
						<div class="alert alert-info"><strong><?php echo "$ketadigan_mahsulot_ismi"; ?></strong> Omborda hozirgi holati <?php echo "$tovar_skladda_soni"; ?> dona</div>
					</div>
				</div>
			<?php endif ?>
			
			<div class="form-group">
			
			
				<div class="col-md-3">
					<div class="label label-primary">Qaytariladigan <?php echo "$mahsulot"; ?> soni</div><div class="badge badge-success"> <?php echo " Max: $recieved_maximum" ?></div>
					<input id="x" name="product_back_quant" type="number" step="any" min="1" max='<?php echo "$recieved_maximum" ?>' class="form-control input-lg" value="1">
				</div>
			
			
			
				<div class="col-md-3">
					<div class="label label-primary">Qaytariladigan <?php echo "$mahsulot"; ?> narxi</div>
					<input id="y" name="product_back_prize" readonly class="form-control input-lg" value='<?php echo "$bitasini_narxi"; ?>'>
				</div>

				<?php if ($recieved_comp_id !== '10'): ?>
					
						<div class="col-md-3">
							<div class="label label-primary">Tashkilot hozirgi byudjeti</div>
							<input id="z" disabled class="form-control input-lg" value='<?php echo "$company_budget"; ?>'>
						</div>
							<?php $newbudget = $bitasini_narxi + $company_budget; ?>
						<div class="col-md-3">
							<div class="label label-primary">Tashkilot yangi byudjeti</div>
							<input name="newbudget" readonly id="k" class="form-control input-lg" value="<?php echo "$newbudget"; ?>">
						</div>
					
				<?php endif ?>

			</div>

			<script type="text/javascript">
			  x.addEventListener('input', function () {
			    y.value = (this.value * <?php echo "$bitasini_narxi"; ?>);
			    k.value = (y.value*1 + z.value*1);
			  });
			</script>
			<!-- Keyingi stranitsaga kerak bolgan malumotlarni ketishga tayorlaymiz -->
			<input type="hidden" value='<?php echo "$company_id"; ?>' name="companyid">
			<input type="hidden" value='<?php echo "$mahsulot"; ?>' name="mahsulot">
			<input type="hidden" value='<?php echo "$recieved_pro_id"; ?>' name="tovarumumid">
			<input type="hidden" value='<?php echo "$number_invoice"; ?>' name="invoice">
			<input type="hidden" value='<?php echo "$date_order"; ?>' name="date">
			<input type="hidden" value='<?php echo "$recieved_maximum"; ?>' name="maximum">

			<?php if (isset($tovarga_ketadigan_mahsulot_idsi)): ?>
			<input type="hidden" value='<?php echo "$tovarga_ketadigan_mahsulot_idsi"; ?>' name="xizmatdagimaxsulot">
			<?php endif ?>

			<?php if (isset($maxsuID)): ?>
			<input type="hidden" value='<?php echo "$maxsuID"; ?>' name="maxsulotid">
			<?php endif ?>
			
            <div class="clear"></div>
            <br>
			<div class="form-group">
				<button name="backoff" type="submit" class="btn btn-block btn-danger" onClick="deleteqilish(this);return false;">
						<i class="entypo-cancel"></i>Mahsulotni (Servisni) qaytarish
				</button>
			</div>
			<script>
            function deleteqilish(f) {
            if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?")) 
               f.submit();
            }
        </script>
			<div class="clear"></div>
			<br>
		</div>
	</div>
</form>

<!-- /Shu yerdan asosiy conternt -->
<!-- Footercha -->
		<br />
		<footer class="main">
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

	<!-- Imported scripts on this page -->
	<script src="assets/js/bootstrap-switch.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>
<!-- /Bu yerda xam skriptlar -->
</body>
</html>