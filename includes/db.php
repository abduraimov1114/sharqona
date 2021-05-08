<?php 
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_base = 'magazin9';
$connection = mysqli_connect ($db_host, $db_user, $db_pass, $db_base);
if (!$connection) {
	die('Database Connection Error');
}

mysqli_set_charset($connection,"utf8");
date_default_timezone_set('Asia/Tashkent');
error_reporting(E_ERROR);
?>