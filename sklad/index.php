<?
    include_once('../DB/functions.php');
    $func = new database_func();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

            #myInput {

            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th, #myTable td {
            text-align: left;
            padding: 12px;
        }

       #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
Select: <select name=""  id="panel">
    <?
    $sorov="select * from saved_datails INNER JOIN saved ON saved_datails.saved_id=saved.saved_id";
    $func->queryMysql($sorov);
    while($row=$func->result->fetch_array(MYSQL_ASSOC)){
    ?>
        <option id="id_<? echo $row['sd_id']; ?>" value="<? echo $row['one_price']; ?>"><? echo $row['one_price']; ?></option>
    <?}?>
</select><br/><br/>
<script>
//    var select1=document.getElementById('id_71').selected=true;
</script>
<table id="myTable">
    <tr class="header">
        <th>saved_id</th>
        <th>buyer_id</th>
        <th>saved_times</th>
        <th>ps_id</th>
        <th>count</th>
        <th>one_price</th>
        <th>is_product</th>
    </tr>
        <?
            $sorov="select * from saved_datails INNER JOIN saved ON saved_datails.saved_id=saved.saved_id";
            $func->queryMysql($sorov);
            while($row=$func->result->fetch_array(MYSQL_ASSOC)){
        ?>
    <tr>
        <td><? echo $row['saved_id']; ?></td>
        <td><? echo $row['buyer_id']; ?></td>
        <td><? echo $row['saved_times']; ?></td>
        <td><? echo $row['ps_id']; ?></td>
        <td><? echo $row['count']; ?></td>
        <td><? echo $row['one_price']; ?></td>
        <td><? echo $row['is_product']; ?></td>
    </tr>
        <? } ?>
</table>
<!---->
</body>
<!---->
</html>