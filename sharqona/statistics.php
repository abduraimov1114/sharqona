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
	<title>Statistika</title>
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
		<form role="form" method="post" class="form-horizontal hidden-print">
			<div class="form-group">
		  	  	<div class="col-sm-3">
		  	  		<select name="companies" class="select2" data-allow-clear="true" data-placeholder="Tashkilotni tanlang...">
		  				<option></option>
		  				<optgroup label="Tashkilotlar">
		  					<?php 
		  						$queforcomp = "SELECT buyers_id, buyers_name FROM buyers";
		  						$queready = mysqli_query($connection, $queforcomp);
		  						while ($row = mysqli_fetch_assoc($queready)) {
		  							$allcompid = $row['buyers_id'];
		  							$allcompname = $row['buyers_name'];
		  						?>
								<option value='<?php echo "$allcompid"; ?>'><?php echo "$allcompname"; ?></option>
		  						<?php }
		  					 ?>
		  				</optgroup>
		  			</select>
		  	  	</div>
				<div class="col-sm-3">
					<select name="payment" class="select2" data-allow-clear="true" data-placeholder="To'lov turini tanlang...">
						<option></option>
						<optgroup label="To'lov usuli">
							<option value="1=>">Naqd</option>
							<option value="2=>">Plastik</option>
							<option value="3=>">Pul ko'chirish</option>
							<option value="4=>">Qarz</option>
							<option value="5=>">Click</option>
						</optgroup>
					</select>
					<br/>
				</div>
			  		<div class="col-sm-3">
			  			<div class="input-group">
			  				<input type="date" name="date1" class="form-control" data-format="Y/m/d">
			  				<div class="input-group-addon">
			  					<a href="#"><i class="entypo-calendar"></i></a>
			  				</div>
			  			</div>
			  		</div>

			  		<div class="col-sm-3">
			  			<div class="input-group">
			  				<input type="date" name="date2" class="form-control" data-format="Y/m/d">
			  				<div class="input-group-addon">
			  					<a href="#"><i class="entypo-calendar"></i></a>
			  				</div>
			  			</div>
			  		</div>
			</div>
		  	<button type="submit" name="statistics" class="btn btn-blue btn-block">TANLANGAN SOZLAMALARNI TASDIQLASH!</button>
		</form>
		<br>
		<?php 
			$today = date("Y/m/d");
			if (isset($_POST['statistics'])) {
				// Yangi chislo aniqlab olamiz
				// Yangi chislo end
				// Chislolarni aniqlab olamiz
				if (isset($_POST['date1'])) {
					$date1 = $_POST['date1'];
				}
				else {
					$date1 = $today;
				}

				if (isset($_POST['date2'])) {
					$date2 = $_POST['date2'];
				}
				else {
					$date2 = $today;
				}

				if (empty($date1)) {
					$date1 = $today;
				}

				if (empty($date2)) {
					$date2 = $today;
				}

				if ($date1 > $date2) {
					die("Vaqtlar diapazoni normal emas");
				}

				if (isset($_POST['payment'])) {
					$tulov_turi = $_POST['payment'];
				}

				if (isset($_POST['companies'])) {
					$choosed_company = $_POST['companies'];
				}

				if (!empty($choosed_company) AND !empty($tulov_turi) AND !empty($date1) AND !empty($date2)) {
					// $zapros = "SELECT * FROM orders WHERE order_date BETWEEN '$date1' AND '$date2'";
					$zapros = "SELECT * FROM orders WHERE (`customer_id` = '$choosed_company') AND (`payment_type` LIKE '%$tulov_turi%') AND (`order_date` BETWEEN '$date1' AND '$date2') ORDER BY `order_id` DESC";
				}

				if (empty($choosed_company) AND !empty($tulov_turi) AND !empty($date1) AND !empty($date2)) {
					$zapros = "SELECT * FROM orders WHERE (`payment_type` LIKE '%$tulov_turi%') AND (`order_date` BETWEEN '$date1' AND '$date2') ORDER BY `order_id` DESC";
				}

				if (!empty($choosed_company) AND empty($tulov_turi) AND !empty($date1) AND !empty($date2)) {
					$zapros = "SELECT * FROM orders WHERE (`customer_id` = '$choosed_company') AND (`order_date` BETWEEN '$date1' AND '$date2') ORDER BY `order_id` DESC";
				}

				if (empty($choosed_company) AND empty($tulov_turi) AND !empty($date1) AND !empty($date2)) {
					$zapros = "SELECT * FROM orders WHERE `order_date` BETWEEN '$date1' AND '$date2' ORDER BY `order_id` DESC";
				}
				// Chislolarni aniqlab olamiz
				// $pustoyzapros = "SELECT * FROM orders WHERE order_date = '$today'";
				// $order_query = mysqli_query($connection, $pustoyzapros);
			}
			else {
				$date1 = $today;
				$date2 = $today;
				$zapros = "SELECT * FROM orders WHERE `order_date`='$date2' ORDER BY `order_id` DESC";
			}

			$zaprosquery = mysqli_query($connection, $zapros);
			if (!$zaprosquery) {
				die("Bazada zaprosda xatolik");
			}
			else {
				if (!empty($choosed_company)) {
					$queforcompany = "SELECT buyers_name FROM buyers WHERE buyers_id = '$choosed_company'";
					$queryready1 = mysqli_query($connection, $queforcompany);
					if (!$queryready1) {
						die("Zaprosda xatolik");
					}
					else {
						$compdata = mysqli_fetch_array($queryready1);
						$choosed_comp_name = $compdata['buyers_name'];
					}
					
				}
				else {
					$choosed_comp_name = "Barcha savdo";
				}
				?>
					<div class="clearfix"></div>
						<div class="col-md-6 text-left print-inline">
							<h4 class="margin-bottom text-left"><?php echo $choosed_comp_name; ?></h4>
						</div>
						<div class="col-md-6 text-right print-inline">
							<h4 class="margin-bottom text-right">Davr: <?php echo $date1 . "-" . $date2; ?></h4>
						</div>
					<div class="clearfix"></div>
				<?php
				$totalsum = 0;
				$totalcash = 0;
				$totalplastic = 0;
				$totaltransfer = 0;
				$totaldept = 0;
				$totalclick = 0;
				?>
				<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
      var $table1 = jQuery( '#table-1' );
      
      // Initialize DataTable
      $table1.DataTable( {
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bStateSave": true
      });
      
      // Initalize Select Dropdown after DataTables is created
      $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
        minimumResultsForSearch: -1
      });
    } );
    </script>
					<table class="table table-bordered datatable" id="table-1">
						<thead>
							<tr>
								<th width="10%" class="text-right"><strong>San'a</strong></th>

								<?php if (empty($choosed_company)): ?>
								<th class="text-right"><strong>Tashkilot Ismi</strong></th>
								<?php endif ?>

								<th class="text-right"><strong>Maxsulot yoki xizmat</strong></th>
								<th class="text-right"><strong>Narxi (Dona)</strong></th>
								<th class="text-right"><strong>Soni</strong></th>
								<?php if (empty($choosed_company) OR $choosed_company == 10): ?>
								<th class="text-right"><strong>To'lov</strong></th>
								<?php endif ?>
								<th class="text-right"><strong>Ism</strong></th>
								<th class="text-right"><strong>Tel</strong></th>
								<th class="text-right"><strong>Umumiy narxi</strong></th>
							</tr>
						</thead>
						
						<tbody>
				<?php
				include_once("../DB/functions.php");
				$func = new database_func();
				$num=0;
				$naqd=0;
				$plastik=0;
				$send=0;
				$qarz=0;
				$click=0;
				$array_id[$num]=0;
				while ($row = mysqli_fetch_assoc($zaprosquery)){
					$son = 1;
					$order_id = $row['order_id'];
					$company_id = $row['customer_id'];
					$order_date = $row['order_date'];
					$payment_type = $row['payment_type'];
//					echo "<br/>".$order_id;
					$arrays = explode(",",$payment_type);
					for($i=0;$i<count($arrays);$i++){
						$array1 = explode("=>",$arrays[$i]);
						$payment_type_id[$i]=$array1[0];
						$payment_type_value[$i]=$array1[1];
//						echo "<br>".$payment_type_value[$i];
					}
					$total_amount = $row['total_amount'];
					$total_amount = number_format($total_amount);

					$order_note = $row['order_note'];
					$order_name = $row['user_name'];
					$order_phone = $row['user_tell'];

					if (empty($order_name)) {
						$order_name = "No info";
					}
					if (empty($order_phone)) {
						$order_phone = "No info";
					}

					$findnameready = "SELECT buyers_name FROM buyers WHERE buyers_id = '$company_id'";
					$findnamequery = mysqli_query($connection, $findnameready);
					$findname = mysqli_fetch_array($findnamequery);
					$compname = $findname['buyers_name'];
					if ($company_id == 10) {
						$classcha = "badge-success";
					}
					else {
						$classcha = "badge-secondary";
					}
				?>
				<!-- Ishla htmlllar -->
					
							
							<?php  
							// SHerda tovar va xizmatlar zaprosi
//									echo "<br/>".$order_id;
									$ximatlarready = "SELECT * FROM ordered_products WHERE orders_id = '$order_id'";
									$xizmatsquery = mysqli_query($connection, $ximatlarready);
									while ($row = mysqli_fetch_assoc($xizmatsquery)) {
										$general_id = $row['products_id'];
										$general_quantity = $row['product_quantity'];
										$oneprice = $row['product_price'];
										$is_product = $row['is_product'];
										if ($is_product == 1){
											$this_is = "product";
										}
										elseif($is_product == 0){
											$this_is = "service";
										}

										$array_id[$num]=$order_id;
										// Ordered tablesdan zapros end
										// Agar tanlangan tovar maxsulot bolsa
										if ($this_is == "product"){
											$productionready = "SELECT product_name, product_id FROM products WHERE product_id = '$general_id'";
											$productos_query = mysqli_query($connection, $productionready);	
											if ($productos_query === false) {
												die("Chota neto");
											}
											else {
												$stroka_soni = mysqli_num_rows($productos_query);
												if ($stroka_soni == 1) {
													$product_result = mysqli_fetch_array($productos_query);
													$product_id = $product_result['product_id'];
													$product_name = $product_result['product_name'];
												?>	
													<tr style="background: #b9e3f5;">
													<td class="text-right"><?php echo $order_date; ?>
													</td>

													<?php if (empty($choosed_company)): ?>
													<td class="text-right"><?php echo $compname; ?></td>
													<?php endif ?>
													
													<td class="text-right"><?php echo $product_name; ?></td>
													<td class="text-right"><?php echo $oneprice; ?></td>
													<td class="text-right"><?php echo $general_quantity; ?></td>
													<?php if (empty($choosed_company) OR $choosed_company == 10): ?>
													<td class="text-right">
														<?php
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
//															echo $payment_type."<br>";
														}
														echo $tulovforshow;
//														echo count($arrays);
														?>
													</td>
													<?php endif ?>
													<td class="text-right"><?php echo $order_name; ?></td>
													<td class="text-right"><?php echo $order_phone; ?></td>
													<td class="text-right"><?php $totalproone = $oneprice * $general_quantity;
													echo $totalproone; ?></td>
													<?php 
														  $son++; 
														  $totalsum += $totalproone;
														  
														  if ($payment_type == 1) {
														  	$totalcash += $totalproone;
														  }
														  elseif ($payment_type == 2) {
														  	$totalplastic += $totalproone;
														  }
														  elseif ($payment_type == 3) {
														  	$totaltransfer += $totalproone;
														  }
														  elseif ($payment_type == 4) {
														  	$totaldept += $totalproone;
														  }
														  elseif ($payment_type == 5) {
															  $totalclick += $totalproone;
														  }
													?></tr>
												<?php
												}
											}
										}
										// Tanlangan narsa xizmat bolsa
										if ($this_is == "service") {
											$productionready = "SELECT service_name, service_id FROM services WHERE service_id = '$general_id'";
											$servicetos_query = mysqli_query($connection, $productionready);	
											if ($servicetos_query === false) {
												die("Chota neto");
											}
											else {
												$stroka_soni = mysqli_num_rows($servicetos_query);
												if ($stroka_soni == 1) {
													$service_result = mysqli_fetch_array($servicetos_query);
													$service_id = $service_result['service_id'];
													$service_name = $service_result['service_name'];
												?>	<tr>
													<td class="text-right"><?php echo $order_date; ?>
													</td>
													<?php if (empty($choosed_company)): ?>
													<td class="text-right"><?php echo $compname; ?></td>
													<?php endif ?>
													<td class="text-right"><?php echo $service_name; ?></td>
													<td class="text-right"><?php echo $oneprice; ?></td>
													<td class="text-right"><?php echo $general_quantity; ?></td>
													<?php if (empty($choosed_company) OR $choosed_company == 10): ?>
														<td class="text-right">
															<?php
															$tulovforshow1 = "";
															for($i=0;$i<count($arrays);$i++){
																$payment_type = $payment_type_id[$i];

																if ($payment_type == 1) {
																	$tulovforshow1 .= "Naqd ".$payment_type_value[$i]." ";
																}
																if ($payment_type == 2) {
																	$tulovforshow1 .= "Terminal ".$payment_type_value[$i]." ";
																}
																if ($payment_type == 3) {
																	$tulovforshow1 .= "Pul ko'chirish ".$payment_type_value[$i]." ";
																}
																if ($payment_type == 4) {
																	$tulovforshow1 .= "Qarzdorlik ".$payment_type_value[$i]." ";
																}
																if ($payment_type == 5) {
																	$tulovforshow .= "Click ".$payment_type_value[$i]." ";
																}
//															echo $payment_type."<br>";
															}
															echo $tulovforshow1;
															?>
														</td>
													<?php endif ?>
													
													<td class="text-right"><?php echo $order_name; ?></td>
													<td class="text-right"><?php echo $order_phone; ?></td>
													<td class="text-right"><?php $totalproone2 = $oneprice * $general_quantity;
													echo $totalproone2; ?></td>
													<?php 
														  $son++; 
														  $totalsum += $totalproone2;

														  if ($payment_type == 1) {
														  	$totalcash += $totalproone2;
														  }
														  elseif ($payment_type == 2) {
														  	$totalplastic += $totalproone2;
														  }
														  elseif ($payment_type == 3) {
														  	$totaltransfer += $totalproone2;
														  }
														  elseif ($payment_type == 4) {
														  	$totaldept += $totalproone2;
														  }
														  elseif ($payment_type == 5) {
															  $totalclick += $totalproone2;
														  }
													?></tr>
												<?php
												}
											}
										}
										$num++;
									}
								// SHerda tovar va xizmatlar zaprosi end!
								?>
				<!-- Ishlar htmllar tugadi -->
			<?php }
				$new_array = array_unique($array_id);
				$payment_type_id1[$num];
				$payment_type_value1[$num];
				for($i=0;$i<=count($new_array);$i++){
					$tulovforshow1="";
					if($new_array[$i]!=""){
						$sorov = "select * from orders WHERE order_id=".$new_array[$i];
						$func->queryMysql($sorov);
						$row=$func->result->fetch_array(MYSQL_ASSOC);

						$payment_type=$row['payment_type'];
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
						}
					}
				}
			}
		 ?>
		 	</tbody>
		 	<tfoot>
		 		<tr>
		 			<?php if (empty($choosed_company)): ?>
		 				<th colspan="9" class="text-right">Jami narxi: <?php echo number_format($totalsum); ?></th>
		 			<?php else: ?>
		 				<th colspan="9" class="text-right">Jami narxi: <?php echo number_format($totalsum); ?></th>
		 			<?php endif ?>
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
			<div class="col-md-2 text-right hidden-print"><input type="text" class="form-control input-md" disabled="" value="Jami: <?php echo number_format($totalsum); ?>">
			</div>
		 	<div class="clearfix"></div>
		 	<br>
		 	<div class="col-md-12 text-left"><a id="printjon" href="javascript:window.print();" class="btn btn-primary btn-icon icon-left btn-block hidden-print">Qog'ozga chiqarish</a>
		 	</div>
		
		 <script>
		     $("#printjon").click(function(){
             $("#table-1_length").addClass("hidden-print");
             $("#table-1_filter").addClass("hidden-print");
             $("#table-1_info").addClass("hidden-print");
             $("#table-1_paginate").addClass("hidden-print");
             })
		 </script>
		 
		 <style>
		 	td {
		 		color: black;
		 	}
		 </style>
		
		

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
<!-- Imported styles on this page -->
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


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

<!-- /Bu yerda xam skriptlar -->
</body>
</html>