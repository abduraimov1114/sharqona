<?php 
$db_host = 'localhost';
$db_user = 'admin_superadmin';
$db_pass = 'zA^t*2N1KyJbUTZ';
$db_base = 'admin_compass';
$connection = mysqli_connect ($db_host, $db_user, $db_pass, $db_base);
if (!$connection) {
	die('Database Connection Error');
}

mysqli_set_charset($connection,"utf8");
date_default_timezone_set('Asia/Tashkent');
error_reporting(E_ERROR);
?>