
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
			<legend><strong>Yangi xizmat qo'shish</strong></legend>
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" onkeypress="return event.keyCode != 13;">
						
						<div class="form-group">
							
								<div class="col-sm-6">
									<div class="label label-primary">Xizmat turi</div>
									<input type="text" placeholder="Xizmat ismini kiriting.." class="form-control input-lg" name="xizmat" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi.">
								</div>

								<div class="col-sm-6">
									<div class="label label-info">Ketadigan maxsulot</div>
									<select name="maxsulotlar" class="select2" data-allow-clear="true">
										<option></option>
										<optgroup label="Mahsulotlar">
											<?php 
											$query = "SELECT * FROM products";
											$proquery = mysqli_query($connection, $query);

											if (!$proquery) {
												die ("Maxsulot ismini zaprosida xatolik");
											}

											while ($row = mysqli_fetch_assoc($proquery)) {
												$maxsulot_id = $row['product_id'];
												$maxsulot_ismi = $row['product_name'];
											 ?>
												<option value="<?php echo $maxsulot_id; ?>"><?php echo "$maxsulot_ismi"; ?></option>
											<?php } ?>
										</optgroup>
									</select>
									
								</div>
								<div class="clearfix"></div><br>

								<div class="col-sm-6">
									<div class="label label-danger">Narxi (T)</div>
										<input type="number" step="any" min="500" class="form-control input-lg" name="xiz_narxi" required data-validate="number required" placeholder="Xizmat narxi (T)">
								</div>

								<div class="col-sm-6">
									<div class="label label-danger">Narxi (K)</div>
										<input type="number" class="form-control input-lg" name="street_price" step="any" min="500" data-validate="number required" required placeholder="Xizmat narxi (K)">
								</div>

								<div class="clear"></div>
								<div class="col-sm-12">
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
								</div>
						</div>

						<div class="form-group">
							<button type="submit" name="create_service" data-loading-text="Iltimos kuting..." class="btn btn-success">Yaratish</button>
							<button type="reset" class="btn" onclick="Enabler()">Tozalash</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
		</fieldset>
		
		<?php 

			if (isset($_POST['create_service'])) {

				if (empty($_POST['xizmat']) OR empty($_POST['xiz_narxi']) OR $_POST['xiz_narxi'] < 0 ) {
					$_SESSION['xabar'] = "xato";
					header("Location: /compass/services.php?source=add_service");
				}

				else {

					$service_title = $_POST['xizmat'];
					$service_price = $_POST['xiz_narxi'];
					$street_price = $_POST['street_price'];
					$barcode = $_POST['barcode'];

					if (!empty($_POST['maxsulotlar'])) {
					$product_choosed = $_POST['maxsulotlar'];
					}
					else {
					$product_choosed = 0;
					}
					
					$service_title = mysqli_real_escape_string($connection, $service_title);
					$service_price = mysqli_real_escape_string($connection, $service_price);
					$street_price = mysqli_real_escape_string($connection, $street_price);
					$barcode = mysqli_real_escape_string($connection, $barcode);

					$service_tayorgarlik = "INSERT INTO services (service_name, service_price, service_street_price, service_pro_id, service_barcode)
					VALUES ('$service_title', '$service_price', '$street_price', '$product_choosed', '$barcode')";
					$service_save = mysqli_query($connection, $service_tayorgarlik);

					if (!$service_save) {
						die("Xizmatni bazada saqlashda xatolik yuz berdi");
					}
					else {
						$_SESSION['xabar'] = "service_yaratildi";
						header("Location: /compass/services.php");
					}


				}
			}

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
