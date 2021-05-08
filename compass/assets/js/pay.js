/**
 * Created by User on 21.02.2020.
 */
// alert("Salom aka uzir sal halaqit beraman");
//master_org_outgoins.php

function disabledButtons1(id){
    var price1 = document.getElementById('price2').value;
    var price2 = document.getElementById('price3').value;
    var price3 = document.getElementById('price5').value;
// //    news
    var price4 = document.getElementById('price1').value;
    var summa=Number(price1)+Number(price2)+Number(price3)+Number(price4);
    var total = Number(document.getElementById("total").value);

    if((price1=="" || price1==0) || (price2=="" || price2==0) || ( price3=="" ||  price3==0)){
        if(Number(total)-(Number(price1)+Number(price2)+Number(price3)+Number(price4))>=0){
            document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price2)+Number(price3));
        }else{
            // alert(id);
            if(id==1){
                document.getElementById('price2').value=0;
            }else if(id==2){
                document.getElementById('price3').value=0;

            }else if(id==3){
                document.getElementById('price5').value=0;
            }
            document.getElementById('price4').value=Number(total)-(Number(price4));
        }
    }else{
        if(summa>total){
            if(id==1){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price2)+Number(price3));
                document.getElementById('price2').value=0;
            }else if(id==2){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price3));
                document.getElementById('price3').value=0;
            }else if(id==3){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price2));
                document.getElementById('price5').value=0;
            }

        }
    }
}
function disabledButtons(id){
    var price1 = document.getElementById('price2').value;
    var price2 = document.getElementById('price3').value;
    var price3 = document.getElementById('price5').value;
// //    news
    var price4 = document.getElementById('price1').value;
    var summa=Number(price1)+Number(price2)+Number(price3)+Number(price4);
    var total = Number(document.getElementById("total").value);

    if((price1=="" || price1==0) || (price2=="" || price2==0) || ( price3=="" ||  price3==0)){
        if(Number(total)-(Number(price1)+Number(price2)+Number(price3)+Number(price4))>=0){
            document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price2)+Number(price3));
                //alert("test");
        }else{
            // alert(id);
            if(id==1){
                document.getElementById('price2').value=0;
                //alert("1");
            }else if(id==2){
                document.getElementById('price3').value=0;
                //alert("2");
            }else if(id==3){
                document.getElementById('price5').value=0;
                //alert("3");
            }
            document.getElementById('price4').value=Number(total)-(Number(price4));
        }
    }else{
        if(summa>total){
            if(id==1){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price2)+Number(price3));
                document.getElementById('price2').value=0;
                //alert("1");
            }else if(id==2){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price3));
                document.getElementById('price3').value=0;
                //alert("2");
            }else if(id==3){
                document.getElementById('price4').value=Number(total)-(Number(price4)+Number(price1)+Number(price2));
                document.getElementById('price5').value=0;
                //alert("3");
            }
        }
    }

    if(Number(price1)>0 || Number(price2)>0 || Number(price3)>0){
        document.getElementById("savdo1").style.display="block";
        document.getElementById("savdo").style.display="none";
    }else{
        document.getElementById("savdo").style.display="block";
        document.getElementById("savdo1").style.display="none";
    }
}
$("#saqlash").click(function(){
    $("#user_name").attr('required', '');
})
$("#savdo").click(function(){
    $("#user_name").removeAttr("required");
})
var cheking1 = document.getElementById("org_type").value;
// alert(cheking1);
// alert(cheking1);
if(cheking1=="org"){
    // alert("if");
    function createKech(data) {
        var value = data.split("");
        var total = Number(document.getElementById("total").value);
        var price1 = Number(document.getElementById("price2").value);
        var price2 = Number(document.getElementById("price3").value);
        var price3 = Number(document.getElementById("price5").value);
        var summa = Number($('#org_summa').val());
        if(data<=summa){
            if ((value[0] == "0" && value.length == 1) || (value[0] != "0" && (data < total))) {
                document.getElementById("Div_price").style.display = "block";
                if (data < total) {
                    document.getElementById("price4").value = (total - data) - (price1 + price2 + price3);

                    document.getElementById("savdo").disabled = true;
                    disabledButtons(10);
                }
            }
            else if (data > total) {
                document.getElementById("price1").value = total;
                disabledButtons(10);
            }
            else if (data == total) {
                document.getElementById("Div_price").style.display = "none";
                document.getElementById("savdo").disabled = false;
                disabledButtons(10);
            }
            disabledButtons(10);
        }else{
            document.getElementById("price1").value=summa;
            document.getElementById("price2").value=0;
            document.getElementById("price3").value=0;
            document.getElementById("price5").value=0;
        }
    }

    function checkPrice(data,id){

       data = data.replace(/^[0]/,'');
       if(id==1){
            document.getElementById('price2').value=data;
            // alert(data);
        }else if(id==2){
            document.getElementById('price3').value=data;    
        }else if(id==3){
            document.getElementById('price5').value=data;
        }
       // alert(data);
        // document.getElementById('price'+id).value=data;

        var price1= Number(document.getElementById("price2").value);
        var price2= Number(document.getElementById("price3").value);
        var price3= Number(document.getElementById("price5").value);
        if(id==1){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price2-price3;
            if(data=="" || data==0){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price2-price3;
                document.getElementById("price4").value=check1;
                disabledButtons(id);
                // alert("1");
            }
        }
        if(id==2){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price3;
            if(data=="" || data==0){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price3;
                document.getElementById("price4").value=check1;
                disabledButtons(id);
                // alert("2");
            }
        }
        if(id==3){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price2;
            if(data=="" || data==0){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price2;
                document.getElementById("price4").value=check1;
                disabledButtons(id);
                // alert("3");
            }
        }
        if(check>=data && data!=0){
            document.getElementById("price4").value=(check-data);
            disabledButtons(id);
        }else if(check<data || data!=0){
            document.getElementById("price4").value=check;
            disabledButtons(id);
        }
        // disabledButtons(id);
        // alert("Salim");
    }

    function deleteqilish(f) {
        var total = Number($('#total').val());
        var summa = Number($('#org_summa').val());
        var qarz = Number($('#price4').val());
        var price = Number($('#price1').val());
        if (price != 0) {
            if (summa >= total) {
                if (qarz == 0) {
                    if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
                        f.submit();
                } else {
                    alert("Tashkilot puli yetarli");
                }
            } else if (summa < total && summa > 0) {
                if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
                    f.submit();
            }
        } else if (price == 0 && summa <= 0) {
            if (qarz != 0) {
                if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
                    f.submit();
            } else {
                alert("Qarzsiz olish mumkin emas");
            }
        }
    }
    $('body').on('keyup', '.item-price', function (e) {
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
    });

}else{
    function createKech(data,id){
        var value=data.split("");
        var total = Number(document.getElementById("total").value);
        if((value[0]=="0" && value.length==1) || (value[0]!="0" && (data<total))){
            document.getElementById("Div_price").style.display = "block";
            if(data<total){
                document.getElementById("price4").value=(total-data);
                disabledButtons1(10);
            }
        }
        else if(data>total){
            document.getElementById("price1").value=total;
            // disabledButtons1(10);
        }
        else if(data==total){
            document.getElementById("Div_price").style.display = "none";
            // disabledButtons1(10);
        }
    }
    function checkPrice(data,id){
        data = data.replace(/^[0]/,'');
        if(id==1){
            document.getElementById('price2').value=data;
            // alert(data);
        }else if(id==2){
            document.getElementById('price3').value=data;    
        }else if(id==3){
            document.getElementById('price5').value=data;
        }
        var price1= Number(document.getElementById("price2").value);
        var price2= Number(document.getElementById("price3").value);
        var price3= Number(document.getElementById("price5").value);
        if(id==1){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price2-price3;
            if(data==""){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price2-price3;
                document.getElementById("price4").value=check1;
                disabledButtons1(id);
            }
        }
        if(id==2){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price3;
            if(data==""){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price3;
                document.getElementById("price4").value=check1;
                disabledButtons1(id);
            }
        }
        if(id==3){
            var check = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price2;
            if(data==""){
                var check1 = Number(document.getElementById("total").value)-Number(document.getElementById("price1").value)-price1-price2;
                document.getElementById("price4").value=check1;
                disabledButtons1(id);
            }
        }
        if(check>=data && data!=0){
            document.getElementById("price4").value=(check-data);
            disabledButtons1(id);
        }else if(check<data || data!=0){
            document.getElementById("price4").value=check;
            disabledButtons1(id);
        }
        // alert(data);
        disabledButtons1(id);
    }
    function deleteqilish(f) {
        if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?"))
            f.submit();
    }
    // alert("else");
    $('body').on('keyup','.item-price', function (e) {

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
        // alert(prodLength+"<>"+servLength);
        document.getElementById("sr_subtotal").value=totalService;
        document.getElementById("pr_subtotal").value=totalProduct;
        document.getElementById("total").value=total;
        document.getElementById("price1").value=total;
        document.getElementById("price2").value=0;
        document.getElementById("price3").value=0;
        document.getElementById("price4").value=0;
        document.getElementById("price5").value=0;
        document.getElementById("Div_price").style.display = "none";
    });
}
function items() {
    // alert("Assssalom");
    var cheking1 = document.getElementById("org_type").value;
    if(cheking1=='org') {
        var total = 0;
        var totalService = 0;
        var totalProduct = 0;
        var prodLength = $('#products').find('.row-item').length;
        for (var i = 1; i <= prodLength; i++) {
            totalProduct += Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
            document.getElementById("pr_total" + i).value = Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
        }

        var servLength = $('#services').find('.row-item').length;
        for (var i = 1; i <= servLength; i++) {
            totalService += Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
            document.getElementById("sr_total" + i).value = Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
        }
        total = totalService + totalProduct;
        var org_summa = Number(document.getElementById("org_summa").value);

        document.getElementById("price2").value = 0;
        document.getElementById("price3").value = 0;
        document.getElementById("price5").value = 0;
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

    }else{
        var total = 0;
        var totalService = 0;
        var totalProduct = 0;
        var prodLength = $('#products').find('.row-item').length;
        for (var i = 1; i <= prodLength; i++){
            totalProduct += Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
            document.getElementById("pr_total" + i).value = Number(document.getElementById("pr_price" + i).value) * Number(document.getElementById("pr_quantity" + i).value);
        }
        var servLength = $('#services').find('.row-item').length;
        for (var i = 1; i <= servLength; i++) {
            totalService += Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
            document.getElementById("sr_total" + i).value = Number(document.getElementById("sr_price" + i).value) * Number(document.getElementById("sr_quantity" + i).value);
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
$('body').on('change', '.item-quantity', function () {
    items();
    document.getElementById("savdo1").style.display = 'none';
    document.getElementById("savdo").style.display = 'block';
});