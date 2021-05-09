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
            if(data!=""){
                var i = $('#products').find('.row-item').length+1;
                //alert(i);
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
                        .find('.pr-pricein input').each(function () {
                            // Update ID
                            var newId = this.id + i;
                            this.id = newId;

                            // Update name
                            var newName = this.name.replace(/__i__/g, i);
                            this.name = newName;

                        }).end()
                        .find('.pr-priceout input').each(function () {
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
                        .appendTo('#products table');
                    //setTimeout(function () {
                    //    calculateByPrPriceOrQuantiry(e);
                    //    subtotal($(e.currentTarget));
                    //}, 100);
                    $("#code").focus();
                    alert("Test");
                    //    part 3
                    //var pr_price = $("#pr_name"+i).find('option:selected').data('price');
                    //alert(pr_price);
                    //var pr_left = Number($("#pr_name"+i).find('option:selected').data('left'))-1;
                    //
                    //if(pr_left<=0){
                    //    alert("Kechirasiz ushu tovardan qolmadi");
                    //    pr_left=0;
                    //}
                    //const parentItem = $("#pr_name"+i).closest('.row-item');
                    //// Set product details' values
                    //parentItem.find('.item-price').val(pr_price);
                    //if (parentItem.find('.item-left').length)
                    //    parentItem.find('.item-left').text(pr_left);
                    //
                    //// Calculate total product price before changing quantity by hand
                    //var pr_quantity = parentItem.find('.item-quantity').val();
                    //var pr_total = pr_price * pr_quantity;
                    //parentItem.find('.item-price').val(pr_price);
                    //parentItem.find('.item-total').val(pr_total);
                    //summ+=pr_total;
                    //document.getElementById("pr_subtotal").value=summ;
                    $("#ID_"+i).val(value);
                    ////    functions
                    //// Calculate when changes product price or quantity
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