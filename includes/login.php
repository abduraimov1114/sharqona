<?php 
session_start();
ob_start();
require_once 'db.php';

	if (md5($_POST['norobot']) == $_SESSION['randomnr2'])	{ 
		
		if (isset($_POST ['login'] )) {
			if ( empty ($_POST ['email'] ) || empty($_POST ['pass'] )) {
				header ("Location: /index.php");
			}
			else {
				// Terilganlani vremenkaga saqlab olamiz!
				$user_Email = $_POST ['email'];
				$user_Pass = $_POST ['pass'];
				// Saqlanganlani bazaga zapros tashashdan oldin tozalab olamiz!
				$user_Email = mysqli_real_escape_string ( $connection, $user_Email);
				$user_Pass = mysqli_real_escape_string ( $connection, $user_Pass);
				// Bazaga zapros tashlashni boshlaymiz!
				$query = "SELECT * FROM users WHERE user_email = '$user_Email' ";
				$result_db = mysqli_query ($connection, $query);
				// Bazaga zaprosda xatolik ro'y bersa programmani o'ldiramiz!
				if (!$result_db) {
					die ("Bazaga zaprosda xatolik ro'y bersa programmani o'ldiramiz!");
				}
				// Shunday emailli foydalanuvchi bor yoqligini tekshiramiz! Bo'lsa vremenkaga saqlaymiz!
				$count_user = mysqli_num_rows ($result_db);
				if ($count_user == 1) {
					while ( $row = mysqli_fetch_assoc ($result_db)) {
						$db_user_id = $row ['user_id'];
						$db_user_email = $row ['user_email'];
						$db_user_pass = $row ['user_password'];
						$db_user_name = $row ['user_name'];
						$db_user_image = $row ['user_image'];
						$db_user_role = $row ['user_role'];
					}
					if ($db_user_email !== $user_Email || $db_user_pass !== md5($user_Pass)) {
						$_SESSION ['user_type_wrong'] = 'xato';
						header("Location: /index.php");
					}

					elseif ($db_user_email == $user_Email && $db_user_pass == md5($user_Pass)) {
						$_SESSION['ses_user_id'] = $db_user_id;
						$_SESSION['ses_user_name'] = $db_user_name;
						$_SESSION['ses_user_role'] = $db_user_role;
						$_SESSION['ses_user_image'] = $db_user_image;
						header("location: /sharqona");
					}

					else {
						header("Location: /index.php");
					}
				}


				else {
					$_SESSION ['user_type_wrong'] = 'xato';
					header("Location: /index.php");
				}


			}
		}
		else {
			header("Location: /index.php");
		}
			
	}	else {  
		
		$_SESSION ['user_type_wrong'] = 'xato';
		header("Location: /index.php");
			
	}



?>