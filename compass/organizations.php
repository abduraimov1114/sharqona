<?php require_once 'addincludes/head.php' ?>
<link rel="stylesheet" href="assets/css/select2.min.css">
</head>
<body class="page-body" data-url="http://neon.dev">
<div class="page-container">
	
<?php require_once 'addincludes/sidebar.php'; ?>
<?php require_once 'addincludes/userinfo.php'; ?>

<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
	var $table3 = jQuery("#table-3");
	
	var table3 = $table3.DataTable( {
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
	} );
	
	// Initalize Select Dropdown after DataTables is created
	$table3.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
		minimumResultsForSearch: -1
	});
	
	// // Setup - add a text input to each footer cell
	// $( '#table-3 tfoot th' ).each( function () {
	// 	var title = $('#table-3 thead th').eq( $(this).index() ).text();
	// 	$(this).html( '<input type="text" class="form-control" />' );
	// } );
	
	// // Apply the search
	// table3.columns().every( function () {
	// 	var that = this;
	
	// 	$( 'input', this.footer() ).on( 'keyup change', function () {
	// 		if ( that.search() !== this.value ) {
	// 			that
	// 				.search( this.value )
	// 				.draw();
	// 		}
	// 	} );
	// } );
} );
</script>

	
<?php 

	if (isset($_GET['source'])) {
		$source = $_GET['source'];
	}
	else {
		$source = '';
	}

	switch ($source) {
		
		case 'add_organization':
			include "addincludes/add_organization.php";
			break;

			case 'edit_organization':
			include "addincludes/edit_organization.php";
			break;

		
		default:
			include "addincludes/allorganizations.php";
			break;
	}

 ?>












<?php require_once 'addincludes/footer.php'; ?>
<?php require_once 'addincludes/scripts.php' ?>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">


<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>

<script src="assets/js/neon-chat.js"></script>
<script src="assets/js/select2.min.js"></script>

</body>
</html>