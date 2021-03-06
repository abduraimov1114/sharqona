
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		<?php if (isset($_GET['category_id'])) {
			$kelgan_service_id = $_GET['category_id'];
			$kelgan_service_id = mysqli_real_escape_string($connection, $kelgan_service_id);
		} 
		 $servicni_topish = "SELECT * FROM product_category WHERE pcat_id = '$kelgan_service_id'";
		 $service_tanlov = mysqli_query($connection, $servicni_topish);

		 if (!$service_tanlov) {
		 	die("Bunday IDli kategoriyani qidirishda xatolik");
		 }

		 else {
		 	$count = mysqli_num_rows($service_tanlov);
		 }

		 if ($count == 1) {
		 	while ($row = mysqli_fetch_assoc($service_tanlov)) {
		 		$kategoriya_id = $row["pcat_id"];
		 		$kategoriya_name = $row['pcat_name'];
		 		$nowmothercat = $row['mother_category'];
		 	}
		 }
		 else {
		 	header("Location: /sharqona/categories.php");
		 	$_SESSION['xabar'] = "xato";
		 }


		?>

		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate">
						<ol class="breadcrumb">
							<li><a href="#">Kategoriyalar</a></li>
							<li><a href="#">Kategoriyani o'zgartirish</a></li>
						</ol>
						<br />
						
						<div class="form-group">
								<div class="col-sm-6">
								<div class="label label-info">Родительская категория</div>
								<select name="mother_category_idsi" class="select2" data-allow-clear="true" data-validate="required">
									<?php 
										$query = "SELECT * FROM mother_categories";
										$mothcatquery = mysqli_query($connection, $query);

										if (!$mothcatquery) {
											die ("Something went wrong!");
										}

										while ($row = mysqli_fetch_assoc($mothcatquery)) {
											$mother_cat_id = $row['mother_cat_id'];
											$mother_cat_name = $row['mother_cat_name'];
											if ($mother_cat_id == $nowmothercat) {
												$selected = "selected";
											}
											else {
												$selected = "";
											}
										 ?>
										<option <?php echo $selected; ?> value="<?php echo $mother_cat_id; ?>"><?php echo "$mother_cat_name"; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-6">
								    <div class="label label-info">Подкатегория</div>
									<div class="input-group">
										<input type="text" class="form-control input-lg" name="categoriya" data-validate="required"
										data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi."
										value="<?php echo $kategoriya_name; ?>">
										
										<span class="input-group-btn">
											<button class="btn btn-success btn-lg" type="submit" name="edit_category" data-loading-text="Iltimos kuting...">Saqlash!</button>
										</span>
									</div>
								</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
		
		<?php 

			if (isset($_POST['edit_category'])) {

				if (empty($_POST['categoriya'])) {
					$_SESSION['xabar'] = "xato";
					header("Location: /sharqona/categories.php?source=add_category");
				}

				else {

					$edited_name_category = $_POST['categoriya'];
					$mother = $_POST['mother_category_idsi'];
					
					$edited_name_category = mysqli_real_escape_string($connection, $edited_name_category);

					$service_tayorgarlik = "UPDATE product_category SET pcat_name = '$edited_name_category', mother_category = '$mother' WHERE pcat_id = '$kategoriya_id'";
					$service_save = mysqli_query($connection, $service_tayorgarlik);

					if (!$service_save) {
						die("Kategoriyani bazada saqlashda xatolik yuz berdi");
					}
					else {
						$_SESSION['xabar'] = "service_yaratildi";
						header("Location: /sharqona/categories.php");
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
