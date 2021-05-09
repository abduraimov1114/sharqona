<?php 
    if (isset($_SESSION['ses_user_id'])) {
        $session_id = $_SESSION['ses_user_id'];
    }
    else {
        die('Unorganized User Detected');
    }
    if (isset($_SESSION['ses_user_image'])) {
        $session_image = $_SESSION['ses_user_image'];
    }
    else {
        die('Unorganized User Detected');
    }
    if (isset($_SESSION['ses_user_name'])) {
        $session_name = $_SESSION['ses_user_name'];
    } 
    else {
        die('Unorganized User Detected');
    }
    if (isset($_SESSION['ses_user_role'])) {
        $session_role = $_SESSION['ses_user_role'];
    }
    else {
        die('Unorganized User Detected');
    }
?>

<?php
    if ($session_role == 'Superadmin') {
        require_once 'addincludes/sidebarall.php';
    }
    elseif ($session_role == 'Direktor') {
        require_once 'addincludes/sidebarhead.php';
    }
    elseif ($session_role == 'Admin') {
        require_once 'addincludes/sidebaradmin.php';
    }
    elseif ($session_role == 'Master') {
        require_once 'addincludes/sidebarmaster.php';
    }
?>