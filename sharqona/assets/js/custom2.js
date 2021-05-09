/********* Added by Lotus ********/

$(document).ready(function () {

    // *********************** PRODUCTS AREA *********************** //

    // ************************************************************* //

    // ======================== Clone Products Template ======================== //

    function findGetParameter(parameterName) {

        var result = null,

            tmp = [];

        var items = location.search.substr(1).split("&");

        for (var index = 0; index < items.length; index++) {

            tmp = items[index].split("=");

            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);

        }
        // alert(result);
        return result;

    }

    var oTable=document.getElementById('myTable');

    var length = Number(oTable.rows.length);

    var update_id = Number(findGetParameter('update'));
    // alert(update_id);
    var summ=0;

    var summ1=0;

    for(var k=1;k<length;k++) {

        var id = oTable.rows.item(k).cells.item(0).textContent;

        var is_product = oTable.rows.item(k).cells.item(6).textContent;

        var buyer_id = oTable.rows.item(k).cells.item(1).textContent;

        var ps_id = Number(oTable.rows.item(k).cells.item(3).textContent);

        var count = oTable.rows.item(k).cells.item(4).textContent;

        var one_price = oTable.rows.item(k).cells.item(5).textContent;



        if (update_id == id && is_product == 1) {

            // Define counter

            var i = $('#products').find('.row-item').length;

            // Define products template

            var prTemplate = $('#pr_template .pr-row').clone();

            // Add new product input form with dynamic attributes



            //$(document).ready(function () {

            if ($(this).closest('.item-table').find('.row-item').length) {

                if ($(this).closest('.item-table').find('.row-item:last select').val() == '')

                    return false;

            }

            // Increase counter by one

            i++;



            // Loop through each element

            prTemplate.clone()

                .find('.pr-row-num').each(function () {

                    // Update row number

                    $(this).html(i);



                }).end()

                .find('select').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;

                    this.value = ps_id;

                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;

                    $(this).select2({'width': '100%'});

                    //var vale=$(this).select2();

                }).end().find('#ID').each(function (){

                    // Update row number

                    this.id ="ID_"+i;

                }).end()

                .find('.pr-price input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;

                    this.value=one_price;

                    //alert(one_price);



                }).end()

                .find('.pr-quantity input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;



                    this.value = count;



                }).end()

                .find('.pr-total input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;



                }).end()

                .find('.pr-remove a').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name + i;

                    this.name = newName;



                }).end()

                .appendTo('#products table tbody');



            //$('button[name=confirm_outgoings]').prop('disabled', true);



            setTimeout(function () {

                // calculateByPrPriceOrQuantiry(e);

                // subtotal($(e.currentTarget));

            }, 100);

            // ======================== Calculation function ======================== //



            var pr_price = $("#pr_name"+i).find('option:selected').data('price');

            //alert(pr_price);

            var pr_left = $("#pr_name"+i).find('option:selected').data('left');

            var bar_code1 = $("#pr_name"+i).find(':selected').data('barcode1');

            //alert(bar_code1);

            if(bar_code1!="undefined"){

                var ID1 = $('#products').find('.row-item').length;

                if(ID1!=0){

                    document.getElementById("ID_" + ID1).value = bar_code1;

                }

            }

            var bar_code = $(this).find(':selected').data('barcode');

            if(bar_code!="undefined"){

                var ID2 = $('#services').find('.row-item').length;

                if(ID2!=0){

                    document.getElementById("ID__" + ID2).value = bar_code;

                }

            }



            const parentItem = $("#pr_name"+i).closest('.row-item');

            // Set product details' values

            parentItem.find('.item-price').val(one_price);

            if (parentItem.find('.item-left').length)

                parentItem.find('.item-left').text(pr_left);



            // Calculate total product price before changing quantity by hand

            var pr_quantity = parentItem.find('.item-quantity').val();

            var pr_total = one_price * pr_quantity;

            parentItem.find('.item-price').val(one_price);

            parentItem.find('.item-total').val(pr_total);

            //    /////////////////////////////////////////////////

            //    /////////////////////////////////////////////////.pr-quantity

            //    /////////////////////////////////////////////////.item-quantity

            //alert(pr_total);

            summ+=pr_total;

            document.getElementById("pr_subtotal").value=summ;

            //alert("Product "+one_price);

        }

        //function for products

        //////////////////////////////

        //////////////////////////////

        // Define counter

        var i = $('#products').find('.row-item').length;



        // Define products template

        var prTemplate = $('#pr_template .pr-row').clone();

        // Add new product input form with dynamic attributes

        $('body').on('click', '#pr_add', function (e) {

            if ($(this).closest('.item-table').find('.row-item').length) {

                if ($(this).closest('.item-table').find('.row-item:last select').val() == '')

                    return false;

            }

            // Increase counter by one

            var i = $('#products').find('.row-item').length;

            i++;

            //alert(i);

            // Loop through each element

            prTemplate.clone()

                .find('.pr-row-num').each(function () {



                    // Update row number

                    $(this).html(i);



                }).end()

                .find('select').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;

                    $(this).select2({'width': '100%'});



                }).end().find('#ID').each(function (){

                    // Update row number

                    this.id ="ID_"+i;

                }).end()

                .find('.pr-price input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;



                }).end()

                .find('.pr-quantity input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;



                }).end()

                .find('.pr-total input').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, i);

                    this.name = newName;



                }).end()

                .find('.pr-remove a').each(function () {



                    // Update ID

                    var newId = this.id + i;

                    this.id = newId;



                    // Update name

                    var newName = this.name + i;

                    this.name = newName;



                }).end()

                .appendTo('#products table tbody');



            $('button[name=confirm_outgoings]').prop('disabled', true);

            var value = document.getElementById("code").value;

        });



        $('body').on('change', '.item-quantity', function () {

            const parentItem = $(this).closest('.row-item');

            if (parentItem.find('select').val() != '') {

                if (parentItem.find('select option:selected').data('left') < $(this).val()) {

                    $(this).val(parentItem.find('select option:selected').data('left'));

                    return false;
                ////////////////////////////////////////////////////////////////

                ////////////////////////////////////////////////////////////////


                }

            }

        });
        //$('body').on('change','.item-quantity', function (e) {

        //});
        // $('body').on('keyup', '.item-price', function (e) {
        //         // calculateByPrPriceOrQuantiry(e);

                
        //     });
        $('body').on('change', '.item-select', function () {

            checkDisableGoButton();

        });



        function checkDisableGoButton() {

            var countEmpty = 0;

            $('.item-select').each(function () {

                if ($(this).val() == '') {

                    countEmpty++;

                }

            })



            if (countEmpty == 0) {

                $('button[name=confirm_outgoings]').prop('disabled', true);

            } else {

                $('button[name=confirm_outgoings]').prop('disabled', false);

            }

        }

        // ======================== Remove products on the form ======================== //

        $('#products').on('click', '.pr-remove a', function (e) {



            // Call calculation function

            removeItem(e);

            i--;



        });

        //////////////////////////////

        //////////////////////////////

        //function for products end



        // ======================== Clone Services Template ======================== //

        if (update_id == id && is_product == 0){

            // Define counter

            var j = $('#services').find('.row-item').length;



            // Define products template

            var srTemplate = $('#sr_template .sr-row').clone();

            // Add new product input form

            if ($(this).closest('.item-table').find('.row-item').length) {

                if ($(this).closest('.item-table').find('.row-item:last select').val() == '')

                    return false;

            }

            // Increase counter by one

            j++;



            // Loop through each element

            srTemplate.clone()

                .find('.sr-row-num').each(function () {



                    // Update row number

                    $(this).html(j);



                }).end().find('#ID_').each(function ()

                {

                    // Update row number

                    this.id ="ID__"+j;

                }).end()

                .find('select').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    this.value = ps_id;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;

                    $(this).select2({'width': '100%'});



                }).end()

                .find('option').each(function () {



                    //var options=$(this).data().price;

                    //alert(options);

                    // Update ID

                    //var pr_price = this.data-price;

                    //alert(pr_price);

                    // Update ID

                    var newId = this.id +"id_"+ j;

                    this.id = newId;

                    // Update name



                }).end()

                .find('.sr-price input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;

                    //this.value=12;

                    //alert(one_price);

                }).end()

                .find('.sr-quantity input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    this.value = count;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;



                }).end()

                .find('.sr-total input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;



                }).end()

                .find('.sr-remove a').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name + j;

                    this.name = newName;



                }).end()

                .appendTo('#services table tbody');



            //$('button[name=confirm_outgoings]').prop('disabled', true);

            // ======================== Detecting changes on the form ======================== //

            setTimeout(function () {

                calculateByPrPriceOrQuantiry(e);

                subtotal($(e.currentTarget));

            }, 100);

            // ======================== Calculation function ======================== //

            var pr_price = $("#sr_name"+j).find('option:selected').data('price');

            //alert(pr_price);

            var pr_left = $("#sr_name"+j).find('option:selected').data('left');



            var bar_code1 = $("#sr_name"+j).find('option:selected').data('barcode1');

            //alert(bar_code1);

            if(bar_code1!="undefined"){

                var ID1 = $('#products').find('.row-item').length;

                if(ID1!=0){

                    document.getElementById("ID_" + ID1).value = bar_code1;

                }

            }

            var bar_code = $("#sr_name"+j).find('option:selected').data('barcode');

            if(bar_code!="undefined"){

                var ID2 = $('#services').find('.row-item').length;

                if(ID2!=0){

                    document.getElementById("ID__" + ID2).value = bar_code;

                }

            }

            //alert(bar_code);

            const parentItem = $("#sr_name"+j).closest('.row-item');

            // Set product details' values

            parentItem.find('.item-price').val(one_price);

            if (parentItem.find('.item-left').length)

                parentItem.find('.item-left').text(pr_left);



            // Calculate total product price before changing quantity by hand

            var pr_quantity = parentItem.find('.item-quantity').val();

            var pr_total = one_price * pr_quantity;

            parentItem.find('.item-price').val(one_price);

            parentItem.find('.item-total').val(pr_total);

            summ1+=pr_total;

            document.getElementById("sr_subtotal").value=summ1;

            //alert("Service "+one_price);

        }

        var summ_all=summ + summ1;

        document.getElementById("total").value=summ_all;

        // Define counter

        var j = $('#services').find('.row-item').length;

        // Define products template

        var srTemplate = $('#sr_template .sr-row').clone();





        // Add new product input form

        $('body').on('click', '#sr_add', function (e) {

            if ($(this).closest('.item-table').find('.row-item').length) {

                if ($(this).closest('.item-table').find('.row-item:last select').val() == '')

                    return false;

            }

            var j = $('#services').find('.row-item').length;

            // Increase counter by one

            j++;



            // Loop through each element

            srTemplate.clone()

                .find('.sr-row-num').each(function () {



                    // Update row number

                    $(this).html(j);



                }).end()

                .find('select').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;

                    $(this).select2({'width': '100%'});



                }).end()

                .find('.sr-price input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;



                }).end()

                .find('.sr-quantity input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;



                }).end()

                .find('.sr-total input').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name.replace(/__i__/g, j);

                    this.name = newName;



                }).end()

                .find('.sr-remove a').each(function () {



                    // Update ID

                    var newId = this.id + j;

                    this.id = newId;



                    // Update name

                    var newName = this.name + j;

                    this.name = newName;



                }).end()

                .appendTo('#services table tbody');



            $('button[name=confirm_outgoings]').prop('disabled', true);

        });





        // ======================== Remove products on the form ======================== //

        $('#services').on('click', '.sr-remove a', function (e) {
            // Call calculation function
            removeItem(e);

            j--;



        });





        // ======================== Detecting changes on the form ======================== //

        $('body fieldset.servicefield').on('keyup', 'input, select', function (e) {

            // Call calculation function

            //alert("Salom");

            // Call subtotal function

            setTimeout(function () {
                subtotal($(e.currentTarget));

                calculateByPrPriceOrQuantiry(e);

            }, 100)

        });
        $('body fieldset.productsfield').on('keyup', 'input, select', function (e) {

            // Call calculation function

            //alert("Salom");

            // Call subtotal function

            setTimeout(function () {
                subtotal($(e.currentTarget));

                calculateByPrPriceOrQuantiry(e);

            }, 100)

        });




        // ======================== Calculation function ======================== //





        $('body').on('change', '.item-select', function (e) {



            var pr_price = $(this).find(':selected').data('price');

            var pr_left = $(this).find(':selected').data('left');

            const parentItem = $(this).closest('.row-item');

            // Set product details' values

            parentItem.find('.item-price').val(pr_price);

            if (parentItem.find('.item-left').length)

                parentItem.find('.item-left').text(pr_left);



            // Calculate total product price before changing quantity by hand

            var pr_quantity = parentItem.find('.item-quantity').val();

            var pr_total = pr_price * pr_quantity;

            parentItem.find('.item-price').val(pr_total);
            parentItem.find('.item-total').val(pr_total);
            var totalService1=0;
            var totalProduct1=0;
            var total1=0;
            var prodLength = $('#products').find('.row-item').length;
            for (var i=1;i<=prodLength;i++) {
                totalProduct1+=Number(document.getElementById("pr_price"+i).value)*Number(document.getElementById("pr_quantity"+i).value);
                document.getElementById("pr_total"+i).value=Number(document.getElementById("pr_price"+i).value)*Number(document.getElementById("pr_quantity"+i).value);
            }

            var servLength = $('#services').find('.row-item').length;
            for (var i=1;i<=servLength;i++) {
                totalService1+=Number(document.getElementById("sr_price"+i).value)*Number(document.getElementById("sr_quantity"+i).value);
                document.getElementById("sr_total"+i).value=Number(document.getElementById("sr_price"+i).value)*Number(document.getElementById("sr_quantity"+i).value);
            }
            document.getElementById('sr_subtotal').value=totalService1;
            document.getElementById('pr_subtotal').value=totalProduct1;
            total1 = totalService1 + totalProduct1;
            var checking2 = document.getElementById("org_type").value;
            if(checking2=='org') {
                var org_summa = Number(document.getElementById("org_summa").value);

                document.getElementById("price2").value = 0;
                document.getElementById("price3").value = 0;
                document.getElementById("price5").value = 0;
                document.getElementById("sr_subtotal").value = totalService1;
                document.getElementById("pr_subtotal").value = totalProduct1;
                document.getElementById("total").value = total1;
                // alert(prodLength+"<>"+servLength);

                if (org_summa >= total1 && org_summa > 0) {
                    document.getElementById("price1").value = total1;
                    document.getElementById("price4").value = 0;
                } else if (org_summa < total1 && org_summa > 0) {
                    document.getElementById("price1").value = org_summa;
                    document.getElementById("price4").value = total1 - org_summa;
                } else if (org_summa <= 0) {
                    document.getElementById("price1").value = 0;
                    document.getElementById("price4").value = total1;
                }
                document.getElementById("Div_price").style.display = "block";

                // Now calculate subtotal

                // text += "<br>The number is " + i;item-total
            }else{
                document.getElementById("price1").value = total1;
                document.getElementById("total").value = total1;
                document.getElementById("price2").value = 0;
                document.getElementById("price3").value = 0;
                document.getElementById("price5").value = 0;
                document.getElementById("price4").value = 0;
                document.getElementById("Div_price").style.display = "none";
            }

        });
        


        // Calculate when changes product price or quantity

        function calculateByPrPriceOrQuantiry(e) {
            // console.log(e.currentTarget);calculateByPrPriceOrQuantiry
            var element = e.currentTarget;
            // console.log(element);
            var itemParent = $(element).closest('.row-item');
            var pr_quantity = itemParent.find("input.item-quantity").val();
            // console.log('Quantity ' + pr_quantity);
            var pr_price = itemParent.find("input.item-price").val();
            // console.log('Price: ' +  pr_price);
            var pr_total = pr_price * pr_quantity;
            // console.log(pr_total);
            itemParent.find(".item-total").val(pr_total);
            var bar_code1 = $(element).find(':selected').data('barcode1');
            if(bar_code1!="undefined"){
                var ID1 = $('#products').find('.row-item').length;
                if(ID1!=0){
                    document.getElementById("ID_" + ID1).value = bar_code1;
                }
            }
            var bar_code = $(element).find(':selected').data('barcode');

            if(bar_code!="undefined"){

                var ID = $('#services').find('.row-item').length;

                document.getElementById("ID_").id="ID__"+ID;

                if(ID!=0){

                    document.getElementById("ID__" + ID).value = bar_code;

                }

            }

        }

        // copy start

        // copy end

        // Calculate subtotal

        function subtotal(element) {
            var pr_subtotal = 0;
            element.closest('.item-table').find('input.item-total').each(function () {
                if ($(this).val() != '')
                    pr_subtotal = pr_subtotal + parseInt($(this).val());
            });
            element.closest('.item-table').find('.subtotal').val(pr_subtotal);

            calSumTotal();

        }



        var num=0;

        var arrays=[];

        function calSumTotal(){

            var total = 0;

            $('.subtotal').each(function () {

                if ($(this).val() != '')

                    total = total + parseInt($(this).val());

            })
                // alert(total);
            var check1 = document.getElementById("price1").value;

            var check2 = document.getElementById("price2").value;

            var check3 = document.getElementById("price3").value;

            var check4 = document.getElementById("price4").value;

            var check5 = document.getElementById("price5").value;

            $('#total').val(total);

            if(check1==""){

                check1=0;

            }else{

                check1 = Number(document.getElementById("price1").value);

            }

            if(check2==""){

                check2=0;

            }else {

                check2 = Number(document.getElementById("price2").value);

            }

            if(check3==""){

                check3=0;

            }else {

                check3 = Number(document.getElementById("price3").value);

            }

            if(check4==""){

                check4=0;

            }else {

                check4 = Number(document.getElementById("price4").value);

            }

            if(check5==""){

                check5=0;

            }else {

                check5 = Number(document.getElementById("price5").value);

            }

            var checkAll = check1+check2+check3+check4+check5;
            var orgSumma = Number(document.getElementById("org_summa").value);
            //alert(orgSumma+"-"+total);
            if(check1==0 || total!=checkAll){
                    $('#price1').val(total);
                num++;


                var cheking1 = document.getElementById("org_type").value;
                if(cheking1=='10'){
                    document.getElementById("price2").value = 0;
                    document.getElementById("price3").value = 0;
                    document.getElementById("price4").value = 0;
                    document.getElementById("price5").value = 0;
                    document.getElementById("Div_price").style.display = "none";
                }else{
                            var total=0;
                            var totalService=0;
                            var totalProduct=0;
                            var prodLength = $('#products').find('.row-item').length;
                            for (var i=1;i<=prodLength;i++) {
                                totalProduct+=Number(document.getElementById("pr_price"+i).value)*Number(document.getElementById("pr_quantity"+i).value);
                                document.getElementById("pr_total"+i).value=Number(document.getElementById("pr_price"+i).value)*Number(document.getElementById("pr_quantity"+i).value);
                            }

                            var servLength = $('#services').find('.row-item').length;
                            for (var i=1;i<=servLength;i++) {
                                totalService+=Number(document.getElementById("sr_price"+i).value)*Number(document.getElementById("sr_quantity"+i).value);
                                document.getElementById("sr_total"+i).value=Number(document.getElementById("sr_price"+i).value)*Number(document.getElementById("sr_quantity"+i).value);
                            }
                            total = totalService + totalProduct;
                            var org_summa = Number(document.getElementById("org_summa").value);

                            document.getElementById("price2").value=0;
                            document.getElementById("price3").value=0;
                            document.getElementById("price5").value=0;
                            document.getElementById("sr_subtotal").value=totalService;
                            document.getElementById("pr_subtotal").value=totalProduct;
                            document.getElementById("total").value=total;
                            // alert(prodLength+"<>"+servLength);

                            if(org_summa>=total && org_summa>0){
                                document.getElementById("price1").value = total;
                                document.getElementById("price4").value = 0;
                            }else if(org_summa<total && org_summa>0){
                                document.getElementById("price1").value = org_summa;
                                document.getElementById("price4").value = total-org_summa;
                            }else if(org_summa<=0){
                                document.getElementById("price1").value = 0;
                                document.getElementById("price4").value = total;
                            }
                            document.getElementById("Div_price").style.display = "block";
                }
            }

        }





        // Remove product row

        function removeItem(e) {

            var element = e.currentTarget;

            const otherE = $(element).closest('.item-table').find('.subtotal');
            items();


            $(element).closest('tr').remove();



            setTimeout(function () {

                subtotal(otherE);

            }, 100);



            checkDisableGoButton();



        }



    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



});

