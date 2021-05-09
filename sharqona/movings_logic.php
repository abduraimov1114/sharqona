<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>

<?php 
	if (isset($_POST['confirm_moving'])) {
		// var_dump($_REQUEST);
		$products_count = count($_POST['product']);
		if ($products_count == 0 OR $products_count < 0) {
			die("Tanlanmadi xech narsa, keyinroq bu yerda chiroyliroq oshibka chiqoramiz");
		}
		else {
			// echo "Yaxshi tanlandi endi dalshe";
			$move_to_storage = $_POST['to_storage'];
			$moving_desc = $_POST['moving_desc'];
			$move_to_storage = mysqli_real_escape_string($connection, $move_to_storage);
			$moving_desc = mysqli_real_escape_string($connection, $moving_desc);
			if (empty($moving_desc)) {
				$moving_desc = "Eslatma kiritilmagan";
			}
			$products = $_POST['product'];
			
			// Narsalar tuliq tanlanganligiga tekshirib olish
			foreach ($products as $product) {
				$product_id = $product['name'];
				$product_quantity = $product['quantity'];
				if (
					$product_id == NULL OR 
					$product_quantity == NULL OR 
					empty($product_id) OR 
					empty($product_quantity) OR 
					$product_quantity <= 0 OR 
					$product_id <= 0
				) 
				{
					die("Tanlangan maxsulotlardan qaysidir biri tanlanmay qolib ketdi, keyinroq bu yerda chiroyliroq oshibka chiqoramiz");
				}
			}
			// Narsalar tuliq tanlanganligiga tekshirib olish tugatildi


			// Narsalar xammasi tugri tanlanibdi endi programma davom etadi

			// Movings tablitsaga istoriya qoldiradi
			$autodate = date('Y-m-d H:i:s');
			$history_moving = "INSERT INTO moving_products(from_storage, to_storage, moving_description, moving_date) VALUES ('2', '$move_to_storage', '$moving_desc', '$autodate')";
			$makestory = mysqli_query($connection, $history_moving);
			$last_id = mysqli_insert_id($connection);
			if (!$makestory) {
				die("Error description: " . $mysqli -> error);
			}
			// Movings tablitsaga istoriya qoldirdi

			foreach ($products as $product) {
				$product_id = $product['name'];
				$product_quantity = $product['quantity'];
				$surov = "SELECT product_id, product_name, product_count FROM products WHERE product_id = '$product_id'";
				$query = mysqli_query($connection, $surov);
				if (!$query) {
					die("Malumotlar bazasi so'rovida xatolik");
				}
				else {
					while ($result = mysqli_fetch_assoc($query)) {
						$name = $result['product_name'];
						$id = $result['product_id'];
						$quantity = $result['product_count'];
						if ($quantity < $product_quantity) {
							die("Tanlangan maxsulotdan omborda yetarli emas!");
						}
						// Tovarni admin skladidan ayiradi
						$admin_new_quantity = $quantity - $product_quantity;
						$save = "UPDATE products SET product_count = $admin_new_quantity WHERE product_id = '$id'";
						$save_query = mysqli_query($connection, $save);
						if (!$save_query) {
							die('Maxsulotni bazadan ayirishda xatolik');
						}
						// Tovarni admin skladidan ayirdi

						// Tovavarni usto skladiga qushadi 
						$cheking = "SELECT * FROM master_storage WHERE product_id = $id AND storage_id = $move_to_storage";
						$result = mysqli_query($connection, $cheking);
						$counting = mysqli_num_rows($result);
						if ($counting == 0) {
							$new_product = "INSERT INTO master_storage(product_id, storage_id, product_quantity) VALUES ('$id', '$move_to_storage', '$product_quantity')";
							$save_product = mysqli_query($connection, $new_product);
							if (!$save_product) {
								die('Yango maxsulotni bazada qoshishda xatolik');
							}
						}
						elseif ($counting > 0) {
							while ($loading = mysqli_fetch_assoc($result)) {
								$master_old_quantity = $loading['product_quantity'];
							}
							$master_new_quantity = $master_old_quantity + $product_quantity;
							$saving_query = "UPDATE master_storage SET product_quantity = '$master_new_quantity' WHERE product_id = '$id' AND storage_id = '$move_to_storage'";
							$update_result = mysqli_query($connection, $saving_query);
							if (!$update_result) {
								die('Bor malumotni sonini ozgartirishda xatolik');
							}
						}
						// Tovavarni usto skladiga qushdi 

						// Movings details tablitsaga istoriya qoldiradi
						$move_details = "INSERT INTO moving_details(moving_id, mov_product_id, mov_product_quantity) VALUES ('$last_id', '$id', '$product_quantity')";
						$history_details = mysqli_query($connection, $move_details);
						if (!$history_details) {
							die("Story Details yaratishda xatolik: " . $mysqli -> error);
						}
						// Movings details tablitsaga istoriya qoldirdi
						$_SESSION['xabar'] = "success";
						header("Location: index.php");
					}
				}
			}
		}
	}
 ?>