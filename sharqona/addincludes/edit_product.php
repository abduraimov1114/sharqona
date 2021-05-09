
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<script src="/ckeditor/ckeditor.js"></script>

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

		<?php 
				if (isset($_GET['product_id'])) {
					$tanlangan_id_tovar = $_GET['product_id'];
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
							$choosed_pro_category = $row['product_category_id'];
							$choosed_pro_dangerous = $row['product_danger'];
							$choosed_pro_sell_price = $row['product_prise_out'];
							$pro_image = $row['product_img'];
							$descreption = $row['product_desc'];
							$kirim_narx = $row['product_prise_in'];
							$barcode = $row['product_barcode'];
							$guaranty = $row['product_guarantee'];
							$guaranty_length = $row['guarantee_length'];
						}
					}
				}

				else {
					$_SESSION['xabar'] = "xato";
					header("Location: /sharqona/products.php");
				}
		 ?>
		<fieldset>
			<legend><strong>Mahsulotni o'zgartirish</strong></legend>
		<div class="row">
			<div class="col-md-12">
					<div class="panel-body">
						<form role="form" method="post" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" novalidate="novalidate" onkeypress="return event.keyCode != 13;">
							
							<br />
							
							<div class="form-group">
								<!-- Show image -->
								<div class="text-center">
									<?php 
										if (!empty($pro_image)) {
										?>
										<div class="col-md-12 text-center">
											<img src="../images/<?php echo $pro_image; ?>" width="300" class='img-thumbnail' style='margin: 15px 0;'><br>
										</div>
										<?php }
										else {
											?>
										<div class="col-md-12 text-center">
											<img src="/images/noimage.jpg" width="300" class='img-thumbnail' style='margin: 15px 0;'><br>
										</div>	
										<?php }

									 ?>
								</div>
								<!-- Show image -->

								<div class="col-sm-5">
									<div class="label label-primary">Mahsulot ismi</div>
									<input type="text" class="form-control input-lg" name="name" data-validate="required" 
									data-message-required="Ushbu forma bo'sh qolishi ruxsat etilmaydi."
									value="<?php echo $choosed_pro_name ?>">
								</div>

								<div class="col-sm-4">
									<div class="label label-info">Kategoriyasi</div>
									<select name="category_idsi" class="select2" data-allow-clear="true" data-validate="required">
										<?php 
											$query = "SELECT * FROM product_category";
											$catquery = mysqli_query($connection, $query);

											if (!$catquery) {
												die ("Something went wrong!");
											}

											while ($row = mysqli_fetch_assoc($catquery)) {
												$pcat_id = $row['pcat_id'];
												$pcat_name = $row['pcat_name'];
												if ($pcat_id == $choosed_pro_category) {
													$selected = "selected";
												}
												else {
													$selected = "";
												}
											 ?>
											<option <?php echo $selected; ?> value="<?php echo $pcat_id; ?>"><?php echo "$pcat_name"; ?></option>
										<?php } ?>
									</select>
									
								</div>
								

								<div class="col-sm-3">
									<div class="label label-danger">Danger</div>
									<div class="input-spinner">
										<button type="button" class="btn btn-info btn-lg">-</button>
										<input type="text" name="number" class="form-control size-1 input-lg" value="<?php echo $choosed_pro_dangerous ?>" data-validate="number" aria-invalid="false" aria-describedby="number-error">
										<button type="button" class="btn btn-info btn-lg">+</button>
									</div>
								</div>
								<div class="clear"></div>
								<br>
								<div class="col-sm-3">
    							        <?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?><div class="label label-success">Kelish narxi</div><?php endif ?>
    									<input 
    									<?php if ($_SESSION['ses_user_role'] == 'Admin'): ?>
    									class="hidden"
    									<?php endif ?>
    									type="number" min="0" step="any" name="in_price" class="form-control input-lg pr-price item-price" value="<?php echo $kirim_narx ?>" placeholder="Kirim narxi" data-validate="required">
								</div>
								<div class="col-sm-3">
    							        <div class="label label-success">Sotish narxi</div>
    									<input type="number" min="0" step="any" name="sell_price" class="form-control input-lg pr-price item-price" value="<?php echo $choosed_pro_sell_price ?>" placeholder="Sotish narxi" data-validate="required">
								</div>
								<div class="col-sm-3">
									<div class="label label-danger">Garantiya birligi</div>
									<?php 
										if (empty($guaranty)) {
											$guaranty = 0;
											$guaranty_length = 0;
										}
									 ?>
									<input type="number" step="1" min="0" value="<?php echo $guaranty; ?>" class="form-control size-1 input-lg" name="garanty">
								</div>
								<div class="col-sm-3">
									<input type="text" id="dbinf" hidden value="<?php echo $guaranty_length ?>">
									<div class="label label-danger">Garantiya muddati</div>
									<select name="garanty_length" id="select" class="form-control input-lg">
										<option value="0">Tanlang..</option>
										<option value="kun">Kun</option>
										<option value="oy">Oy</option>
										<option value="yil">Yil</option>
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
								<div class="clear"></div><br>
								<div class="col-sm-12">
									<div class="input-group" style="margin-top: 20px;">
										<!-- real barcode area -->
										<input placeholder="Scan barcode or generate!" type="text" class="form-control input-lg" name="barcode" id="barcode" autocomplete="off" required value="<?php echo $barcode; ?>">
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
								</div>
							</div>

							<!-- Image Select -->
							<div class="form-group">
								
								<div class="col-sm-5">
									
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" data-trigger="fileinput">
											<img src="https://placehold.it/512x512" alt="...">
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 512px; max-height: 512px"></div>
										<div>
											<span class="btn btn-white btn-file">
												<span class="fileinput-new">Rasm tanlash</span>
												<span class="fileinput-exists">O'zgartirish</span>
												<input type="file" name="image" accept="image/*">
											</span>
											<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Olib tashlash</a>
										</div>
									</div>
									
									
								</div>
							</div>
							<!-- Image Select -->
							
							<!-- CK Editor-->
							<div class="form-group">
								<div class="col-md-12">
									<textarea name="post_content">
										<?php 
											if (!empty($descreption)) {
												echo $descreption;
											}
										 ?>
									</textarea>
								</div>
							</div>
							<!-- CK Editor -->
							
							<div class="form-group">
								<button type="submit" name="edit_product" data-loading-text="Iltimos kuting..." class="btn btn-success">Saqlash</button>
								<button type="reset" class="btn" onclick="Enabler()">Tozalash</button>
							</div>
						</form>	
						
					</div>
			</div>
		</div>
		</fieldset>
		<?php 

		if (isset($_POST['edit_product'])) {

			if (empty($_POST['name']) OR empty($_POST['category_idsi']) OR empty($_POST['number']) OR $_POST['number'] < 0 ) {
				$_SESSION['xabar'] = "xato";
				header("Location: /sharqona/products.php?source=add_product");
			}
			else {
			$product_title = $_POST['name'];
			$product_category = $_POST['category_idsi'];
			$product_danger = $_POST['number'];
			$new_sell_prize = $_POST['sell_price'];
			$in_prize = $_POST['in_price'];
			$post_content = $_POST['post_content'];

			$post_image = $_FILES['image']['name'];
			$post_image_temp = $_FILES['image']['tmp_name'];
			move_uploaded_file($post_image_temp, "../images/$post_image");

			if (empty($post_image)) {
				$query = "SELECT * FROM products WHERE product_id = '$tanlangan_id_tovar'";
				$select_image = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array($select_image)) {
					$post_image = $row['product_img'];
				}
			}
			$newbarcode = $_POST['barcode'];
			$product_garanty = $_POST['garanty'];
			if ($product_garanty > 0) {

				$garanty_length = $_POST['garanty_length'];

			}

			else {
				$product_garanty = 0;
				$garanty_length = 0;
			}

			$newbarcode = mysqli_real_escape_string($connection, $newbarcode);
			$product_garanty = mysqli_real_escape_string($connection, $product_garanty);
			$garanty_length = mysqli_real_escape_string($connection, $garanty_length);
			$product_title = mysqli_real_escape_string ($connection, $product_title);
			$product_category = mysqli_real_escape_string ($connection, $product_category);
			$product_danger = mysqli_real_escape_string ($connection, $product_danger);
			$new_sell_prize = mysqli_real_escape_string ($connection, $new_sell_prize);
			$in_prize = mysqli_real_escape_string ($connection, $in_prize);
			$post_content = mysqli_real_escape_string ($connection, $post_content);

			$queryprd = "UPDATE products SET product_barcode = '$newbarcode', guarantee_length = '$garanty_length', product_guarantee = '$product_garanty', product_name = '$product_title', product_category_id = '$product_category', product_danger = '$product_danger', product_prise_out = '$new_sell_prize', product_desc = '$post_content', product_prise_in = '$in_prize', product_img = '$post_image' WHERE product_id = '$choosed_pro_id'";
			$edit_the_product = mysqli_query($connection, $queryprd);
			
			if (!$edit_the_product) {
				die("Malumotni bazada saqlashda xatolik yuz berdi");
			}

			else {
				$_SESSION['xabar'] = "success";
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
	<link rel="stylesheet" href="assets/js/dropzone/dropzone.css">
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">



	<!-- Imported scripts on this page -->
	<script src="assets/js/fileinput.js"></script>
	<script src="assets/js/dropzone/dropzone.js"></script>
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
	<script>CKEDITOR.replace('post_content');</script>
