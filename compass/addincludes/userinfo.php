    <div class="main-content">
    	<div class="row hidden-print">
    		<div class="col-md-9 col-sm-9 clearfix">
    			<ul class="user-info pull-left pull-none-xsm">
    				<li class="profile-info dropdown">
    					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="assets/images/<?php echo $session_image;?>" class='img-circle' width='44'>
                            <?php 
                                if (isset($session_name)) {
                                    echo $session_name;
                                }
                                else {
                                    die('Lets get out of here');
                                }
                             ?>
    					</a>
    				</li>
                <?php if ($session_role == 'Admin'): ?>

                    <li class="notifications dropdown">
                        <a href="#" onclick="data1()" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"><i class="entypo-bell"></i><span class="badge badge-secondary" id="count">0</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>                                
                                <ul id="divs" class="dropdown-menu-list" style="padding: 5px;">
                                <!-- Shu yerda opovoshenie -->
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <script src="../../compass/assets/js/select.js"></script>                    
                <?php endif ?>
    			</ul>
    		</div>
    		<?php 
        		if (isset($_POST['dollar'])) {
        			$kurs = $_POST['dollar_value'];
        			$kurs = mysqli_real_escape_string($connection, $kurs);
        			$ready_dollar = "UPDATE dollar SET dollar_value = '$kurs' WHERE dollar_id = 1";
        			$update_dollar = mysqli_query($connection, $ready_dollar);
        			if (!$update_dollar) {
        				die("Dollarni yangilashda xatolik");
        			}
        			else {
        				header("Refresh:0");
        			}
        		}
    		?>
    		<div class="col-md-3 col-sm-3 clearfix">
    			<ul class="list-inline links-list pull-right">
                    
                    <?php if ($session_role == 'Admin' OR $session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
    			    <li>
    					<a style="color:white;" href="/compass/statistics.php" class="btn btn-danger">
    						Hisobotlar <i class="entypo-chart-pie right"></i>
    					</a>
    				</li>
                    <?php endif ?>

    				<li>
    					<a style="color:white;" href="/includes/logout.php" class="btn btn-gold">
    						Chiqish <i class="entypo-logout right"></i>
    					</a>
    				</li>    				
    			</ul>
    		</div>
    		<div class="clearfix"></div>

            <?php if ($session_role !== 'Master'): ?>
    		<div class="col-md-4 col-sm-4 pull-left">
    			<form action="" method="post">
    			     <div class="input-group"> <input type="number" step="any" min="0" name="dollar_value" class="form-control">
                        <span class="input-group-btn"> <button class="btn btn-primary" type="submit" name="dollar">
                            <div class="icon"><i class="entypo-star"></i> <?php echo $sum; ?> Sum</div></button>
                        </span>
                     </div>
    			</form>
    		</div>
            <?php endif ?>

    	</div>
		<div class="col-md-12">
		</div>
		<hr />
        <script>

        </script>
        <?php 
                
                if (isset($_SESSION['xabar'])) {
                echo "<br />";
                $xabar = $_SESSION['xabar'];

                if ($xabar == "xato") {
                    echo '<div class="alert alert-danger"><strong>Tizimda xatolik!</strong> Iltimos kiritilayotgan ma\'lumotlarni yana bir bor tekshirib ko\'ring.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "success") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Bajarilgan amal muvaffaqiyatli yakunlandi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "produkt_yaratildi") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Tizimda yangi mahsulot muvaffaqiyatli yaratildi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "service_yaratildi") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Tizimda yangi xizmat muvaffaqiyatli yaratildi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "org_yaratildi") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Tizimda yangi tashkilot muvaffaqiyatli yaratildi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "org_deleted") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Tashkilot muvaffaqiyatli o\'chirib tashlandi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "ser_deleted") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Xizmat turi muvaffaqiyatli o\'chirib tashlandi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "pro_deleted") {
                    echo '<div class="alert alert-success"><strong>Muvaffaqiyatli!</strong> Mahsulot muvaffaqiyatli o\'chirib tashlandi.</div>';
                    $_SESSION['xabar'] = null;
                }

                if ($xabar == "backmax") {
                    echo '<div class="alert alert-danger"><strong>Xatolik!</strong> Qaytarilayotgan maxsulot soni sotilgan maxsulot sonidan oshib ketmoqda!</div>';
                    $_SESSION['xabar'] = null;
                }

            } 

            if (isset($_SESSION['proback'])) {
                $xabar1 = $_SESSION['proback'];
                echo "<div class='alert alert-success'><strong>Muvaffaqiyatli!</strong> $xabar1</div>";
                $_SESSION['proback'] = null;
            }            

            if (isset($_SESSION['newbudget'])) {
                $xabar2 = $_SESSION['newbudget'];
                echo "<div class='alert alert-success'><strong>Muvaffaqiyatli!</strong> $xabar2</div>";
                $_SESSION['newbudget'] = null;
            }

            ?>
