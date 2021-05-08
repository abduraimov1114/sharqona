<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php require_once 'functions.php'; ?>
<?php

    if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {

        die("<h1 align='center'>Let's get out of here!</h1>");

    }



    if (isset($_GET['notid'])) {

        $notification_id = $_GET['notid'];

        $notification_id = mysqli_real_escape_string($connection, $notification_id);

        $notaccept = "SELECT * FROM accept_notifications WHERE notification_id = '$notification_id'";

        $notaccept_query = mysqli_query($connection, $notaccept);

        if (!$notaccept_query) {

            die('Bazadan notification ID ni qidirishda xatolik');

        }

        $countrows = mysqli_num_rows($notaccept_query);

        if ($countrows == 1) {

            while ($notification = mysqli_fetch_assoc($notaccept_query)) {

               $notid = $notification['notification_id'];

               $client = $notification['client_name'];

               $client_number = $notification['client_number'];

               $storage = $notification['notification_storage'];

               $customer = $notification['notification_user'];

               $time = $notification['notification_time'];

               $notdesc = $notification['notification_desc'];

               $buyer_id = $notification['buyer_id'];

            }

            $select_cust = "SELECT user_image, user_name FROM users WHERE user_id = '$customer'";

            $customer_query = mysqli_query($connection, $select_cust);

            

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

                    if ($buyer_id != 10) {
                        $buyer_budget = $selected_buyer['buyers_budget'];
                    }
                    else {
                        $buyer_budget = 0;
                    }

                }

                else {

                    die('Bunday buyer topilmadi');

                }

            }



            if (!$customer_query) {

               die("Topilmadi bunday user");

            } 

            else {

                $result = mysqli_fetch_assoc($customer_query);

                $customer_img = $result['user_image'];

                $customer_name = $result['user_name'];

            }

        }

        else {

            die ("Bunday bildirishnoma topilmadi");



        }

    }

    else {

        header("Location: index.php");

    }

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="robots" content="noindex, nofollow" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="description" content="Compass Group Admin Panel" />

    <link rel="icon" href="assets/images/favicon.ico">

    <title>Tasdiqlash sahifasi</title>

    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">

    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/css/neon-core.css">

    <link rel="stylesheet" href="assets/css/neon-theme.css">

    <link rel="stylesheet" href="assets/css/neon-forms.css">

    <link rel="stylesheet" href="assets/css/custom.css">

    <script src="assets/js/jquery-1.11.3.min.js"></script>

