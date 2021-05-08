<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		header('Location: https://vosxod.uz/back_login.php');
		die();
	}

	if (isset($_GET['contr']) AND ($_GET['contr']) > 0 ) {
		$idcompany = $_GET['contr'];
		$idcompany = mysqli_real_escape_string($connection, $idcompany);
		$querypvr = "SELECT buyers_id, buyers_name FROM buyers WHERE buyers_id = '$idcompany'";
		$tekshiruvka = mysqli_query($connection, $querypvr);
		if (!$tekshiruvka) {
			die("Qandaydir xatolik!");
		}
		elseif (mysqli_num_rows($tekshiruvka) > 0 ) {
			while ($row = mysqli_fetch_assoc($tekshiruvka)) {
				$buyers_id = $row['buyers_id'];
				$buyers_name = $row['buyers_name'];
			}
		}

	}
	else {
		$idcompany = "";
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
	<title><?php echo $buyers_name; ?> Contracts</title>
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

	<ol class="breadcrumb"> 
		<li> <a href="organizations.php"> <i class="entypo-folder"></i>Tashkilotlar</a> </li> 
		<li> <a href="#"><?php echo $buyers_name; ?></a></li>
		<li><a href="#">Contracts</a></li> 
	</ol>
	<br>
	
	<script type="text/javascript">
	jQuery( document ).ready( function( $ ) {
		var $table4 = jQuery( "#table-4" ); 
		$table4.DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			]
		} );
	} );		
	</script>
	
	<table class="table table-bordered table-striped datatable" id="table-4">
		<thead>
			<tr>
				<th>№</th>
				<th>№ Contract</th>
				<th>San'a</th>
				<th>Summa</th>
				<th>Tushganiga qadar balans</th>
				<th>Tushgandan keyin balans</th>
			</tr>
		</thead>
			<tbody>
				<?php 

				if (!empty($idcompany)) {
				  $nomercha = 0;
				  $sumcha = 0;
				  $query = "SELECT * FROM contracts WHERE contract_org_id = '$idcompany' ORDER BY `contract_date` DESC";
				  $proquery = mysqli_query($connection, $query);
				  if (!$proquery) {
				    die ("Tashkilotni aniqlashda xatolik");
				  }
				  if (mysqli_num_rows($proquery) > 0) {
				  while ($row = mysqli_fetch_assoc($proquery)) {
				    $contract_id = $row['contract_id'];
				    $contract_number = $row['contract_number'];
				    $order_date1 = $row['contract_date'];
				    $contract_date = date('d.m.Y', strtotime($order_date1));
				    $contract_ammount = $row['contract_ammount'];
				    $till_contract = $row['till_contract'];
				    $after_contract = $row['after_contract'];
				    $nomercha++;
				    $sumcha += $contract_ammount;
				  ?>
				  <tr class="odd gradeX">
				  	<td width="5%"><?php echo $nomercha; ?></td>
				  	<td><?php echo  $contract_number; ?></td>
				  	<td><?php echo $contract_date; ?></td>
				  	<td><?php echo "<span class='badge badge-success'>$contract_ammount</span>"; ?></td>
				  	<td><?php echo $till_contract; ?></td>
				  	<td><?php echo $after_contract; ?></td>
				  </tr>
				<?php }
				}
				else {
					echo "<h4 style='color:red'>Tashkilot tarixi yo'q!</h4>";
				}
			}
				else {
					echo "Yuq";
				}

				 ?>
			</tbody>
		<tfoot>
			<tr>
				<th>№</th>
				<th>№ Contract</th>
				<th>San'a</th>
				<th>Summa</th>
				<th>Tushganiga qadar balans</th>
				<th>Tushgandan keyin balans</th>
			</tr>
		</tfoot>
	</table>

<!-- /Shu yerdan asosiy conternt -->
<!-- Footercha -->
	<?php require_once 'addincludes/footer.php'; ?>
<!-- /Footercha -->
<!-- Bu yerda xam skriptlar -->
	<link rel="stylesheet" href="assets/js/datatables/datatables.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/datatables/datatables.js"></script>
	<script src="assets/js/select2/select2.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>
<!-- /Bu yerda xam skriptlar -->
</body>
</html>