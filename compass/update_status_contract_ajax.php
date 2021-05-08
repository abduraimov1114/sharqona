<?php
include_once("../DB/functions.php");
$func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
    $json_data = json_decode($_POST['values']);
    $id = $func->secur($json_data->id);
    $docx = $func->secur($json_data->docx);
    $fak = $func->secur($json_data->fak);
    $akt = $func->secur($json_data->akt);
    $send = $func->secur($json_data->send);
    $trust = $func->secur($json_data->trust);
    $pay_price = $func->secur($json_data->pay_price);
    $pay_date = $func->secur($json_data->pay_date);
    $desc = $func->secur($json_data->desc);
    $total_price = $func->secur($json_data->total_price);
    $user_name = $func->secur($json_data->user_name);
    $new_user_name = $func->secur($json_data->new_user_name);
    $user_name = $func->secur($json_data->user_name);
    $new_user_contact = $func->secur($json_data->new_user_contact);


    $sorov = "select * from new_contract WHERE nc_id=".$id;
    $func->queryMysql($sorov);

    $row = $func->result->fetch_array(MYSQL_ASSOC);
    $pay_price = $row['pay_price']+$pay_price;
    if((isset($new_user_name) && !empty($new_user_name)) || (isset($user_name) && !empty($user_name))){
        if(isset($new_user_name) && !empty($new_user_name)){
            $sorov = "insert into
              buyers
              (
                  `buyers_name`,
                  `buyers_budget`,
                  `buyers_contact`,
                  `buyers_safety`
              )VALUES(
                  '$new_user_name',
                  '0',
                  '$new_user_contact',
                  '0'
              )";
            $result = $func->queryMysql($sorov);
            $user_id=$func->qr_id();
        }else{
            $user_id=$user_name;
        }
        $sorov = "UPDATE new_contract SET
      `buyer_id`='$user_id',
      `shartnoma`='$docx',
      `hisob_faktura`='$fak',
      `ishonchnoma`='$trust',
      `akt`='$akt',
      `yetkazib_berildi`='$send',
      `pay_date`='$pay_date',
      `description`='$desc',
      `pay_price`='$pay_price'
       WHERE `nc_id`='" . $id . "'";
    }else{
        $sorov = "UPDATE new_contract SET
      `shartnoma`='$docx',
      `hisob_faktura`='$fak',
      `ishonchnoma`='$trust',
      `akt`='$akt',
      `yetkazib_berildi`='$send',
      `pay_date`='$pay_date',
      `description`='$desc',
      `pay_price`='$pay_price'
       WHERE `nc_id`='" . $id . "'";
    }
    $result = $func->queryMysql($sorov);
    if($docx==1 && $fak==1 && $akt==1 && $send && $trust && ($pay_price>=$total_price)){
        $sorov = "UPDATE new_contract SET
      `status`='close'
       WHERE `nc_id`='".$id."'";
        $func->queryMysql($sorov);
    }
    if(empty($result)){
        echo true;
    }
//    echo $_POST['values'];
}