<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once 'functions.php'; ?>

<?php 
    // If isset post submit
    if (isset($_POST['accept_the_form'])) {
        $chooseds = $_POST['accept'];
        $count_rows = count($_POST['accept']);
        // If submit not empty
        if ($count_rows > 0 AND !empty($chooseds)) {
            $sold_user = $_POST['customer'];
            $storage_number = $_POST['storage_number'];
            $client_name = $_POST['client_name'];
            $client_number = $_POST['client_number'];
            $client_desc = $_POST['client_desc'];
            $total_amount = $_POST['total_amount'];
            $notification_id = $_POST['notification_id'];
            $buyer_id = sqlinjection($_POST['buyer_id']);
            $payment_type = pay_type();
            $transfer_money = sqlinjection($_POST['prices3']);
            $dept_money = sqlinjection($_POST['prices4']);
            $total_minusing = $transfer_money + $dept_money;
            // Escape from SQL injection
            $client_number = mysqli_real_escape_string($connection, $client_number);
            $client_desc = mysqli_real_escape_string($connection, $client_desc);
            $client_name = mysqli_real_escape_string($connection, $client_name);
            // If main infos empty it will error
            if ($total_amount < 0 OR empty($sold_user) OR empty($storage_number) OR empty($buyer_id)) {
                $_SESSION['xabar'] = 'xato';
                header("Location: index.php");
            }
            // If main infos not empty
            else {
                $tekshiruvdanOtdi = 0;
                foreach ($chooseds as $choosed) {
                    $going_isproduct = $choosed['isProduct'];
                    $going_productid = $choosed['prodId'];
                    $going_quantity = $choosed['proquant'];
                    $going_oneprice = $choosed['oneprice'];
                    // Agar bu maxsulot bolsa skladda undan yetarlimi
                    if ($going_isproduct == 1) {
                        if (isenought_product($going_productid, $storage_number, $going_quantity) !== true) {
                            die("Savdodagi maxsulot omborda yetarlicha emas");
                        }
                        else {
                            $tekshiruvdanOtdi++;
                        }
                    }
                    // Agar bu maxsulot bolsa skladda undan yetarlimi end
                    // Agar bu xizmat bolsa va xizmat skladdan maxsulot iste'mol qilsa
                    if ($going_isproduct == 0) {
                        $knowidpro = "SELECT service_pro_id FROM services WHERE service_id = '$going_productid'";
                        $proforknow = mysqli_query($connection, $knowidpro);
                        $uses = mysqli_fetch_array($proforknow);
                        $our_ser_pro_id = $uses['service_pro_id'];
                        if ($our_ser_pro_id > 0) {
                            if (isenought_product($our_ser_pro_id, $storage_number, $going_quantity) !== true) {
                                die("Xizmatga ketadigan maxsulot omborda yetarlicha emas");
                            }
                            else {
                                $tekshiruvdanOtdi++;
                            }
                        }
                        else {
                            $tekshiruvdanOtdi++;
                        }
                    } // If its service checking for isenought end
                }
                if ($tekshiruvdanOtdi == $count_rows) {
                    // Create orders
                    $date = date('Y-m-d H:i:s');
                    $ordersinsert = "INSERT INTO orders(customer_id, order_date, order_user, order_storage, payment_type, total_amount, order_note, user_name, user_tell) VALUES ('$buyer_id', '$date', '$sold_user', '$storage_number', '$payment_type','$total_amount','$client_desc', '$client_name', '$client_number')";
                    $ordquery = mysqli_query($connection, $ordersinsert);
                    if (!$ordquery) {
                        die("Ordersni yaratishda xatolik");
                    }
                    // Orders created
                    else {
                        $last_order_id = mysqli_insert_id($connection);
                        $minusPro = 0;
                        $product_yemaydi = 0;
                        $savedProducts = 0;
                        $delete_notdetails = 0;
                        // Minusing products and saving to history
                        foreach ($chooseds as $choosed) {
                            $going_isproduct = $choosed['isProduct'];
                            $going_productid = $choosed['prodId'];
                            $going_quantity = $choosed['proquant'];
                            $going_oneprice = $choosed['oneprice'];
                            
                            // Minusing pro
                            if ($going_isproduct == 1) {
                                if (Minusproduct($storage_number, $going_productid, $going_quantity) !== true) {
                                    die("Maxsulotni bazadan ayirishda xatolik");
                                }
                                else {
                                    $minusPro++;
                                    // Saving history 
                                   if (Savetrade($last_order_id, $going_productid, $going_quantity, $going_oneprice, $going_isproduct) !== true) {
                                        die("Maxsulotni istoriyaga saqlashda xatolik");
                                    }
                                    else {
                                        $savedProducts++;
                                        // Delete from notification details
                                        if (DeleteNotDetails($going_productid, $going_isproduct, $going_quantity) !== true) {
                                            die("Maxsulotni notification details tablitsadan o'chirishda xatolik");
                                        }
                                        else {
                                            $delete_notdetails++;
                                        }
                                    }
                                }
                            }
                            if ($going_isproduct == 0) {
                                $knowidpro = "SELECT service_pro_id FROM services WHERE service_id = '$going_productid'";
                                $proforknow = mysqli_query($connection, $knowidpro);
                                $uses = mysqli_fetch_array($proforknow);
                                $our_ser_pro_id = $uses['service_pro_id'];
                                if ($our_ser_pro_id > 0) {
                                    // Minusing service pro
                                    if (Minusproduct($storage_number, $our_ser_pro_id, $going_quantity) !== true) {
                                        die("Xizmat maxsulotini bazadan ayirishda xatolik");
                                    }
                                    else {
                                        $minusPro++;
                                        // Saving history
                                        if (Savetrade($last_order_id, $going_productid, $going_quantity, $going_oneprice, $going_isproduct) !== true) {
                                            die("Xizmat maxsulotini istoriyada saqlashda xatolik");
                                        }
                                        else {
                                            $savedProducts++;
                                            // Delete from notification details
                                            if (DeleteNotDetails($going_productid, $going_isproduct, $going_quantity) !== true) {
                                                die("Xizmat maxsulotini notification details tablitsadan o'chirishda xatolik");
                                            }
                                            else {
                                                $delete_notdetails++;
                                            }
                                        }
                                    }
                                }
                                else {
                                    $product_yemaydi++;
                                    // Saving history
                                    if (Savetrade($last_order_id, $going_productid, $going_quantity, $going_oneprice, $going_isproduct) !== true) {
                                        die("Maxsulot iste'mol qilmaydigan xizmatni istoriyada saqlashda xatolik");
                                    }
                                    else {
                                        $savedProducts++;
                                        if (DeleteNotDetails($going_productid, $going_isproduct, $going_quantity) !== true) {
                                            die("Pro iste'mol qilmaydigan xizmatni notification details tablitsadan o'chirishda xatolik");
                                        }
                                        else {
                                            $delete_notdetails++;
                                        }
                                    }
                                }
                            }
                            // Minusing service pro
                        }
                        // Minusing products and saving to history end
                        // Deleting notification from notifications table
                        if ($count_rows == $savedProducts AND $count_rows == $delete_notdetails AND $count_rows == ($minusPro + $product_yemaydi)) {
                            if ($buyer_id != 10) {
                                if (MinusBuyerBudget($buyer_id, $total_minusing) !== true) {
                                  die("Tashkilot buyudjetidan $total_minusing summani ayirishda xatolik");
                                }
                            }
                            if (DeleteNotification($storage_number, $sold_user) !== true) {
                                die("Bildirishnomani o'chirib tashlashda xatolik!");
                            }
                            else {
                                $_SESSION['xabar'] = 'success';
                                header("Location: index.php");
                            }
                        }
                    }
                }
                else {
                    die('Tanlangan maxsulotlar va tekshiruvdan o\'tgan maxsulotlar soni teng emas!');
                }
            }
        } // If submit not empty end
        else {
            $_SESSION['xabar'] = 'xato';
            header("Location: index.php");
        }
    }
    // Post submit if end
    // If submit form not pressed
    elseif (isset($_POST['delete_notification'])) {
        $notification_id = $_POST['notification_id'];
        if (MinusNotDetails($notification_id) == true) {
            if (MinusNotifications($notification_id) == true) {
                $_SESSION['xabar'] = 'success';
                header("Location: index.php");
            }
            else {
                die("Cant Minus Notifications");
            }
        }
        else {
            die("Cant MinusNotDetails");
        }
    }
    else {
        $_SESSION['xabar'] = 'xato';
        header("Location: index.php");
    }
?>