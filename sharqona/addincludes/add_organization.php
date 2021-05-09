
<head>

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate">
						<ol class="breadcrumb">
						  <li><a href="organizations.php">Tashkilotlar boshqaruvi</a></li>
						  <li><a href="#">Yangi Tashkilot Yaratish</a></li>
						</ol>
						<br />
						
						<div class="form-group">
							
								<div class="col-sm-6">
									<div class="label label-primary">Tashkilot nomi</div>
									<input type="text" class="form-control input-lg" name="org_name" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi.">
								</div>
								<div class="col-sm-2">
									<div class="label label-primary">Ishonchliligi</div>
									<select name="safety" id="select" class="form-control input-lg">
										<option value="0">Ishonchsiz</option>
										<option value="1">50/50</option>
										<option value="2">Ishonchli</option>
									</select>
								</div>
								<div class="col-sm-4">
									<div class="label label-danger">Qo'shimcha ma'lumot (Bog'lanish)</div>
										<input type="text" class="form-control input-lg" name="org_contact" data-validate="required" 
										data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi."
										placeholder="Telefon, pochta va hk">
								</div>
						</div>

						<div class="form-group">
							<button type="submit" name="create_organization" data-loading-text="Iltimos kuting..." class="btn btn-success">Yaratish</button>
							<button type="reset" class="btn">Tozalash</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
		
		<?php 

			if (isset($_POST['create_organization'])) {

				if (empty($_POST['org_name']) OR empty($_POST['org_contact'])) {
					$_SESSION['xabar'] = "xato";
					header("Location: /sharqona/organizations.php?source=add_organization");
				}

				else {

					$org_title = $_POST['org_name'];
					$org_contact = $_POST['org_contact'];
					$safety = $_POST['safety'];
					
					$org_title = mysqli_real_escape_string($connection, $org_title);
					$org_contact = mysqli_real_escape_string($connection, $org_contact);
					$safety = mysqli_real_escape_string($connection, $safety);

					$org_tayorgarlik = "INSERT INTO buyers (buyers_name, buyers_contact, buyers_budget, buyers_safety) VALUES ('$org_title', '$org_contact', 0, '$safety')";
					$org_save = mysqli_query($connection, $org_tayorgarlik);

					if (!$org_save) {
						die("Tashkilotni bazada saqlashda xatolik yuz berdi");
					}
					
					else {
						$_SESSION['xabar'] = "org_yaratildi";
						header("Location: /sharqoan/organizations.php");
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
