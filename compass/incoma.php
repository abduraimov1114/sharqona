<?php require_once 'addincludes/head.php' ?>
<style>
  .income_price::-webkit-outer-spin-button,
  .income_price::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>
</head>
<body class="page-body" data-url="http://neon.dev">
<div class="page-container">

  <?php require_once 'addincludes/sidebar.php'; ?>
  <?php require_once 'addincludes/userinfo.php'; ?>

  <script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
      var $table3 = jQuery("#table-3");

      var table3 = $table3.DataTable( {
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      } );

      // Initalize Select Dropdown after DataTables is created
      $table3.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
        minimumResultsForSearch: -1
      });
    } );
  </script>

  <form role="form" method="post" onkeypress="return event.keyCode != 13;" action="incoma_logic.php" class="form-horizontal form-groups-bordered order">
        <input type="hidden" value="incoming" id="type_comming" class="code form-control">
        <ol class="breadcrumb hidden-print">
          <li><a href="#">Mahsulot</a></li>
          <li><a href="#">Kirimi</a></li>

          <input type="hidden" id="dollar" value="<? echo $sum; ?>"/>
        </ol>
        <br>
		
        <!-- Start Products Rows -->
        <fieldset for="products" id="products">
          <legend class="hidden-print">Mahsulotlar</legend>
          <div class="table-responsive">
            <!--      autofocus-->
            <input placeholder="Scan barcode here..." autofocus autocomplete="off" type="text" onkeypress="autoCode(value)" value="" style="display: block;margin: 0 0 5px 0;" id="code" class="code form-control"/>
            <table class="table pr-table item-table table-bordered table-striped">
              <thead>
              <tr>
                <th>#</th>
                <th class="col-sm-3">Mahsulot</th>
                <th class="col-sm-2">Kelish Narxi</th>
                <th class="col-sm-2">Sotish Narxi</th>
                <th class="col-sm-2">Soni</th>
                <th class="col-sm-2">Jami</th>
                <th class="hidden-print">-</th>
              </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
              <tr class="hidden-print">
                <td colspan="7">
                  <div class="input-group pull-left">
                    <a href="#" onclick="return false;" id="pr_add" class="btn btn-default btn-icon icon-left">
                      Mahsulot qo'shish
                      <i class="entypo-plus-squared"></i>
                    </a>
                    <input id="pr_subtotal" type="hidden" class="form-control input-md subtotal" name="product[subtotal]" disabled>
                  </div>
                </td>
              </tr>
              </tfoot>
            </table>
          </div>
        </fieldset><!-- End Products Row -->
        <div class="row">
          <div class="col-md-4">
            <div class="input-group pull-left hidden-print">
              <input type="date" class="form-control" data-validate="required" name="date">
              <div class="input-group-addon">
                <a href="#"><i class="entypo-calendar"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
          	<!-- <div class="label label-danger">Qayedan</div> -->
          	<select name="vendor" id="select" class="form-control" required>
          		<option value=""><strong>Sotuvchini tanlang..</strong></option>
          		<option value="1"><strong>JAHON AKA</strong></option>
          		<option value="2"><strong>XON</strong></option>
          		<option value="3"><strong>TOSHKENT BOZORI</strong></option>
          		<option value="4"><strong>NAVOIY BOZORI</strong></option>
          	</select>
          </div>
          <div class="col-md-4">
            <div class="input-group pull-left">
              <div class="input-group-addon dollar">Umumiy qiymat:</div>
              <input id="total" type="text" class="form-control input-md number" name="total" readonly>
              <div class="input-group-addon">$</div>
            </div>
            <div class="input-group pull-left marginostop">
              <div class="input-group-addon sum">Umumiy qiymat:</div>
              <input type="text" class="form-control input-md number" id="total_sums" name="total_sums" readonly>
              <div class="input-group-addon">S</div>
            </div>
          </div>
          <div class="clearfix hidden-print"></div><br><br>
          <div class="col-md-12 hidden-print">
            <button onClick="deleteqilish(this);return false;" type="submit" id="kirim" name="confirm_incoming" class="btn btn-primary btn-icon hidden-print">KIRIMNI AMALGA OSHIRISH<i class="entypo-check"></i></button>
            <a href="index.php" class="btn btn-danger btn-icon hidden-print">ORQAGA QAYTISH
              <i class="entypo-cancel"></i>
            </a>
          </div>
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
            <td class="pr-row-num verticam"></td>
            <!--      <td>-->
            <input type="hidden" value="" id="ID" class="code form-control"/>
            <!--      </td>-->
            <td id="verticam" class="verticam">
              <select id="pr_name" name="product[__i__][name]" class="form-control input-md pr-name item-select">
                <option value="">- TANLANG! -</option>
                <?php
                $query = "SELECT * FROM products";
                $proquery = mysqli_query($connection, $query);
                if (!$proquery) {
                  die ("Mahsulot ismini zaprosida xatolik");
                }
                while ($row = mysqli_fetch_assoc($proquery)) {
                  $barcode = $row['product_barcode'];
                  $maxsulot_id = $row['product_id'];
                  $maxsulot_ismi = $row['product_name'];
                  $maxsulot_skladdagi_soni = $row['product_count']; // Hozirda omborda
                  $maxsulot_sotish_narxi = $row['product_prise_in']; // Oldingi kelish narxi
                  $product_old_outprice = $row['product_prise_out']; // Oldingi sotish narxi 
                  ?>
                  <option value="<?php echo $maxsulot_id; ?>" data-barcode1="<?php echo $barcode; ?>" data-price="<?php echo $maxsulot_sotish_narxi; ?>" data-price_out="<?php echo $product_old_outprice; ?>" data-left="<?php echo $maxsulot_skladdagi_soni; ?>"><?php echo "$maxsulot_ismi"; ?></option>
                <?php } ?>
              </select>
            </td>
            <td>
              <div class="input-group pr-pricein">
                <div class="input-group-addon dollar">$</div>
                <input id="income_price" onkeyup="Test('$')" type="number" min="0.001" step="any" name="product[__i__][inprice]" class="form-control pr-price item-price income_price" required><br>
              </div>
              <div class="input-group marginostop">
                <div class="input-group-addon sum">S</div>
                <input class="inprice_sum form-control" onkeyup="Test('S')" id="inprice_sum" type="number" step="any" min="0.001" required>
              </div>
            </td>
            <td>
              <div class="input-group pr-priceout">
                <div class="input-group-addon dollar">$</div>
                <input id="outgoing_price" value="0" onkeyup="Test('SN')" type="number" step="any" min="0.001" name="product[__i__][outprice]" class="form-control pr-priceout">
              </div>
              <div class="input-group marginostop2">
                <div class="input-group-addon sum">S</div>
                <input class="outprice_sum form-control" id="outprice_sum" onkeyup="Test('NS')" type="number" step="any" min="0.001" value="0">
              </div>
            </td>
            <td>
              <div class="input-group pr-quantity">
                <input id="pr_quantity" type="number" onchange="Test('num')" onkeyup="Test('num')" min="1" name="product[__i__][quantity]" class="form-control pr-quantity item-quantity" value="0">
              </div>
              <div class="input-group marginostop3">
                <input class="storage_quantity form-control" id="storage_quantity" type="text" value="Hozirda omborda: " readonly>
              </div>
            </td>
            <td>
              <div class="input-group pr-total">
                <div class="input-group-addon dollar">$</div>
                <input id="pr_total" type="number" name="totallsum" class="form-control pr-total sub-total item-total" value="0" min="0" readonly>
              </div>
              <div class="input-group marginostop3">
                <div class="input-group-addon sum">S</div>
                <input class="pr_total_sum form-control" type="text" id="pr_total_sum" value="0" value="0" min="0" readonly>
              </div>
            </td>

            <td class="pr-remove hidden-print verticam">
              <a href="#" onclick="return false;" id="btn_pr_remove" name="btn_pr_remove" class="btn btn-red"><i class="entypo-trash"></i></a>
            </td>
          </tr>
        </table>
      </div>

      <script>
        function dollars(data){
          var dollar = Number(document.getElementById("dollar").value);
          var summa_dollar = 0;
          var summa_sums = 0;
          var k = Number($('#products').find('.row-item').length);
          if(data=="$") {
            for (var i = 1; i <= k; i++) {
              var count = Number(document.getElementById("pr_quantity_"+i).value);
//              Kelish narxi
              document.getElementById("inprice_sum_" + i).value = Number(document.getElementById("income_price" + i).value) * dollar;
//              total
              document.getElementById("pr_total" + i).value = document.getElementById("income_price" + i.value)*count;
              document.getElementById("pr_total_sum" + i).value = document.getElementById("income_price" + i).value*count*dollar;
//              sotilish narxi
              document.getElementById("outprice_sum_" + i).value = document.getElementById("outgoing_price_" + i).value *dollar;
              summa_dollar += Number($('#income_price' + i).val()) * Number($('#pr_quantity_' + i).val());
//                    sum total
              summa_sums += Number($('#income_price' + i).val()) * Number($('#pr_quantity_' + i).val()) * dollar;
            }
            document.getElementById("total").value = summa_dollar;
            document.getElementById("total_sums").value = summa_sums;
          }else if(data=="S"){
            for (var i = 1; i <= k; i++) {
              var count = Number(document.getElementById("pr_quantity_"+i).value);

              document.getElementById("income_price" + i).value = Math.ceil(Number(document.getElementById("inprice_sum_" + i).value)/dollar*100)/100;
              document.getElementById("pr_total" + i).value = (Math.ceil(Number(document.getElementById("inprice_sum_" + i).value)/dollar*100)/100)*count;
              document.getElementById("pr_total_sum" + i).value =Number(document.getElementById("inprice_sum_" + i).value)*count;
              summa_dollar += Number($('#income_price' + i).val()) * Number($('#pr_quantity_' + i).val());
//                    sum total
              summa_sums +=  Number($('#inprice_sum_' + i).val());
//              Math.ceil(num * 100) / 100
            }
            document.getElementById("total").value = summa_dollar;
            document.getElementById("total_sums").value = summa_sums;
          }else if(data=="SN"){
            for(var i = 1; i <= k; i++){
                var val_dollar = document.getElementById("outgoing_price_"+i).value;
                document.getElementById("outprice_sum_"+i).value=(Math.ceil(val_dollar*dollar*100)/100);
            }
          }else if(data=="NS"){
            for(var i = 1; i <= k; i++){
              document.getElementById("outgoing_price_"+i).value=(Math.ceil(Number(document.getElementById("outprice_sum_" + i).value)/dollar*100)/100);
            }
          }else if(data=="num"){
            var summa_dollar1 = 0;
            var summa_sums1 = 0;
            for(var i = 1; i <= k; i++){
              var dollarItem = document.getElementById("income_price"+i).value;
              var summItem = document.getElementById("inprice_sum_"+i).value;
              var num = document.getElementById("pr_quantity_"+i).value;
              document.getElementById("pr_total"+i).value=dollarItem*num;
              document.getElementById("pr_total_sum"+i).value=summItem*num;
              summa_dollar1+= dollarItem*num;
              summa_sums1+= summItem*num;
            }
            document.getElementById("total").value = summa_dollar1;
            document.getElementById("total_sums").value = summa_sums1;
          }

        }
        function Test(data){
              var k = Number($('#products').find('.row-item').length);
              var dollar = Number(document.getElementById("dollar").value);
              var summa_dollar = 0;
              var summa_sums = 0;
            if(data=="$") {
                dollars('$');
            }else if(data=="S"){
              dollars('S');
            }else if(data=="SN"){
              dollars("SN");
            }else if(data=="NS"){
              dollars("NS");
            }else if(data=="num"){
              dollars("num");
            }else{
              for (var i = 1; i <= k; i++) {
//                    dollar total
                summa_dollar += Number($('#income_price' + i).val()) * Number($('#pr_quantity_' + i).val());
//                    sum total
                summa_sums += Number($('#income_price' + i).val()) * Number($('#pr_quantity_' + i).val()) * dollar;
//                    change dollar
              }
              document.getElementById("total").value = summa_dollar;
              document.getElementById("total_sums").value = summa_sums;
//                alert(summa_sums);
            }
              }
      </script>
  <!-- Imported styles on this page -->
  <link rel="stylesheet" href="assets/js/datatables/datatables.css">
  <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
  <link rel="stylesheet" href="assets/js/select2/select2.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <!-- Imported scripts on this page -->
  <script src="assets/js/datatables/datatables.js"></script>
  <script src="assets/js/neon-chat.js"></script>
<!--  <script src="assets/js/custom.js"></script>-->
  <script src="assets/js/custom5.js"></script>
  <script src="assets/js/select2/select2.min.js"></script>
    <!-- /Shu yerdan asosiy conternt -->
    <!-- Footercha -->
        <br />
        <footer class="main">
          &copy; 2020 <strong>Compass Group</strong> All Rights Reserved
        </footer>
      </div>
    <!-- /Footercha -->

    <!-- Scripts -->

    <!-- Scripts -->
</body>
</html>