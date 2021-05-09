/********* Added by Lotus ********/
//var oTable=document.getElementById('myTable');
//var length = Number(oTable.rows.length);
//for product
var summ=0;
var summ1=0;
var summ2=0;
function Total(){
    var check_type = Number(document.getElementById("org_type").value);
    if(check_type!="10"){
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
        if (check1 == 0 || total != checkAll) {
            //alert("check1 == 0 || total != checkAll");
            var summa = Number($('#org_summa').val());
            if (summa < 0) {
                //alert("check2 == 0 && check3 == 0 && check5 == 0");
                document.getElementById("price1").value = 0;
                document.getElementById("price1").readOnly = true;
                document.getElementById("price4").value = total;
                document.getElementById("Div_price").style.display = "block";
                //$('#price1').val(total);
                document.getElementById("price2").value = 0;
                document.getElementById("price3").value = 0;
                document.getElementById("price5").value = 0;
            } else if (summa > total && summa > 0) {
                $('#price1').val(total);
                document.getElementById("price2").value = 0;
                document.getElementById("price3").value = 0;
                document.getElementById("price5").value = 0;
            } else {
                if (summa < total && summa > 0) {
                    //alert("summa < total && summa > 0");
                    document.getElementById("price1").value = (summa);
                    document.getElementById("price4").value = (total - summa);
                    document.getElementById("Div_price").style.display = "block";
                } else if (summa <= 0) {
                    if (check2 == 0 && check3 == 0 && check5 == 0) {
                        //alert("check2 == 0 && check3 == 0 && check5 == 10");
                        document.getElementById("price1").value = 0;
                        document.getElementById("price1").readOnly = true;
                        document.getElementById("price4").value = total;
                        document.getElementById("Div_price").style.display = "block";
                    }
                }
            }
        }
    }
}
//alert("Alert");
function autoCode(data){
    var summ=0;
    var summ1=0;
        //ajax start
    $.ajax({
        url:"example.php",
        method:"POST",
        data:{id:data},
        success:function(data){
            if(data!=""){
                var i = $('#products').find('.row-item').length+1;
                var Alike = 0,checkId=0;
                    var value = document.getElementById("code").value;
                    for(var j=1;j<i;j++){
                        var check = document.getElementById("ID_"+j).value;
                        if(value==check){
                            //alert("J- "+check);
                            Alike++;
                            checkId=j;
                        }
                    }
            if(Alike==0){
                //create new tr
                //$('#pr_name'+i).val(data);
                //avto create
                var prTemplate = $('#pr_template .pr-row').clone();
                prTemplate.clone()
                    .find('.pr-row-num').each(function () {
                        // Update row number
                        $(this).html(i);

                    }).end().find('#ID').each(function (){
                        // Update row number
                        this.id ="ID_"+i;
                    }).end()
                    .find('select').each(function(){
                        // Update ID
                        var newId = this.id + i;
                        this.id = newId;
                        this.value=data;
                        // Update name
                        var newName = this.name.replace(/__i__/g, i);
                        this.name = newName;
                        $(this).select2({'width': '100%'});
                        //var vale=$(this).select2();
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

                        this.value = 1;
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
                setTimeout(function () {
                    calculateByPrPriceOrQuantiry(e);
                    subtotal($(e.currentTarget));
                }, 100);
                $("#code").focus();
            //    part 3
                var pr_price = $("#pr_name"+i).find('option:selected').data('price');
                //alert(pr_price);
                var pr_left = Number($("#pr_name"+i).find('option:selected').data('left'))-1;

                if(pr_left<=0){
                    alert("Kechirasiz ushu tovardan qolmadi");
                    pr_left=0;
                }
                const parentItem = $("#pr_name"+i).closest('.row-item');
                // Set product details' values
                parentItem.find('.item-price').val(pr_price);
                if (parentItem.find('.item-left').length)
                    parentItem.find('.item-left').text(pr_left);

                // Calculate total product price before changing quantity by hand
                var pr_quantity = parentItem.find('.item-quantity').val();
                var pr_total = pr_price * pr_quantity;
                parentItem.find('.item-price').val(pr_price);
                parentItem.find('.item-total').val(pr_total);
                summ+=pr_total;
                document.getElementById("pr_subtotal").value=summ;
                $("#ID_"+i).val(value);
                //    functions
                // Calculate when changes product price or quantity
                } else{
                        var countS=Number($('#pr_quantity'+checkId).val())+1;
                var pr_left = Number($("#pr_name" + checkId).find('option:selected').data('left')) - countS;
                if(pr_left>=0){
                $('#pr_quantity'+checkId).val(countS);

                var pr_price = $("#pr_name"+checkId).find('option:selected').data('price');
                ////alert(pr_price);

                    var pr_left = Number($("#pr_name" + checkId).find('option:selected').data('left')) - countS;
                    const parentItem = $("#pr_name"+checkId).closest('.row-item');
                    //// Set product details' values
                    parentItem.find('.item-price').val(pr_price);
                    if (parentItem.find('.item-left').length)
                        parentItem.find('.item-left').text(pr_left);
                    //
                    //// Calculate total product price before changing quantity by hand
                    var pr_quantity = parentItem.find('.item-quantity').val();
                    var pr_total = pr_price * pr_quantity;
                    parentItem.find('.item-price').val(pr_price);
                    parentItem.find('.item-total').val(pr_total);
                    summ1+=pr_total;
                    document.getElementById("pr_subtotal").value=summ1;
                    //alert("Update");
                }
                else{
                    alert("Kechirasiz ushu tovardan qolmadi");
                }
            }
                $("#code").val("");
                var k = Number($('#products').find('.row-item').length);
                //alert(k);
                var new1=0;
                if(k!=1){
                    for(var i=1;i<=k;i++){
                        new1 += Number(document.getElementById("pr_total" + i).value);
                    }
                    document.getElementById("pr_subtotal").value=new1;
                    //alert(result);
                }else{
                    var result = document.getElementById("pr_total1").value;
                    document.getElementById("pr_subtotal").value=result;
                }
                var product = Number(document.getElementById("pr_subtotal").value);
                var service = Number(document.getElementById("sr_subtotal").value);
                document.getElementById("total").value=service+product;
                var org_type = $('#org_type').val();
                if(org_type=='10'){
                    $('#price1').val(service+product);
                    document.getElementById("Div_price").style.display="none";
                    $('#price2').val(0);
                    $('#price3').val(0);
                    $('#price4').val(0);
                    $('#price5').val(0);
                }else{
                        Total();
                }
            }
        }
    })

}

function autoCode1(data){
        //ajax start
    $.ajax({
        url:"example1.php",
        method:"POST",
        data:{id:data},
        success:function(data){
            if(data!=""){

                var i = $('#services').find('.row-item').length+1;
                var Alike = 0,checkId=0;
                    var value = document.getElementById("code1").value;
                    for(var j=1;j<i;j++){
                        var check = document.getElementById("ID__"+j).value;
                        if(value==check){
                            Alike++;
                            checkId=j;
                        }
                    }
                if(Alike==0){
                    //create new tr
                    //$('#pr_name'+i).val(data);
                    //avto create
                    var prTemplate = $('#sr_template .sr-row').clone();
                    prTemplate.clone()
                        .find('.sr-row-num').each(function () {
                            // Update row number
                            $(this).html(i);

                        }).end().find('#ID_').each(function (){
                            // Update row number
                            this.id ="ID__"+i;
                        }).end()
                        .find('select').each(function(){
                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;
                            this.value=data;
                            // Update name
                            var newName = this.name.replace(/__i__/g, i);
                            this.name = newName;
                            $(this).select2({'width': '100%'});
                            //var vale=$(this).select2();
                        }).end()
                        .find('.sr-price input').each(function () {
                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;

                            // Update name
                            var newName = this.name.replace(/__i__/g, i);
                            this.name = newName;

                        }).end()
                        .find('.sr-quantity input').each(function () {

                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;

                            // Update name
                            var newName = this.name.replace(/__i__/g, i);
                            this.name = newName;

                            this.value = 1;
                        }).end()
                        .find('.sr-total input').each(function () {

                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;

                            // Update name
                            var newName = this.name.replace(/__i__/g, i);
                            this.name = newName;

                        }).end()
                        .find('.sr-remove a').each(function () {
                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;

                            // Update name
                            var newName = this.name + i;
                            this.name = newName;

                        }).end()
                        .appendTo('#services table tbody');
                    setTimeout(function () {
                        calculateByPrPriceOrQuantiry(e);
                        subtotal($(e.currentTarget));
                    }, 100);
                    $("#code1").focus();
                    //    part 3
                    var pr_price = $("#sr_name"+i).find('option:selected').data('price');
                    //alert(pr_price);
                    if($("#sr_name"+i).find('option:selected').data('left')!="Not need"){
                        var pr_left = Number($("#sr_name" + i).find('option:selected').data('left')) - 1;
                    }else{
                        var pr_left_orig = $("#sr_name" + i).find('option:selected').data('left');
                        var pr_left =1000;
                    }
                    //alert($("#sr_name"+i).find('option:selected').data('left'));
                    if(pr_left<=0 && $("#sr_name"+i).find('option:selected').data('left')!="Not need"){
                        alert("Kechirasiz ushu tovardan qolmadi");
                        pr_left=0;
                    }
                    const parentItem = $("#sr_name"+i).closest('.row-item');
                    // Set product details' values
                    //alert();
                    parentItem.find('.item-price').val(pr_price);
                    if(pr_left_orig != "Not need"){
                        if (parentItem.find('.item-left').length)
                            parentItem.find('.item-left').text(pr_left);
                    }else{
                        if (parentItem.find('.item-left').length)
                            parentItem.find('.item-left').text(pr_left_orig);
                    }
                    // Calculate total product price before changing quantity by hand
                    var pr_quantity = parentItem.find('.item-quantity').val();
                    var pr_total = pr_price * pr_quantity;
                    parentItem.find('.item-price').val(pr_price);
                    parentItem.find('.item-total').val(pr_total);
                    summ+=pr_total;
                    //document.getElementById("sr_subtotal").value=summ;
                    $("#ID__"+i).val(value);
                    //    functions
                    // Calculate when changes product price or quantity
                } else{
                    var countS=Number($('#sr_quantity'+checkId).val())+1;
                    //alert();
                    if($("#sr_name" + checkId).find('option:selected').data('left')!="Not need"){
                        var pr_left = Number($("#sr_name" + checkId).find('option:selected').data('left')) - countS;
                    }else{
                        var pr_left =countS;
                    }
                    if(pr_left>=0){
                        $('#sr_quantity'+checkId).val(countS);

                        var pr_price = $("#sr_name"+checkId).find('option:selected').data('price');
                        ////alert(pr_price);

                        var pr_left = Number($("#sr_name" + checkId).find('option:selected').data('left')) - countS;
                        const parentItem = $("#sr_name"+checkId).closest('.row-item');
                        //// Set product details' values
                        parentItem.find('.item-price').val(pr_price);

                        if($("#sr_name" + checkId).find('option:selected').data('left') != "Not need"){
                            if (parentItem.find('.item-left').length)
                                parentItem.find('.item-left').text(pr_left);
                        }else{
                            if (parentItem.find('.item-left').length)
                                parentItem.find('.item-left').text(pr_left_orig);
                        }
                        //
                        //// Calculate total product price before changing quantity by hand
                        var pr_quantity = parentItem.find('.item-quantity').val();
                        var pr_total = pr_price * pr_quantity;
                        parentItem.find('.item-price').val(pr_price);
                        parentItem.find('.item-total').val(pr_total);
                        summ1+=pr_total;
                    }
                    else{
                        //if($("#sr_name"+i).find('option:selected').data('left')!="Not need"){
                            alert("Kechirasiz ushu tovardan qolmadi");
                        //}
                    }
                }
                $("#code1").val("");

                var k = Number($('#services').find('.row-item').length);
                var new1=0;
                if(k!=1){
                    for(var i=1;i<=k;i++){
                        new1 += Number(document.getElementById("sr_total" + i).value);
                    }
                    document.getElementById("sr_subtotal").value=new1;
                    //alert(result);
                }else{
                    var result = document.getElementById("sr_total1").value;
                    document.getElementById("sr_subtotal").value=result;
                }
                var product = Number(document.getElementById("pr_subtotal").value);
                var service = Number(document.getElementById("sr_subtotal").value);

                //alert(res);
                document.getElementById("total").value=service+product;
                var org_type = $('#org_type').val();
                if(org_type=='10'){
                    $('#price1').val(service+product);
                    document.getElementById("Div_price").style.display="none";
                    $('#price2').val(0);
                    $('#price3').val(0);
                    $('#price4').val(0);
                    $('#price5').val(0);
                }else{
                    Total();
                }
            }
        }
    })

}
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
function Xcode(id){
    if(id==1){
        var check = document.getElementById("code1").style.display;
        //alert(check);
        if(check=="none"){
            document.getElementById("code1").style.display = "block";
            document.getElementById("code").style.display = "none";
            //document.getElementById("code").autofocus=false;
            //document.getElementById("code1").autofocus=true;
            $("#code1").focus();
        }else{
            document.getElementById("code1").style.display = "none";
            document.getElementById("code1").autofocus=false;
        }
    }else if(id==2){
        var check1 = document.getElementById("code").style.display;
        if(check1=="none"){
            document.getElementById("code").style.display="block";
            document.getElementById("code1").style.display="none";
            //document.getElementById("code1").autofocus=false;
            //document.getElementById("code").autofocus=true;
            $("#code").focus();
        }else{
            document.getElementById("code").style.display = "none";
            document.getElementById("code").autofocus=false;
        }
    }
}