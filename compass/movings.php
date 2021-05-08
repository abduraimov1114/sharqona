<?php require_once 'movingstart.php'; ?>
<!-- Shu yerdan asosiy conternt -->
<form role="form" method="post" onkeypress="return event.keyCode != 13;" action="movings_logic.php" class="form-horizontal form-groups-bordered order">
	<input type="hidden" value="moving" id="type_comming" class="code form-control"/>
	<ol class="breadcrumb hidden-print">
		<li><a href="#">Mahsulotlar</a></li>
		<li><a href="#">Ko'chiruvi</a></li>
	</ol>
	<br>
	<div class="row hidden-print">
	    <div class="clearfix"></div>
	    <div class="col-sm-6">
			<div class="label label-danger">Ko'chiruv manzili</div>
			<select name="to_storage" id="select" class="form-control input-lg" required>
				<option value="">Omborni tanlang..</option>
				<option value="3">Elektro ishlab chiqaruv ombori</option>
				<option value="1">Ishlab chqaruv ombori</option>
			</select>
		</div>
	</div><br>
	<div class="row hidden-print">
	    <div class="clearfix"></div>
	    <div class="col-md-12">
	      <div class="label label-primary">Ko'chiruv eslatmasi</div>
	      <textarea rows="5" class="form-control" id="field-ta" type="text" name="moving_desc" placeholder="Eslatma.."></textarea>
	    </div>
	</div><br>

	<!-- Start Services Rows -->
	
	<!-- Start Products Rows -->
	<fieldset for="products" id="products" class="productsfield">
		<legend class="hidden-print productlegend" onclick="Xcode(2)">Mahsulotlar</legend>
		<div class="table-responsive">
			<!--      autofocus-->
			<input placeholder="Scan barcode here..." type="text" onkeypress="autoCode(value)" value="" style="margin: 0 0 5px 0;display: none;" id="code" class="code form-control" autocomplete="off">
			<table class="table pr-table item-table table-bordered table-striped">
				<thead>
					<tr>
						<th class="col-sm-1">#</th>
						<th class="col-sm-7">Ismi</th>
						<th class="col-sm-3">Soni</th>
						<th class="col-sm-1 hidden-print">-</th>
					</tr>
				</thead>
			<tbody></tbody>
			<tfoot>
			<tr class="hidden-print">
				<td colspan="4">
					<div class="input-group pull-left">
						<a href="#" onclick="return false;" id="pr_add" class="btn btn-info btn-lg btn-icon icon-left">
							Mahsulot qo'shish
						<i class="entypo-plus-squared"></i></a>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
	</div>
	</fieldset><!-- End Products Row -->
	<div class="row">
		<div class="col-md-12">
			<button onClick="deleteqilish(this);return false;" type="submit" id="moving" name="confirm_moving" class="btn btn-primary btn-icon hidden-print">MAHSULOTLARNI KO'CHIRISH<i class="entypo-check"></i></button>
			<a href="index.php" class="btn btn-danger btn-icon">ORQAGA QAYTISH
				<i class="entypo-cancel"></i>
			</a>
		</div>
		<script>
		function deleteqilish(f) {
		if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
		f.submit();
		}
		</script>
	</div>
</form>
<!-- Products Templates -->
<div id="pr_template" style="display: none;">
	<table id="prod_div">
		<tr class="pr-row row-item">
			<td class="pr-row-num"></td>
			<!--      <td>-->
			<input type="hidden" value="" id="ID" class="code form-control"/>
			<input type="hidden" id="org_type" class="code form-control" value="10"/>
			<!--      </td>-->
			<td width="60%">
				<select id="pr_name" name="product[__i__][name]" class="form-control input-md pr-name item-select">
					<option value="">- TANLANG! -</option>
					<?php
					$query = "SELECT * FROM products WHERE product_count > 0";
					$proquery = mysqli_query($connection, $query);
					if (!$proquery) {
					die ("Mahsulot ismini zaprosida xatolik");
					}
					while ($row = mysqli_fetch_assoc($proquery)) {
					$barcode = $row['product_barcode'];
					$maxsulot_id = $row['product_id'];
					$maxsulot_ismi = $row['product_name'];
					$maxsulot_skladdagi_soni = $row['product_count'];
					$maxsulot_sotish_narxi = $row['product_prise_out'];
					$maxsulot_sotish_narxi = $maxsulot_sotish_narxi * $sum;
					$maxsulot_sotish_narxi = round($maxsulot_sotish_narxi, -2);
					?>
					<option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<div class="input-group pr-quantity" style="width: 100%;">
					<input id="pr_quantity" type="number" min="1" name="product[__i__][quantity]" class="form-control input-lg bold pr-quantity item-quantity"  value="1">
				</div>
				<div class="hidden-print"><span class="badge storageinfo1 badge-roundless">Omborda:</span><span id="pr_left" class="badge badge-info badge-roundless storageinfo2 item-left"></span></div>
			</td>
			<td class="pr-remove hidden-print">
				<a href="#" onclick="return false;" id="btn_pr_remove" name="btn_pr_remove" class="btn btn-default btn-lg"><i class="entypo-trash"></i></a>
			</td>
		</tr>
	</table>
</div>
<!-- Services Templates -->
<!-- /Shu yerdan asosiy conternt -->

<!-- Footercha -->
<br />

<footer class="main">
	&copy; 2021 <strong>Sharqona Group</strong> All Rights Reserved
</footer>
</div>
<!-- /Footercha -->
<!-- Scripts -->
	<link rel="stylesheet" href="assets/js/datatables/datatables.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<!-- Imported scripts on this page -->
	<script src="assets/js/datatables/datatables.js"></script>
	<script src="assets/js/neon-chat.js"></script>
<!--	<script src="assets/js/custom.js"></script>-->
	<script src="assets/js/custom6.js"></script>
	<script src="assets/js/select2/select2.min.js"></script>
<!-- Scripts -->
</body>
</html>



