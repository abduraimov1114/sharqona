<?php 
	include_once('db.php');
	include_once('dollar.php');
	error_reporting(E_ALL);
	//SELECT SUM(`total_amount`) AS Total FROM `orders` WHERE `order_date` BETWEEN '2019-12-31 00:00:00' AND '2020-03-01 00:00:00'
	$query = "SELECT * FROM `orders` WHERE `order_date` BETWEEN '2019-12-31' AND '2020-02-01'";
	$query_go = mysqli_query($connection, $query);
	if (!$query_go) {
		die('Connection error');
	}
	else {
		$count_order = mysqli_num_rows($query_go);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>Stat</title>
</head>
<body>
	<div class="tablecha">
		<?php 
			$maxsulot = 0;
			$xizmat = 0;
			$toza_xizmat = 0;
			$total = 0;
			$promatrix = 0;
			$sermatrix = 0;
			while ($row = mysqli_fetch_assoc($query_go)) {
				$order_id = $row['order_id'];
				$customer_id = $row['customer_id'];
				$order_date = $row['order_date'];
				$total_amount = $row['total_amount'];
				$total += $total_amount;
				$query2 = "SELECT * FROM ordered_products WHERE orders_id = '$order_id'";
				$query2_go = mysqli_query($connection, $query2);

				while ($row2 = mysqli_fetch_assoc($query2_go)) {
					$is_product = $row2['is_product'];
					$products_id = $row2['products_id'];
					$product_quantity = $row2['product_quantity'];
					$product_price = $row2['product_price'];

					if ($products_id == 383 AND $is_product == 1) {
						$promatrix += $product_price * $product_quantity;
					}

					if ($products_id == 110 AND $is_product == 0) {
						$sermatrix += $product_price * $product_quantity;
					}

					if ($is_product == 1) {
						$query3 = "SELECT product_name, product_prise_in FROM products WHERE product_id = '$products_id'";
						$query3_go = mysqli_query($connection, $query3);
						while ($row3 = mysqli_fetch_assoc($query3_go)) {
							$product_name = $row3['product_name'];
							$product_prise_in = $row3['product_prise_in'];
							$selectos_own_price = "SELECT incoma_id, product_in_price FROM incoma_details WHERE product_in_id = $products_id";
							$selectos_own_price_query = mysqli_query($connection, $selectos_own_price);
							while ($row = mysqli_fetch_assoc($selectos_own_price_query)) {
								echo "<pre>";
								var_dump($selectos_own_price_query);
								echo "</pre>";
							}
							die();
							$maxsulot += $product_quantity * $product_price;
							$jami_olingan_narx += $product_prise_in * $product_quantity;
							$jami_sotilgan_narx += $product_price * $product_quantity; 
						}
					}
					elseif ($is_product == 0) {
						$xizmat += $product_quantity * $product_price;
						$eatproduct_and_product = Iseatproduct($products_id);
						$iseatproduct = $eatproduct_and_product['0'];
						$eatproduct = $eatproduct_and_product['1'];
						if ($iseatproduct == true AND $eatproduct > 0) {
							$query4 = "SELECT product_name, product_prise_in FROM products WHERE product_id = '$eatproduct'";
							$query4_go = mysqli_query($connection, $query4);
							while ($row4 = mysqli_fetch_assoc($query4_go)) {
								$eat_product_name = $row4['product_name'];
								$eat_product_prise_in = $row4['product_prise_in'];
								$jami_olingan_narx_xizmat += ($eat_product_prise_in * $product_quantity) * $sum;
								$jami_sotilgan_narx_xizmat += $product_price * $product_quantity;
							}
						}
						else {
							$xama_xizmat += $product_quantity * $product_price;
							if ($products_id != 110) {
								$toza_xizmat += $product_quantity * $product_price;
							}
						}
					}
				}

			}
		?>
		<div> Yanvar - Fevral oylarida bolgan jami savdo: <strong><?=number_format($total)?></strong></div>
		<div> Yanvar - Fevral oylarida sotilgan jami maxsulotlar summasi: <strong><?=number_format($maxsulot)?></strong></div>
		<div> Yanvar - Fevral oylarida qilingan jami xizmatlar summasi: <strong><?=number_format($xizmat)?></strong></div>
		<hr><br>
		<h3>MAXSULOTLARDAN FOYDA:</h3>
		<div> Sotilgan maxsulotlarni olishdagi xarajat Sum da <strong><?=number_format($jami_olingan_narx * $sum)?> Sum</strong></div>
		<div> Jami sotilgan narx: <strong><?=number_format($jami_sotilgan_narx)?> Sum</strong> - Jami olishdagi xarajat sumda <strong><?=number_format($jami_olingan_narx * $sum)?> </strong> = Foyda <strong><?=number_format(($jami_sotilgan_narx) - ($jami_olingan_narx * $sum))?></strong> </div>
		<hr><br>
		<h3>XIZMATLARDAN FOYDA (MAXSULOT SARFLANSA):</h3>
		<div> Yanvar - Fevral oylarida bolgan (Maxsulot sarflanadigan) xizmatlar summasi: <strong><?=number_format($jami_sotilgan_narx_xizmat)?> Sum</strong></div>
		<div> Qilingan xizmatlarni maxsulotlarini olishdagi xarajat sumda: <strong><?=number_format($jami_olingan_narx_xizmat)?> Sum</strong></div>
		<div> Foyda: <strong><?php echo number_format($jami_sotilgan_narx_xizmat - $jami_olingan_narx_xizmat) ?> Sum</strong></div>
		<hr><br>
		<h3>XIZMATLARDAN FOYDA (MAXSULOT SARFLANMASA)</h3>
		<div> Yanvar - Fevral oylarida bolgan (Maxsulot yemaydigan) xizmatlar summasi : <strong><?=number_format($xama_xizmat)?></strong> 
			Shundan - <strong><?=number_format($sermatrix)?></strong> Matrix
		</div>
		<div>Foyda: <strong><?php echo number_format($toza_xizmat); ?> Sum</strong></div>
	</div>
</body>
</html>


<?php 
	function Iseatproduct($service_id) {
		GLOBAL $connection;
		$finding_service_query = "SELECT service_pro_id FROM services WHERE service_id = '$service_id'";
		$finding_service = mysqli_query($connection, $finding_service_query);
		if (!$finding_service) {
			die("Tanlangan xizmatni bazadan topib olishda xatolik!");
		}
		else {
			$rowcount = mysqli_num_rows($finding_service);
			if ($rowcount == 1) {
				$tempresult = mysqli_fetch_array($finding_service);
				$eating_product = $tempresult['service_pro_id'];
				if ($eating_product > 0) {
					return [true, $eating_product];
				}
				elseif ($eating_product == 0) {
					return false;
				}
				elseif ($eating_product < 0) {
					die('Xizmat istemol qiladigan maxsulot noaniq');
				}
			}
			else {
				die('Bunday hizmat turi bazadan topilmadi!');
			}
		}
	}
?>