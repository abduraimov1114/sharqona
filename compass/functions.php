<?php

    function isenought_product($proID, $storID, $reqQuant) {

	    GLOBAL $connection;

	    $checkquant = "SELECT product_quantity FROM master_storage WHERE product_id = $proID AND storage_id = $storID";

	    $checkquery = mysqli_query($connection, $checkquant);

	    if (!$checkquery) {

	        die("Bazadan bunday tovarni tanlashda xatolik");

	    }

	    else {

	    	$rowcount = mysqli_num_rows($checkquery);

	    	if ($rowcount == 1) {

	    		$javob = mysqli_fetch_array($checkquery);

	    		$storage_quantity = $javob['product_quantity'];

	    		if ($storage_quantity < $reqQuant) {

	    		    return false;

	    		}

	    		else {

	    		    return true;

	    		}

	    	}

	    	else {

	    		return false;

	    	}

	    }

	}

	function isenought_product_storage2($choosed_product_id, $choosed_product_quantity) {

		GLOBAL $connection;

		$checkquant = "SELECT product_count FROM products WHERE product_id = '$choosed_product_id'";

		$checkquery = mysqli_query($connection, $checkquant);

		if (!$checkquery) {

		    die("Bazadan bunday tovarni tanlashda xatolik");

		}

		else {

			$rowcount = mysqli_num_rows($checkquery);

			if ($rowcount == 1) {

				$javob = mysqli_fetch_array($checkquery);

				$storage_quantity = $javob['product_count'];

				if ($storage_quantity < $choosed_product_quantity) {

				    return false;

				}

				else {

				    return true;

				}

			}

			else {

				return false;

			}

		}

	}



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

	function DeleteSaved($saved_id) {
		GLOBAL $connection;
		$query = "SELECT * FROM saved_datails WHERE saved_id = '$saved_id'";
		$query_go = mysqli_query($connection, $query);
		if (!$query_go) {
			die('Saqlangan ishni qidirishda xatolik');
		}
		else {
			$details_saved = mysqli_num_rows($query_go);
		}
		if ($details_saved > 0) {
			$query = "DELETE FROM saved_datails WHERE saved_id = '$saved_id'";
			$delete_go = mysqli_query($connection, $query);
			if (!$delete_go) {
				die('Saqlangan ishni o\'chirishda xatolik');
			}
		}
		$query_del = "DELETE FROM saved WHERE saved_id = '$saved_id'";
		$delete_saved = mysqli_query($connection, $query_del);
		if (!$delete_saved) {
			die("Savedni o'chirishda xatolik");
		}
		else {
			return true;
		}
	}

	function CreateOrder($buyer_id, $date, $sold_user, $storage, $payment_type, $total_amount, $client_desc, $client_name, $client_number) {

		GLOBAL $connection;

		$ordersinsert = "INSERT INTO orders(customer_id, order_date, order_user, order_storage, payment_type, total_amount, order_note, user_name, user_tell) VALUES ('$buyer_id', '$date', '$sold_user', '$storage', '$payment_type','$total_amount','$client_desc', '$client_name', '$client_number')";

		$ordquery = mysqli_query($connection, $ordersinsert);

		if (!$ordquery) {

		    die("Ordersni yaratishda xatolik");

		}

		else {

			$last_order_id = mysqli_insert_id($connection);

			return ["created" => true, "last_ctreated_id" => $last_order_id];

		}

	}



	function MinusBuyerBudget($buyer_id, $minusingprice) {

		GLOBAL $connection;

		$buyer_query = "SELECT buyers_budget FROM buyers WHERE buyers_id = '$buyer_id'";

		$buyer_budget = mysqli_query($connection, $buyer_query);

		if (!$buyer_budget) {

			die("Tashkilotni bazadan izlashda xatolik!");

		}

		else {

			$rowcountbudget = mysqli_num_rows($buyer_budget);

			if ($rowcountbudget == 1) {

				$tempresult = mysqli_fetch_array($buyer_budget);

				$oldbudget = $tempresult['buyers_budget'];

				$new_budget = $oldbudget - $minusingprice;

				$newbudget_do = "UPDATE buyers SET buyers_budget = '$new_budget' WHERE buyers_id = '$buyer_id'";

				$new_budget_query = mysqli_query($connection, $newbudget_do);

				if (!$new_budget_query) {

					return false;

				}

				else {

					return true;

				}

			}

		}

	}

	function MinusNotDetails($notid) {
		GLOBAL $connection;
		$query = "DELETE FROM accept_notifications_details WHERE notification_id = '$notid'";
		$delete_query = mysqli_query($connection, $query);
		if (!$delete_query) {
			die("Cant delete from notification details");
		}
		else {
			return true;
		}
	}

	function MinusNotifications($notid) {
		GLOBAL $connection;
		$query = "DELETE FROM accept_notifications WHERE notification_id = '$notid'";
		$delete_not_query = mysqli_query($connection, $query);
		if (!$delete_not_query) {
			die('Cant delete from notifications');
		}
		else {
			return true;
		}
	}

	function Minusproduct($ourstorage, $ourproduct_id, $tradequant) {

	    GLOBAL $connection;

	    $selectable = "SELECT id, product_quantity FROM master_storage WHERE storage_id = '$ourstorage' AND product_id = '$ourproduct_id'";

	    $selectquery = mysqli_query($connection, $selectable);

	    while ($rowselect = mysqli_fetch_assoc($selectquery)) {

	        $rowid = $rowselect['id'];

	        $rowquant = $rowselect['product_quantity'];

	    }

	    $new_quant = $rowquant - $tradequant;

	    $newquant_do = "UPDATE master_storage SET product_quantity = '$new_quant' WHERE id = '$rowid'";

	    $newquant_do_query = mysqli_query($connection, $newquant_do);

	    if (!$newquant_do_query) {

	    	return false;

	    }

	    else {

	    	return true;

	    }

	}



	function Minusproduct_storage2($ourstorage, $ourproduct_id, $tradequant) {

	    GLOBAL $connection;

	    if ($ourstorage != 2) {

	    	die("Tfu yoptvoyu mat");

	    }

	    $selectable = "SELECT product_id, product_count FROM products WHERE product_id = '$ourproduct_id'";

	    $selectquery = mysqli_query($connection, $selectable);

	    while ($rowselect = mysqli_fetch_assoc($selectquery)) {

	        $rowid = $rowselect['product_id'];

	        $rowquant = $rowselect['product_count'];

	    }

	    $new_quant = $rowquant - $tradequant;

	    $newquant_do = "UPDATE products SET product_count = '$new_quant' WHERE product_id = '$rowid'";

	    $newquant_do_query = mysqli_query($connection, $newquant_do);

	    if (!$newquant_do_query) {

	    	return false;

	    }

	    else {

	    	return true;

	    }

	}



	function Savetrade($orders_id, $products_id, $product_quantity, $product_price, $is_product) {

	    GLOBAL $connection;

	    $insertarch = "INSERT INTO ordered_products(orders_id, products_id, product_quantity, product_price, is_product) VALUES ($orders_id, $products_id, $product_quantity, $product_price, $is_product)";

	        $gosave = mysqli_query($connection, $insertarch);

        if (!$gosave) {

           return false;

        }

        else {

        	return true;

        }

	}



	function Savearchive($notif, $pro, $price, $quant, $is) {

		GLOBAL $connection;

		$insertarch = "INSERT INTO accept_notifications_details(notification_id, product_id, product_price, product_quantity, is_product) VALUES ($notif, $pro, $price, $quant, $is)";

			$goarchive = mysqli_query($connection, $insertarch);

			if (!$goarchive) {

				die("Tovarni notification details tablitsaga saqlashda xatolik");

			}

			else {

				return true;

			}

	}



	function DeleteNotDetails($proID, $isProduct, $proQuant) {

		GLOBAL $connection;

		GLOBAL $notification_id;

		$delete_not_dt = "DELETE FROM accept_notifications_details WHERE notification_id = '$notification_id' AND product_id = '$proID' AND is_product = '$isProduct' AND product_quantity = '$proQuant'";

		$delete_not_dt_query = mysqli_query($connection, $delete_not_dt);

		if (!$delete_not_dt_query) {

			return false;

		}

		else {

			return true;

		}

	}



	function DeleteNotification($storageID, $notUser) {

		GLOBAL $connection;

		GLOBAL $notification_id;

		$delete_notification = "DELETE FROM accept_notifications WHERE notification_id = '$notification_id' AND notification_storage = '$storageID' AND notification_user = '$notUser'";

		$delete_notification_query = mysqli_query($connection, $delete_notification);

		if (!$delete_notification_query) {

			return false;

		}

		else {

			return true;

		}

	}



	// Sherdan qushishni boshladim



	function sqlinjection($data) {

		GLOBAL $connection;

		$cleaned = mysqli_real_escape_string($connection, $data);

		return $cleaned;

	}



	function checkbuyer($buyer_id) {

		GLOBAL $connection;

		$checkbuyer_query = "SELECT * FROM buyers WHERE buyers_id = '$buyer_id'";

		$checkbuyer = mysqli_query($connection, $checkbuyer_query);

		if (!$checkbuyer) {

		    die('Connecting Field while searching buyer');

		}

		else {

		    $count_buyer = mysqli_num_rows($checkbuyer);

		    if ($count_buyer == 1) {

		        $selected_buyer = mysqli_fetch_assoc($checkbuyer);

		        $buyer_id = $selected_buyer['buyers_id'];

		        $buyer_name = $selected_buyer['buyers_name'];

		    }

		    else {

		        return false;

		    }

		}

	}



	function checkstorage($storage) {

		GLOBAL $connection;

		$checkstorage_query = "SELECT * FROM storages WHERE storage_id = '$storage'";

		$checkstorage = mysqli_query($connection, $checkstorage_query);

		if (!$checkstorage) {

			die('Connecting Field while searching storage');

		}

		else {

			$count_storage = mysqli_num_rows($checkstorage);

			if ($count_storage == 1) {

				return true;

			}

			else {

				return false;

			}

		}

	}



	function checkmaster($master_id) {

		GLOBAL $connection;

		$checkmaster_query = "SELECT * FROM users WHERE user_id = '$master_id' AND user_role = 'Master'";

		$checkmaster = mysqli_query($connection, $checkmaster_query);

		if (!$checkmaster) {

			die('Connecting Field while searching master');

		}

		else {

			$count_master = mysqli_num_rows($checkmaster);

			if ($count_master == 1) {

				return true;

			}

			else {

				return false;

			}

		}

	}



	function checkadmin($admin_id) {

		GLOBAL $connection;

		$checkmaster_query = "SELECT * FROM users WHERE user_id = '$admin_id' AND user_role = 'Admin'";

		$checkmaster = mysqli_query($connection, $checkmaster_query);

		if (!$checkmaster) {

			die('Connecting Field while searching master');

		}

		else {

			$count_master = mysqli_num_rows($checkmaster);

			if ($count_master == 1) {

				return true;

			}

			else {

				return false;

			}

		}

	}



	// Sherdan qushishni tugatdim





	//	Hussaniki Saved

	function Saved($id_order,$etaj,$usto){

		include_once("../DB/functions.php");

		$func = new database_func();

		GLOBAL $connection;

		GLOBAL $OK;

			$reset = $_POST['reset'];

			$user_name=$func->secur($_POST['user_name']);

			$desc=$func->secur($_POST['desc']);

			$usto = $func->secur($usto);

			$tell_num=$func->secur($_POST['tell_num']);

			$buyer_id=$id_order;

			if ($reset == "") {

				$sorov = "select max(saved_times) from saved WHERE buyer_id=" . $buyer_id;

				$func->queryMysql($sorov);



				$row = $func->result->fetch_array(MYSQL_ASSOC);

				//        agar max element bo`lmasa $saved_times = 1

				if ($row['max(saved_times)'] == "") {

					$saved_times = 1;

				} else {

					$saved_times = $row['max(saved_times)'] + 1;

				}

				//        data

				if (isset($_POST['date'])) {

					$date = $_POST['date'];

				}

				else {

					$date = new DateTime();

				}

				$date = mysqli_real_escape_string ($connection, $date);

				$sale_date = date_format (new DateTime($date), 'Y-m-d');



				if (isset($_POST['prices1']) || isset($_POST['prices2']) || isset($_POST['prices3']) || isset($_POST['prices4']) || isset($_POST['prices5'])) {

					$payment_type = "";

					$count = 0;

					$arrays[$count]="";

					if (isset($_POST['prices1']) && $_POST['prices1']!="" && $_POST['prices1']!="0") {

						$arrays[$count] = "1=>" . $_POST['prices1'];

						$count++;

					}

					if (isset($_POST['prices2']) && $_POST['prices2']!="" && $_POST['prices2']!="0") {

						$arrays[$count] = "2=>" . $_POST['prices2'];

						$count++;

					}

					if (isset($_POST['prices3']) && $_POST['prices3']!="" && $_POST['prices3']!="0") {

						$arrays[$count] = "3=>" . $_POST['prices3'];

						$count++;

					}

					if (isset($_POST['prices4']) && $_POST['prices4']!="" && $_POST['prices4']!="0") {

						$arrays[$count] = "4=>" . $_POST['prices4'];

						$count++;

					}

					if (isset($_POST['prices5']) && $_POST['prices5']!="" && $_POST['prices5']!="0") {

						$arrays[$count] = "5=>" . $_POST['prices5'];

						$count++;

					}

					for($i=0;$i<$count;$i++){

						if($i!=$count-1){

							$payment_type .= $arrays[$i] . ",";

						}else{

							$payment_type .= $arrays[$i];

						}

					}

					if($payment_type!=""){

						$ok++;

					}

				}



				$sorov = "insert into saved(`saved_desc`,`tell_num`,`buyer_id`,`saved_times`,`user_name`,`data`,`payment_type`,`usto_id`,`storage_id`)

 				VALUES

 				('$desc','$tell_num','$buyer_id','$saved_times','$user_name','$sale_date','$payment_type','$usto','$etaj')";

				$result = $func->queryMysql($sorov);

				if (!isset($result)) {

					//            insert into => saved:=>saved_desc,tell_num,buyer_id,saved_times

					$sorov = "select * from saved WHERE buyer_id=" . $buyer_id . " ORDER BY saved_id DESC";

					$func->queryMysql($sorov);

					$row = $func->result->fetch_array(MYSQL_ASSOC);

					$saved_id = $row['saved_id'];

					//           insert into => saved datails :=> ps_id,count,one_price,is_product,saved_id;

					foreach ($_POST['product'] as $var1) {

						$product_id = $var1['name'];

						$one_price = $var1['price'];

						$quantity = $var1['quantity'];

						$is_product = 1;

						$sorov = "insert into saved_datails

                (`ps_id`,`count`,`one_price`,`is_product`,`saved_id`)

                VALUES ('$product_id','$quantity','$one_price','$is_product','$saved_id')";

						$func->queryMysql($sorov);

					}

					foreach ($_POST['service'] as $var1) {

						$product_id = $var1['name'];

						$one_price = $var1['price'];

						$quantity = $var1['quantity'];

						$is_product = 0;

						$sorov = "insert into saved_datails

                (`ps_id`,`count`,`one_price`,`is_product`,`saved_id`)

                VALUES ('$product_id','$quantity','$one_price','$is_product','$saved_id')";

						$func->queryMysql($sorov);

					}

					$OK=true;

				}else{

					$OK=false;

				}

			}else{

				//				$buyer_id = $_POST['tashkilot'];

				if (isset($_POST['prices1']) || isset($_POST['prices2']) || isset($_POST['prices3']) || isset($_POST['prices4']) || isset($_POST['prices5'])) {

					$payment_type = "";

					$count = 0;

					$arrays[$count]="";

					if (isset($_POST['prices1']) && $_POST['prices1']!="" && $_POST['prices1']!="0") {

						$arrays[$count] = "1=>" . $_POST['prices1'];

						$count++;

					}

					if (isset($_POST['prices2']) && $_POST['prices2']!="" && $_POST['prices2']!="0") {

						$arrays[$count] = "2=>" . $_POST['prices2'];

						$count++;

					}

					if (isset($_POST['prices3']) && $_POST['prices3']!="" && $_POST['prices3']!="0") {

						$arrays[$count] = "3=>" . $_POST['prices3'];

						$count++;

					}

					if (isset($_POST['prices4']) && $_POST['prices4']!="" && $_POST['prices4']!="0") {

						$arrays[$count] = "4=>" . $_POST['prices4'];

						$count++;

					}

					if (isset($_POST['prices5']) && $_POST['prices5']!="" && $_POST['prices5']!="0") {

						$arrays[$count] = "5=>" . $_POST['prices5'];

						$count++;

					}

					for($i=0;$i<$count;$i++){

						if($i!=$count-1){

							$payment_type .= $arrays[$i] . ",";

						}else{

							$payment_type .= $arrays[$i];

						}

					}

				}

				//        echo $buyer_id;

				$sorov = "UPDATE  `saved` SET

                                `saved_desc` = '$desc',

                                `tell_num` = '$tell_num',

                                `payment_type` = '$payment_type',

                                `user_name` = '$user_name'

                        WHERE  `saved_id` =" . $reset;

				$func->queryMysql($sorov);

				$sorov1="delete from saved_datails WHERE `saved_id`=".$reset;

				$result = $func->queryMysql($sorov1);

				if(!isset($result)){

					$OK=true;

				}else{

					$OK=false;

				}

				//////////////////////////////////////////////////////////////

				/////////////////insert///////////////////////////////////////

				//////////////////////////////////////////////////////////////



				//           insert into => saved datails :=> ps_id,count,one_price,is_product,saved_id;

				foreach ($_POST['product'] as $var1) {

					$product_id = $var1['name'];

					$one_price = $var1['price'];

					$quantity = $var1['quantity'];

					$is_product = 1;

					$sorov = "insert into saved_datails

                (`ps_id`,`count`,`one_price`,`is_product`,`saved_id`)

                VALUES ('$product_id','$quantity','$one_price','$is_product','$reset')";

					$func->queryMysql($sorov);

				}

				foreach ($_POST['service'] as $var1) {

					$product_id = $var1['name'];

					$one_price = $var1['price'];

					$quantity = $var1['quantity'];

					$is_product = 0;

					$sorov = "insert into saved_datails

                (`ps_id`,`count`,`one_price`,`is_product`,`saved_id`)

                VALUES ('$product_id','$quantity','$one_price','$is_product','$reset')";

					$func->queryMysql($sorov);

				}

			}

		return $OK;

	}

	function pay_type(){

		if (isset($_POST['prices1']) || isset($_POST['prices2']) || isset($_POST['prices3']) || isset($_POST['prices4']) || isset($_POST['prices5'])) {

			$payment_type = "";

			$count = 0;

			$arrays[$count]="";

			if (isset($_POST['prices1']) && $_POST['prices1']!="" && $_POST['prices1']!="0") {

				$arrays[$count] = "1=>" . $_POST['prices1'];

				$count++;

			}

			if (isset($_POST['prices2']) && $_POST['prices2']!="" && $_POST['prices2']!="0") {

				$arrays[$count] = "2=>" . $_POST['prices2'];

				$count++;

			}

			if (isset($_POST['prices3']) && $_POST['prices3']!="" && $_POST['prices3']!="0") {

				$arrays[$count] = "3=>" . $_POST['prices3'];

				$count++;

			}

			if (isset($_POST['prices4']) && $_POST['prices4']!="" && $_POST['prices4']!="0") {

				$arrays[$count] = "4=>" . $_POST['prices4'];

				$count++;

			}

			if (isset($_POST['prices5']) && $_POST['prices5']!="" && $_POST['prices5']!="0") {

				$arrays[$count] = "5=>" . $_POST['prices5'];

				$count++;

			}

			for($i=0;$i<$count;$i++){

				if($i!=$count-1){

					$payment_type .= $arrays[$i] . ",";

				}else{

					$payment_type .= $arrays[$i];

				}

			}

		}
		if (isset($_POST['prices4']) && $_POST['prices4']!="" && $_POST['prices4']!="0") {
			//				db ga qushish
			GLOBAL $func;
			//            insert into dept
			if ($buyer_id==10){
				$user_name = $_POST['user_name'];
				$desc = $_POST['desc'];
				$tell_num = $_POST['tell_num'];
				$date = date('Y-m-d');
				if ($_POST['prices4'] > 0) {
					$max_id = "select max(order_id) from orders";
					$func->queryMysql($max_id);
					$row = $func->result->fetch_array(MYSQL_ASSOC);
					$max_id = $row['max(order_id)'];
					$summa_dept = $_POST['prices4'];
					$fin_data = $_POST['finish'];
					$create_dept = "INSERT INTO dept(order_id, name, tell, description, summa, start_data, finish_data, is_org, payment_type)
          VALUES ('$max_id','$user_name','$tell_num' , '$desc' , '$summa_dept' ,'$date,'$fin_data','0','$payment_type')";
					$func->queryMysql($create_dept);
				}
			}
		}
		return $payment_type;

	}

	

?>