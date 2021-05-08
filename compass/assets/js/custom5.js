/********* Added by Lotus ********/
//var oTable=document.getElementById('myTable');
//var length = Number(oTable.rows.length);
//for product
var summ=0;
var summ1=0;
var summ2=0;
function autoCode(data){
    var summ=0;
    var summ1=0;
        //ajax start
    $.ajax({
        url:"example.php",
        method:"POST",
        data:{id:data},
        success:function(data){
            var checking = document.getElementById("type_comming").value;
            if(checking=="incoming") {
                if (data != "") {
                    var i = $('#products').find('.row-item').length + 1;
                    var Alike = 0, checkId = 0;
                    var value = document.getElementById("code").value;
                    for (var j = 1; j <i; j++) {
                        var check = document.getElementById("ID_" + j).value;
                        if (value == check) {
                            Alike++;
                            checkId = j;
                        }
                    }
                    if (Alike == 0) {
                        //avto create
                        var prTemplate = $('#pr_template .pr-row').clone();
                        prTemplate.clone()
                            .find('.pr-row-num').each(function () {
                                // Update row number
                                $(this).html(i);
                            }).end()
                            .find('#ID').each(function () {
                                // Update row number
                                this.id = "ID_" + i;
                            }).end()
                            .find('select').each(function () {
                                // Update ID
                                var newId = this.id + i;
                                this.id = newId;
                                this.value = data;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                                $(this).select2({'width': '100%'});
                            }).end()
                            .find('#income_price').each(function () {
                                // Update ID
                                var newId = this.id + i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;

                                this.value = 1;
                            }).end()
                            .find('#inprice_sum').each(function () {
                                // Update ID
                                var newId = this.id +"_"+ i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#pr-priceout').each(function () {
                                // Update ID
                                var newId = this.id +"_"+ i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#outprice_sum').each(function () {
                                // Update ID
                                var newId = this.id +"_"+ i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#outgoing_price').each(function () {
                                // Update ID
                                var newId = this.id +"_"+ i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#pr_quantity').each(function () {
                                // Update ID
                                var newId = this.id +"_"+ i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#storage_quantity').each(function () {
                                // Update ID
                                var newId = this.id + i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#pr_total').each(function () {
                                // Update ID
                                var newId = this.id + i;
                                this.id = newId;
                                // Update name
                                var newName = this.name.replace(/__i__/g, i);
                                this.name = newName;
                            }).end()
                            .find('#pr_total_sum').each(function () {
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
                        $("#ID_" + i).val(value);
                        var pr_price = $("#pr_name"+i).find('option:selected').data('price');
                        var pr_left = $("#pr_name"+i).find('option:selected').data('left');
                        var pr_price_out = $("#pr_name"+i).find('option:selected').data('price_out');
                        var dollar = Number(document.getElementById("dollar").value);

                         document.getElementById("income_price"+i).value=pr_price;
                         document.getElementById("pr_total"+i).value=pr_price;
                         document.getElementById("inprice_sum_"+i).value=pr_price*dollar;
                         document.getElementById("outgoing_price_"+i).value=pr_price_out;
                         document.getElementById("outprice_sum_"+i).value=pr_price_out*dollar;
                         document.getElementById("storage_quantity"+i).value="Ombordagi soni: "+pr_left;
                         document.getElementById("pr_total_sum"+i).value=pr_price*dollar;
                    } else {
                        var countS = Number($('#pr_quantity_' + checkId).val()) + 1;
                            $('#pr_quantity_' + checkId).val(countS);
                            //shunga keldim
                            var pr_price = $("#pr_name" + checkId).find('option:selected').data('price');
                            const parentItem = $("#pr_name" + checkId).closest('.row-item');
                    //    new alert
                        var pr_left = $("#pr_name"+checkId).find('option:selected').data('left');
                        var pr_price_out = $("#pr_name"+checkId).find('option:selected').data('price_out');
                        var dollar = Number(document.getElementById("dollar").value);
                        document.getElementById("income_price"+checkId).value=pr_price;
                        document.getElementById("pr_total"+checkId).value=pr_price*countS;
                        document.getElementById("inprice_sum_"+checkId).value=pr_price*dollar;
                        document.getElementById("outgoing_price_"+checkId).value=pr_price_out;
                        document.getElementById("outprice_sum_"+checkId).value=pr_price_out*dollar;
                        document.getElementById("storage_quantity"+checkId).value="Ombordagi soni: "+pr_left;
                        document.getElementById("pr_total_sum"+checkId).value=pr_price*dollar*countS;
                    }
                    $("#code").val("");
                }
                Test(10);
            }
        }
    })
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
$(document).ready(function () {
    $('body').on('click', '#pr_add', function (e) {
        const parentItem = $(this).closest('.row-item');
        parentItem.find('.item-left').text(0);
        var i = $('#products').find('.row-item').length + 1;
        //alert(i);
        //avto create
        var prTemplate = $('#pr_template .pr-row').clone();
        prTemplate.clone()
            .find('.pr-row-num').each(function () {
                // Update row number
                $(this).html(i);
            }).end()
            .find('#ID').each(function () {
                // Update row number
                this.id = "ID_" + i;
            }).end()
            .find('select').each(function () {
                // Update ID
                var newId = this.id + i;
                this.id = newId;
                //this.value = data;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
                $(this).select2({'width': '100%'});
            }).end()
            .find('#income_price').each(function () {
                // Update ID
                var newId = this.id + i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;

                this.value = 1;
            }).end()
            .find('#inprice_sum').each(function () {
                // Update ID
                var newId = this.id +"_"+ i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#pr-priceout').each(function () {
                // Update ID
                var newId = this.id +"_"+ i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#outprice_sum').each(function () {
                // Update ID
                var newId = this.id +"_"+ i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#outgoing_price').each(function () {
                // Update ID
                var newId = this.id +"_"+ i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#pr_quantity').each(function () {
                // Update ID
                var newId = this.id +"_"+ i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#storage_quantity').each(function () {
                // Update ID
                var newId = this.id + i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#pr_total').each(function () {
                // Update ID
                var newId = this.id + i;
                this.id = newId;
                // Update name
                var newName = this.name.replace(/__i__/g, i);
                this.name = newName;
            }).end()
            .find('#pr_total_sum').each(function () {
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
        //    part 3
        document.getElementById("pr_add").disabled=true;
    });

    $('body').on('change', '.item-select', function (e){
        var dollar = Number(document.getElementById("dollar").value);
        var pr_price = $(this).find(':selected').data('price');
        var pr_left = $(this).find(':selected').data('left');
        var pr_price_out = $(this).find(':selected').data('price_out');
        const parentItem = $(this).closest('.row-item');
            parentItem.find('.income_price').val(pr_price);
            parentItem.find('.pr-total').val(pr_price);
            parentItem.find('.inprice_sum').val(pr_price*dollar);
            parentItem.find('.pr_total_sum').val(pr_price*dollar);
            parentItem.find('.pr-priceout').val(pr_price_out);
            parentItem.find('.outprice_sum').val(pr_price_out*dollar);
            parentItem.find('.storage_quantity').val("Ombordagi soni: "+pr_left);
        var bar_code1 = $(this).find(':selected').data('barcode1');
        if(bar_code1!="undefined"){
            var ID1 = $('#products').find('.row-item').length;
            // alert(ID1);
            if(ID1!=0){
                document.getElementById("ID_" + ID1).value = bar_code1;
            }
        }
        document.getElementById("pr_add").disabled=false;
    //    new code
        Test(12);
    });
    // Calculate when changes product price or quantity
    $('#products').on('click', '.pr-remove a', function (e) {

        // Call calculation function
        removeItem(e);
        i--;
    });
    $('body').on('change', '.item-quantity', function () {
        Test(5);
    });
    $('body').on('keyup', '.item-quantity', function () {
        Test(5);
    });
    function removeItem(e){
        document.getElementById("pr_add").disabled=false;
        var element = e.currentTarget;
        const otherE = $(element).closest('.item-table').find('.subtotal');

        $(element).closest('tr').remove();

        setTimeout(function () {
            subtotal(otherE);
        }, 100);
        checkDisableGoButton();

    }
});