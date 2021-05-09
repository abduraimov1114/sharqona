<?php
include_once("../DB/functions.php");
$func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
    $sorov = "UPDATE new_contract SET `status`='cancel' WHERE `nc_id`='".$_POST['values']."'";
    $result = $func->queryMysql($sorov);
    if(empty($result)){
        echo true;
    }
}