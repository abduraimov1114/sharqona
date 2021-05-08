<?php include_once "db.php" ?>
<?php 
$dollar_select = "SELECT * FROM dollar WHERE dollar_id = 1";
$dollar_me = mysqli_query($connection, $dollar_select);
$dollar_you = mysqli_fetch_row($dollar_me);
$dollar = $dollar_you[1];
$sum = $dollar;

 ?>