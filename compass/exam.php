<?

include_once("../DB/functions.php");

$func = new database_func();

$sorov = "select * from accept_notifications INNER JOIN users on accept_notifications.notification_user=users.user_id ORDER BY accept_notifications.notification_id DESC";

$func->queryMysql($sorov);

$text = "";

$num=0;
$buyer="";
while($row = $func->result->fetch_array(MYSQL_ASSOC)){
        if($row['buyer_id']!=10){
            $buyer="<span style='color:white;font-weight:900;padding:3px;background:red;display:inline-block;margin-right:5px;'>T</span>";
        }else{ $buyer="<span style='color:white;font-weight:900;padding:3px;background:red;display:inline-block;margin-right:5px;'>K</span>";}

    if($row['notification_storage']==1){

        $etab[$num] = 'Podval';

    }

    elseif($row['notification_storage']==3){

        $etab[$num] = '2-Qavat';

    }

if ($row['notification_id']!="") {

//    echo $row['notification_id']."=>".$row['client_name']."=>".$row['notification_storage']."=>".$row['notification_time']."=>".$row['notification_user'];

    $text .="                                    <li class='active'>

                                        <a href='/compass/accept_form.php?notid=".$row['notification_id']."'>

                                            <span class='image'>

                                                <img src='assets/images/".$row['user_image']."' width='44' alt='' class='img-circle' />

                                            </span>



                                            <span class='line'>

                                                <strong>".$row['user_name']."</strong>

                                                ".$row['notification_time']."

                                            </span>



                                            <span class='line desc small summary'>

                                                ".$buyer.$row['notification_desc']. "

                                            </span>



                                            <span class='line pull-right storageactive'>

                                                <i class='glyphicon glyphicon-shopping-cart'> </i> ".$etab[$num]." / 

                                            </span>



                                            <span class='line pull-right usdactive'>

                                                <i class='glyphicon glyphicon-usd'> </i>

                                                ".number_format($row['total'])." / 

                                            </span>



                                            <span class='line pull-right nameactive'>

                                                <i class='glyphicon glyphicon-user'> </i> ".$row['user_name']." / 

                                            </span>

                                        </a>

                                    </li>";

        $num++;

        }

        else {

            $text .= "<li>You have 0 Notifications</li>";

        }

    }

$text.="<input type='hidden' id='num' value='$num'/>";

echo $text;

?>