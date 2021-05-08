<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Xizmat g`azna shartnomasi</title>
</head>
<body>
<?php
include_once("../DB/functions.php");
$func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
    $json_data = json_decode($_POST['values']);
    $type = $func->secur($json_data->type);
    $company = $func->secur($json_data->company);
    $check_date = $func->secur($json_data->check_date);
    $user_name = $func->secur($json_data->user_name);
    $new_user_name = $func->secur($json_data->new_user_name);
    $new_user_contact = $func->secur($json_data->new_user_contact);

    $product_name = $json_data->product_name;
    $product_count =$json_data->product_count;
    $product_price = $json_data->product_price;

    $product_total = $func->secur($json_data->product_total);

    $service_name =  $json_data->service_name;
    $service_count = $json_data->service_count;
    $service_price = $json_data->service_price;

    $service_total = $func->secur($json_data->service_total);
    $contract_type = $func->secur($json_data->contract_type);
}
?>
<div>
<!--    <div style="text-align: center;color:red;">-->
<!--        <h2>Umimiy ma`lumotlar</h2>-->
<!--        <p>companiya: --><?// echo $company; ?><!--</p>-->
<!--        <p>Belgilangan muddat: --><?// echo $check_date; ?><!--</p>-->
<!--        <p>Foydalanuvchi ismi: --><?// echo $user_name; ?><!--</p>-->
<!--        <p>Yangi foydalanuvchi ismi: --><?// echo $new_user_name; ?><!--</p>-->
<!--        <p>Yangi foydalanuvchi kontakti: --><?// echo $new_user_contact; ?><!--</p>-->
<!--        <p>Maxsulot umumiy qiymati: --><?// echo $product_total; ?><!--</p>-->
<!--        <p>Service umumiy qiymati: --><?// echo $service_total; ?><!--</p>-->
<!--        <p>Kontrakt turi: --><?// echo $contract_type; ?><!--</p>-->
<!--    </div>-->
<!--    <div style="text-align: center;color:green;">-->
<!--        <h3>Servis uchun</h3>-->
<!--        --><?// for($i=0;$i<count($service_name);$i++){ ?>
<!--            <p>Servis nomi: --><?// echo $service_name[$i]; ?><!-- Servislar soni: --><?// echo $service_count[$i]; ?><!-- Servis narxi: --><?// echo $service_price[$i]; ?><!--</p>-->
<!--        --><?//}?>
<!--    </div>-->
<!--    <div style="text-align: center;color:#0000C0;">-->
<!--        <h3>Maxsulot uchun</h3>-->
<!--        --><?// for($i=0;$i<count($product_name);$i++){ ?>
<!--            <p>Maxsulot nomi: --><?// echo $product_name[$i]; ?><!-- Maxsulot soni: --><?// echo $product_count[$i]; ?><!-- Maxsulot narxi: --><?// echo $product_price[$i]; ?><!--</p>-->
<!--        --><?//}?>
<!--    </div>-->
<!--</body>-->
<!--</html>-->
</div>
<?
