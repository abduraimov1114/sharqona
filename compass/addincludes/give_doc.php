<ol class="breadcrumb">
  <li><a href="" style="color: white" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-center" role="button" id="dropdownMenuLink">Shartnoma yaratish</a></li>
</ol>
<table class="table table-bordered table-striped datatable" id="table-3">
	<thead>
		<th>Nomeri</th>
		<th>Sanani tanlash</th>
		<th>Mijoz</th><!--(select2 agar mijoz bulmasa modal oyna chiqib qushish kk)bush qolsa ham buladi-->
		<th>Mijoz turi</th><!--radio advanced button -->
		<th>Shartnoma predmeti</th><!--radio advanced button -->
	</thead>
	<tbody>
		<td></td>
		<td><input type="date" value="<? echo date('Y-m-d') ?>" class="form-control" name="doc_date" /></td>
		<td>
			<div class="form-group">
				<label class="col-sm-3 control-label">Select2</label>

				<div class="col-sm-5">

					<select name="test" id="pr_name" class="select2" data-allow-clear="true" data-placeholder="Select one city...">
						<option></option>
						<optgroup label="United States">
							<option value="1">Alabama</option>
							<option value="2">Boston</option>
							<option value="3">Ohaio</option>
							<option value="4">New York</option>
							<option value="5">Washington</option>
						</optgroup>
					</select>
					<script>
						jQuery(document).ready(function($)
						{
							$('#pr_name').val('4');
						});
					</script>
				</div>
			</div>
		</td>
		<td></td>
		<td></td>
	</tbody>
</table>
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header" style="width: 820px;background: white;margin-left: -200px;">
				<h5 class="modal-title mt-0">Haydovchi qo'shish oynasi</h5>
			</div>
			<div class="modal-body" style="width: 820px;background: white;margin-left: -200px;">
				<!--forma qushish start-->
				<div class="card m-b-20" style="width: 800px;margin-left: 0px;">
					<div class="card-body">
						<table class="table table-striped mb-0" id="table">
							<thead>
							<tr>
								<th style="color:red;">Maydonlar nomi</th>
								<th style="color: red">To`ldiriladigan maydonlar</th>
								<th style="color:red;">Maydonlar nomi</th>
								<th style="color: red">To`ldiriladigan maydonlar</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>Familiyasi</td>
								<td>
									<input type="text"  class="form-control" required id="inline-firstname">
								</td>
								<td>Ismi </td>
								<td>
									<input type="text" class="form-control" required id="inline-lastname">
								</td>
							</tr>
							<tr>
								<td>Otasining ismi</td>
								<td>
									<input type="text" class="form-control" required id="inline-fathername">
								</td>
								<td>Telefon raqami</td>
								<td>
									<input type="text" class="form-control" required id="inline-tell">
								</td>
							</tr>
							<tr>
								<td>Mashina raqami</td>
								<td>
									<input type="text" class="form-control" required id="inline-car_num">
								</td>
								<td>Mashina rusumi</td>
								<td>
									<input type="text" class="form-control" required id="inline-car_name">
								</td>
							</tr>
							<tr>
								<td>Haydovchilik Guvohnoma raqami</td>
								<td>
									<input type="text" class="form-control" required id="inline-g_num">
								</td>
								<td>Haydovchilik Guvohnomasi tugash muddati</td>
								<td>
									<input type="date" class="form-control" required id="inline-g_time">
								</td>
							</tr>
							<tr>
								<td>Litsenziya raqami</td>
								<td>
									<input type="text" class="form-control" required id="inline-lit_num">
								</td>
								<td>Litsenziya tugash muddati</td>
								<td>
									<input type="date" class="form-control" required id="inline-lit_date">
								</td>
							</tr>
							<tr>

								<td>Sug`urta raqami</td>
								<td>
									<input type="text" class="form-control" required id="inline-sug_num">
								</td>
								<td>Sug`urta tugash muddati</td>
								<td>
									<input type="date" class="form-control" required id="inline-sug_date">
								</td>
							</tr>
							<tr>
								<td>Manzili</td>
								<td>
									<textarea name="" class="form-control" required id="inline-adress" cols="30" ></textarea>
								</td>
								<td>Passport seria nomeri</td>
								<td>
									<input type="text" class="form-control" required id="inline-pass_seria">
								</td>
							</tr>
							<tr>
								<td style="text-align: center;">Aktivatsiya vaqti</td>
								<td><input type="date" id="active_date" value="<? echo date('Y-m-d'); ?>" class="form-control"></td>
								<td style="text-align: center;">Tarif</td>
								<td>
									<select name="" id="tarif" class="form-control">
										<option selected value="normal">Normal</option>
										<option value="best">Best</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="4" style="text-align: center;">Tulov kirimi</td>
							</tr>
							<tr>
								<td>Tulov turini tanlash</td>
								<td><select name="" id="pay_type" class="form-control">
										<option selected value="naqd">Naqd</option>
										<option value="plastik">Plastik</option>
										<option value="bank">Bank</option>
									</select></td>
								<td>Tulov summasi</td>
								<td colspan="2"><input class="form-control" value="" id="bank" type="text"/></td>
							</tr>
							<tr>
								<? if($_SESSION['ses_user_role']=="Direktor" ){ ?>
								<td>Izoh</td>
								<td>
									<textarea name="" class="form-control" required id="inline-comments" cols="30" ></textarea>
									<input type="hidden" name="update" id="update" value="off" pattern="^[0-9]*$" />
								</td>
								<td>Acive</td>
								<td>
									<input type="checkbox" onclick="ajaxDB(document.getElementById('update').value)"  required id="inline-user_active">
								</td>

								<!--                                --><?// if($row['active']=='1'){ ?>
								<!--                                    <input type="checkbox" id="inline-user_active" onclick="ajaxDB(document.getElementById('update').value)" value="false1" checked>-->
								<!--                                --><?//}else{?>
								<!--                                    <input type="checkbox" id="inline-user_active" onclick="ajaxDB(document.getElementById('update').value)"  value="true1">-->
								<!--                                --><?//}?>
							</tr>
							<?}else{?>
								<td>Izoh</td>
								<td colspan="3">
									<textarea name="" rows="5" class="form-control" required id="inline-comments" cols="30" ></textarea>
									<input type="hidden" name="update" id="update" value="off" pattern="^[0-9]*$" />
								</td>
							<?}?>
							</tbody>
						</table><br/>
						<div style="float: right;margin-top: -20px">
							<a href="#" onclick="submit()" style="padding: 10px;background: #0069d9;color: #fff;border-radius: 10px;">Saqlash</a>
							<a href="#" data-dismiss="modal" aria-hidden="true" style="padding: 10px;background: red;color: #fff;border-radius: 10px;">Bekor qilish</a>
						</div>
					</div>
				</div>
				<!--forma qushish end-->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>