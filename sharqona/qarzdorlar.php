<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>

<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		die("<h1 align='center'>Let's get out of here!</h1>");
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Compass Group Admin Panel" />
	<link rel="icon" href="assets/images/favicon.ico">
	<title>Tashkilotlarning qarzdorlik ko'rsatgichi</title>
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

<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
	var $table4 = jQuery( "#table-4" );
	
	$table4.DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		]
	} );
} );		
</script>
<h2>Tashkilotlarning qarzdorlik ko'rsatgichi</h2><br>
<table class="table table-bordered table-striped datatable" id="table-4">
	<thead>
		<tr>
			<th>№</th>
			<th>Tashkilot Ismi</th>
			<th>Qarzdorligi</th>
			<th>Bog'lanish</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$n = 0;
			$query = "SELECT * FROM buyers WHERE buyers_budget < 0 ORDER BY buyers_budget ASC";
			$service_query = mysqli_query($connection, $query);
			while ($row = mysqli_fetch_assoc($service_query)) {
				$buyers_id = $row['buyers_id'];
				$buyers_name = $row['buyers_name'];
				$buyers_budget = $row['buyers_budget'];
				$buyers_contact = $row['buyers_contact'];
				$n++;
			 ?>
		<tr class="odd gradeX">
			<td><?php echo $n; ?></td>
			<td><?php echo $buyers_name; ?></td>
			<td><span class="badge badge-secondary"><?php echo number_format($buyers_budget); ?></span></td>
			<td><span class="badge badge-info"><?php echo $buyers_contact; ?></span></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>№</th>
			<th>Tashkilot Ismi</th>
			<th>Qarzdorligi</th>
			<th>Bog'lanish</th>
		</tr>
	</tfoot>
</table>

<!-- Footercha -->
		<br />
		<footer class="main">
			&copy; 2021 <strong>Sharqona Group</strong> All Rights Reserved
		</footer>
	</div>
</div>
<!-- /Footercha -->
<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/datatables/datatables.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/datatables/datatables.js"></script>
	<script src="assets/js/select2/select2.min.js"></script>
<!-- Imported styles on this page -->
</body>
</html>