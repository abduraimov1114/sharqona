<?php 
if ($session_role !== 'Master') {die("Lets get out of here stranger!");}
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

			<?php if (strpos($_SERVER['REQUEST_URI'], 'storage=3') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
			<?php endif ?>
				<a href="street_accept.php?storage=3"><i class="entypo-basket"></i>
					<span class="title">Savdo (Laboratoriya)</span>
				</a>
			</li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'saved_accepts_lab') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
				<?php endif ?>
				<a href="saved_accepts_lab.php"><i class="entypo-download"></i>
					<span class="title">Saqlangan ishlar (Laboratoriya)</span>
					<span class="badge badge-info">
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

			<?php if (strpos($_SERVER['REQUEST_URI'], 'ombor.php?inventory=3') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
				<?php endif ?>
				<a href="ombor.php?inventory=3"><i class="entypo-archive"></i>
					<span class="title">Ombor holati (Laboratoriya)</span>
				</a>
			</li>
			
			<li class="lenta"></li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'storage=1') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
			<?php endif ?>
				<a href="street_accept.php?storage=1"><i class="entypo-basket"></i>
					<span class="title">Savdo (Podval)</span>
				</a>
			</li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'saved_accepts_padval') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
				<?php endif ?>
				<a href="saved_accepts_padval.php"><i class="entypo-download"></i>
					<span class="title">Saqlangan ishlar (Podval)</span>
					<span class="badge badge-success">
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

			<?php if (strpos($_SERVER['REQUEST_URI'], 'ombor.php?inventory=1') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
				<?php endif ?>
				<a href="ombor.php?inventory=1"><i class="entypo-archive"></i>
					<span class="title">Ombor holati (Podval)</span>
				</a>
			</li>

			<li class="lenta"></li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'organizations') == true): ?>
			<li class="active">
			<?php else: ?>
			<li>
			<?php endif ?>
				<a href="organizations.php"><i class="entypo-briefcase"></i>
					<span class="title">Tashkilotlar boshqaruvi</span>
				</a>
			</li>
			
			<li>
				<a href="/compass/price" target="_blank">
				<i class="entypo-print"></i>
				<span class="title">Price List</span>
				</a>
			</li>
			<li class="lenta"></li>

			<?php if (strpos($_SERVER['REQUEST_URI'], 'organizations') == true): ?>
			<li class="active">
				<?php else: ?>
			<li>
				<?php endif ?>
				<a href="list_page.php"><i class="entypo-briefcase"></i>
					<span class="title">Shartnomalar</span>
				</a>
			</li>
		</ul>
	</div>
</div>