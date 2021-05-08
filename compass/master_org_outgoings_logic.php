<?php session_start(); ?>
<?php ob_start(); ?>
<?php error_reporting(E_ALL); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once 'functions.php'; ?>

<?php 
  // Xar ikkala knopka bosilsa xam tayorgarlik

  if (isset($_POST['master_org_outgoing']) OR isset($_POST['master_org_outgoing_admin'])) {
    $data = $_POST;
    // Getting extra Informations start and clean it
    if (isset($data['saveId'])) {
    	$saved_id = sqlinjection($data['saveId']);
    }
    else {
    	$saved_id = 0;
    }
    $buyer_id = sqlinjection($data['tashkilot']);
    $client_name = sqlinjection($data['user_name']);
    $session_name = sqlinjection($data['session_name']);
    if (empty($client_name)) {
      $client_name = sqlinjection($session_name . " " . "xaridor ismini kiritmadi.");
    }
    $client_phone = sqlinjection($data['tell_num']);
    if (empty($client_phone)) {
      $client_phone = sqlinjection($session_name . " " . "xaridor raqamini kiritmadi.");
    }
    $client_decs = sqlinjection($data['desc']);
    if (empty($client_decs)) {
      $client_decs = sqlinjection($session_name . " " . "izoh kiritmadi.");
    }
    $storage = sqlinjection($data['storage']);
    $master_id = sqlinjection($data['user_id']);
    $date = sqlinjection($data['date']);
    if (empty($date)) {
      $date = date('Y-m-d H:i:s');
    }
    $total_amount = sqlinjection($data['total']);
    $transfer_money = sqlinjection($data['prices3']);
    $dept_money = sqlinjection($data['prices4']);
    $total_minusing = $transfer_money + $dept_money;
    $payment_type = pay_type();
    // Getting extra Informations start and clean it end

    // Checking storage start
    if (checkstorage($storage) !== true) {
      die('Bunday ombor mavjud emas');
    }
    // Checking storage end

    // Checking master start
    if (checkmaster($master_id) !== true) {
      die('Bunday foydalanuvchi mavjud emas');
    }
    // Checking master end

    // Xizmatlar bo'limidan tanlandimi?
    if (isset($data['service'])) {
      $count_selected_services = count($data['service']);
    }
    else {
      $count_selected_services = 0;
    }

    // Mahsulotlar bo'limidan tanlandimi?
    if (isset($data['product'])) {
      $count_selected_products = count($data['product']);
    }
    else {
      $count_selected_products = 0;
    }

    // Mahsulotar test start
    if ($count_selected_products > 0) {
      $products = $data['product'];
      if (empty($products)) {
        die('Mahsulotlarning biri tanlanmay qolib ketgan');
      }
      $tested_products = 0;
      foreach ($products as $product) {
        $choosed_product_id = $product['name'];
        $choosed_product_quantity = $product['quantity'];
        if (empty($choosed_product_id) OR empty($choosed_product_quantity)) {
          die('Maxsulotlardan biri tanlanmay qolgan!');
        }
        if (isenought_product($choosed_product_id, $storage, $choosed_product_quantity) !== true) {
          die("Mahsulotlardan biri omborda yetarli emas!");
        }
        else {
          $tested_products++;
        }
      }
    }
    else {
      $tested_products = 0;
    }
    // Mahsulotlar test end

    // Xizmatlar test start
    if ($count_selected_services > 0) {
      $services = $data['service'];
      if (empty($services)) {
        die('Xizmatlarning biri tanlanmay qolib ketgan');
      }
      $tested_services = 0;
      foreach ($services as $service) {
        $choosed_service_id = $service['name'];
        $choosed_service_quantity = $service['quantity'];
        if (empty($choosed_service_id) OR empty($choosed_service_quantity)) {
          die("Xizmatlardan biri tanlanmay qolgan!");
        }

        // Is this service eat product?
        $eatproduct_and_product = Iseatproduct($choosed_service_id);
        $iseatproduct = $eatproduct_and_product['0'];
        $eatproduct = $eatproduct_and_product['1'];

        // Yes this service eat product
        if ($iseatproduct == true AND $eatproduct > 0) {
          if (isenought_product($eatproduct, $storage, $choosed_service_quantity) == true) {
            $tested_services++;
          }
          else {
            die("Xizmatga sarflanadigan maxsulot omborda yetarlicha emas!");
          }
        }

        // No this service don't eat product
        else {
          $tested_services++;
        }
      }
    }
    else {
      $tested_services = 0;
    }
    // Xizmatlar test end
  }
  // Xar ikkala knopka bosilsa xam tayorgarlik end




  // Aynan Sotuv knopka bosilsa start
  if (isset($_POST['master_org_outgoing'])) {
    // Knowing result of testings and creating orders table
    if ($count_selected_services == $tested_services AND $count_selected_products == $tested_products) {
      // Testings okay creating order
      $create_order = CreateOrder($buyer_id, $date, $master_id, $storage, $payment_type, $total_amount, $client_decs, $client_name, $client_phone);
      $order_created = $create_order['created'];
      $created_order_id = $create_order['last_ctreated_id'];
      if ($order_created !== true OR $created_order_id <= 0 OR empty($created_order_id)) {
        die("Error while creating order");
      }
      else {
        // Order successfully created
        $minusPro = 0;
        $noteatPro = 0;
        $savingStory = 0;

        // Minusing product and saving to story start
        if ($count_selected_products > 0) {
          foreach ($products as $product) {
            $choosed_product_id = $product['name'];
            $choosed_product_quantity = $product['quantity'];
            $choosed_product_price = $product['price'];
            if (Minusproduct($storage, $choosed_product_id, $choosed_product_quantity) !== true) {
                die("Maxsulotni bazadan ayirishda xatolik");
            }
            else {
              $minusPro++;
              if (Savetrade($created_order_id, $choosed_product_id, $choosed_product_quantity, $choosed_product_price, 1) !== true) {
                die("Maxsulotni istoriyaga saqlashda xatolik");
              }
              else {
                $savingStory++;
              }
            }
          }
        }
        // Minusing product and saving to story end

        // Minusing services and saving to story start
        if ($count_selected_services > 0) {
          foreach ($services as $service) {
            $choosed_service_id = $service['name'];
            $choosed_service_quantity = $service['quantity'];
            $choosed_service_price = $service['price'];

            // Is this service eat product?
            $eatproduct_and_product = Iseatproduct($choosed_service_id);
            $iseatproduct = $eatproduct_and_product['0'];
            $eatproduct = $eatproduct_and_product['1'];

            // Yes this service eat product
            if ($iseatproduct == true AND $eatproduct > 0) {
              if (Minusproduct($storage, $eatproduct, $choosed_service_quantity) !== true) {
                die("Xizmat maxsulotini bazadan ayirishda xatolik");
              }
              else {
                $minusPro++;
                if (Savetrade($created_order_id, $choosed_service_id, $choosed_service_quantity, $choosed_service_price, 0) !== true) {
                  die("Xizmatni istoriyaga saqlashda xatolik");
                }
                else {
                  $savingStory++;
                }
              }
            }
            // No this service don't eat product
            else {
              $noteatPro++;
              if (Savetrade($created_order_id, $choosed_service_id, $choosed_service_quantity, $choosed_service_price, 0) !== true) {
                die("Maxsulotsiz xizmatni istoriyaga saqlashda xatolik");
              }
              else {
                $savingStory++;
              }
            }
          }
        }
        // Minusing services and saving to story end

        // Ending the logic
        $allselected = $count_selected_products + $count_selected_services;
        if ($allselected == $savingStory AND $allselected == ($minusPro + $noteatPro)) {
          if (MinusBuyerBudget($buyer_id, $total_minusing) == true) {
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
          else {
            die("Error while minusing buyers budget!");
          }
        }
        else {
          die("Unknown Error Detected!");
        }
        // Ending the logic
      }
    }
  }
  // Aynan Sotuv knopka bosilsa end





  // Naqd pul aralashsa va tasdiqlash knopkasi bosilsa start
  if (isset($_POST['master_org_outgoing_admin'])) {
    if ($count_selected_services == $tested_services AND $count_selected_products == $tested_products) {
    	$autodate = date('Y-m-d H:i:s');
      $notinsert = "INSERT INTO accept_notifications(buyer_id, client_name, client_number, notification_desc, notification_storage, notification_user, payment_type, total, notification_time) VALUES ('$buyer_id', '$client_name', '$client_phone', '$client_decs', '$storage', '$master_id','$payment_type','$total_amount', '$autodate')";
      $notquery = mysqli_query($connection, $notinsert);
      if (!$notquery) {
        die("Notification yaratishda xatolik");
      }
      else {
      $last_id = mysqli_insert_id($connection);
      $saved = 0;
        // Notification created now time to save all to archive for accepting
        // If its product start
        if ($count_selected_products > 0) {
          foreach ($products as $product) {
            $choosed_product_id = $product['name'];
            $choosed_product_quantity = $product['quantity'];
            $choosed_product_price = $product['price'];
            if (Savearchive($last_id, $choosed_product_id, $choosed_product_price, $choosed_product_quantity, '1') !== true) {
                die("Maxsulotni notificationda saqlashda xatolik");
            }
            else {
              $saved++;
            }
          }
        }
        // If its product end
        // If its service start
        if ($count_selected_services > 0) {
          foreach ($services as $service) {
            $choosed_service_id = $service['name'];
            $choosed_service_quantity = $service['quantity'];
            $choosed_service_price = $service['price'];
            if (Savearchive($last_id, $choosed_service_id, $choosed_service_price, $choosed_service_quantity, '0') !== true) {
                die("Xizmatni notificationda saqlashda xatolik");
            }
            else {
              $saved++;
            }
          }
        }
        // If its service end
        $allselected = $count_selected_products + $count_selected_services;
        if ($allselected == $saved) {
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
    }
  }
  // Naqd pul aralashsa va tasdiqlash knopkasi bosilsa start

  if (isset($_POST['save'])) {
    // Husan Og'a Saveeee
      $saveds=$_POST['save'];
  if(isset($saveds)) {
    $storage_number = $_POST['storage'];
    $tashkilot = $_POST['tashkilot'];
    // echo $storage_number."Salol";
 // echo "<br>".$saved;
    $session_id = $_SESSION['ses_user_id'];
    // echo "<br/>".$saveds;
    // echo "<br/>".$session_id;

    $resltSave = Saved($tashkilot, $storage_number, $session_id);
    if($resltSave==true){
        if($storage_number==1){
            $_SESSION['xabar'] = 'success';
            header("Location: saved_accepts_padval.php");
        }elseif ($storage_number==3) {
          $_SESSION['xabar'] = 'success';
            header("Location: saved_accepts_lab.php");
        }else{
          $_SESSION['xabar'] = 'xato';
          header("Location: index.php"); 
        }
        // echo $storage_number;
      }
      
    }
      
    }
  
?>