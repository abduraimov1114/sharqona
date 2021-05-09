
<head>

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

		
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate">
						<strong>Yangi kategoriya qo'shish</strong>
						<br />
						
						<div class="form-group">
							
								<div class="col-sm-6">
									<div class="label label-primary">Подкатегория</div>
									<input type="text" class="form-control input-lg" name="categoriya_ism" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi.">
								</div>
								
								<div class="col-sm-6">
									<div class="label label-primary">Родительская категория</div>
									<select class="form-control input-lg" name="mother_category_idsi" required>
									<?php 
										$query = "SELECT * FROM mother_categories";
										$mothcatquery = mysqli_query($connection, $query);

										if (!$mothcatquery) {
											die ("Something went wrong!");
										}

										while ($row = mysqli_fetch_assoc($mothcatquery)) {
											$mother_cat_id = $row['mother_cat_id'];
											$mother_cat_name = $row['mother_cat_name'];
										 ?>
										<option value="<?php echo $mother_cat_id; ?>"><?php echo "$mother_cat_name"; ?></option>
									<?php } ?>
								</select>
								</div>

						</div>

						<div class="form-group">
							<button type="submit" name="create_category" data-loading-text="Iltimos kuting..." class="btn btn-success">Yaratish</button>
							<button type="reset" class="btn">Tozalash</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
		
		<?php 

			if (isset($_POST['create_category'])) {

				if (empty($_POST['categoriya_ism'])) {
					$_SESSION['xabar'] = "xato";
					header("Location: /sharqona/categories.php?source=add_category");
				}

				else {

					$category_title = $_POST['categoriya_ism'];
					$mother_cat = $_POST['mother_category_idsi'];
					
					$category_title = mysqli_real_escape_string($connection, $category_title);

					$service_tayorgarlik = "INSERT INTO product_category (pcat_name, mother_category) VALUES ('$category_title', '$mother_cat')";
					$service_save = mysqli_query($connection, $service_tayorgarlik);

					if (!$service_save) {
						die("Kategoriyani bazada saqlashda xatolik yuz berdi");
					}
					else {
						$_SESSION['xabar'] = "service_yaratildi";
						header("Location: /compass/categories.php");
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
