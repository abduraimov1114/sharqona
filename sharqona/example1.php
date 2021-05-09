<?
    include_once("../DB/functions.php");
    $func = new database_func();
    $sorov = "select * from services WHERE service_barcode='".$_POST['id']."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    if($row['service_barcode']!=""){
        echo $row['service_id'];
    }
?>