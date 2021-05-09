		<!-- /Footercha -->
		<!-- Bu yerda xam skriptlar -->
		<?php require_once 'addincludes/footer.php'; ?>
		<?php require_once 'addincludes/scripts.php' ?>
		<!-- Imported styles on this page -->
		<link rel="stylesheet" href="assets/js/datatables/datatables.css">
		<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
		<link rel="stylesheet" href="assets/js/select2/select2.css">
		<link rel="stylesheet" href="assets/css/custom.css">
		<!-- Imported scripts on this page -->
		<script src="assets/js/datatables/datatables.js"></script>
		<script src="assets/js/neon-chat.js"></script>
		<script src="assets/js/custom.js"></script>
		<script src="assets/js/custom3.js"></script>
		<script src="assets/js/select2/select2.min.js"></script>
		<script src="assets/js/pay.js"></script>
		<!-- /Bu yerda xam skriptlar -->
		<script type="text/javascript">
		  jQuery(document).ready(function($)
		  {
		        var opts = {
		        "closeButton": true,
		        "debug": false,
		        "positionClass": "toast-bottom-left",
		        "onclick": null,
		        "showDuration": "300",
		        "hideDuration": "1000",
		        "timeOut": "0",
		        "extendedTimeOut": "0",
		        "showEasing": "swing",
		        "hideEasing": "linear",
		        "showMethod": "fadeIn",
		        "hideMethod": "fadeOut"
		      };
		      toastr.info("<?php echo $ombor; ?>", "Ombor", opts);
		      toastr.success("Jismoniy shaxslarga savdo", "Savdodagi tashkilot", opts);
		    });
		  ;
		</script>

		<script src="assets/js/toastr.js"></script>
	</body>
</html>