</head>

    <body class="page-body">

        <div class="page-container">

            <?php require_once 'addincludes/sidebar.php'; ?>

            <?php require_once 'addincludes/userinfo.php'; ?>

            <?php  if ($session_role !== 'Admin') { $_SESSION['xabar'] = 'xato'; header("Location:index.php"); } ?>

            <h2 class="title text-center"><?php echo $buyer_name; ?></h2>

            <br>

            <div class="member-entry" style="margin-bottom: 20px;">

                

                <a href="#" class="member-img">

                    <img src="assets/images/<?php echo $customer_img; ?>" class="img-rounded">

                    <i class="entypo-forward"></i>

                </a>

                

                <div class="member-details">

                    <h4>

                    <a href="#"><?php echo $customer_name; ?></a>

                    </h4>

                    

                    <!-- Details with Icons -->

                    <div class="row info-list">

                        

                        <div class="col-sm-4">

                            <i class="entypo-basket"></i>

                            <?php 

                                if ($storage == 1) {

                                    echo "Podval";

                                }

                                elseif ($storage == 3) {

                                    echo "2-Qavat";

                                }

                            ?>

                        </div>

                        

                        <div class="col-sm-4">

                            <i class="entypo-user"></i>

                            <?php echo $client; ?>

                        </div>

                        

                        <div class="col-sm-4">

                            <i class="entypo-clock"></i>

                            <strong><?php echo $time; ?></strong>

                        </div>



                        <div class="col-sm-12">

                            <br>

                            <?php echo $notdesc;?> <br>

                            Telefon: <?php echo $client_number; ?>

                        </div>

                        <div class="clear"></div>

                    </div>

                </div>

            </div>

        <form onkeypress="return event.keyCode != 13;" action="accept_form_logic.php" method="POST">
        <input type="hidden" name="buyer_id" value="<?php echo $buyer_id; ?>">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Maxsulot va xizmat</th>

                        <th>Narxi</th>

                        <th>Soni</th>

                        <th>Umumiy Narxi</th>

                    </tr>            

                </thead>

                <tbody>

                    <?php 

                        $counter = 0;

                        $summa=0;

                        $notifdt = "SELECT * FROM accept_notifications_details WHERE notification_id = '$notid'";

                        $notid_query = mysqli_query($connection, $notifdt);

                        if (!$notid_query) {

                            die("Die when reload extra informations from database");

                        }

                        else {

                            while ($notification_details = mysqli_fetch_assoc($notid_query)) {

                                $isproduct = $notification_details['is_product'];

                                $product_id = $notification_details['product_id'];

                                $proquant = $notification_details['product_quantity'];

                                $oneprice = $notification_details['product_price'];

                            ?>

                             <tr>

                                <td>

                                    <?php 

                                        if ($isproduct == 1) {

                                            $buprotmp = "SELECT product_name FROM products WHERE product_id = '$product_id'";

                                            $buprorsl = mysqli_query($connection, $buprotmp);

                                            $bupro = mysqli_fetch_array($buprorsl);

                                            $proname = $bupro['product_name'];



                                        }

                                        elseif ($isproduct == 0) {

                                            $busrvtmp = "SELECT service_name FROM services WHERE service_id = '$product_id'";

                                            $busrvrsl = mysqli_query($connection, $busrvtmp);

                                            $buserv = mysqli_fetch_array($busrvrsl);

                                            $proname = $buserv['service_name'];

                                        }

                                    $summa+=$proquant*$oneprice;

                                     ?>

                                    <input class="form-control" name="name" type="text" value="<?php echo $proname;?>" readonly>

                                    <input type="number" name="accept[<?php echo $counter;?>][isProduct]" hidden value="<?php echo $isproduct;?>">

                                    <input type="number" name="accept[<?php echo $counter;?>][prodId]" hidden value="<?php echo $product_id;?>">



                                    <input type="number" name="storage_number" hidden value="<?php echo $storage;?>">

                                    <input type="number" name="customer" hidden value="<?php echo $customer;?>">

                                    <input type="text" name="client_name" hidden value="<?php echo $client;?>">

                                    <input type="text" name="client_desc" hidden value="<?php echo $notdesc;?>">

                                    <input type="text" name="client_number" hidden value="<?php echo $client_number;?>">

                                    <input type="number" name="notification_id" hidden value="<?php echo $notid;?>">

                                </td>

                                <td><input id="price_<? echo $counter+1; ?>"  onchange="realTime(value,<? echo $counter+1; ?>)"  onkeyup="realTime(value,<? echo $counter+1; ?>)" class="form-control" name="accept[<?php echo $counter;?>][oneprice]" min="0" type="number" value="<?php echo $oneprice;?>"></td>

                                <td><input class="form-control" id="num_<? echo $counter+1; ?>" name="accept[<?php echo $counter;?>][proquant]" type="number" value="<?php echo $proquant;?>" readonly></td>

                                <td><input class="form-control" id="total_<? echo $counter+1; ?>" name="accept[<?php echo $counter;?>][total]" type="number" value="<?php echo $proquant*$oneprice;?>" readonly></td>

                            </tr>

                           <?php $counter++; }

                        }

                     ?>

                </tbody>

                <tfoot>

                <script>
                    function realTime(value,id) {
                        var cheking1 = document.getElementById("org_type").value;
                        var summa_org = Number($('#org_summa').val());
                        if (cheking1 == '10'){
                            document.getElementById('total_' + id).value = Number(value) * Number(document.getElementById('num_' + id).value);
                            var k = Number(<? echo $counter; ?>);
                            var summa = 0;
                            for (var i = 1; i <= k; i++) {
                                summa += Number(document.getElementById('total_' + i).value);
                            }
                            document.getElementById('total').value = summa;
                            var summa1 = Number(document.getElementById('total').value);
                            var check = Number(document.getElementById('price1').value) + Number(document.getElementById('price2').value) + Number(document.getElementById('price3').value) + Number(document.getElementById('price4').value) + Number(document.getElementById('price5').value);
                            if (summa1 != check) {
                                document.getElementById('price1').value = summa;
                                document.getElementById('price2').value = 0;
                                document.getElementById('price3').value = 0;
                                document.getElementById('price4').value = 0;
                                document.getElementById('price5').value = 0;
                                document.getElementById('Div_price').style.display = "none";
                            }
                        }else{
                            document.getElementById('total_' + id).value = Number(value) * Number(document.getElementById('num_' + id).value);
                            var k = Number(<? echo $counter; ?>);
                            var summa = 0;
                            for (var i = 1; i <= k; i++) {
                                summa += Number(document.getElementById('total_' + i).value);
                            }
                            document.getElementById('total').value = summa;
                            var summa1 = Number(document.getElementById('total').value);
                            var check = Number(document.getElementById('price1').value) + Number(document.getElementById('price2').value) + Number(document.getElementById('price3').value) + Number(document.getElementById('price4').value) + Number(document.getElementById('price5').value);
                              if(summa_org>0 && summa>=summa_org){
                                  document.getElementById('price1').value = summa_org;
                                  document.getElementById('price4').value = summa-summa_org;

                              }else if(summa_org<0){
                                  document.getElementById('price1').value = 0;
                                  document.getElementById('price2').value = 0;
                                  document.getElementById('price3').value = 0;
                                  document.getElementById('price5').value = 0;
                                  document.getElementById('price4').value = summa;
                              }
                        }
                    }
                </script>

                    <tr>

                        <td colspan="3"><p class="pull-right">Jami narxi</p></td>

                        <td><input  class="form-control" id="total" type="number" name="total_amount" value="<? echo $summa; ?>" readonly></td>

                    </tr>

                </tfoot>

            </table>

