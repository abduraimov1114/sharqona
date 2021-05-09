/********* Added by Lotus ********/

//var oTable=document.getElementById('myTable');

//var length = Number(oTable.rows.length);

//for product

//    alert("Alert");

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

            if(checking=="moving") {

                if (data != "") {

                    var i = $('#products').find('.row-item').length + 1;

                    var Alike = 0, checkId = 0;

                    var value = document.getElementById("code").value;

                    for (var j = 1; j < i; j++) {

                        var check = document.getElementById("ID_" + j).value;

                        if (value == check) {

                            Alike++;

                            checkId = j;

                        }

                    }

                    if (Alike == 0){

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

                            .find('.pr-quantity input').each(function () {



                                // Update ID

                                var newId = this.id + i;

                                this.id = newId;



                                // Update name

                                var newName = this.name.replace(/__i__/g, i);

                                this.name = newName;



                                this.value = 1;

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

                        //alert(checking);

                        $("#ID_"+i).val(value);

                        //    functions

                        // Calculate when changes product price or quantity

                        var pr_left = Number($("#pr_name" + i).find('option:selected').data('left'));

                        const parentItem = $("#pr_name"+i).closest('.row-item');

                        document.getElementById("pr_left").id="pr_left_"+i;

                        // Set product details' values

                        if (parentItem.find('.item-left').length)

                            parentItem.find('.item-left').text(pr_left-1);

                    } else {

                        //var i = $('#products').find('.row-item').length;

                        var countS=Number($('#pr_quantity'+checkId).val())+1;

                        var pr_left = Number($("#pr_name" + checkId).find('option:selected').data('left')) - countS;

                        if(pr_left>=0){

                            $('#pr_quantity'+checkId).val(countS);

                            document.getElementById("pr_left_"+checkId).innerHTML=pr_left;

                        }else{

                            alert("uzir boshqa maxsulot yoq");

                        }

                    }

                    $("#code").val("");

                    Test(10);

                }

            }

        }})

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

            $("#code").focus();

        }else{

            document.getElementById("code").style.display = "none";

            document.getElementById("code").autofocus=false;

        }

    }

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

$('body').on('click', '#pr_add', function (e) {

    var i = $('#products').find('.row-item').length + 1;

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

        .find('.pr-quantity input').each(function () {



            // Update ID

            var newId = this.id + i;

            this.id = newId;



            // Update name

            var newName = this.name.replace(/__i__/g, i);

            this.name = newName;



            this.value = 1;

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

    document.getElementById("pr_add").disabled=true;

});

$('body').on('change', '.item-select', function (e){

    var pr_price = $(this).find(':selected').data('left');

    const parentItem = $(this).closest('.row-item');

    parentItem.find('.item-left').text(pr_price);

    var counts = parentItem.find('.sub-total').val(0);



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

    }

    document.getElementById("pr_add").disabled=false;

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
$('#products').on('click', '.pr-remove a', function (e) {



        // Call calculation function

        removeItem(e);

        i--;

    });
    function removeItem(e){

        document.getElementById("pr_add").disabled=false;

        var element = e.currentTarget;

        const otherE = $(element).closest('.item-table').find('.subtotal');



        $(element).closest('tr').remove();



        setTimeout(function () {

            subtotal(otherE);

        }, 100);

        checkDisableGoButton();}