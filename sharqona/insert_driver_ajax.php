<?php
    include_once("../DB/functions.php");
    $func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
    $json_data = json_decode($_POST['values']);
    $l_name = $func->secur($json_data->l_name);
    $f_name = $func->secur($json_data->f_name);
    $fath_name = $func->secur($json_data->fath_name);
    $tell = $func->secur($json_data->tell);
    $car_num = $func->secur($json_data->car_num);
    $car_name = $func->secur($json_data->car_name);
    $guv_num = $func->secur($json_data->guv_num);
    $guv_date = $func->secur($json_data->guv_date);
    $lit_num = $func->secur($json_data->lit_num);
    $lit_date = $func->secur($json_data->lit_date);
    $sug_num = $func->secur($json_data->sug_num);
    $sug_date = $func->secur($json_data->sug_date);
    $adress = $func->secur($json_data->adress);
    $desc = $func->secur($json_data->desc);
    $bank = $func->secur($json_data->bank);
    $pay_type = $func->secur($json_data->pay_type);
    $tarif = $func->secur($json_data->tarif);
    $pass_seria = $func->secur($json_data->pass_seria);
    $active_date = $func->secur($json_data->active_date);
    $reg_date = date("Y-m-d H:i:s");
    if($bank=="" || $bank=="0"){
        $bank=0;
    }
    $fio = $l_name . " " . $f_name . " " . $fath_name;
    if($json_data->update == 'off'){
        $info = [];
//      sql injection
        $sorov = "insert into
              drivers
              (
              `fio`,
              `tell_number`,
              `car_num`,
              `car_name`,
              `adress`,
              `guvohnoma_mum`,
              `guvohnoma_ftime`,
              `litsenziya_num`,
              `litsenziya_ftime`,
              `sugurta_num`,
              `sugurta_ftime`,
              `balance`,
              `tarif`,
              `active_date`,
              `reg_date`,
              `pass_seria`,
              `description`
              )VALUES(
              '$fio',
              '$tell',
              '$car_num',
              '$car_name',
              '$adress',
              '$guv_num',
              '$guv_date',
              '$lit_num',
              '$lit_date',
              '$sug_num',
              '$sug_date',
              '$bank',
              '$tarif',
              '$active_date',
              '$reg_date',
              '$pass_seria',
              '$desc'
              )";
        $result = $func->queryMysql($sorov);
        if(!empty($result)){
            echo "uhxshadi";
        }else{
            $sorov_id = $func->qr_id();
            $tr = $sorov_id;
            if($bank>0 && $bank!=0){
                $dr_id = $func->qr_id();
                $sorov = "insert into
              order_list
              (
              `price`,
              `pay_type`,
              `reg_date`,
              `dr_id`
              )VALUES(
              '$bank',
              '$pay_type',
              '$reg_date',
              '$dr_id'
              )";
                $result = $func->queryMysql($sorov);
            }
            echo $info = true . "=>" . $tr;
        }
    }elseif (preg_match("/[0-9]+/", $json_data->update)){
        $sorov1 = "UPDATE  `drivers` SET
                                `fio` = '$fio',
                                `tell_number` = '$tell',
                                `car_num` = '$car_num',
                                `car_name` = '$car_name',
                                `adress` = '$adress',
                                `guvohnoma_mum` = '$guv_num',
                                `guvohnoma_ftime` = '$guv_date',
                                `litsenziya_num` = '$lit_num',
                                `litsenziya_ftime` = '$lit_date',
                                `sugurta_num` = '$sug_num',
                                `sugurta_ftime` = '$sug_date',
                                `balance` = '$bank',
                                `tarif` = '$tarif',
                                `active_date` = '$active_date',
                                `description` = '$desc'
                        WHERE  `dr_id` =" . $json_data->update;
        $func->queryMysql($sorov1);
        if($bank>0&&$bank!="") {
//      update pay_type
//        select
            $sorov = "select * from drivers WHERE dr_id=" . $json_data->update;
            $func->queryMysql($sorov);
            $reg_date1 = $func->result->fetch_array(MYSQL_ASSOC);
            $reg_date1 = $reg_date1['reg_date'];

            $sorov1 = "UPDATE  `order_list` SET
                                `pay_type` = '$pay_type',
                                `price` =  '$bank'
                        WHERE  `reg_date` ='" . $reg_date1 . "'";
            $result = $func->queryMysql($sorov1);
        }else{
            $result=1;
        }
        if (!empty($result)){
            echo "uhxshadi";
        } else {
            echo $info = true . "=>" . $json_data->update;
        }

    }
}