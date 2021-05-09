
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		<?php 
				if (isset($_GET['product'])) {
					$tanlangan_id_tovar = $_GET['product'];
					$tanlangan_id_tovar = mysqli_real_escape_string($connection, $tanlangan_id_tovar);

					$ready_for_checking = "SELECT * FROM products WHERE product_id = '$tanlangan_id_tovar'";
					$result_checking = mysqli_query($connection, $ready_for_checking);
					if (!$result_checking) {
						die("Tekshiruvda xatolik");
					}

					else {
						$sanash = mysqli_num_rows($result_checking);
					}

					if ($sanash <= 0) {
						$_SESSION['xabar'] = "xato";
						header("Location: /sharqona/products.php");
					}

					else {
						while ($row = mysqli_fetch_assoc($result_checking)) {
							$choosed_pro_id = $row['product_id'];
							$choosed_pro_name = $row['product_name'];
							$choosed_product_quantity = $row['product_count'];
							$choosed_product_prise_in = $row['product_prise_in'];
							$choosed_product_prise_out = $row['product_prise_out'];
						}
					}
				}
				else {
					$_SESSION['xabar'] = "xato";
					header("Location: /sharqona/products.php");
				}
		 ?>

		<div class="row">
			<div class="col-md-12">
					<div class="panel-body">
						
						<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate">
							<ol class="breadcrumb">
								<li><a href="products.php">Mahsulotlar boshqaruvi</a></li>
								<li><a href="#">Kirim</a></li>
								<li><a href="#"><?php echo "$choosed_pro_name"; ?></a></li>
							</ol>
							<br>
							
							<fieldset for="services" id="services" style="border: 2px solid #00a651 !important;padding: 30px 20px !important;">
								<legend style="background: #00a651;color: white; width: auto;"><?php echo "$choosed_pro_name"; ?></legend>
								<div class="form-group">
									

									<div class="col-sm-3">
										<div class="label label-info">Date</div>
										<div class="input-group">
											<input type="date" class="form-control" data-validate="required" placeholder="San'a" name="chislo">
											<div class="input-group-addon">
												<a href="#"><i class="entypo-calendar"></i></a>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="label label-info">Quantity</div>
										<input type="number" min="1" class="form-control" name="soni" placeholder="Mahsulot soni" data-validate="required">
										<div><span class="badge badge-secondary badge-roundless">Hozirda omborda:</span><span class="badge badge-success badge-roundless item-left"><?php echo $choosed_product_quantity; ?></span></div>
									</div>
									
									<div class="col-sm-3">
										<div class="label label-info">Incoming Price $</div>
										<input type="number" min="0" step="any" name="kirish_narxi" class="form-control" data-validate="required" aria-invalid="false" aria-describedby="number-error" placeholder="Mahsulot kelish narxi $">
										<div><span class="badge badge-secondary badge-roundless">Oldingi kelish narxi:</span><span class="badge badge-success badge-roundless item-left"><?php echo $choosed_product_prise_in . " " . "$"; ?></span></div>
									</div>
									
									<div class="col-sm-3">
										<div class="label label-info">Selling Prize $</div>
										<input type="number" min="0" step="any" name="sotish_narxi" class="form-control" data-validate="required" aria-invalid="false" aria-describedby="number-error" placeholder="Mahsulot sotish narxi $">
										<div><span class="badge badge-secondary badge-roundless">Oldingi sotish narxi:</span><span class="badge badge-success badge-roundless item-left"><?php echo number_format($choosed_product_prise_out); ?></span></div>
									</div>
								</div>
							</fieldset>
							<div class="row">
								<div class="form-group col-sm-6">
									<button type="submit" name="submit_pro_incoming" data-loading-text="Iltimos kuting..." class="btn btn-success btn-icon">Mahsulotga kirim
									<i class="entypo-check"></i>
									</button>
									<button type="reset" class="btn btn-orange btn-icon">Tozalash
									<i class="entypo-minus"></i>
									</button>
									<a href="products.php" class="btn btn-danger btn-icon">Bekor qilish
										<i class="entypo-cancel"></i>
									</a>
								</div>
							</div>
						</form>
						
					</div>
			</div>
		</div>
		
		<?php 

		if (isset($_POST['submit_pro_incoming'])) {

			if (empty($_POST['soni']) OR empty($_POST['kirish_narxi']) OR empty($_POST['sotish_narxi']) OR $_POST['soni'] < 0 ) {
				$_SESSION['xabar'] = "xato";
				header("Location: products.php");
			}

			else {
			// Make date start
			if (isset($_POST['chislo'])) {
			  $date = $_POST['chislo'];
			}
			else {
			  $date = new DateTime();
			}
			$date = mysqli_real_escape_string ($connection, $date);
			$mahsulot_kirim_sanasi = date_format (new DateTime($date), 'Y-m-d');
			// Make date end!
			$mahsulot_kirim_soni = $_POST['soni'];
			$mahsulot_kirim_narxi = $_POST['kirish_narxi'];
			$mahsulot_sotish_narxi = $_POST['sotish_narxi'];


			$mahsulot_kirim_soni = mysqli_real_escape_string ($connection, $mahsulot_kirim_soni);
			$mahsulot_kirim_narxi = mysqli_real_escape_string ($connection, $mahsulot_kirim_narxi);
			$mahsulot_sotish_narxi = mysqli_real_escape_string ($connection, $mahsulot_sotish_narxi);

			if ($choosed_product_quantity == 0) {
				$queryprd = "UPDATE products SET product_prise_in = '$mahsulot_kirim_narxi', product_prise_out = '$mahsulot_sotish_narxi', product_count = '$mahsulot_kirim_soni' WHERE product_id = '$choosed_pro_id'";
				$income_the_product = mysqli_query($connection, $queryprd);
				if (!$income_the_product) {
					die("Ma'lumotni bazada saqlashda xatolik yuz berdi");
				}
				else {
					$_SESSION['xabar'] = "success";
					header("Location: products.php");
				}
			}

			elseif ($choosed_product_quantity > 0) {
				
				if ($choosed_product_prise_in > $mahsulot_kirim_narxi) {
					$new_product_income_price = $choosed_product_prise_in;
				}
				elseif ($choosed_product_prise_in < $mahsulot_kirim_narxi) {
					$new_product_income_price = $mahsulot_kirim_narxi;
				}

				$product_new_quantity = $mahsulot_kirim_soni + $choosed_product_quantity;

				$queryprd = "UPDATE products SET product_prise_in = '$new_product_income_price', product_prise_out = '$mahsulot_sotish_narxi', product_count = '$product_new_quantity' WHERE product_id = '$choosed_pro_id'";
				$income_the_product = mysqli_query($connection, $queryprd);
				if (!$income_the_product) {
					die("Ma'lumotni bazada saqlashda xatolik yuz berdi");
				}
				else {
					$_SESSION['xabar'] = "success";
					header("Location: products.php");
				}
			}

			else {
				die("Qandaydir noaniq quantity!");
			}
		}}

		 ?>




	<!-- Imported styles on this page -->

	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">



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
	<script src="assets/js/jquery.validate.min.js"></script>
