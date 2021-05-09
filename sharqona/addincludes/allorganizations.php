<ol class="breadcrumb">
  <li><a href="organizations.php">Tashkilotlar boshqaruvi</a></li>
</ol>


<table class="table table-bordered table-striped datatable" id="table-3">
		<thead>
			<tr class="replace-inputs">
				<th>Tashkilot</th>
				<th>Balans</th>
				<th>Ishonch</th>
				<th>Ma'lumot</th>
				<?php if ($session_role == 'Admin' OR $session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
				<th>O'zgartirish</th>
				<?php endif ?>
				<th>Muomala</th>
			</tr>
		</thead>
		<tbody>

<?php 
	$query = "SELECT * FROM buyers";
	$service_query = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($service_query)) {
		$buyers_id = $row['buyers_id'];
		$buyers_name = $row['buyers_name'];
		$buyers_budget = $row['buyers_budget'];
		$buyers_contact = $row['buyers_contact'];
		$safety = $row['buyers_safety'];
	 ?>
	 		<tr class="odd gradeX">
				<td>
					<?php echo "$buyers_name";?> 
					<?php if ($session_role !== 'Master'): ?>
						<a href='invoice_list.php?invoice=<?php echo $buyers_id; ?>'><i class="entypo-eye"></i></a>
					<?php endif ?>
				</td>
				<?php if ($buyers_budget < 0): ?>
					<td width="15%">
						<strong style="color:red;"><?php echo number_format($buyers_budget); ?> Sum</strong> 
					<?php if ($session_role == 'Admin' OR $session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
						<a href="contracts.php?contr=<?php echo $buyers_id;?>"><i class="entypo-eye"></i></a>
					<?php endif ?>
					</td>
				<?php elseif ($buyers_id == 10): ?>
						<td>
							<strong>Millions</strong>
						</td>
				<?php else: ?>
					<td width="15%">
						<strong style="color:green;"><?php echo number_format($buyers_budget); ?> Sum</strong> 
					<?php if ($session_role == 'Admin' OR $session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
						<a href="contracts.php?contr=<?php echo $buyers_id;?>"><i class="entypo-eye"></i></a>
					<?php endif ?>
					</td>
				<?php endif ?>
					<td class="tdalign">
						<?php if ($safety == 0): ?>
							<span title="Ishonchsiz" style="width: 15px; height: 15px;" class="badge badge-danger badge-square"> </span>
						<?php elseif ($safety == 1): ?>
							<span title="50/50" style="width: 15px; height: 15px;" class="badge badge-warning badge-square"> </span>
						<?php elseif ($safety == 2): ?>
							<span title="Ishonchli" style="width: 15px; height: 15px;" class="badge badge-success badge-square"> </span>
						<?php endif ?>
					</td>
				<?php if (!empty($buyers_contact)): ?>
					<td><?php echo "$buyers_contact"; ?></td>
				<?php else: ?>
					<td>Ma'lumot kiritilmagan</td>
				<?php endif ?>
				
				<?php if ($session_role == 'Admin' OR $session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
					
				<td width="11%">
					<a href="organizations.php?source=edit_organization&org_id=<?php echo $buyers_id;?>" class="btn btn-orange"><i class="entypo-check"></i></a> 
					<?php if ($_SESSION['ses_user_role'] !== 'Admin'): ?>
					<a onClick="deleteqilish(this);return false;" href="organizations.php?delete=<?php echo $buyers_id; ?>" class="btn btn-black"><i class="entypo-cancel"></i></a>
					<?php endif ?>
				</td>

				<script>
				   function deleteqilish(f) {
				    if (confirm("Belgilangan bo'limni o'chirishga aminmisiz?\nO'chirilgan bo'limni qayta tiklab bo'lmaydi.")) 
				       f.submit();
				   }
			    </script>

			    <?php endif ?>

				<?php if ($buyers_id == 10): ?>
					<?php if ($session_role == 'Master'): ?>
						<td>
							<a href="#" class="btn btn-blue btn-block">Jizza</a>
						</td>
					<?php else: ?>
						<td>
							<a href="outgoings.php?source=street_outgoings" class="btn btn-danger btn-sm">Savdo</a>
						</td>
					<?php endif ?>
				<?php else: ?>
					<td width="13%">
					    <?php if ($session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
							<a href="incomings.php?source=org_incomings&orgid=<?php echo $buyers_id; ?>" class="btn btn-info btn-sm">Kirim</a>
						<?php endif ?>
						<?php if ($session_role !== 'Master'): ?>
							<a href="outgoings.php?source=org_outgoings&orgid=<?php echo $buyers_id; ?>" class="btn btn-danger btn-sm">Chiqim</a>
						<?php endif ?>
						<?php if ($session_role == 'Master'): ?>
							<a href="outgoings.php?source=master_org&orgid=<?php echo $buyers_id; ?>&stor=1" class="btn dollar btn-block">Chiqim Podval</a>
							<a href="outgoings.php?source=master_org&orgid=<?php echo $buyers_id; ?>&stor=3" class="btn sum btn-block">Chiqim Laboratory</a>
						<?php endif ?>
					</td>
				<?php endif ?>
			</tr>
	<?php } ?>
			</tbody>
		</table><br>
		

			

		<?php if ($session_role == 'Direktor' OR $session_role == 'Superadmin'): ?>
		<a class="btn btn-green btn-block" href="organizations.php?source=add_organization">Yangi tashkilot qo'shish</a>
		<?php endif ?>

		<?php 
			if (isset($_GET['delete'])) {
				$org_for_del = $_GET['delete'];
				if ($org_for_del == 10) {
					$_SESSION['xabar'] = "xato";	
					header("Location: organizations.php");
				}
				else {
				$query = "DELETE FROM buyers WHERE buyers_id = {$org_for_del}";
				$delete_org = mysqli_query($connection, $query);
				if (!$delete_org) {
					die("Tashkilotni o'chirishda xatolik yuz berdi");
				}
				else {
				$_SESSION['xabar'] = "org_deleted";	
				header("Location: organizations.php");
				}
			}
			}
		 ?>
