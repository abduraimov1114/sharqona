<?
    include_once("../DB/functions.php");
    $func = new database_func();
    $sorov = "select * from buyers ";
    $func->queryMysql($sorov);
    while($row = $func->result->fetch_array(MYSQL_ASSOC)){
        $val = $row['buyers_name'];
        echo "<option value=$val>";
    }

//    echo "Misol";
?>