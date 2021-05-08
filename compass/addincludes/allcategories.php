<ol class="breadcrumb">
	<li><a href="#">Kategoriyalar</a></li>
	<li><a href="#">Kategoriyalar boshqaruvi</a></li>
</ol>

<table class="table table-bordered table-striped datatable" id="table-3">
		<thead>
			<tr class="replace-inputs">
				<th>Подкатегория</th>
				<th>Родительская категория</th>
				<th>Правка</th>
			</tr>
		</thead>
		<tbody>

<?php 
	$query = "SELECT * FROM product_category";
	$service_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($service_query)) {
		$category_id = $row['pcat_id'];
		$category_name = $row['pcat_name'];
		$mother = $row['mother_category'];
	 ?>
	 		<tr class="odd gradeX">
			<td><strong><?php echo "$category_name"; ?></strong>
			</td>
			<?php
			    $mothercat = "SELECT mother_cat_name FROM mother_categories WHERE mother_cat_id = '$mother'";
			    $mothercatquery = mysqli_query($connection, $mothercat);
			    if (!$mothercatquery){
			        die('Motherni topishda xatolik');
			    }
			    else {
			        while ($rowm = mysqli_fetch_array($mothercatquery)) {
			            $mothername = $rowm['mother_cat_name'];
			        }
			    }
			?>
		    <td><?php echo $mothername; ?></td>
			
			<td width="20%">
			    <a href="categories.php?source=edit_category&category_id=<?php echo $category_id; ?>" class="btn btn-info btn-sm">O'zgartirish</a> 
			    <?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
			    <a onClick="deleteqilish(this);return false;" href="categories.php?delete=<?php echo $category_id; ?>" class="btn btn-danger btn-sm">O'chirish</a>
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
		<a class="btn btn-green btn-block" href="categories.php?source=add_category">Новая подкатегория</a>
		<a class="btn btn-green btn-block" href="categories.php?source=add_mother_category">Новая родительская категория</a>

		<?php
			if (isset($_GET['delete'])) {
				$ser_for_del = $_GET['delete'];
				$query = "DELETE FROM product_category WHERE pcat_id = {$category_id}";
				$delete_ser = mysqli_query($connection, $query);
				if (!$delete_ser) {
					die("Kategoriyani o'chirishda xatolik yuz berdi");
				}
				else {
				$_SESSION['xabar'] = "ser_deleted";	
				header("Location: categories.php");
				}
			}
		 ?>