<?
    include_once("../DB/functions.php");
    $func = new database_func();
    $sorov = "select * from products WHERE product_barcode='".$_POST['id']."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    if($row['product_barcode']!="") {
        echo $row['product_id'];
    }

//    echo "Misol";
?>