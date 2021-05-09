/********* Added by Lotus ********/
$(document).ready(function () {
    
    //function autoCode(data){
    //    alert(data);
    //}
    // *********************** PRODUCTS AREA *********************** //
    // ************************************************************* //
    // ======================== Clone Products Template ======================== //
    // Define counter

    // Define products template
    var prTemplate = $('#pr_template .pr-row').clone();


    // Add new product input form with dynamic attributes
    $('body').on('click', '#pr_add', function (e){
        if ($(this).closest('.item-table').find('.row-item').length) {
            if ($(this).closest('.item-table').find('.row-item:last select').val() == '')
                return false;
        }
        var i = $('#products').find('.row-item').length;
        // Increase counter by one
        i++;

        // Loop through each element
        prTemplate.clone()
            .find('.pr-row-num').each(function () {
            // Update row number
            $(this).html(i);

        }).end().find('#ID').each(function (){
                // Update row number
                this.id ="ID_"+i;
            }).end()
            .find('select').each(function (){

            // Update ID
            var newId = this.id + i;
            this.id = newId;

            // Update name
            var newName = this.name.replace(/__i__/g, i);
            this.name = newName;
            $(this).select2({'width': '100%'});

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

    });

    $('body').on('change', '.item-quantity', function () {
        const parentItem = $(this).closest('.row-item');
        if (parentItem.find('select').val() != '') {
            if (parentItem.find('select option:selected').data('left') < $(this).val()) {
                $(this).val(parentItem.find('select option:selected').data('left'));
                return false;
            }
        }
    });
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
    var del_p = 0;
    var del_s=0;
    // ======================== Remove products on the form ======================== //
    $('#products').on('click', '.pr-remove a', function (e) {
        // Call calculation function
        del_p++;
        // alert(del_p);
        removeItem(e);
        items();
        
    });
    // *********************** SERVICES AREA *********************** //
    // ************************************************************* //
    // ======================== Clone Services Template ======================== //

    // Define counter

    // Define products template
    var srTemplate = $('#sr_template .sr-row').clone();


    // Add new product input form
    $('body').on('click', '#sr_add', function (e){
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

        }).end().find('#ID_').each(function (){
                // Update row number
                this.id ="ID__"+j;
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
          del_s++;
        removeItem(e);
        items();
      

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


    $('body').on('change', '.item-select', function (e){
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
        // Now calculate subtotal
        // text += "<br>The number is " + i;
        var bar_code1 = $(this).find(':selected').data('barcode1');
        if(bar_code1!="undefined"){
            var ID1 = $('#products').find('.row-item').length;
            // alert(ID1);
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
            // alert(ID);
        }
        items();
    });

    // Calculate when changes product price or quantity
    function calculateByPrPriceOrQuantiry(e){

        var element = e.currentTarget;
        // console.log(element);
        var itemParent = $(element).closest('.row-item');
        var pr_quantity = itemParent.find("input.item-quantity").val();


        var pr_price = itemParent.find("input.item-price").val();

        var pr_total = pr_price * pr_quantity;

        itemParent.find(".item-total").val(pr_total);

    }


    // Calculate subtotal
    function subtotal(element) {
        var pr_subtotal = 0;
        element.closest('.item-table').find('input.item-total').each(function () {
            if ($(this).val() != '')
                pr_subtotal = pr_subtotal + parseInt($(this).val());
        });

        element.closest('.item-table').find('.subtotal').val(pr_subtotal);
        calSumTotal();
        items();
    }
    var num=0;
    var arrays=[];
    function calSumTotal(){
        var check_type = Number(document.getElementById("org_type").value);
        if(check_type!="10") {
            var total = 0;
            $('.subtotal').each(function () {
                if ($(this).val() != '')
                    total = total + parseInt($(this).val());
            })
            var check1 = document.getElementById("price1").value;
            var check2 = document.getElementById("price2").value;
            var check3 = document.getElementById("price3").value;
            var check4 = document.getElementById("price4").value;
            var check5 = document.getElementById("price5").value;
            $('#total').val(total);
            if (check1 == "") {
                check1 = 0;
            } else {
                check1 = Number(document.getElementById("price1").value);
            }
            if (check2 == "") {
                check2 = 0;
            } else {
                check2 = Number(document.getElementById("price2").value);
            }
            if (check3 == "") {
                check3 = 0;
            } else {
                check3 = Number(document.getElementById("price3").value);
            }
            if (check4 == "") {
                check4 = 0;
            } else {
                check4 = Number(document.getElementById("price4").value);
            }
            if (check5 == "") {
                check5 = 0;
            } else {
                check5 = Number(document.getElementById("price5").value);
            }
            var checkAll = check1 + check2 + check3 + check4 + check5;
            //alert(checkAll);
            if (check1 == 0 || total != checkAll) {
                var summa = Number($('#org_summa').val());
                if (summa < 0) {
                    if (check2 == 0 && check3 == 0 && check5 == 0) {
                        $('#price1').val(total);
                    }
                }
                num++;

                if (check1 == 0 && total != checkAll) {
                    document.getElementById("price2").value = 0;
                    document.getElementById("price3").value = 0;
                    document.getElementById("price4").value = 0;
                    document.getElementById("price5").value = 0;
                }
                if (summa > 0) {
                    document.getElementById("price2").value = 0;
                    document.getElementById("price3").value = 0;
                    document.getElementById("price4").value = 0;
                    document.getElementById("price5").value = 0;
                } else if (summa < 0 && total != checkAll) {
                    document.getElementById("price4").value = total;
                }
                var type = $('#org_type').val();
                if (type != "10") {
                    if (summa < total && summa > 0) {
                        document.getElementById("price1").value = (summa);
                        document.getElementById("price4").value = (total - summa);
                        document.getElementById("Div_price").style.display = "block";
                    } else if (summa <= 0) {
                        if (check2 == 0 && check3 == 0 && check5 == 0) {
                            document.getElementById("price1").value = 0;
                            document.getElementById("price1").readOnly = true;
                            document.getElementById("price4").value = total;
                            document.getElementById("Div_price").style.display = "block";
                        }
                    }
                    //else if (summa > 0) {
                    //    document.getElementById("price1").value = total;
                    //}

                }

                //}
                //}
            }
            items();
        }else{
            var total = 0;
            $('.subtotal').each(function () {
                if ($(this).val() != '')
                    total = total + parseInt($(this).val());
            })
            var check1 = document.getElementById("price1").value;
            var check2 = document.getElementById("price2").value;
            var check3 = document.getElementById("price3").value;
            var check4 = document.getElementById("price4").value;
            var check5 = document.getElementById("price5").value;
            $('#total').val(total);
            if (check1 == "") {
                check1 = 0;
            } else {
                check1 = Number(document.getElementById("price1").value);
            }
            if (check2 == "") {
                check2 = 0;
            } else {
                check2 = Number(document.getElementById("price2").value);
            }
            if (check3 == "") {
                check3 = 0;
            } else {
                check3 = Number(document.getElementById("price3").value);
            }
            if (check4 == "") {
                check4 = 0;
            } else {
                check4 = Number(document.getElementById("price4").value);
            }
            if (check5 == "") {
                check5 = 0;
            } else {
                check5 = Number(document.getElementById("price5").value);
            }

            var checkAll = check1 + check2 + check3 + check4 + check5;
            if (check1 == 0 || total != checkAll){
                $('#price1').val(total);
                document.getElementById("price2").value = 0;
                document.getElementById("price3").value = 0;
                document.getElementById("price4").value = 0;
                document.getElementById("price5").value = 0;
                num++;
            }
            items();
        }
            items();
}


    // Remove product row
    function removeItem(e){
        // alert("Salom");
        var element = e.currentTarget;
        const otherE = $(element).closest('.item-table').find('.subtotal');

        $(element).closest('tr').remove();

        setTimeout(function () {
            subtotal(otherE);
        }, 100);
        items();
        checkDisableGoButton();
    }
function items() {
    // alert("Assssalom");
    var cheking1 = document.getElementById("org_type").value;
    if(cheking1=='org') {
        var total = 0;
        var totalService = 0;
        var totalProduct = 0;
        var prodLength = $('#products').find('.row-item').length;
        // alert(prodLength);
    if(prodLength>=1){
        for (var i = 1; i <= prodLength+del_p; i++) {
            // alert("Rasvo"+i);
        if(document.getElementById("pr_price" + i)){
             // alert(Number(document.getElementById("sr_price" + i).value));
            totalProduct += Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
            document.getElementById("pr_total" + i).value = Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
        }
        }
    }
        var servLength = $('#services').find('.row-item').length;
    if(servLength>=1){
        for (var i = 1; i <= servLength+del_s; i++) {
            if(document.getElementById("sr_price" + i)){
            totalService += Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
            document.getElementById("sr_total" + i).value = Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
        }
        }
    }
        total = totalService + totalProduct;
        var org_summa = Number(document.getElementById("org_summa").value);

        document.getElementById("price2").value = 0;
        document.getElementById("price3").value = 0;
        document.getElementById("price5").value = 0;
        document.getElementById("price4").value = 0;
        document.getElementById("sr_subtotal").value = totalService;
        document.getElementById("pr_subtotal").value = totalProduct;
        document.getElementById("total").value = total;
        // alert(prodLength+"<>"+servLength);

        if (org_summa >= total && org_summa > 0) {
            document.getElementById("price1").value = total;
            document.getElementById("price4").value = 0;
        } else if (org_summa < total && org_summa > 0) {
            if(Number(document.getElementById("org_summa").value)<Number(document.getElementById("total").value)){
                     document.getElementById("price1").value = org_summa;
                     // alert(org_summa);
            }else{
                    document.getElementById("price1").value = total;
                    // alert(total);
                }
            document.getElementById("price4").value = total - org_summa;
        } else if (org_summa <= 0) {
            document.getElementById("price1").value = 0;
            document.getElementById("price4").value = total;
        }
        document.getElementById("Div_price").style.display = "block";

        if(Number(document.getElementById("price3").value)==0 && Number(document.getElementById("price2").value)==0 && Number(document.getElementById("price5").value)==0)
        {
            document.getElementById("savdo1").style.display = 'none';
            document.getElementById("savdo").style.display = 'block';
        }else{
            document.getElementById("savdo").style.display = 'none';
            document.getElementById("savdo1").style.display = 'block';
        }
    }else{
        var total = 0;
        var totalService = 0;
        var totalProduct = 0;
        var prodLength = $('#products').find('.row-item').length;
    if(prodLength>=1){
        for (var i = 1; i <= prodLength+del_p; i++){
        if(document.getElementById("pr_price" + i).value){
            totalProduct += Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
            document.getElementById("pr_total" + i).value = Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
            }
        }
    }
        var servLength = $('#services').find('.row-item').length;
    if(servLength>=1){
        for (var i = 1; i <= servLength+del_s; i++) {
        if(document.getElementById("sr_price" + i)){
            totalService += Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
            document.getElementById("sr_total" + i).value = Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
        }
    }
}
        total = totalService + totalProduct;
        document.getElementById("price2").value = 0;
        document.getElementById("price3").value = 0;
        document.getElementById("price5").value = 0;
        document.getElementById("price4").value = 0;
        document.getElementById("sr_subtotal").value = totalService;
        document.getElementById("pr_subtotal").value = totalProduct;
        document.getElementById("total").value = total;
        document.getElementById("price1").value = total;
        // alert(prodLength+"<>"+servLength);
        document.getElementById("Div_price").style.display = "block";
    }
}

    // ======================== Detecting changes on products area for single product  ======================== //

    if($('#products').find('.row-item').length==0){
        del_p=0;
        
    }
    if($('#services').find('.row-item').length==0){
        del_s=0;
    }
    // $('body form.order').on('keyup change paste', 'input, select', function(){
    // 		alert("Change!");
    // 	});
});
