<?php
/**
 * Created by Radon
 * Date: 12/18/2019
 * Time: 3:20 PM
 */


include_once("S.H.I.E.L.D.php");
include_once("config.php");

$keyword = $_GET['keyword'];
$savdoturi = $_GET['savdoturi'];

try{
    $conn = new PDO(_DB_['host'],_DB_['user'],_DB_['pass']);
}catch (PDOException $e){
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}

//get products
$stmt = $conn->prepare("SELECT * FROM cityservice_uz.products WHERE `product_name` LIKE ('%".$keyword."%')");
$stmt->execute();

//get dollar value
$stmtDollar = $conn->prepare("SELECT * FROM cityservice_uz.dollar WHERE dollar_id = 1");
$stmtDollar->execute();
$rowDollar = $stmtDollar->fetch();
$dollar = $rowDollar['dollar_value']*1;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search page for Compass Finder v1</title>
    <link rel="stylesheet" href="style.css?25">
</head>
<body>
<!--cards here starts-->
<!--dollar kursi-->
<!--<div class="dollar">$:--><?//= $dollar echo $numRows?><!--</div>-->
<div class="cards">
<?php

    $i = 0;
    while ($row = $stmt->fetch()) { $i++;
//        if ($row["product_count"] == 0) continue;

        if ($row["product_count"] == 0){
            echo '<div class="card count0_bg">';
        }else{
            echo '<div class="card count1_bg">';
        }
        $count =  $row["product_count"] == 0 ? "qolmagan" : $row["product_count"] ;
        echo '
                <div class="card_img"><img src="https://city-service.uz/images/';
        if($row["product_img"] != "")
            echo $row["product_img"].'"';
        else
            echo 'noimage.jpg"';
        echo 'alt="img"></div>
                <div class="card_content">
                    <p class="card_name">'.$row["product_name"].'</p>';
//                    '<p class="card_price_out">Narxi: '.$row["product_prise_out"].' $</p>'

        if($savdoturi == 1){
            echo '<p class="card_price_out">UZS '.number_format(round($row["product_prise_out"] * $dollar / 0.85,-2)).'</p>';
        }else{
            echo '<p class="card_price_out">UZS '.number_format($row["product_prise_out"] * $dollar).'</p>';
        }

        echo'<p class="card_count">Soni: '.$count.'</p>
            </div>
            </div>';
    }
    if ($i == 0)
        echo "<h1 style='text-align: center'>No data :(</h1>";
?>
</div>
<!--cards end-->


<!--    card template-->
<!--<div class="card">-->
<!--    <div class="card_img"><img src="https://city-service.uz/images/noimage.jpg" alt="wtf"></div>-->
<!--    <div class="card_content">-->
<!--        <p class="card_name"></p>-->
<!--        <p class="card_price_in"></p>-->
<!--        <p class="card_price_out"></p>-->
<!--        <p class="card_count"></p>-->
<!--    </div>-->
<!--</div>-->
</body>
</html>
