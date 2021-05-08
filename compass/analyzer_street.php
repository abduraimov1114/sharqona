<?php session_start(); ?>
<?php ob_start(); ?>

<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php require_once 'functions.php' ?>
<?php 
    if (isset($_POST['confirm_str_outgoings']) OR isset($_POST['save'])) {
       $data = $_POST;
       // Getting extra Informations start and clean it
       $buyer_id = sqlinjection($data['tashkilot']);
       $client_name = sqlinjection($data['user_name']);
       $client_phone = sqlinjection($data['tell_num']);
       $client_decs = sqlinjection($data['desc']);
       $session_name = sqlinjection($data['session_name']);
       $storage = sqlinjection($data['storage']);
       $admin_id = sqlinjection($data['user_id']);
       $date = sqlinjection($data['date']);
       $total_amount = sqlinjection($data['total']);
       $payment_type = pay_type();
       // Getting extra Informations start and clean it end

       // Filling extra informations
       if (empty($client_name)) {
         $client_name = sqlinjection($session_name . " " . "xaridor ismini kiritmadi.");
       }
       if (empty($client_phone)) {
         $client_phone = sqlinjection($session_name . " " . "xaridor raqamini kiritmadi.");
       }
       if (empty($client_decs)) {
         $client_decs = sqlinjection($session_name . " " . "izoh kiritmadi.");
       }
       if (empty($date)) {
         $date = date('Y-m-d H:i:s');
       }
       if (isset($_POST['saveId'])) {
        $saved_id = sqlinjection($_POST['saveId']);
       }
       else {
        $saved_id = 0;
       }
       // Filling extra informations

       // Checking master start
       if (checkadmin($admin_id) !== true) {
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
       if ($count_selected_products > 0 AND !empty($data['product'])) {
         $products = $data['product'];
         if (empty($products)) {
           die('Mahsulotlarning biri tanlanmay qolib ketgan');
         }
         $tested_products = 0;
         foreach ($products as $product) {
           $choosed_product_id = $product['name'];
           $choosed_product_quantity = sqlinjection($product['quantity']);
           $choosed_product_price = sqlinjection($product['price']);
           if (empty($choosed_product_id) OR empty($choosed_product_price) OR empty($choosed_product_quantity)) {
               die('Mahsulotlarning biri tanlanmay qolib ketgan, yoki narx va sonidan biri kiritilmagan!');
           }
           $choosed_product_quantity = $product['quantity'];
           if (isenought_product_storage2($choosed_product_id, $choosed_product_quantity) !== true) {
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
           $choosed_service_quantity = sqlinjection($service['quantity']);
           $choosed_service_price = sqlinjection($service['price']);
           if (empty($choosed_service_id) OR empty($choosed_service_price) OR empty($choosed_service_quantity)) {
               die('Xizmatlarning biri tanlanmay qolib ketgan, yoki narx va soni kiritilmagan');
           }
           $choosed_service_quantity = $service['quantity'];

           // Is this service eat product?
           $eatproduct_and_product = Iseatproduct($choosed_service_id);
           $iseatproduct = $eatproduct_and_product['0'];
           $eatproduct = $eatproduct_and_product['1'];

           // Yes this service eat product
           if ($iseatproduct == true AND $eatproduct > 0) {
             if (isenought_product_storage2($eatproduct, $choosed_service_quantity) == true) {
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

    /* If pressed order button start */
    if (isset($_POST['confirm_str_outgoings'])) {
        if ($count_selected_services == $tested_services AND $count_selected_products == $tested_products) {
            if ($count_selected_services == 0 AND $count_selected_products == 0) {
                die('Mahsulotlardan va xizmatlardan xech nima tanlanmagan!');
            }
            // Testings okay creating order
            $create_order = CreateOrder($buyer_id, $date, $admin_id, $storage, $payment_type, $total_amount, $client_decs, $client_name, $client_phone);
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
                        if (Minusproduct_storage2($storage, $choosed_product_id, $choosed_product_quantity) !== true) {
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
                        if (Minusproduct_storage2($storage, $eatproduct, $choosed_service_quantity) !== true) {
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
                    die("Unknown Error Detected!");
                }
                // Ending the logic
            }
        }
    }
    /* If pressed order button end */

    if (isset($_POST['save'])) {

  $saveds=$_POST['save'];
  if(isset($saveds)) {
    $storage_number = $storage;
    // echo $storage_number."Salol";
//  echo "<br>".$saved;
    $session_id = $_SESSION['ses_user_id'];
    // echo "<br/>".$saveds;
    // echo "<br/>".$session_id;

    $resltSave = Saved(10, $storage_number, $session_id);
    if($resltSave==true){

        $_SESSION['xabar'] = 'success';
        header("Location: saved.php");
      }
    	
    }
  }
?>
<?php require_once 'addincludes/scripts.php';
?>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/css/bootstrap.css">
<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/neon-chat.js"></script>
<script src="assets/js/custom.js"></script>