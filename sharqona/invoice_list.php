<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
	}

	if (isset($_GET['invoice']) AND ($_GET['invoice']) > 0 ) {
		$idcompany = $_GET['invoice'];
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
	<title><?php echo $buyers_name; ?> Invoice List</title>
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
		<li><a href="#">Invoice List</a></li> 
	</ol>
	<br />
	
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
				<th>№ Invoice</th>
				<th>San'a</th>
				<th>Xizmatlar</th>
				<th>Maxsulotlar</th>
				<th>Summasi</th>
				<th>Xodim</th>
				<th>Tel</th>
				<th>Inf</th>
				<th>Tulov holati</th>
				<th>-</th>
			</tr>
		</thead>
			<tbody>
				<?php 

				if (!empty($idcompany)){
				  $nomercha = 0;
				  $sumcha = 0;
				  $xizmatcha = 0;
				  $maxsulotcha = 0;
				  $query = "SELECT * FROM orders WHERE customer_id = '$idcompany' ORDER BY `order_id` DESC LIMIT 1000";
				  $proquery = mysqli_query($connection, $query);
				  if (!$proquery) {
				    die ("Tashkilotni aniqlashda xatolik");
				  }
				  if (mysqli_num_rows($proquery) > 0) {
					  include_once("../DB/functions.php");
					  $func = new database_func();
					  $num=0;
					  $naqd=0;
					  $plastik=0;
					  $send=0;
					  $qarz=0;
					  $click=0;
					  $array_id[$num]=0;
				  while ($row = mysqli_fetch_assoc($proquery)){
				    $order_id = $row['order_id'];
				    $order_date1 = $row['order_date'];
				    $order_date = date('d.m.Y', strtotime($order_date1));
				    $ammount = $row['total_amount'];
				    $customer_worker = $row['user_name'];
					  $payment_type = $row['payment_type'];
//					echo "<br/>".$payment_type;
					  $arrays = explode(",",$payment_type);
					  for($i=0;$i<count($arrays);$i++){
						  $array1 = explode("=>",$arrays[$i]);
						  $payment_type_id[$i]=$array1[0];
						  $payment_type_value[$i]=$array1[1];
//						echo "<br>".$payment_type_value[$i];
					  }

				    if (empty($customer_worker)) {
                    $customer_worker = "Malumot kiritilmagan";
                    }
                    $phone = $row['user_tell'];
                    if (empty($phone)) {
                    $phone = "Malumot kiritilmagan";
                    }
                    $desc = $row['order_note'];

				    $nomercha++;
				    $sumcha += $ammount;
				  ?>
				  <tr class="odd gradeX">
				  	<td width="5%"><?php echo $nomercha; ?></td>
				  	<td width="10%"><?php echo $order_id; ?></td>
				  	<td><?php echo $order_date; ?></td>
				  	<td width="5%">
				  		<?php 
				  			$serv = "SELECT SUM(`product_quantity`) AS jamiservice FROM `ordered_products` WHERE `orders_id` = '$order_id' AND `is_product` = 0";
				  			$servi = mysqli_query($connection, $serv);
				  			$resser = mysqli_fetch_assoc($servi);
				  			$resserv = $resser['jamiservice'];
				  			if (is_null($resserv)) {
				  				echo "<span class='badge badge-success'>0</span>";
				  			}
				  			else {
				  				echo "<span class='badge badge-success'>$resserv</span>";
				  				$xizmatcha += $resserv;
				  			}
				  		 ?>
				  	</td>
				  	<td width="5%">
				  		<?php 
				  			$pro = "SELECT SUM(`product_quantity`) AS jamipro FROM `ordered_products` WHERE `orders_id` = '$order_id' AND `is_product` = 1";
				  			$prod = mysqli_query($connection, $pro);
				  			$produc = mysqli_fetch_assoc($prod);
				  			$product = $produc['jamipro'];
				  			if (is_null($product)) {
				  				echo "<span class='badge badge-info'>0</span>";
				  			}
				  			else {
				  				echo "<span class='badge badge-info'>$product</span>";
				  				$maxsulotcha += $product;
				  			}
				  		 ?>
				  	</td>
				  	<td width="5%"><?php echo "<span class='badge badge-secondary'>$ammount</span>"; ?></td>
				  	<td><?php echo $customer_worker; ?></td>
				  	<td><?php echo $phone; ?></td>
				  	<td><?php echo $desc; ?></td>
				  	<td><?php
						$tulovforshow = "";
						for($i=0;$i<count($arrays);$i++){
							$payment_type = $payment_type_id[$i];

							if ($payment_type == 1) {
								$tulovforshow .= "Naqd ".$payment_type_value[$i]." ";
							}
							if ($payment_type == 2) {
								$tulovforshow .= "Terminal ".$payment_type_value[$i]." ";
							}
							if ($payment_type == 3) {
								$tulovforshow .= "Pul ko'chirish ".$payment_type_value[$i]." ";
							}
							if ($payment_type == 4) {
								$tulovforshow .= "Qarzdorlik ".$payment_type_value[$i]." ";
							}
							if ($payment_type == 5) {
								$tulovforshow .= "Click ".$payment_type_value[$i]." ";
							}
						}
						echo $tulovforshow;
						?></td>
				  	<td><a href="invoice_details.php?invoicedt=<?php echo $order_id; ?>"><i class="entypo-eye"></i></a></td>
				  </tr>
				<?php $num++;$array_id[$num]=$order_id;}
					  $new_array = array_unique($array_id);
					  $payment_type_id[$num];
					  $payment_type_value[$num];
					  $totalsum=0;
					  for($i=0;$i<=count($new_array);$i++){
						  $tulovforshow1="";
						  if($new_array[$i]!=""){
							  $sorov = "select * from orders WHERE order_id=".$new_array[$i];
							  $func->queryMysql($sorov);
							  $row=$func->result->fetch_array(MYSQL_ASSOC);

							  $payment_type=$row['payment_type'];
//							  echo "<br/>".$payment_type;
							  $arrays = explode(",",$payment_type);
							  for($j=0;$j<count($arrays);$j++){
								  $array1 = explode("=>",$arrays[$j]);
								  $payment_type_id1[$j]=$array1[0];
								  $payment_type_value1[$j]=$array1[1];
								  $payment_type = $payment_type_id1[$j];

								  if ($payment_type == 1) {
									  $naqd +=$payment_type_value1[$j];
								  }
								  if ($payment_type == 2) {
									  $plastik +=$payment_type_value1[$j];
								  }
								  if ($payment_type == 3) {
									  $send +=$payment_type_value1[$j];
								  }
								  if ($payment_type == 4) {
									  $qarz+=$payment_type_value1[$j];
								  }
								  if ($payment_type == 5) {
									  $click+=$payment_type_value1[$j];
								  }
								  $totalsum +=$click+$qarz+$send+$plastik+$naqd;
							  }
						  }
					  }
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
				<th>№ Invoice</th>
				<th>San'a</th>
				<th>Xizmatlar <?php echo $xizmatcha; ?> ta</th>
				<th>Maxsulotlar <?php echo $maxsulotcha; ?> ta</th>
				<th><?php echo number_format($sumcha); ?> SUM</th>
				<th>Xodim</th>
				<th>Tel</th>
				<th>Inf</th>
				<th>Tulov holati</th>
				<th>-</th>
			</tr>
		</tfoot>
	</table>
	<br>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Naqd: <?php echo number_format($naqd); ?>">
	</div>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Plastik: <?php echo number_format($plastik); ?>">
	</div>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Ko'chirish: <?php echo number_format($send); ?>">
	</div>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Click: <?php echo number_format($click); ?>">
	</div>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Qarz: <?php echo number_format($qarz); ?>">
	</div>
	<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Jami: <?php echo number_format($sumcha); ?>">
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-12 text-left"><a id="printjon" href="javascript:window.print();" class="btn btn-primary btn-icon icon-left btn-block hidden-print">Qog'ozga chiqarish</a>
	</div>
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