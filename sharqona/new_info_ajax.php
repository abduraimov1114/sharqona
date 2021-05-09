<?php
include_once("../DB/functions.php");
$func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
//    new_contract_datails
    $product_name=[];
    $product_price=[];
    $product_count=[];
    $pr_num=0;

    $service_price=[];
    $service_name=[];
    $service_count=[];
    $sr_num=0;

    $sorov = "select * from new_contract_datails WHERE `nc_id`='".$_POST['values']."'";
    $func->queryMysql($sorov);
    while($row = $func->result->fetch_array(MYSQL_ASSOC)){
        if($row['sp_type']=='P'){
            $product_name[$pr_num] = $row['sp_name'];
            $product_price[$pr_num] = $row['sp_price'];
            $product_count[$pr_num] = $row['sp_count'];
            $pr_num++;
        }else{
            $service_name[$sr_num] = $row['sp_name'];
            $service_price[$sr_num] = $row['sp_price'];
            $service_count[$sr_num] = $row['sp_count'];
            $sr_num++;
        }
    }
//    new_contract
    $sorov = "select * from new_contract WHERE `nc_id`='".$_POST['values']."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    $total_sum = $row['product_total']+$row['service_total'];
    $array_info=[];
    $array_info=[
        'shartnoma'=>$row['shartnoma'],
        'hisob_faktura'=>$row['hisob_faktura'],
        'ishonchnoma'=>$row['ishonchnoma'],
        'akt'=>$row['akt'],
        'yetkazib_berildi'=>$row['yetkazib_berildi'],
        'pay_date'=>$row['pay_date'],
        'pay_price'=>$row['pay_price'],
        'desc'=>$row['description'],
        'total_sum'=>$total_sum,
        'id'=>$row['nc_id']
    ];
    $json_send = json_encode($array_info);
    if(empty($result)){
        echo $json_send;
    }
}