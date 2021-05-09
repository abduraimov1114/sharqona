

<head>



	<script src="assets/js/jquery-1.11.3.min.js"></script>



</head>

<?php 
	// Podgotavlivaem randomniy shtrix
	function RandomNumber(){
		$son = mt_rand(1000001, 9999999);	
		$son2 = rand(11111, 99999);
		return $son . $son2;
	}
	$random = RandomNumber();
	// Proveryaem esli takoy strix na baze, esli est to obnovlyayem stranitsu i generiruem noviy shtrix
	$mimo = "SELECT service_barcode FROM services";
	$zapr = mysqli_query($connection,$mimo);
	while ($row = mysqli_fetch_array($zapr)) {
		 if (in_array($random, $row)) {
		 	header("Refresh:1");
		 }
	}
	$mimon = "SELECT product_barcode FROM products";
	$zapron = mysqli_query($connection,$mimon);
	while ($rowan = mysqli_fetch_array($zapron)) {
		 if (in_array($random, $rowan)) {
		 	header("Refresh:1");
		 }
	}
 ?>
		<fieldset>
			<legend><strong>Yangi Mahsulot qo'shish</strong></legend>
		<div class="row">
			<div class="col-md-12">
					<div class="panel-body">
						<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" onkeypress="return event.keyCode != 13;">
							<br />
							<div class="form-group">
								<div class="col-sm-5">
									<div class="label label-primary">Mahsulot ismi</div>
									<input type="text" class="form-control input-lg" name="name" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi.">
								</div>
								<div class="col-sm-4">
									<div class="label label-info">Kategoriyasi</div>
									<select name="category_idsi" class="select2" data-allow-clear="true" data-validate="required" required>
										<option></option>
										<optgroup label="Kategoriyalar">
											<?php 
											$query = "SELECT * FROM product_category";
											$catquery = mysqli_query($connection, $query);
											if (!$catquery) {
												die ("Something went wrong!");
											}
											while ($row = mysqli_fetch_assoc($catquery)) {
												$pcat_id = $row['pcat_id'];
												$pcat_name = $row['pcat_name'];
											 ?>
												<option value="<?php echo $pcat_id; ?>"><?php echo "$pcat_name"; ?></option>
											<?php } ?>
										</optgroup>
									</select>
								</div>
								<div class="col-sm-3">
									<div class="label label-danger">Danger</div>
									<div class="input-spinner">
										<button type="button" class="btn btn-info btn-lg">-</button>
										<input type="text" name="number" class="form-control size-1 input-lg" value="3" data-validate="number" aria-invalid="false" aria-describedby="number-error">
										<button type="button" class="btn btn-info btn-lg">+</button>
									</div>
								</div>
								<div class="clearfix">
								</div><br>
								<div class="col-sm-3">
									<div class="label label-danger">Garantiya birligi</div>
									<input type="number" step="1" min="0" value="0" class="form-control size-1 input-lg" name="garanty">
								</div>
								<div class="col-sm-3">
									<div class="label label-danger">Garantiya muddati</div>
									<select name="garanty_length" id="" class="select2">
										<option value="kun">Kun</option>
										<option selected value="oy">Oy</option>
										<option value="yil">Yil</option>
									</select>
								</div>
								<div class="col-sm-6">
									<div class="input-group" style="margin-top: 20px;">
										<!-- real barcode area -->
										<input placeholder="Scan barcode or generate!" type="text" class="form-control input-lg" name="barcode" id="barcode" autocomplete="off" required>
										<!-- false generated barcode area -->
										<input hidden type="text" value="<?php echo $random; ?>" id="draftbarcode">
										<span class="input-group-btn"> 
											<button type="button" class="btn btn-primary btn-lg" onclick="CopyPaster()">
												<div class="icon">
													<i class="entypo-shareable"></i> Generate
												</div>
											</button>
										</span>
									</div>
								</div>
								<script>
									function CopyPaster() {
										var draft = document.getElementById('draftbarcode').value;
										document.getElementById('barcode').value = draft;
										document.getElementById('barcode').setAttribute('readonly', true);
										document.getElementById('printbarcode').removeAttribute('hidden');
									}
									function Enabler() {
										document.getElementById('barcode').removeAttribute('readonly');
										document.getElementById('printbarcode').setAttribute('hidden', true);
									}
								</script>
								<div class="clearfix"></div>
								<br>
								<div id="printbarcode" class="text-center" hidden>
									<hr>
									<div class="col-sm-4"></div>
									<div class="col-sm-4">
										<div class="tile-title tile-blue">
											<div class="icon">
												<a target="_blank" href="barcode.php?barcode=<?php echo $random ?>"><i class="glyphicon glyphicon-barcode"></i></a>
											</div>
							
											<div class="title">
												<a target="_blank" href="barcode.php?barcode=<?php echo $random ?>"><h3>Print Barcode</h3></a>
												<a target="_blank" href="barcode.php?barcode=<?php echo $random ?>"><p>Tasodifiy generatsiya qilingan shtrix kod.</p></a>
											</div>
										</div>
									</div>
									<div class="col-sm-4"></div>
									<hr>
								</div>

							</div>
							<div class="form-group">
								<button type="submit" name="create_product"  data-loading-text="Iltimos kuting..." class="btn btn-success btn-lg">Yaratish</button>
								<button type="reset" class="btn btn-lg" onclick="Enabler()">Tozalash</button>
							</div>
						</form>	
					</div>
			</div>
		</div>
		</fieldset>

		

		<?php 



		if (isset($_POST['create_product'])) {



			if (empty($_POST['name']) OR empty($_POST['category_idsi']) OR empty($_POST['barcode']) OR empty($_POST['number']) OR $_POST['number'] < 0 ) {

				$_SESSION['xabar'] = "xato";

				header("Location: /sharqona/products.php?source=add_product");

			}

			else {

			$product_title = $_POST['name'];

			$product_category = $_POST['category_idsi'];

			$product_danger = $_POST['number'];

			$product_garanty = $_POST['garanty'];

			$product_barcode = $_POST['barcode'];

			if ($product_garanty > 0) {

				$garanty_length = $_POST['garanty_length'];
				$product_garanty = $product_garanty;

			}

			else {
				$product_garanty = 0;
				$garanty_length = 0;
			}


			$product_barcode = mysqli_real_escape_string($connection, $product_barcode);

			$product_garanty = mysqli_real_escape_string($connection, $product_garanty);

			$garanty_length = mysqli_real_escape_string($connection, $garanty_length);

			$product_title = mysqli_real_escape_string ($connection, $product_title);

			$product_category = mysqli_real_escape_string ($connection, $product_category);

			$product_danger = mysqli_real_escape_string ($connection, $product_danger);




			$queryprd = "INSERT INTO products (product_barcode, product_guarantee, guarantee_length, product_name, product_category_id, product_danger, product_count, product_prise_in, product_prise_out, product_desc, product_img) VALUES ('$product_barcode', '$product_garanty', '$garanty_length', '$product_title', '$product_category', '$product_danger', '0', '0', '0', 'No info', 'noimage.jpg')";

			$create_new_product = mysqli_query($connection, $queryprd);

			

			if (!$create_new_product) {

				die("Malumotni bazada saqlashda xatolik yuz berdi");

			}



			else {

				$_SESSION['xabar'] = "produkt_yaratildi";

				header("Location: /sharqona/products.php");

			}



		}}



		 ?>

		

		

		



		

		

		

		<script type="text/javascript">

		jQuery(document).ready(function($)

		{

			$('input.icheck').iCheck({

				checkboxClass: 'icheckbox_minimal',

				radioClass: 'iradio_minimal'

			});

			

			$('input.icheck-2').iCheck({

				checkboxClass: 'icheckbox_minimal-blue',

				radioClass: 'iradio_minimal-blue'

			});

		});

		

		

		jQuery(document).ready(function($)

		{

			var icheck_skins = $(".icheck-skins a");

			

			icheck_skins.click(function(ev)

			{

				ev.preventDefault();

				

				icheck_skins.removeClass('current');

				$(this).addClass('current');

				

				updateiCheckSkinandStyle();

			});

			

			$("#icheck-style").change(updateiCheckSkinandStyle);

		});

			

		function updateiCheckSkinandStyle()

		{

			var skin = $(".icheck-skins a.current").data('color-class'),

				style = $("#icheck-style").val();

			

			var cb_class = 'icheckbox_' + style + (skin.length ? ("-" + skin) : ''),

				rd_class = 'iradio_' + style + (skin.length ? ("-" + skin) : '');

			

			if(style == 'futurico' || style == 'polaris')

			{

				cb_class = cb_class.replace('-' + skin, '');

				rd_class = rd_class.replace('-' + skin, '');

			}

			

			$('input.icheck-2').iCheck('destroy');

			$('input.icheck-2').iCheck({

				checkboxClass: cb_class,

				radioClass: rd_class

			});

		}

		</script>









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

