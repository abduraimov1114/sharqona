<?php 
	if ($session_role == 'Master') {
	    $_SESSION['xabar'] = "xato";
	    header("Location: index.php");
	}

	if (isset($_GET['delete'])) {
		$prd_for_del = $_GET['delete'];
		$prd_for_del = mysqli_real_escape_string($connection, $prd_for_del);

		$tekshir = "SELECT * FROM products WHERE product_id = '$prd_for_del'";
		$proverka_produkta = mysqli_query($connection, $tekshir);
		if (!$proverka_produkta) {
			die("Maxsulot idsini tekshirishda xatolik");
		}
		else {
			$sanoq = mysqli_num_rows($proverka_produkta);
		}

		if ($sanoq <= 0) {
			$_SESSION['xabar'] = "xato";
			header("Location: /compass/products.php");
		}
		else {

		$query = "SELECT * FROM services WHERE service_pro_id = {$prd_for_del}";
		$proverka_service = mysqli_query($connection, $query);
		if (!$proverka_service) {
			die("Tashkilotni o'chirishda xatolik yuz berdi");
		}
		else {
			$count = mysqli_num_rows($proverka_service);
		}

		if ($count > 0) { ?>
			<div class="alert alert-danger"><strong>Xatolik!</strong> Ushbu mahsulotdan "xizmat ko'rsatish" bo'limlarida foydalanilgan. Iltimos ushbu mahsulotni o'chirish uchun, avval xizmat ko'rsatish bo'limidan kerakli xizmatlarni o'chiring. Keyinchalik qayta urinib ko'ring. Quyida qaysi xizmatlarda ushbu maxsulotdan foydalanilgani ko'rsatilgan: <hr>
			<?php
			while ($row = mysqli_fetch_assoc($proverka_service)) {
				$xizmat_nomi = $row['service_name']; ?>
				<li><strong><?php echo "$xizmat_nomi xizmati"; ?></strong></li>
			<?php }
			echo "<br><a href='/compass/products.php' class='btn btn-danger btn-sm'>
					Ok
				</a> <a href='/compass/services.php' class='btn btn-success btn-sm'>
					Xizmatlar bo'limiga o'tish
				</a></div>";
		}
		else {
			$ready_for_del = "DELETE FROM products WHERE product_id = '$prd_for_del'";
			$delete_product = mysqli_query($connection, $ready_for_del);
			
			if (!$delete_product) {
				die("Maxsulotni o'chirishda xatolik!");
			}

			else {
				$_SESSION['xabar'] = "pro_deleted";
				header("Location: /compass/products.php");
			}
		}
		}
	}
 ?> 

<ol class="breadcrumb">
	<li><a href="#">Mahsulotlar boshqaruvi</a></li>
</ol>
<form action="" method="POST">
<div id="myDIV" class="datatablebtns">
	<?php 
		if (isset($_POST['pressed'])) {
			$tanlangan = ($_POST['pressed']);
		}
		else {
			$tanlangan = 0;
		}
	?>
<?php 
	$catquery = "SELECT * FROM mother_categories";
	$category = mysqli_query($connection, $catquery);
	while ($row = mysqli_fetch_assoc($category)) {
		$mother_id = $row['mother_cat_id'];
		$mother_name = $row['mother_cat_name'];?>
		<?php 
			if ($tanlangan == $mother_id) {
				$active = "active";
			}
			else {
				$active = " ";
			}
		?>
			<button name="pressed" type="submit" class="btn btn-info mybutton <?php echo $active; ?>" value="<?php echo $mother_id; ?>"><?php echo $mother_name; ?></button>
	<?php }
?>
</div>
</form><br><br>

<?php if (isset($_POST['pressed'])): ?>
	<?php $tanlangan = ($_POST['pressed']); ?>
	
<table class="table table-bordered table-striped datatable" id="table-3">
		<thead>
			<tr class="replace-inputs">
				<th>Ismi</th>
				<?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
				<th>Kelish narxi</th>
				<?php endif ?>
				<th>Sotish (K)</th>
				<th>Sotish (T)</th>
				<th>Soni</th>
				<th>Bo'limi</th>
				<th>O'zgartirish</th>
			</tr>
		</thead>
		<tbody>

<?php 
	$totalprofit = 0;
	$totalsoting = 0;
	$query = "
	SELECT products.*, mother_categories.mother_cat_id , product_category.mother_category , product_category.pcat_id FROM products INNER JOIN product_category on product_category.pcat_id=products.product_category_id LEFT JOIN mother_categories on mother_categories.mother_cat_id=product_category.mother_category WHERE mother_categories.mother_cat_id ='{$tanlangan}'
	";
	$product_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($product_query)) {
		$product_id = $row['product_id'];
		$product_name = $row['product_name'];
		$product_category = $row['product_category_id'];
		$product_count = $row['product_count'];
		$product_price_in = $row['product_prise_in'];
		$product_price_out = $row['product_prise_out'];
		$tashkilotga = $product_price_out / 0.85;
        $tashkilotga = round($tashkilotga, 1);
		$product_danger = $row['product_danger'];
	 ?>
	 		<tr class="odd gradeX">
			<td><?php echo "<a href='#'>$product_name </a>"; ?>
			<?php if ($product_count < $product_danger OR $product_count == 0): ?>
			<span class="badge badge-secondary">Внимание!</span>
			<?php endif ?>
			</td>
			<?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
			<td><?php echo "$product_price_in $"; ?></td>
			<?php endif ?>
			<td><?php echo "$product_price_out $"; ?></td>
			<td><?php echo "$tashkilotga $"; ?></td>
	<?php 
	$query = "SELECT * FROM product_category WHERE pcat_id = '{$product_category}' ";
	$cat_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($cat_query)) {
		$product_kategoriyasi = $row['pcat_name'];
	}

	?>
			<?php if ($product_count < $product_danger OR $product_count == 0): ?>
			<td class="danger"><?php echo "<a href='#'>$product_count</a>"; ?></td>
			<?php else: ?>
			<td class="info"><?php echo "<a href='#'>$product_count</a>"; ?></td>
			<?php endif ?>
			<td width="10%"><?php echo "<a href='#'>$product_kategoriyasi</a>"; ?></td>
			<td width="11%"><a href="products.php?source=edit_product&product_id=<?php echo $product_id;?>" class="btn btn-orange"><i class="entypo-check"></i></a> 
				<?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
				<a onClick="deleteqilish(this);return false;" href="products.php?delete=<?php echo $product_id; ?>" class="btn btn-black"><i class="entypo-cancel"></i></a>
				<?php endif ?>
			</td>
				<script>
				   function deleteqilish(f) {
				    if (confirm("Belgilangan bo'limni o'chirishga aminmisiz?\nO'chirilgan bo'limni qayta tiklab bo'lmaydi.")) 
				       f.submit();
				   }
				  </script>
			</tr>
			<?php $totalprofit += $product_price_in * $product_count; 
			      $totalsoting += $product_price_out * $product_count;
			?>
<?php 	} ?>
			</tbody>

			<?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
			<div class="text-right">
				<i class="fa fa-usd"> Ombordagi mahsulotlar: </i> <strong><?php echo number_format($totalprofit); ?></strong><br>
				<i class="fa fa-money"> Kutilayotgan foyda: </i> <strong><?php echo number_format($totalsoting - $totalprofit); ?></strong>
			</div>
			<?php endif ?>
		</table><br>

		<?php endif ?>
		<br><br>
		<a class="btn btn-green btn-block" href="products.php?source=add_product">Yangi mahsulot qo'shish</a>