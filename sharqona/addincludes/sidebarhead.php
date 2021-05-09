<?php 
if ($session_role !== 'Direktor') {die("Lets get out of here stranger!");}
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

			<?php if (strpos($_SERVER['REQUEST_URI'], 'incoma') == true): ?>
				<li class="active">
			<?php else: ?>
				<li>
			<?php endif ?>
				<a href="/sharqona/incoma.php">
				<i class="entypo-download"></i>
				<span class="title">Mahsulotlar kirimi</span>
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
				<a href="/sharqona/price" target="_blank">
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
			</ul>
			
		</div>
</div>