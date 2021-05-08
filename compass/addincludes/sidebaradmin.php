<?php 
if ($session_role !== 'Admin') {die("Lets get out of here stranger!");}
?>

<div class="sidebar-menu">

		<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.php">
						<img src="assets/images/logo@2x.png" width="120" alt="" />
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>
			

			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<?php if (strpos($_SERVER['REQUEST_URI'], 'street_outgoings') == true): ?>
							<li class="active">
				<?php else: ?>
							<li>
				<?php endif ?>
					<a href="outgoings.php?source=street_outgoings">
					<i class="entypo-paper-plane"></i>
					<span class="title">Ko'chaga savdo</span>
					</a>
				</li>

				<?php if (strpos($_SERVER['REQUEST_URI'], 'saved.php') == true): ?>
			<li class="active">
			<?php else: ?>
				<li>
					<?php endif ?>
					<a href="saved.php">
						<i class="entypo-install"></i>
						<span class="title">Saqlangan ishlar Magazin</span>
						<span class="badge badge-info">
							<?php 
								$query = "SELECT COUNT(*) as total FROM saved WHERE storage_id = 2";
								$savings = mysqli_query($connection, $query);
								if (!$savings) {
									die('Tanlashda xatolik');
								}
								else {
									$savings_result = mysqli_fetch_array($savings);
									$result = $savings_result['total'];
									echo $result;
								}
							 ?>
						</span>
					</a>
				</li>

				<?php if (strpos($_SERVER['REQUEST_URI'], 'categories') == true): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif ?>
					<a href="categories.php">
						<i class="entypo-folder"></i>
						<span class="title">Kategoriyalar boshqaruvi</span>
					</a>
			</li>

						
				<?php if (strpos($_SERVER['REQUEST_URI'], 'products') == true): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif ?>
					<a href="products.php">
						<i class="entypo-basket"></i>
						<span class="title">Mahsulotlar boshqaruvi</span>
					</a>
			</li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'movings') == true): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif ?>
					<a href="movings.php">
						<i class="entypo-minus-circled"></i>
						<span class="title">Mahsulotlar ko'chiruvi</span>
					</a>
			</li>
			

			<!-- Shotdan ikkinchi Menyu -->
				
				<?php if (strpos($_SERVER['REQUEST_URI'], 'services') == true): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif ?>
					<a href="services.php">
						<i class="entypo-monitor"></i>
						<span class="title">Xizmatlar boshqaruvi</span>
					</a>
			</li>
				<!-- Tugadi 2-Menyu -->

				<!-- Shotdan uchunchi Menyu -->
				
				<?php if (strpos($_SERVER['REQUEST_URI'], 'organizations') == true): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif ?>
					<a href="organizations.php">
						<i class="entypo-briefcase"></i>
						<span class="title">Tashkilotlar boshqaruvi</span>
					</a>
			</li>

			<li>
				<a href="/compass/price" target="_blank">
				<i class="entypo-print"></i>
				<span class="title">Price List</span>
				</a>
			</li>


					<!-- Tugadi 3-Menyu -->
					<?php if (strpos($_SERVER['REQUEST_URI'], 'returns_page') == true): ?>
								<li class="active">
					<?php else: ?>
								<li hidden="">
					<?php endif ?>
						<a href="returns_page.php">
						<i class="entypo-retweet"></i>
						<span class="title">Qaytarilish</span>
						</a>
					</li>

					<?php if (strpos($_SERVER['REQUEST_URI'], 'accept_form') == true): ?>
								<li class="active">
					<?php else: ?>
								<li hidden="">
					<?php endif ?>
						<a href="#">
						<i class="entypo-check"></i>
						<span class="title">Tasdiqlash</span>
						</a>
					</li>

					<li class="lenta"></li>
					
					<?php 
						$url1 = strpos($_SERVER['REQUEST_URI'], 'saved_accepts_lab');
						$url2 = strpos($_SERVER['REQUEST_URI'], 'saved_accepts_padval');
						if ($url1 OR $url2) {
							$active = "opened active";
						}
						else {
							$active = "";
						}
					?>
					<li class="has-sub <?php echo $active; ?>">
						<a href="#">
							<i class="entypo-download"></i>
							<span class="title">Saqlangan ishlar</span>
						</a>
						<ul>	
							<?php if ($url1 == true): ?>
							<li class="active">
							<?php else: ?>
								<li>
									<?php endif ?>
									<a href="saved_accepts_lab.php">
										<span class="title">Laboratoriya</span>
										<span class="badge badge-success">
											<?php 
												$query = "SELECT COUNT(*) as total FROM saved WHERE storage_id = 3";
												$savings = mysqli_query($connection, $query);
												if (!$savings) {
													die('Tanlashda xatolik');
												}
												else {
													$savings_result = mysqli_fetch_array($savings);
													$result = $savings_result['total'];
													echo $result;
												}
											 ?>
										</span>
									</a>
								</li>
								<?php if ($url2 == true): ?>
							<li class="active">
							<?php else: ?>
								<li>
									<?php endif ?>
									<a href="saved_accepts_padval.php">
										<span class="title">Podval</span>
										<span class="badge badge-info">
											<?php 
												$query = "SELECT COUNT(*) as total FROM saved WHERE storage_id = 1";
												$savings = mysqli_query($connection, $query);
												if (!$savings) {
													die('Tanlashda xatolik');
												}
												else {
													$savings_result = mysqli_fetch_array($savings);
													$result = $savings_result['total'];
													echo $result;
												}
											 ?>
										</span>
									</a>
								</li>
						</ul>
					</li>
			</ul>
			
		</div>
</div>