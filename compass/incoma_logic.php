<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php 

  	if (isset($_POST['confirm_incoming'])) {
  		$number_rows_product = count($_POST['product']);
  		$vendor = $_POST['vendor'];
		$totalammount = $_POST['total'];

  		// Checking for date or create it
  		if (!empty($_POST['date'])) {
  			$date = $_POST['date'];
  		}
  		else {
  			$date = date("Y-m-d");
  		}
 
  		// Checking products and services for choosed or not
  		if ($number_rows_product <= 0) {
  			die("Xizmat va Maxsulotlardan xech narsa tanlanmadi");
  		}

  		// CHecking for product inputs
  		if ($number_rows_product > 0) {
  			$products = $_POST['product'];
  			if (isset($products) AND !empty($products)) {
  				foreach ($products as $product) {
  					$our_pro_id = $product['name'];
  					$our_pro_quant = $product['quantity'];
  					$our_pro_in_price = $product['inprice'];
  					$our_pro_out_price = $product['outprice'];
  					if (
  						empty($our_pro_id) OR 
  						empty($our_pro_quant) OR 
  						$our_pro_in_price <= 0 OR 
  						$our_pro_out_price <= 0 OR 
  						empty($our_pro_in_price) OR 
  						empty($our_pro_out_price)
  						) 
  					{
  						die("Maxsulotlardan biri tanlanmay qolib ketgan, yoki qayerdadir narxlar kiritilmadi");
  					}
  				}
  			}
  		}
  		// CHecking for product inputs

  		// Incoma table.ga incoming qiladi 
      $autodate = date('Y-m-d H:i:s');
  		$incomainsert = "INSERT INTO incoma(incoma_date, incoma_vendor, incoma_ammount, this_day_dollar, auto_date) VALUES ('$date', '$vendor', '$totalammount', '$sum', '$autodate')";
  		$inquery = mysqli_query($connection, $incomainsert);
  		if (!$inquery) {
  			die("Incoma yaratishda xatolik");
  		}
  		else {
  			$last_incoma_id = mysqli_insert_id($connection);
  		}
  		
		foreach ($products as $productone) {
			$pro_in_id = $productone['name'];
			$pro_in_quant = $productone['quantity'];
			$pro_in_price = $productone['inprice'];
			$pro_out_price = $productone['outprice'];
			// Incomadan IDni olib incoma details.ga xama maxsulotni kiritadi 
			$incomadtls = "INSERT INTO incoma_details(incoma_id, product_in_id, product_in_quantity, product_in_price) VALUES ('$last_incoma_id', '$pro_in_id', '$pro_in_quant', '$pro_in_price')";
			$incomadtls_query = mysqli_query($connection, $incomadtls);
			// Maxsulotni bazadan tanlab oladi, sonini va narxini yangilaydi
			$selectos_product = "SELECT product_id, product_count FROM products WHERE product_id = $pro_in_id";
			$selquery = mysqli_query($connection, $selectos_product);
			if (!$selquery) {
				die('Productni bazadan tanlashda xatolik');
			}
			while ($row = mysqli_fetch_assoc($selquery)) {
				$choosed_id = $row['product_id'];
				$choosed_count = $row['product_count'];

				$new_count = $choosed_count + $pro_in_quant;
				$update = "UPDATE products SET product_count = '$new_count', product_prise_in = '$pro_in_price', product_prise_out = '$pro_out_price' WHERE product_id = '$choosed_id'";
				$update_query = mysqli_query($connection, $update);
				if (!$update_query) {
					die("Narx va qoldiqlarni yangilashda xatolik");
				}
				else {
					$_SESSION['xabar'] = "success";
					header("Location: incoma.php");
				}
			}
		}
  	}

   ?>