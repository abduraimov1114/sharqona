<?php

	session_start();
	$_SESSION['ses_user_id'] = null;
	$_SESSION['ses_user_name'] = null;
	$_SESSION['ses_user_role'] = null;
	$_SESSION['ses_user_image'] = null;
	header("location: /index.php");

 ?>