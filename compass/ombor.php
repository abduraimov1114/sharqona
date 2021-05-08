<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php';
?>
<?php
if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
    die("<h1 align='center'>Let's get out of here!</h1>");
}
if (isset($_GET['inventory'])) {
	$inventory = $_GET['inventory'];
	$inventory = mysqli_real_escape_string($connection, $inventory);
	if ($inventory == 1) {
		$inv_name = "Podval";
	}
	elseif ($inventory == 3) {
		$inv_name="Laboratoriya";
	}
	else {
		die("Bunday ombor mavjud emas");
	}
}
else {
	$_SESSION['xabar'] = 'xato';
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Compass Group Admin Panel" />
    <link rel="icon" href="assets/images/favicon.ico">
    <title>Ombor holati <?=$inv_name?></title>
    <!-- Bu yerda scriptlar -->
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/neon-core.css">
    <link rel="stylesheet" href="assets/css/neon-theme.css">
    <link rel="stylesheet" href="assets/css/neon-forms.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!-- Bu yerda scriptlar -->
</head>
<body class="page-body">
	<div class="page-container">

	    <?php require_once 'addincludes/sidebar.php'; ?>
	    <?php require_once 'addincludes/userinfo.php'; ?>

	    <!-- Shu yerdan asosiy conternt -->
	    <script type="text/javascript">
	        jQuery( document ).ready( function( $ ) {
	            var $table1 = jQuery( '#table-1' );

	            // Initialize DataTable
	            $table1.DataTable( {
	                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	                "bStateSave": true
	            });

	            // Initalize Select Dropdown after DataTables is created
	            $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
	                minimumResultsForSearch: -1
	            });
	        } );
	    </script>
	    <h3 style="text-align: center;">Ombor holati <?=$inv_name?></h3>
	    <table class="table prices" id="table-1">
	        <thead>
	        <tr class="replace-inputs">
	            <th width="10%">Product ID</th>
	            <th>Product Name</th>
	            <th>Product Quantity</th>
	        </tr>
	        </thead>
	        <tbody>
	            	<?php 
	            		$query = "SELECT * FROM master_storage WHERE storage_id = '$inventory'";
	            		$queryGo = mysqli_query($connection, $query);
	            		if (!$queryGo) {
	            			die("Error connecting database");
	            		}
	            		else {
	            			while ($row = mysqli_fetch_assoc($queryGo)) {
	            				$product_id = $row['product_id'];
	            				$product_quantity = $row['product_quantity'];
	            				$query_name = "SELECT product_name FROM products WHERE product_id = '$product_id'";
	            				$result_name = mysqli_query($connection, $query_name);
	            				if (!$result_name) {die('Connection error');}
            					else {
            						$name = mysqli_fetch_array($result_name);
            						$product_name = $name['product_name'];
            						echo "<tr class='odd gradeX'>";
            						echo "<td class='text-center'>$product_id</td>";
            						echo "<td class='text-center'>$product_name</td>";
            						echo "<td class='text-center'>$product_quantity</td>";
            						echo "</tr>";
            					}
	            			}
	            		}
	            	?>
	        </tbody>
	    </table><br>
	</div>
</div>
<!-- /Footercha -->
<!-- Bu yerda xam skriptlar -->
<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/bootstrap-tagsinput.min.js"></script>
<script src="assets/js/typeahead.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/daterangepicker/daterangepicker.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/icheck/icheck.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

<!-- /Bu yerda xam skriptlar -->
</body>
</html>