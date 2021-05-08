<?php 
	
	if (isset($_GET['barcode'])) {
		$random = $_GET['barcode'];
	}
?>

<!DOCTYPE html>
	<html lang="ru">
		<head>
			<meta charset="UTF-8">
			<script src="assets/js/JsBarcode.all.min.js"></script>
			<title>Product Barcode</title>
		</head>
		<body>	
				<div id="rasm">
					<center><svg id="barcode"></svg></center>
				</div>
				<script>
					JsBarcode("#barcode", "<?php echo $random; ?>");
				</script>
		</body>
	</html>