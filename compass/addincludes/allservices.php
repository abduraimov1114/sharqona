<h1 class="margin-bottom">Xizmatlar boshqaruvi</h1>

<table class="table table-bordered table-striped datatable" id="table-3">
		<thead>
			<tr class="replace-inputs">
				<th>Xizmat turi</th>
				<th>Xizmat narxi (K)</th>
				<th>Xizmat narxi (T)</th>
				<th>Ketadigan mahsulot</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

<?php 
	if ($session_role == 'Master') {
	    $_SESSION['xabar'] = "xato";
	    header("Location: index.php");
	}

	$query = "SELECT * FROM services";
	$service_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($service_query)) {
		$service_id = $row['service_id'];
		$service_name = $row['service_name'];
		$service_price = $row['service_price'];
		$service_street_price = $row['service_street_price'];
		$service_pro_id = $row['service_pro_id'];
	 ?>
	 		<tr class="odd gradeX">
			<td><?php echo "$service_name"; ?>
			</td>
			<td><?php echo number_format($service_street_price); ?></td>
			<td><?php echo number_format($service_price); ?></td>
			
			<?php if ($service_pro_id > 0): ?>

			<?php 
				$zapros = "SELECT * FROM products WHERE product_id = '$service_pro_id'";
				$out_tovar_ismi = mysqli_query($connection, $zapros);
				if (!$out_tovar_ismi) {
					die("Tovarni ismini bilishga tashalgan zaprosda xatolik");
				}
				while ($row = mysqli_fetch_assoc($out_tovar_ismi)) {
					$ketadigan_tovar = $row['product_name'];
					$ketadigan_tovar_id = $row['product_id'];
					$querymax = "SELECT * FROM products WHERE product_id = '$ketadigan_tovar_id'";
					$resultquerymax = mysqli_query($connection, $querymax);

					while ($rowat = mysqli_fetch_assoc($resultquerymax)) {
					  $xizmatga_ketadigan_mahsulotni_skladdagi_soni = $rowat['product_count'];
					}
					?>
					<td><?php echo "$ketadigan_tovar"; ?>
						<div>Omborda: 
							<span class="badge badge-danger item-left"><?php echo $xizmatga_ketadigan_mahsulotni_skladdagi_soni; ?></span>
							
						</div>
					</td>
				<?php } ?>
			<?php else: ?>
				<td>Mahsulot sarflanmaydi</td>
			<?php endif ?>
			
			<td>
			    <a href="services.php?source=edit_service&service_id=<?php echo $service_id; ?>" class="btn btn-info btn-sm">O'zgartirish</a>
			    <?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
			    <a onClick="deleteqilish(this);return false;" href="services.php?delete=<?php echo $service_id; ?>" class="btn btn-danger btn-sm">O'chirish</a>
			    <?php endif ?>
		    </td>
			<script>
			   function deleteqilish(f) {
			    if (confirm("Belgilangan bo'limni o'chirishga aminmisiz?\nO'chirilgan bo'limni qayta tiklab bo'lmaydi.")) 
			       f.submit();
			   }
		    </script>
			</tr>
	<?php } ?>
			</tbody>
		</table><br>
		<a class="btn btn-green btn-block" href="services.php?source=add_service">Yangi xizmat qo'shish</a>

		<?php
			if (isset($_GET['delete'])) {
				$ser_for_del = $_GET['delete'];
				$query = "DELETE FROM services WHERE service_id = {$ser_for_del}";
				$delete_ser = mysqli_query($connection, $query);
				if (!$delete_ser) {
					die("Xizmatni o'chirishda xatolik yuz berdi");
				}
				else {
				$_SESSION['xabar'] = "ser_deleted";	
				header("Location: services.php");
				}
			}
		 ?>