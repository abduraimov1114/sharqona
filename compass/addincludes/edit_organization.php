<head>

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		<?php 
			if (isset($_GET['org_id'])) {
				$get_org_id = $_GET['org_id'];
				$get_org_id = mysqli_real_escape_string($connection, $get_org_id);
			}
			$orgtopish_ready = "SELECT * FROM buyers WHERE buyers_id = '$get_org_id'";
			$rezultat_orgtopish = mysqli_query($connection, $orgtopish_ready);

			if (!$rezultat_orgtopish) {
				die("Bunday ID lik tashkilotni qidirishda xatolik yuz berdi");
			}

			else {
				
				$count = mysqli_num_rows($rezultat_orgtopish);
				
				if ($count == 1) {

					while ($row = mysqli_fetch_assoc($rezultat_orgtopish)) {
						$tanlangan_org_id = $row['buyers_id'];
						$tanlangan_org_name = $row['buyers_name'];
						$tanlangan_org_cntct = $row['buyers_contact'];
						$safety = $row['buyers_safety'];
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
						<strong>Tashkilotni O'zgartirish</strong>
						<br />
						
						<div class="form-group">
							
								<div class="col-sm-6">
									<div class="label label-primary">Tashkilot nomi</div>
									<input type="text" class="form-control input-lg" name="org_name" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi."
									value="<?php echo $tanlangan_org_name; ?>">
								</div>

								<div class="col-sm-2">
									<input type="text" id="dbinf" hidden value="<?php echo $safety; ?>">
									<div class="label label-primary">Ishonchliligi</div>
									<select name="safety" id="select" class="form-control input-lg">
										<option value="0">Ishonchsiz</option>
										<option value="1">50/50</option>
										<option value="2">Ishonchli</option>
									</select>
								</div>

								<script>
									window.onload = function() {
								    	dbinf = document.getElementById('dbinf').value;
								    	const select = document.querySelector('#select').getElementsByTagName('option');
								    	for (let i = 0; i < select.length; i++) {
								    	    if (select[i].value == dbinf) select[i].selected = true;
								    	}
								 	}
								</script>

								<div class="col-sm-4">
									<div class="label label-danger">Qo'shimcha ma'lumot (Bog'lanish)</div>
										<input type="text" class="form-control input-lg" name="org_contact" data-validate="required" 
										data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi."
										value="<?php echo $tanlangan_org_cntct; ?>" 
										>
								</div>
						</div>

						<div class="form-group">
							<button type="submit" name="edit_organization" data-loading-text="Iltimos kuting..." class="btn btn-success">O'zgartirish</button>
							<button type="reset" class="btn">Tozalash</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
		
		<?php 

			if (isset($_POST['edit_organization'])) {

				if (empty($_POST['org_name']) OR empty($_POST['org_contact'])) {
					$_SESSION['xabar'] = "xato";
					header("Location: /compass/organizations.php");
				}

				else {

					$org_title = $_POST['org_name'];
					$org_contact = $_POST['org_contact'];
					$issafe = $_POST['safety'];
					$org_title = mysqli_real_escape_string($connection, $org_title);
					$org_contact = mysqli_real_escape_string($connection, $org_contact);
					$issafe = mysqli_real_escape_string($connection, $issafe);

					$org_tayorgarlik = "UPDATE buyers SET buyers_name = '$org_title', buyers_contact = '$org_contact', buyers_safety = '$issafe' WHERE buyers_id = '$tanlangan_org_id'";
					$org_save = mysqli_query($connection, $org_tayorgarlik);

					if (!$org_save) {
						die("Tashkilotni bazada saqlashda xatolik yuz berdi");
					}
					
					else {
						$_SESSION['xabar'] = "org_yaratildi";
						header("Location: /compass/organizations.php");
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