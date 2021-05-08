<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php 
	if (isset($_POST['option'])) {
		if ($_POST['option'] != '') {
			$update = "UPDATE accept_notifications SET notification_status = 1 WHERE notification_status = 0";
			mysqli_query($connection, $update);
		}

		$select = "SELECT * FROM accept_notifications ORDER BY notification_id";
		$notifications = mysqli_query($connection, $select);
		$output = '';

		if (mysqli_num_rows($notifications) > 0) {
			while ($tempnotification = mysqli_fetch_array($notifications)) {
				$output .= "
					
					<li>                                
					    <ul class='dropdown-menu-list scroller' style='padding: 5px;'>
					        <li class='active'>
					            <a href='#'>
					                <span class='image'>
					                    <img src='assets/images/thumb-1@2x.png' width='44' class='img-circle' />
					                </span>
					                
					                <span class='line'>
					                    <strong>Giyos safarov</strong>
					                    - 23.12.2020 23:12
					                </span>
					                
					                <span class='line desc small summary'>
					                    Aka blyat podtverdit qivoring shuni bir soatdan bera kutaman!
					                </span>

					                <span class='line pull-right storageactive'>
					                    <i class='glyphicon glyphicon-shopping-cart'> </i> Podval 
					                </span>

					                <span class='line pull-right usdactive'>
					                    <i class='glyphicon glyphicon-usd'> </i> 25000 | 
					                </span>

					                <span class='line pull-right nameactive'>
					                    <i class='glyphicon glyphicon-user'> </i> Mominjon | 
					                </span>
					            </a>
					        </li>
					    </ul>
					</li>

				";
			}
		}

		else {
			$output = "<li>You have 0 Notifications</li>";
		}

		$status_query = "SELECT * FROM accept_notifications WHERE notification_status = 0";
		$status_query_result = mysqli_query($connection, $status_query);
		$countnot = mysqli_num_rows($status_query_result);
		$data = array(
			'notification' => $output,
			'UnreadNotification' => $countnot
		);

		echo json_encode($data);
	}



 ?>