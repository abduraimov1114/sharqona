/**
 * Created by Compass on 18.04.2020.
 */
jQuery(document).ready(function($) {
    $('#pr_name').val('4');
});
function restarting(){
    sessionStorage.company="compass";
    sessionStorage.user_type="B";
    sessionStorage.indexP=1;
    sessionStorage.indexS=1;
    sessionStorage.SerSumm=0;
    sessionStorage.ProSumm=0;
}
restarting();
function korxona(id){
//							alert(id);
    document.getElementById("compass").className="btn";
    document.getElementById("compass").value="compass";
    document.getElementById("cowork").className="btn";
    document.getElementById("cowork").value="cowork";
    document.getElementById("x_korxona").className="btn";
    document.getElementById("x_korxona").value="x_korxona";
    document.getElementById(id).className="btn btn-green";
    var comp = document.getElementById(id).value;
//							window.company = comp;
    sessionStorage.company=comp;
//							alert(window.company);
}
$("#label-switch").change(function(){
    var type="";
    var string = $("#label-switch").html().replace(/^\s*/,'').replace(/\s*$/,'');
    if(string.search("switch-off")!=-1){
        type="K";
    }else{
        type="B";
    }
    sessionStorage.user_type=type;
});
function checkType(){
								//alert(sessionStorage.user_type);
}
jQuery(document).ready(function($){
    $('#pr_name').val('def');
    $('#pr_name').on('change', function (e) {
        document.getElementById("new_user_name").value="";
        document.getElementById("new_user_contact").value="";
        if($('#pr_name').val()){
            document.getElementById("new_user_add").style.display="none";
        }else{
            document.getElementById("new_user_add").style.display="block";
        }
    });
});
function reset_select(){
    $('#pr_name').val('def');
    $('#select2-chosen-1').html('tanlang');
}
$('body').on('keyup', '#s2id_autogen1_search', function (e){
    document.getElementById("new_user_name").value="";
    document.getElementById("new_user_contact").value="";
    var check = document.getElementById("select2-results-1").textContent;
    if(check=="No matches found"){
        document.getElementById("new_user_add").style.display="block";
    }else{
        document.getElementById("new_user_add").style.display="none";
    }
});

