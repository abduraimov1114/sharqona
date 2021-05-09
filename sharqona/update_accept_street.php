<?php require_once('street_accept_start.php'); ?>
    <!-- Shu yerdan asosiy conternt -->
    <?php error_reporting(E_ALL); ?>
    <?php 
        if (isset($_GET['update'])) {
            $update = $_GET['update'];
            $update_number = mysqli_real_escape_string($connection, $update);
            // Husan Og'a mana sherdan bosing______________________________________________________________________________
        }
        else {
            $_SESSION['xabar'] = 'xato';
            header("Location: index.php");
        }
    ?> 
    <div style="display:none;">
        <?
            include_once("../sklad/index.php");
        ?>
    </div>
<form role="form" method="post" onkeypress="return event.keyCode != 13;" action="street_accept_logic.php" class="form-horizontal form-groups-bordered order">
    <input type="number" readonly name="storage_number" value="<?php echo $storage_number; ?>" hidden>
    <input type="hidden" name="saveId" value="<? echo $update_number; ?>">
    <ol class="breadcrumb hidden-print">
        <li><a href="#">Savdo - sotiq</a></li>
        <li><a href="#">Ko'cha</a></li>
    </ol>
    <br>
    <div class="row hidden-print">
        <h2 class="text-center"><?php echo "Jismoniy shaxslar (Ko'cha)"; ?></h2>
       <?
    $sorov="select * from saved INNER JOIN buyers ON buyers.buyers_id=saved.buyer_id WHERE buyer_id=10 AND saved_id=".$_GET['update'];
    $func->queryMysql($sorov);
    $row=$func->result->fetch_array(MYSQL_ASSOC);
    ?>
    <?
    if(isset($_GET['update']) && !empty($_GET['update']) && $row['saved_times']!=1){
    ?>
    <h3 class="text-center tabel">Tabel №: <? echo $row['buyer_id']."-".$row['saved_times']; ?></h3>
    <?}else{?>
    <h3 class="text-center tabel">Tabel №: <? echo 10; ?></h3>
    <?}?>
    <br>
    <?
                $sorov="select * from saved INNER JOIN buyers ON buyers.buyers_id=saved.buyer_id WHERE saved_id=".$_GET['update'];
                $func->queryMysql($sorov);
                $row=$func->result->fetch_array(MYSQL_ASSOC);
            ?>
        <div class="col-sm-6">
            <input id="user_name"  class="form-control" value="<? echo $row['user_name']; ?>" type="text" name="user_name" placeholder="Ismi.."/>
        </div>
        <div class="col-sm-6">
            <input class="form-control" type="text" value="<? echo $row['tell_num']; ?>" name="tell_num" placeholder="Telefon nomer.."/>
        </div>
        <div class="clearfix"></div><br>
        <div class="col-md-12">
            <textarea rows="3" class="form-control"  id="field-ta" type="text" name="desc" placeholder="Qabul qilingan maxsulotlar.."><? echo $row['saved_desc']; ?></textarea>
        </div>
    </div><br>
    <!-- Start Services Rows -->
    <fieldset for="services" id="services" class="servicefield">
        <legend class="hidden-print servicelegend" onclick="Xcode(1)">Xizmatlar</legend>
        <div class="table-responsive">
            <!--      autofocus-->
            <input type="text" placeholder="Scan barcode here..." onkeypress="autoCode1(value)" value="" id="code1" class="code form-control">
            <table class="table sr-table item-table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-sm-1">#</th>
                        <th class="col-sm-4">Ismi</th>
                        <th class="col-sm-2">Narxi</th>
                        <th class="col-sm-2">Soni</th>
                        <th class="col-sm-2">Qiymati</th>
                        <th class="col-sm-1 hidden-print">-</th>
                    </tr>
                </thead>
            <tbody></tbody>
            <tfoot>
            <tr class="hidden-print">
                <td colspan="3">
                    <div class="input-group pull-left">
                        <a href="#" onclick="return false;" id="sr_add" class="btn btn-success btn-lg btn-icon icon-left">
                            Xizmat qo'shish
                        <i class="entypo-plus-squared"></i></a>
                    </div>
                </td>
                <td colspan="3">
                  <div class="input-group pull-right">
                    <input id="sr_subtotal" type="number" class="form-control input-lg bold subtotal" name="service[subtotal]" disabled>
                    <div class="input-group-addon servicecolor">Xizmatlar qiymati:</div>
                  </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    </fieldset><!-- End Services Row -->
    <!-- Start Products Rows -->
    <fieldset for="products" id="products" class="productsfield">
        <legend class="hidden-print productlegend" onclick="Xcode(2)">Mahsulotlar</legend>
        <div class="table-responsive">
            <!--      autofocus-->
            <input placeholder="Scan barcode here..." type="text" onkeypress="autoCode(value)" value="" style="margin: 0 0 5px 0;display: none;" id="code" class="code form-control"/>
            <table class="table pr-table item-table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-sm-1">#</th>
                        <th class="col-sm-4">Ismi</th>
                        <th class="col-sm-2">Narxi</th>
                        <th class="col-sm-2">Soni</th>
                        <th class="col-sm-2">Qiymati</th>
                        <th class="col-sm-1 hidden-print">-</th>
                    </tr>
                </thead>
            <tbody></tbody>
            <tfoot>
            <tr class="hidden-print">
                <td colspan="3">
                    <div class="input-group pull-left">
                        <a href="#" onclick="return false;" id="pr_add" class="btn btn-info btn-lg btn-icon icon-left">
                            Mahsulot qo'shish
                        <i class="entypo-plus-squared"></i></a>
                    </div>
                </td>
                <td colspan="3">
                  <div class="input-group pull-right">
                    <input id="pr_subtotal" type="number" class="form-control input-lg bold subtotal" name="product[subtotal]" disabled>
                    <div class="input-group-addon productcolor">Mahsulotlar qiymati:</div>
                  </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    </fieldset><!-- End Products Row -->
    <?
                $num=0;
                $naqd=0;
                $plastik=0;
                $send=0;
                $qarz=0;
                $click=0;
                $sorov = "select * from saved WHERE saved_id=".$_GET['update'];
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
    <div class="row">
        <div class="col-md-6">
            <div class="input-group pull-left">
              <input id="total"  type="number" class="form-control bold input-lg number" name="total" readonly>
              <div class="input-group-addon dollar">Umumiy qiymat:</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group pull-right">
                <input id="price1" value="<? echo $naqd; ?>" onkeyup="createKech(value)" onfocus="checkInput()" type="number" class="form-control bold input-lg" required name="prices1">
                <div class="input-group-addon payment">Naqd pul</div>
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
                        Pul ko`chirish</th>
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
                    <td><input id="price2" value="<? echo $plastik; ?>"  onkeyup="checkPrice(value,1)" type="number" class="form-control bold input-lg number" name="prices2"></td>
                    <td><input id="price3" value="<? echo $send; ?>"  onkeyup="checkPrice(value,2)" type="number" class="form-control bold input-lg number" name="prices3"></td>
                    <td><input id="price5" value="<? echo $click; ?>"  onkeyup="checkPrice(value,3)" type="number" class="form-control bold input-lg number" name="prices5"></td>
                    <td><input id="price4" value="<? echo $qarz; ?>" type="number" class="form-control bold input-lg number" name="prices4" readonly></td>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="reset" id="reset" value="<? echo $_GET['update'] ?>">        
        <div class="clearfix hidden-print"></div><br><br>
        <?php if ($session_role == 'Master'): ?>
            <div class="col-md-12 hidden-print">
                <button onClick="deleteqilish(this);return false;" type="submit" id="savdo" name="confirm_for_accept" class="btn btn-lg btn-success hidden-print">
                    Tasdiqlashga
                </button>
                <a href="index.php" class="btn btn-danger btn-lg hidden-print">
                    Orqaga qaytish
                </a>
                <button id="saqlash" class="btn btn-blue btn-lg hidden-print" name="save" value="<? echo $storage_number; ?>">
                    Saqlash
                </button>
                <br>
            </div>
        <?php endif ?>

        <script>
        function deleteqilish(f) {
        if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
        f.submit();
        }
        </script>
    </div>
</form>
                                                                            <!-- Products Templates -->
<div id="pr_template" style="display: none;">
    <table id="prod_div">
        <tr class="pr-row row-item">
            <td class="pr-row-num"></td>
            <!--      <td>-->
            <input type="hidden" value="" id="ID" class="code form-control"/>
            <input type="hidden" id="org_type" class="code form-control" value="10"/>
            <!--      </td>-->
            <td>
                <select id="pr_name" name="product[__i__][name]" class="form-control bold input-md pr-name item-select">
                    <option value="">- TANLANG! -</option>
                    <?php
                    $query = "SELECT * FROM products WHERE product_id in (SELECT product_id FROM master_storage WHERE product_quantity > 0 AND storage_id = '$storage_number')";
                    $proquery = mysqli_query($connection, $query);
                    if (!$proquery) {
                    die ("Mahsulot ismini zaprosida xatolik");
                    }
                    while ($row = mysqli_fetch_assoc($proquery)) {
                    $barcode = $row['product_barcode'];
                    $maxsulot_id = $row['product_id'];
                    $maxsulot_ismi = $row['product_name'];
                    $maxsulot_sotish_narxi = $row['product_prise_out'];
                    $maxsulot_sotish_narxi = $maxsulot_sotish_narxi * $sum;
                    $maxsulot_sotish_narxi = round($maxsulot_sotish_narxi, -2);
                    $soniuchun = "SELECT product_quantity FROM master_storage WHERE product_id = '$maxsulot_id' AND storage_id = '$storage_number'";
                    $soniuchun_query = mysqli_query($connection, $soniuchun);
                    $soni = mysqli_fetch_array($soniuchun_query);
                    $maxsulot_skladdagi_soni = $soni['product_quantity'];
                    ?>
                    <option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <div class="input-group pr-price">
                    <input id="pr_price" type="number" min="0" step="any" name="product[__i__][price]" class="form-control bold input-lg pr-price item-price" value="0">
                </div>
            </td>
            <td>
                <div class="input-group pr-quantity">
                    <input id="pr_quantity" type="number" min="1" name="product[__i__][quantity]" class="form-control bold input-lg pr-quantity item-quantity"  value="1">
                </div>
                <div class="hidden-print"><span class="badge storageinfo1 badge-roundless">Omborda:</span><span id="pr_left" class="badge badge-info badge-roundless storageinfo2 item-left"></span>
                </div>
            </td>
            <td>
                <div class="input-group pr-total">
                    <input id="pr_total" type="number" name="product[__i__][total]" class="form-control bold input-lg pr-total sub-total item-total" value="0" disabled>
                </div>
            </td>
            <td class="pr-remove hidden-print"><a href="#" onclick="return false;" id="btn_pr_remove" name="btn_pr_remove" class="btn btn-default btn-lg"><i class="entypo-trash"></i></a></td>
        </tr>
    </table>
</div>
                                                                                <!-- Services Templates -->
<div id="sr_template" style="display: none;">
    <table>
        <tr class="sr-row row-item">
            <td class="sr-row-num"></td>
            <input type="hidden" value="" id="ID_" class="code form-control"/>
            <td>
                <select id="sr_name" name="service[__i__][name]" class="form-control bold input-md sr-name item-select">
                    <option value="">- TANLANG! -</option>
                    <?php
                    $query = "SELECT * FROM services WHERE service_pro_id in (SELECT product_id FROM master_storage WHERE product_quantity > 0 AND storage_id = '$storage_number') UNION SELECT * FROM services WHERE service_pro_id = 0";
                    $serquery = mysqli_query($connection, $query);
                    if (!$serquery) {
                    die ("Xizmat ismini zaprosida xatolik");
                    }
                    while ($row = mysqli_fetch_assoc($serquery)) {
                    $xizmat_id = $row['service_id'];
                    $xizmat_ismi = $row['service_name'];
                    $barcode1 = $row['service_barcode'];
                    $xizmat_narxi = $row['service_street_price'];
                    $xizmatga_ketadigan_mahsulot = $row['service_pro_id'];
                    if ($xizmatga_ketadigan_mahsulot == 0) {
                    $xizmatga_ketadigan_mahsulotni_skladdagi_soni = 'Not need';
                    }
                    else {
                        $querymax = "SELECT product_quantity FROM master_storage WHERE product_id = '$xizmatga_ketadigan_mahsulot' AND storage_id = '$storage_number'";
                        $resultquerymax = mysqli_query($connection, $querymax);
                            while ($row = mysqli_fetch_array($resultquerymax)) {
                                $xizmatga_ketadigan_mahsulotni_skladdagi_soni = $row['product_quantity'];
                            }
                    }
                    ?>
                    <option value="<?php echo $xizmat_id; ?>" data-barcode="<?php echo $barcode1; ?>" data-price="<?php echo $xizmat_narxi; ?>" data-left="<?php echo $xizmatga_ketadigan_mahsulotni_skladdagi_soni; ?>"><?php echo $xizmat_ismi; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <div class="input-group sr-price">
                    <input id="sr_price" type="number" min="0" step="any" name="service[__i__][price]" class="form-control input-lg bold sr-price item-price" value="0">
                </div>
            </td>
            <td>
                <div class="input-group sr-quantity">
                    <input id="sr_quantity" type="number" min="1" name="service[__i__][quantity]" class="form-control bold input-lg sr-quantity item-quantity"  value="1">
                </div>
                <div class="hidden-print"><span class="badge storageinfo1 badge-roundless">Omborda:</span><span id="sr_left" class="badge storageinfo2 badge-success badge-roundless item-left"></span></div>
            </td>
            <td>
                <div class="input-group sr-total">
                    <input id="sr_total" type="number" class="form-control input-lg bold item-total" name="service[__i__][total]" value="0" disabled>
                </div>
            </td>
            <td class="sr-remove hidden-print"><a href="#" onclick="return false;" id="btn_sr_remove" name="btn_sr_remove" class="btn btn-lg btn-default"><i class="entypo-trash"></i></a></td>
        </tr>
    </table>
</div>

<script>
         $("#saqlash").click(function(){
             $("#user_name").attr('required', '');
             })
         $("#savdo").click(function(){
             $("#user_name").removeAttr("required");
             })
 </script>

    <!-- /Shu yerdan asosiy conternt -->
<?php require_once('update_street_accept_end.php'); ?>