<!--            php code-->

            <?

            include_once('../DB/functions.php');

            $func = new database_func();

            $num=0;

            $naqd=0;

            $plastik=0;

            $send=0;

            $qarz=0;

            $click=0;

            $sorov = "SELECT * FROM accept_notifications WHERE notification_id = '$notid'";

            $func->queryMysql($sorov);

            $row=$func->result->fetch_array(MYSQL_ASSOC);



            $payment_type=$row['payment_type'];

            //            echo $payment_type;

            $arrays = explode(",",$payment_type);

            for($j=0;$j<count($arrays);$j++){

                $array1 = explode("=>",$arrays[$j]);

                $payment_type_id1[$j]=$array1[0];

                $payment_type_value1[$j]=$array1[1];

                $payment_type = $payment_type_id1[$j];



                if ($payment_type == 1) {

                    $naqd +=$payment_type_value1[$j];

                }

                if ($payment_type == 2) {

                    $plastik +=$payment_type_value1[$j];

                }

                if ($payment_type == 3) {

                    $send +=$payment_type_value1[$j];

                }

                if ($payment_type == 4) {

                    $qarz+=$payment_type_value1[$j];

                }

                if ($payment_type == 5) {

                    $click+=$payment_type_value1[$j];

                }

            }

            ?>

            <div class="row"><hr>

          <!--   <h2 style="text-align: center;">Tulov haqida ma`lumot</h2> -->
        <?php if ($buyer_id != 10): ?>
            
            <div class="col-md-6">

                <div class="input-group pull-left">

                    <input readonly id="org_summa" value="<? echo $buyer_budget; ?>" type="text" class="form-control bold input-lg number" required>

                    <div class="input-group-addon dollar">Tashkilot balansi</div>

                </div>

            </div>

        <?php endif ?>

        <? if($buyer_id == 10) { ?>
            <input type="hidden" id="org_type" class="code form-control" value="10">
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6">

                <div class="input-group pull-left">

                    <input id="price1" value="<? echo $naqd; ?>" onkeyup="createKech(value)" type="text" class="form-control bold input-lg number" required name="prices1">

                    <div class="input-group-addon payment">Naqd</div>

                </div>

            </div>
            <div class="col-md-12" style="display: block;" id="Div_price">

                <br/>

                <table class="table prices">

                    <thead>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401180.svg" alt=""><br>

                        Terminal

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/721/721468.svg" alt=""><br>

                        Pul ko`chirish

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401134.svg" alt=""><br>

                        Click

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/579/579449.svg" alt=""><br>

                        Qarz

                    </th>

                    </thead>

                    <tbody>

                    <td><input id="price2" value="<? echo $plastik; ?>" onkeyup="checkPrice(value,1)" type="text" class="form-control bold input-lg number" name="prices2"></td>

                    <td><input id="price3" value="<? echo $send; ?>" onkeyup="checkPrice(value,2)" type="text" class="form-control bold input-lg number" name="prices3"></td>

                    <td><input id="price5" value="<? echo $click; ?>" onkeyup="checkPrice(value,3)" type="text" class="form-control bold input-lg number" name="prices5"></td>

                    <td><input id="price4" value="<? echo $qarz; ?>" type="text" class="form-control bold input-lg number" name="prices4" readonly></td>

                    </tbody>

                </table>

            </div>
        <? }else{ ?>
            <input type="hidden" id="org_type" class="code form-control" value="org"/>
            <div class="col-md-6">

                <div class="input-group pull-left">
                <? if($buyer_budget<=0){ ?>
                    <input id="price1" readonly value="<? echo $send; ?>" onkeyup="createKech(value)" type="text" class="form-control bold input-lg number" required name="prices3">
                <?}else{?>
                    <input id="price1"  value="<? echo $send; ?>" onkeyup="createKech(value)" type="text" class="form-control bold input-lg number" required name="prices3">
                <?}?>
                    <div class="input-group-addon payment">Pull ko`chirish</div>

                </div>

            </div>
            <div class="col-md-12" style="display: block;" id="Div_price">

                <br/>

                <table class="table prices">

                    <thead>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401180.svg" alt=""><br>

                        Terminal

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/721/721468.svg" alt=""><br>

                        Naqd

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/401/401134.svg" alt=""><br>

                        Click

                    </th>

                    <th>

                        <img class="payment_img" src="https://image.flaticon.com/icons/svg/579/579449.svg" alt=""><br>

                        Qarz

                    </th>

                    </thead>

                    <tbody>

                    <td><input id="price2" value="<? echo $plastik; ?>" onkeyup="checkPrice(value,1)" type="text" class="form-control bold input-lg number" name="prices2"></td>

                    <td><input id="price3" value="<? echo $naqd; ?>" onkeyup="checkPrice(value,2)" type="text" class="form-control bold input-lg number" name="prices1"></td>

                    <td><input id="price5" value="<? echo $click; ?>" onkeyup="checkPrice(value,3)" type="text" class="form-control bold input-lg number" name="prices5"></td>

                    <td><input id="price4" value="<? echo $qarz; ?>" type="text" class="form-control bold input-lg number" name="prices4" readonly></td>

                    </tbody>

                </table>

            </div>
        <? } ?>
            <div class="container">
                
                <div class="buttons pull-left">
                <br>
                <input type="submit" onClick="tasdiqlash(this);return false;" name="accept_the_form" class="btn btn-lg btn-success hidden-print" value="Tasdiqlash">&nbsp;

                <input onClick="tasdiqlash(this);return false;" type="submit" name="delete_notification" class="btn btn-lg btn-danger hidden-print" value="O'chirish"> 

                </div>

            </div>

            </div>

        </form>

        <hr>

        <!-- /Footercha -->

        <!-- Bu yerda xam skriptlar -->

        <?php require_once 'addincludes/footer.php'; ?>

        <?php require_once 'addincludes/scripts.php' ?>

        <!-- Imported styles on this page -->

        <!-- /Bu yerda xam skriptlar -->
        <script src="assets/js/pay_accept.js"></script>
		<!--        <script src="assets/js/pay1.js"></script>-->
        <script>
        function tasdiqlash(f) {
        if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
        f.submit();
        }
        </script>
    </body>

</html>