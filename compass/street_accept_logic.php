<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once 'functions.php'; ?>
<?php
if (isset($_SESSION['ses_user_id'])) {
	$session_id = $_SESSION['ses_user_id'];
}
if (isset($_SESSION['ses_user_role'])) {
	$session_role = $_SESSION['ses_user_role'];
}
if (isset($_SESSION['ses_user_name'])) {
	$session_name = $_SESSION['ses_user_name'];
}

if (isset($_POST['confirm_for_accept']))
{
	if (isset($_POST['saveId'])) {
		$saved_id = sqlinjection($_POST['saveId']);
	}
	else {
		$saved_id = 0;
	}
	$storage_number = sqlinjection($_POST['storage_number']);
	$summa = sqlinjection($_POST['total']);
	if (isset($_POST['product'])) {
		$number_rows_product = count($_POST['product']);
	}
	else {
		$number_rows_product = 0;
	}
	if (isset($_POST['service'])) {
		$number_rows_service = count($_POST['service']);
	}
	else {
		$number_rows_service = 0;
	}
	
	$payment_type = pay_type();
	// Checking products and services for choosed or not
	if ($number_rows_product <= 0 AND $number_rows_service <= 0) {
		die("Xizmat va Maxsulotlardan xech narsa tanlanmadi");
	}

	// CHecking for product inputs => Selected or not? Are there enought products? If error please die.
	if ($number_rows_product > 0) {
		$products = $_POST['product'];
		if (isset($products) AND !empty($products)) {
			foreach ($products as $product) {
				$our_pro_id = $product['name'];
				$our_pro_quant = sqlinjection($product['quantity']);
				$our_pro_one_price = sqlinjection($product['price']);
				if (empty($our_pro_id) OR empty($our_pro_quant) OR $our_pro_one_price < 0) {
					die("Maxsulotlardan biri tanlanmay qolib ketgan");
				}
				if (isenought_product($our_pro_id, $storage_number, $our_pro_quant) !== true) {
					die("Tanlangan maxsulotlar tekshiruvdan utolmadi");
				}
			}
		}
	}
	// Its allright, product inputs selected good, and there are enought products in storage, go to next step

	// CHecking for services inputs => Selected or not? Are there enought products? If error please die.
	if ($number_rows_service > 0) {
		$services = $_POST['service'];
		if (isset($services) AND !empty($services)) {
			foreach ($services as $service) {
				$our_ser_id = $service['name'];
				$our_ser_quant = sqlinjection($service['quantity']);
				$our_ser_one_price = sqlinjection($service['price']);
				if (empty($our_ser_id) OR empty($our_ser_quant) OR $our_ser_one_price < 0) {
					die("Xizmatlardan biri tanlanmay qolib ketgan");
				}
				$knowidpro = "SELECT service_pro_id FROM services WHERE service_id = '$our_ser_id'";
				$proforknow = mysqli_query($connection, $knowidpro);
				$uses = mysqli_fetch_array($proforknow);
				$our_ser_pro_id = $uses['service_pro_id'];
				if ($our_ser_pro_id > 0) {
					if (isenought_product($our_ser_pro_id, $storage_number, $our_ser_quant) !== true) {
						die("Tanlangan xizmatlar tekshiruvdan utolmadi");
					}
				}
			}
		}
	}
	// Its allright service inputs selected good, go to next step

// Cheking for extra informations
	$client_name = sqlinjection($_POST['user_name']);
	if (empty($client_name)) {
		$client_name = $session_name . " " . "mijoz ismini kiritmadi";
	}
	$client_number = sqlinjection($_POST['tell_num']);
	if (empty($client_number)) {
		$client_number = $session_name . " " . "mijoz raqamini kiritmadi";
	}
	$desc = sqlinjection($_POST['desc']);
	if (empty($desc)) {
		$desc = $session_name . " " . "izoh kiritmadi";
	}

	// Now all chekings complete, go to notification
	$autodate = date('Y-m-d H:i:s');
	$notinsert = "INSERT INTO accept_notifications(buyer_id, client_name, client_number, notification_desc, notification_storage, notification_user, payment_type, total, notification_time) VALUES ('10', '$client_name', '$client_number', '$desc', '$storage_number', '$session_id','$payment_type','$summa', '$autodate')";
	$notquery = mysqli_query($connection, $notinsert);
	if (!$notquery) {
		die("Notification yaratishda xatolik");
	}
	else {
	$last_id = mysqli_insert_id($connection);
	}
	// Notification created now time to save all to archive for accepting

	// Archive for products (Insert into notifications)
	$saved = 0;
	if ($number_rows_product > 0) {
		$products = $_POST['product'];
		foreach ($products as $product) {
			$our_pro_id = $product['name'];
			$our_pro_quant = $product['quantity'];
			$our_pro_one_price = $product['price'];
			Savearchive($last_id, $our_pro_id, $our_pro_one_price, $our_pro_quant, '1');
			$saved++;
		}
	}
	// Archive for services (Insert into notifications)
	if ($number_rows_service > 0) {
		$services = $_POST['service'];
		foreach ($services as $service) {
			$our_ser_id = $service['name'];
			$our_ser_quant = $service['quantity'];
			$our_ser_one_price = $service['price'];
			Savearchive($last_id, $our_ser_id, $our_ser_one_price, $our_ser_quant, '0');
			$saved++;
		}
	}

	if ($saved > 0) {
		if ($saved_id != 0 AND $saved_id > 0) {
			if (DeleteSaved($saved_id) == true) {
				$_SESSION['xabar'] = 'success';
				header("Location: index.php");
			}
		}
		else {
			$_SESSION['xabar'] = 'success';
			header("Location: index.php");
		}
	}

}
else{
	$session_name = $_SESSION['ses_user_name'];
	$saveds=$_POST['save'];
	if(isset($saveds)) {
		$storage_number = $_POST['storage_number'];
//	echo "<br>".$saved;
		$session_id = $_SESSION['ses_user_id'];
		echo "<br/>".$saveds;
		echo "<br/>".$session_id;

		$resltSave = Saved(10, $saveds, $session_id);
		if($resltSave==true){
			if($saveds==1){
				$_SESSION['xabar'] = 'success';
				header("Location: saved_accepts_padval.php");
			}elseif($saveds==3){
				$_SESSION['xabar'] = 'success';
				header("Location: saved_accepts_lab.php");
			}else{
				echo "Siz notugri yuldan kirdingiz";
			}

		}else{
			echo "Xatolik bor";
		}
	}
}
?>