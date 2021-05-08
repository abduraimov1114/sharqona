<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php 
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
	}

	if (isset($_POST['backoff'])) {
		// Dannilani qabul qilib olamiz
		$mahsulot = $_POST['mahsulot'];
		$company_id = $_POST['companyid'];
		$product_back_prize = $_POST['product_back_prize'];
		$product_back_quantity = $_POST['product_back_quant'];
		$product_back_max = $_POST['maximum'];
		$invoice = $_POST['invoice'];
		$date = $_POST['date'];
		$umumiy_tovar_id = $_POST['tovarumumid'];

		if ($product_back_quantity > $product_back_max) {
			$_SESSION['xabar'] = "backmax";
			header("Location: /compass/invoice_list.php?invoice=$company_id");
		}

		if (isset($_POST['xizmatdagimaxsulot'])) {
		$xizmatga_ketadigan_mahsulot_id = $_POST['xizmatdagimaxsulot'];
		}

		if (isset($_POST['maxsulotid'])) {
		$maxsulot_id = $_POST['maxsulotid'];
		}

		if ($mahsulot == "mahsulot") {
				// echo "Bu maxsulot va maxsulotni sonini qaytaramiz skladga <br>";
				$ready = "SELECT product_count FROM products WHERE product_id = '$maxsulot_id'";
				$ready_query = mysqli_query($connection, $ready);
				if (!$ready_query) {
					die("Zaprosda xatolik");
				}
				else {
					$ready_query_result = mysqli_fetch_array($ready_query);
					$maxsulot_xolati = $ready_query_result['product_count'];
					$maxsulot_new_xolati = $maxsulot_xolati + $product_back_quantity;
					$ready_upd = "UPDATE products SET product_count = '$maxsulot_new_xolati' WHERE product_id = '$maxsulot_id'";
					$update_product = mysqli_query($connection, $ready_upd);
					if (!$update_product) {
						die("Rasvo Kardem");
					}
					else {
						$_SESSION['proback'] = "Sotilgan maxsulot omborga qaytarildi";
					}
					// maxsulot qaytdi skladga
					// Ordered productsdan qaytgan maxsulot sonini kamaytiramiz
					$update_ordered_ready = "SELECT own_id, product_quantity FROM ordered_products WHERE orders_id = '$invoice' AND products_id = '$maxsulot_id' AND is_product = 1";
					$update_ordered_ready_query = mysqli_query($connection, $update_ordered_ready);
					if (!$update_ordered_ready_query) {
						die("Rasvo Kardem");
					}
					else {
						$info = mysqli_fetch_array($update_ordered_ready_query);
						$ownid = $info['own_id'];
						$quant = $info['product_quantity'];
						$new_quant = $quant - $product_back_quantity;
						$quant_ready = "UPDATE ordered_products SET product_quantity = '$new_quant' WHERE orders_id = '$invoice' AND products_id = '$maxsulot_id' AND is_product = 1";
						$prod_quantity_update = mysqli_query($connection, $quant_ready);
					}
					// Ordered productsdan qaytgan maxsulot sonini kamaytirdik
					// Orders tablitsadan qaytgan maxsulot narxini kamaytiramiz
					$update_order_price_ready = "SELECT total_amount FROM orders WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
					$update_ordered_price_query = mysqli_query($connection, $update_order_price_ready);
					if (!$update_ordered_price_query) {
						die("Rasvo Kardem");
					}
					else {
						$infoprice = mysqli_fetch_array($update_ordered_price_query);
						$old_price = $infoprice['total_amount'];
						
						$new_price = $old_price - $product_back_prize;
						$price_ready = "UPDATE orders SET total_amount = '$new_price' WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
						$order_price_update = mysqli_query($connection, $price_ready);
					}
					// Orders tablitsadan qaytgan maxsulot narxini kamaytirdik
					// Agar sotilgan maxsulot soni 0 ga tenglashsa uni ordered_products tablitsadan ochiramiz
					if ($new_quant == 0) {
						$delete_ordered_ready = "DELETE FROM ordered_products WHERE own_id = '$ownid' AND orders_id = '$invoice' AND products_id = '$maxsulot_id'";
						$delete_ordered = mysqli_query($connection, $delete_ordered_ready);
						if (!$delete_ordered) {
							die("Ordered productsni ochirishda xatolik");
						}
					}
					// Ordered_products tablitsadan kerakli row o'chdi
					// Agar sotilgan maxsulot umumiy narxi nolga tenglashsa uni orders tablitsadan o'chiramiz
					if ($new_price == 0 AND $old_price == $product_back_prize) {
						$delete_order_ready = "DELETE FROM orders WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
						$delete_order= mysqli_query($connection, $delete_order_ready);
						if (!$delete_order) {
							die("Orderni ochirishda xatolik");
						}
					}
					// Orders tablitsa o'chirildi
				}

			if ($company_id !== '10') {
			// Bu maxsulot tashkilotga sotilgan
			// Qaytarilgan maxsulot summasini tashkilot byudjetiga qoshamiz
				$company_choose_ready = "SELECT buyers_budget FROM buyers WHERE buyers_id = '$company_id'";
				$company_choose = mysqli_query($connection, $company_choose_ready);
				if (!$company_choose OR empty($company_choose)) {
					die("Tashkilotni bazadan topib olishda xatolik");
				}
				else {
					$company_old_budget = mysqli_fetch_array($company_choose);
					$old_budget = $company_old_budget['buyers_budget'];
					$new_budget = $old_budget + $product_back_prize;
					$update_company_budget_ready = "UPDATE buyers SET buyers_budget = '$new_budget' WHERE buyers_id = '$company_id'";
					$update_budget = mysqli_query($connection, $update_company_budget_ready);
					if (!$update_budget) {
						die("Byudjetni balansga qayratishda xatolik");
					}
					else {
						$_SESSION['newbudget'] = "Qaytarilgan maxsulot summasi tashkilot balansiga qaytarildi";
					}
				}
			}
			else {
				// Ko'chaga sotilgan maxsulot summani bizni byudjetimizdan ayirish mumkin bu yerda
			}
		}


		elseif ($mahsulot == "xizmat") {
			if ($xizmatga_ketadigan_mahsulot_id !== '0') {
				// Bu xomashyo talab qiladigan xizmat va maxsulotni sonini qaytaramiz skladga
					$ready = "SELECT product_count FROM products WHERE product_id = '$xizmatga_ketadigan_mahsulot_id'";
					$ready_query = mysqli_query($connection, $ready);
					if (!$ready_query) {
						die("Zaprosda xatolik");
					}
					else {
						$ready_query_result = mysqli_fetch_array($ready_query);
						$maxsulot_xolati = $ready_query_result['product_count'];
						$maxsulot_new_xolati = $maxsulot_xolati + $product_back_quantity;
						$ready_upd = "UPDATE products SET product_count = '$maxsulot_new_xolati' WHERE product_id = '$xizmatga_ketadigan_mahsulot_id'";
						$update_product = mysqli_query($connection, $ready_upd);
						if (!$update_product) {
							die("Rasvo Kardem");
						}
						else {
							$_SESSION['proback'] = "Xizmatga sarflangan maxsulot omborga qaytarildi";
						}
					}

				// Bu xomashyo talab qiladigan xizmat va maxsulotni sonini qaytaramiz skladga
			}
			else {
				// Xom ashyo talab qimaydi tovar xech qera uzgarmaydi
			}
				// Maxsulotni ordered pruductsdan ochiramiz

					$update_ordered_ready = "SELECT own_id, product_quantity FROM ordered_products WHERE orders_id = '$invoice' AND products_id = '$umumiy_tovar_id' AND is_product = 0";
					$update_ordered_ready_query = mysqli_query($connection, $update_ordered_ready);
					if (!$update_ordered_ready_query) {
						die("Rasvo Kardem");
					}
					else {
						$info = mysqli_fetch_array($update_ordered_ready_query);
						$ownid = $info['own_id'];
						$quant = $info['product_quantity'];
						$new_quant = $quant - $product_back_quantity;
						$quant_ready = "UPDATE ordered_products SET product_quantity = '$new_quant' WHERE orders_id = '$invoice' AND products_id = '$umumiy_tovar_id' AND is_product = 0";
						$prod_quantity_update = mysqli_query($connection, $quant_ready);
						if (!$prod_quantity_update) {
							die("Xizmat sonini tablitsandan kamaytirishda xatolik");
						}
					}

				// Maxsulotni ordered pruductsdan ochiramiz

				// Xizmat narxini orders tabledan kamaytiramiz

					$update_order_price_ready = "SELECT total_amount FROM orders WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
					$update_ordered_price_query = mysqli_query($connection, $update_order_price_ready);
					if (!$update_ordered_price_query) {
						die("Rasvo Kardem");
					}
					else {
						$infoprice = mysqli_fetch_array($update_ordered_price_query);
						$old_price = $infoprice['total_amount'];
						
						$new_price = $old_price - $product_back_prize;
						$price_ready = "UPDATE orders SET total_amount = '$new_price' WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
						$order_price_update = mysqli_query($connection, $price_ready);
						if (!$order_price_update) {
							die("Xatolik");
						}
					}

				// Xizmat narxi orders tabledan kamaydi

				// Agar sotilgan maxsulot soni 0 ga tenglashsa uni ordered_products tablitsadan ochiramiz
				if ($new_quant == 0) {
					$delete_ordered_ready = "DELETE FROM ordered_products WHERE own_id = '$ownid' AND orders_id = '$invoice' AND products_id = '$umumiy_tovar_id'";
					$delete_ordered = mysqli_query($connection, $delete_ordered_ready);
					if (!$delete_ordered) {
						die("Ordered productsni ochirishda xatolik");
					}
				}
				// Ordered_products tablitsadan kerakli row o'chdi

				// Agar sotilgan maxsulot umumiy narxi nolga tenglashsa uni orders tablitsadan o'chiramiz
				if ($new_price == 0 AND $old_price == $product_back_prize) {
					$delete_order_ready = "DELETE FROM orders WHERE order_id = '$invoice' AND customer_id = '$company_id' AND order_date = '$date'";
					$delete_order= mysqli_query($connection, $delete_order_ready);
					if (!$delete_order) {
						die("Orderni ochirishda xatolik");
					}
				}
				// Orders tablitsa o'chirildi


			if ($company_id !== '10') {
				// Bu xizmat tashkilotga sotilgan
				// Qaytarilgan maxsulot summasini tashkilot byudjetiga qoshamiz
				$company_choose_ready = "SELECT buyers_budget FROM buyers WHERE buyers_id = '$company_id'";
				$company_choose = mysqli_query($connection, $company_choose_ready);
				if (!$company_choose OR empty($company_choose)) {
					die("Tashkilotni bazadan topib olishda xatolik");
				}
				else {
					$company_old_budget = mysqli_fetch_array($company_choose);
					$old_budget = $company_old_budget['buyers_budget'];
					$new_budget = $old_budget + $product_back_prize;
					$update_company_budget_ready = "UPDATE buyers SET buyers_budget = '$new_budget' WHERE buyers_id = '$company_id'";
					$update_budget = mysqli_query($connection, $update_company_budget_ready);
					if (!$update_budget) {
						die("Xatolik boldi");
					}
					else {
						$_SESSION['newbudget'] = "Qaytarilgan xizmat summasi tashkilot balansiga qaytarildi";
					}
				}
				// Qaytarilgan maxsulot summasini tashkilot byudjetiga qoshamiz
			}
			else {
				// Ko'chaga sotilgan maxsulot summani bizni byudjetimizdan ayirish mumkin bu yerda
			}
		}
		$_SESSION['xabar'] = "success";
		header("Location: /compass/invoice_list.php?invoice=$company_id");
	}
	else {
		$_SESSION['xabar'] = "xato";
		header("Location: /compass/organizations.php");
	}
?>