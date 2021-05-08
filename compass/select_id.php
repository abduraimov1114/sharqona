<?php
include_once("../DB/functions.php");
$func = new database_func();

    $sorov = "select max(nc_id) from new_contract";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
//    if(empty($result)){
        echo $row['max(nc_id)']+1;
//    }
