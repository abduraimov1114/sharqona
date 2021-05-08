
<head>

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		<?php 

		  if (isset($_GET['orgid'])) {
		    $org_id = $_GET['orgid'];
		    $org_id = mysqli_real_escape_string($connection, $org_id);
		    $org_search = "SELECT * FROM buyers WHERE buyers_id = '$org_id'";
		    $org_tanlov = mysqli_query($connection, $org_search);
		    
		    if (!$org_tanlov) {
		      die("Tashkilotni qidirishda xatolik");
		    }
		    else {
		      $count = mysqli_num_rows($org_tanlov);
		    }

		    if ($count == 1) {
		      while ($row = mysqli_fetch_assoc($org_tanlov)) {
		        $tashkilot_id = $row["buyers_id"];
		        $tashkilot_ismi = $row['buyers_name'];
		        $tashkilot_byudjeti = $row['buyers_budget'];
		        /*
		        Tashkilotni byudjetini shu yerdan olasiz:
		        $tashkilot_byudjeti
		        */
		      }
		    }
		    else {
		      header("Location: /compass/organizations.php");
		      $_SESSION['xabar'] = "xato";
		    }
		  }

		 ?>

		<div class="row">
			<div class="col-md-12">
					<div class="panel-body">
						
						<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate">
							<ol class="breadcrumb">
							  <li><a href="organizations.php">Tashkilotlar boshqaruvi</a></li>
							  <li><a href="#"><?php echo $tashkilot_ismi; ?></a></li>
							  <li><a href="#">Kirim</a></li>
							</ol>
							<br>
							

							<fieldset for="services" id="services" style="border: 2px solid #00a651 !important;padding: 30px 20px !important;">
							    <legend style="background: #00a651;color: white;"><?php echo $tashkilot_ismi; ?></legend>
							    <div class="form-group">


							    	<div class="col-sm-3">
							    		<input type="text" class="form-control" name="dogovor" placeholder="Shartnoma №" data-validate="required" data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi.">
							    	</div>
									
									<div class="col-sm-3">
										<div class="input-group">
											<input type="date" class="form-control" data-validate="required" placeholder="San'a" name="chislo">
											<div class="input-group-addon">
												<a href="#"><i class="entypo-calendar"></i></a>
											</div>
										</div>
									</div>

							    	<div class="col-sm-6">
							    			<input type="number" min="-100000000" name="summasi" class="form-control" value="" data-validate="required" aria-invalid="false" aria-describedby="number-error" placeholder="Shartnoma Summasi">
							    	</div>
							    </div>
							</fieldset>

							<div class="row">
								<div class="form-group col-sm-6">
									<button type="submit" name="submit_incoming" data-loading-text="Iltimos kuting..." class="btn btn-success btn-icon">Shartnoma tuzish
									<i class="entypo-check"></i>
									</button>
									<button type="reset" class="btn btn-orange btn-icon">Tozalash
									<i class="entypo-minus"></i>
									</button>
									<a href="organizations.php" class="btn btn-danger btn-icon">Bekor qilish
									<i class="entypo-cancel"></i>
									</a>
								</div>
								
								<div class="col-sm-6">
								  <div class="input-group pull-right">
								    <div class="input-group-addon">Ayni damda tashkilot byudjeti:</div>
								    <input type="text" class="form-control input-md" disabled="" placeholder="<?php echo number_format($tashkilot_byudjeti); ?>">
								    <div class="input-group-addon">sums</div>
								  </div>
								</div>
							</div>

						</form>	
					</div>
			</div>
		</div>
		
		<?php 

		if (isset($_POST['submit_incoming'])) {

			if (empty($_POST['dogovor']) OR empty($_POST['chislo']) OR empty($_POST['summasi']) OR $_POST['summasi'] < -100000000 ) {
				$_SESSION['xabar'] = "xato";
				header("Location: /compass/organizations.php");
			}
			else {
			$contract_number = $_POST['dogovor'];
			$date = $_POST['chislo'];
			$contract_cash = $_POST['summasi'];

			$contract_number = mysqli_real_escape_string ($connection, $contract_number);
			$date = mysqli_real_escape_string ($connection, $date);
			$contract_cash = mysqli_real_escape_string ($connection, $contract_cash);
			$yangi_byudjet = $tashkilot_byudjeti + $contract_cash;
			$contract_date = date_format (new DateTime($date), 'Y-m-d');

			$queryprd = "UPDATE buyers SET buyers_budget = '$yangi_byudjet' WHERE buyers_id = '$tashkilot_id'";
			$update_budget = mysqli_query($connection, $queryprd);
			
			if (!$update_budget) {
				die("Malumotni bazada saqlashda xatolik yuz berdi");
			}

			else {
				$ready_contract = "INSERT INTO contracts(contract_org_id, contract_number, contract_date, contract_ammount, till_contract, after_contract) VALUES('$tashkilot_id', '$contract_number', '$contract_date', '$contract_cash', '$tashkilot_byudjeti', '$yangi_byudjet')";
				$contract_query = mysqli_query($connection, $ready_contract);
				if (!$contract_query) {
					die("Ma'lumotlarni bazada saqlashda xatolik!");
				}
				$_SESSION['xabar'] = "success";
				header("Location: /compass/organizations.php");
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
