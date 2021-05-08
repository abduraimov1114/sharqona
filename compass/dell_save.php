<?php session_start(); ?>
<?php ob_start(); ?>
<?

include_once("../DB/functions.php");

$func = new database_func();

if(isset($_GET['dell']) AND isset($_GET['storage'])){

	$storage = $_GET['storage'];

    $sorov = "delete from saved WHERE saved_id=" . $_GET['dell'];

    $func->queryMysql($sorov);

    $sorov1 = "delete from saved_datails WHERE saved_id=" . $_GET['dell'];

    $func->queryMysql($sorov1);

    $_SESSION['xabar'] = 'success';

    if ($storage == 1) {

    	$url = 'saved_accepts_padval.php';

    }

    elseif ($storage == 3) {

    	$url = 'saved_accepts_lab.php';

    }
    elseif ($storage == 2) {

    	$url = 'saved.php';

    }

    else {

    	die();

    }

    header("Location: $url");

} 

else {

	die();

}

?>