//////////////////////////////////////////////////////////////////////////////
/////////////////////////////////PRODUCT///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
var indexP = 2;
$("#btnAdd").on("click",function(){
    var $tableBody = $('#table_products').find("tbody"),
        $trLast = $tableBody.find("tr:last");
    var $clonetableBody = $('#clone_tr').find("tbody"),
        $cloneTrLast = $clonetableBody.find("tr:last"),
        $cloneTrNew = $cloneTrLast.clone();
    $trLast.after($cloneTrNew);
//								update 1 td
    $('#table_products #clone_id').attr('id','product_id_'+indexP);
    $('#table_products #tr_clone_id').attr('id','tr_prod_id_'+indexP);
    $('#table_products #product_id_'+indexP).html(indexP);
//								update 2 td
    $('#table_products #clone_name').attr('id','product_name_'+indexP);
//								update 3 td
    $('#table_products #clone_count').attr('onkeyup','realProductSumm()');
    $('#table_products #clone_count').attr('id','product_count_'+indexP);
//								update 4 td
    $('#table_products #clone_price').attr('onkeyup','realProductSumm()');
    $('#table_products #clone_price').attr('id','product_price_'+indexP);
//								update 5 td
    $('#table_products #clone_summa').attr('id','product_summa_'+indexP);
//								update 6 td
    $('#table_products #clone_dell').attr('onclick','dell_row_product('+indexP+')');
    $('#table_products #clone_dell').attr('id','product_dell_'+indexP);
    $('#table_products #product_dell_'+indexP).val(indexP);
    sessionStorage.indexP=indexP;
    indexP++;
});
function dell_row_product(id){
    var check = $('#table_products tbody').find('tr').length;
    if(check!=1){
        $('#table_products #tr_prod_id_'+id).remove();
    }else{
        $('#table_products #product_name_'+id).val("");
        $('#table_products #product_count_'+id).val("");
        $('#table_products #product_price_'+id).val("");
        $('#table_products #product_summa_'+id).val("");
    }
    realProductSumm();
}
function realProductSumm(){
    var num = sessionStorage.indexP;
    var $summa=0;
//								alert("num"+num);
    for(var $i=1;$i<=num;$i++){
        var check = document.getElementById('tr_prod_id_'+$i);
        if(check){
            var $summ = 0;
            $summa +=Number($('#table_products #product_price_'+$i).val())*Number($('#table_products #product_count_'+$i).val());
            $summ =Number($('#table_products #product_price_'+$i).val())*Number($('#table_products #product_count_'+$i).val());
            $('#table_products #product_summa_'+$i).val($summ);
        }
    }
    $('#total_p').val($summa);
    sessionStorage.ProSumm=$summa;
    if(sessionStorage.SerSumm!=0){
        $('#total_sp').val(Number($summa)+Number(sessionStorage.SerSumm));
    }else{
        $('#total_sp').val($summa);
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////SERVICE//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var indexS = 2;
$("#btnAddService").on("click",function(){
    var $tableBody = $('#table_services').find("tbody"),
        $trLast = $tableBody.find("tr:last");
    var $clonetableBody = $('#clone_tr').find("tbody"),
        $cloneTrLast = $clonetableBody.find("tr:last"),
        $cloneTrNew = $cloneTrLast.clone();
    $trLast.after($cloneTrNew);
//								update 1 td
    $('#table_services #clone_id').attr('id','service_id_'+indexS);
    $('#table_services #tr_clone_id').attr('id','tr_ser_id_'+indexS);
    $('#table_services #service_id_'+indexS).html(indexS);
//	alert(indexS);
//								update 2 td
    $('#table_services #clone_name').attr('id','service_name_'+indexS);
//								update 3 td
    $('#table_services #clone_count').attr('onkeyup','realServiceSumm()');
    $('#table_services #clone_count').attr('id','service_count_'+indexS);
//								update 4 td
    $('#table_services #clone_price').attr('onkeyup','realServiceSumm()');
    $('#table_services #clone_price').attr('id','service_price_'+indexS);
//								update 5 td
    $('#table_services #clone_summa').attr('id','service_summa_'+indexS);
//								update 6 td
    $('#table_services #clone_dell').attr('onclick','dell_row_service('+indexS+')');
    $('#table_services #clone_dell').attr('id','service_dell_'+indexS);
    $('#table_services #service_dell_'+indexS).val(indexS);
    sessionStorage.indexS=indexS;
    indexS++;
});
function dell_row_service(id){
    var check = $('#table_services tbody').find('tr').length;
    if(check!=1){
        $('#table_services #tr_ser_id_'+id).remove();
    }else{
        $('#table_services #service_name_'+id).val("");
        $('#table_services #service_count_'+id).val("");
        $('#table_services #service_price_'+id).val("");
        $('#table_services #service_summa_'+id).val("");
    }
    realServiceSumm();
}
function realServiceSumm(){
    var numS = sessionStorage.indexS;
    var $summaS=0;
//			alert("num"+numS);
    for(var $i=1;$i<=numS;$i++){
        var check = document.getElementById('tr_ser_id_'+$i);
        if(check){
            var $summS = 0;
            $summaS +=Number($('#table_services #service_price_'+$i).val())*Number($('#table_services #service_count_'+$i).val());
            $summS =Number($('#table_services #service_price_'+$i).val())*Number($('#table_services #service_count_'+$i).val());
            $('#table_services #service_summa_'+$i).val($summS);
        }
    }
    $('#total_s').val($summaS);
    sessionStorage.SerSumm=$summaS;
    if(sessionStorage.ProSumm!=0){
        $('#total_sp').val(Number($summaS)+Number(sessionStorage.ProSumm));
    }else{
        $('#total_sp').val($summaS);
    }
}
/////////////////////////////////////////////////////////////////////
///////////////////////////////SENDING/////////////////////////////////
/////////////////////////////////////////////////////////////////////
function sending(){
    alert("Yes");
}
function view(type){
    var comp = sessionStorage.company;
    var check_date = document.getElementById("check_date").value;
    var doc_nomer_id = document.getElementById("doc_nomer_id").value;
    var user_name = document.getElementById("pr_name").value;
    var desc = document.getElementById("desc").value;
    var new_user_name = document.getElementById("new_user_name").value;
    var user_type = sessionStorage.user_type;
    var new_user_contact = document.getElementById("new_user_contact").value;
    //alert("desc "+desc);
    var numP = Number(sessionStorage.indexP);
    var numS = Number(sessionStorage.indexS);
    var ProductName = [];
    var ProductCount = [];
    var ProductPrice = [];
    var ProductTotal = $('#total_p').val();
    var ServiceName = [];
    var ServiceCount = [];
    var ServicePrice = [];
    var ServiceTotal = $('#total_s').val();
    var LengthS=0;
    var LengthP=0;
    var contract_name=$('#contract_name').val();
//	SERVICES
    for(var $i=1;$i<=numS;$i++){
        var check = document.getElementById('tr_ser_id_'+$i);
        if(check){
            var servName = $('#table_services #service_name_'+$i).val();
            var servCount = $('#table_services #service_count_'+$i).val();
            var servPrice = $('#table_services #service_price_'+$i).val();
            if(servName!="" && servCount>=0 && servPrice>=0){
                ServiceName[LengthS] = servName;
                ServiceCount[LengthS] = servCount;
                ServicePrice[LengthS] = servPrice;
                LengthS++;
                //alert(" ServiceName: "+ServiceName[LengthS]+" ServiceCount "+ServiceCount[LengthS]+" ServicePrice "+ServicePrice[LengthS]);
            }
        }
    }
    //alert("ServiceTotal: "+ServiceTotal);
//	PRODUCTS
    for(var $i=1;$i<=numP;$i++){
        var check = document.getElementById('tr_prod_id_'+$i);
        if(check){
            var prodName = $('#table_products #product_name_'+$i).val();
            var prodCount = $('#table_products #product_count_'+$i).val();
            var prodPrice = $('#table_products #product_price_'+$i).val();
            if(prodName!="" && prodCount>=0 && prodPrice>=0){
                ProductName[LengthP] = prodName;
                ProductCount[LengthP] = prodCount;
                ProductPrice[LengthP] = prodPrice;
                LengthP++;
                //alert(" ProductName: "+ProductName[LengthP]+" ProductCount: "+ProductCount[LengthP]+" ProductPrice: "+ProductPrice[LengthP]);
            }
        }
    }
    //alert("ProductTotal: "+ProductTotal);
    //alert("contract_name: "+contract_name);
    var submit = {
        type: type,
        company: comp,
        doc_nomer_id: doc_nomer_id,
        check_date: check_date,
        user_name: user_name,
        user_type: user_type,
        new_user_name: new_user_name,
        new_user_contact: new_user_contact,
        contract_type: contract_name,
        desc: desc,

        product_name: ProductName,
        product_count: ProductCount,
        product_price: ProductPrice,
        product_total: ProductTotal,

        service_name: ServiceName,
        service_count: ServiceCount,
        service_price: ServicePrice,
        service_total: ServiceTotal
    };
    //alert(submit);
    var submit_json = JSON.stringify(submit);
    var link="";
    if(submit.type=='view'){
        document.getElementById("hidden").value=submit_json;
    }else{
        link="contract/index.php";
        $.ajax({
            method: "POST",
            data: {values: submit_json},
            url: link,
            success: function (data){
                location.reload(true);
            }
        })
    }
}
function new_to_active(val){
    $.ajax({
        method: "POST",
        data: {values: val},
        url: "new_to_active_ajax.php",
        success: function (data){
            //alert("Salom dunyo");
            //document.getElementById('info').innerHTML=data;
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function new_to_cancel(val){
    $.ajax({
        method: "POST",
        data: {values: val},
        url: "new_to_cancel_ajax.php",
        success: function (data){
            //document.getElementById('info').innerHTML=data;
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function new_info(val){
    $.ajax({
        method: "POST",
        data: {values: val},
        url: "new_info_ajax.php",
        success: function (data){
            //alert(data);
            document.getElementById("");
        }
    })
}
//tablitsalar
var counter=0;
var old_id="";
var array_id=[];
function clickMenu(id){
    // ARRAY PUSHING AND SEARCHING
    //alert(array_id.indexOf(id));
    if(counter==0){
        document.getElementById("table-1").id = "table1";
        document.getElementById("table-2").id = "table2";
        document.getElementById("table-3").id = "table3";
        document.getElementById("table-4").id = "table4";

        document.getElementById("table" + id).id = "table-1";
        old_id=id;
        counter++;
    }else{
            document.getElementById("table-1").id = "table" + old_id;
            document.getElementById("table" + id).id = "table-1";
            old_id = id;
            counter++;
    }
    //if(!document.getElementById("table" + id)){
    if(array_id.indexOf(id)==-1 && id!=1){
        array_id.push(id);
        var $table1 = jQuery('#table-1');

        // Initialize DataTable
        $table1.DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": true
        });

        // Initalize Select Dropdown after DataTables is created
        $table1.closest('.dataTables_wrapper').find('select').select2({
            minimumResultsForSearch: -1
        });
    }
}
jQuery( document ).ready( function( $ ) {
    var $table1 = jQuery( '#table-1' );

    // Initialize DataTable
    $table1.DataTable( {
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bStateSave": true
    });

    // Initalize Select Dropdown after DataTables is created
    $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
        minimumResultsForSearch: -1
    });
} );
function status_select(id){
    sessionStorage.contractId = id;
    $.ajax({
        method: "POST",
        data: {values: id},
        url: "new_info_ajax.php",
        success: function (data){
            //alert(data);
           var json_array=JSON.parse(data);
            var html = "",html2 = "",html3 = "",html4 = "",html5 = "";
            if(json_array.shartnoma==1){
                html ="switch-on";
                sessionStorage.doc=1;
            }else{
                html ="switch-off";
                sessionStorage.doc=0;
            }
            document.getElementById("docx").innerHTML="<div class='switch-animate "+html+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("docx1").innerHTML="<div class='switch-animate "+html+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
        //    step 2
            if(json_array.hisob_faktura!=1){
                //alert(data);
                html2 ="switch-off";
                sessionStorage.fak=0;
            }else{
                html2 ="switch-on";
                sessionStorage.fak=1;
            }
            document.getElementById("factory").innerHTML="<div class='switch-animate "+html2+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("factory1").innerHTML="<div class='switch-animate "+html2+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            //    step 3
            if(json_array.ishonchnoma!=1){
                //alert(data);
                html3 ="switch-off";
                sessionStorage.trust=0;
            }else{
                html3 ="switch-on";
                sessionStorage.trust=1;
            }
            document.getElementById("trust").innerHTML="<div class='switch-animate "+html3+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("trust1").innerHTML="<div class='switch-animate "+html3+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            //    step 4
            if(json_array.akt!=1){
                //alert(data);
                html4 ="switch-off";
                sessionStorage.akt=0;
            }else{
                html4 ="switch-on";
                sessionStorage.akt=1;
            }
            document.getElementById("akt").innerHTML="<div class='switch-animate "+html4+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("akt1").innerHTML="<div class='switch-animate "+html4+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            //    step 5
            if(json_array.yetkazib_berildi!=1){
                sessionStorage.send=0;
                html5 ="switch-off";
            }else{
                html5 ="switch-on";
                sessionStorage.send=1;
            }
            sessionStorage.total_summa=json_array.total_sum;
            document.getElementById("send").innerHTML="<div class='switch-animate "+html5+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("send1").innerHTML="<div class='switch-animate "+html5+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
            document.getElementById("doc_id").innerHTML=json_array.id;
            document.getElementById("doc_id1").innerHTML=json_array.id;
            document.getElementById("doc_summa").innerHTML=json_array.total_sum;
            document.getElementById("doc_summa1").innerHTML=json_array.total_sum;
            document.getElementById("payed_summa").innerHTML=json_array.pay_price;
            document.getElementById("payed_summa1").innerHTML=json_array.pay_price;
            document.getElementById("desc1").textContent=json_array.desc;
            document.getElementById("desc2").textContent=json_array.desc;
        }
    })
}
function changing1(id){
    var html="";
    var string = $("#"+id).html().replace(/^\s*/,'').replace(/\s*$/,'');
    var value1=0;
    if(string.search("switch-off")!=-1){
        html="switch-on";
        value1=1;
    }else{
        //alert(id);
        html="switch-off";
        value1=0;
    }
    document.getElementById(id).innerHTML="<div class='switch-animate "+html+"'> <input type='checkbox' checked=''><span class='switch-left'>Yes</span><label>&nbsp;</label><span class='switch-right'>No</span></div>";
    if(id=="docx1"){
        sessionStorage.doc=value1;
    }else if(id=="factory1"){
        sessionStorage.fak=value1
    }else if(id=="akt1"){
        sessionStorage.akt=value1
    }else if(id=="send1"){
        sessionStorage.send=value1
    }else if(id=="trust1"){
        sessionStorage.trust=value1
    }
}
function update_active(){
    var pay_price = document.getElementById("pay_price").value;
    var pay_date = document.getElementById("pay_date1").value;
    var desc = document.getElementById("desc1").value;
    var submit1 = {
        id: sessionStorage.contractId,
        docx: sessionStorage.doc,
        fak: sessionStorage.fak,
        akt: sessionStorage.akt,
        send: sessionStorage.send,
        trust: sessionStorage.trust,
        pay_price: pay_price,
        pay_date: pay_date,
        desc: desc,
        total_price: sessionStorage.total_summa,
    };
    var submit_json1 = JSON.stringify(submit1);
    $.ajax({
        method: "POST",
        data: {values: submit_json1},
        url: "update_status_contract_ajax.php",
        success: function (data){
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function update_active1(){
    var new_user_name = document.getElementById("new_user_name1").value;
    var user_name = document.getElementById("user_name1").value;
    var new_user_contact = document.getElementById("new_user_contact1").value;
    var pay_price = document.getElementById("pay_price1").value;
    var pay_date = document.getElementById("pay_date2").value;
    var desc = document.getElementById("desc2").value;
    var submit2 = {
        user_name: user_name,
        new_user_name: new_user_name,
        new_user_contact: new_user_contact,
        id: sessionStorage.contractId,
        docx: sessionStorage.doc,
        fak: sessionStorage.fak,
        akt: sessionStorage.akt,
        send: sessionStorage.send,
        trust: sessionStorage.trust,
        pay_price: pay_price,
        pay_date: pay_date,
        desc: desc,
        total_price: sessionStorage.total_summa,
    };
    var submit_json1 = JSON.stringify(submit2);
    $.ajax({
        method: "POST",
        data: {values: submit_json1},
        url: "update_status_contract_ajax.php",
        success: function (data){
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function cancel_to_new(id){
    //alert(id);
    $.ajax({
        method: "POST",
        data: {values: id},
        url: "cancel_new_ajax.php",
        success: function (data){
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function cancel(id){
    $.ajax({
        method: "POST",
        data: {values: id},
        url: "cancel.php",
        success: function (data){
            if(data==true){
                location.reload(true);
            }
        }
    })
}
function select_id(){
    $.ajax({
        url: "select_id.php",
        success: function (data){
            document.getElementById("nomer_id").textContent=data;
            document.getElementById("doc_nomer_id").value=data;
        }
    })
}
function min_real(value){
    var doc_summa = Number(document.getElementById("doc_summa").textContent);
    var payed_summa = Number(document.getElementById("payed_summa").textContent);
    if(doc_summa<value){
        document.getElementById("pay_price").value = doc_summa;
    }
}
function min_real1(value){
    var doc_summa = Number(document.getElementById("doc_summa1").textContent);
    var payed_summa = Number(document.getElementById("payed_summa1").textContent);
    if(doc_summa<value){
        document.getElementById("pay_price1").value = doc_summa;
    }
}

$('body').on('keyup', '#s2id_autogen2_search', function (e){
    document.getElementById("new_user_name1").value="";
    document.getElementById("new_user_contact1").value="";
    var check = document.getElementById("select2-results-2").textContent;
    //alert(check);
    if(check=="No matches found"){
        document.getElementById("new").style.display="block";
    }else{
        document.getElementById("new").style.display="none";
    }
});