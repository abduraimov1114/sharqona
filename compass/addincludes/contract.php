<?php session_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php'; ?>
<?php
	if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
		header('Location: https://city-service.uz/back_login.php');
		die();
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="assets/images/favicon.ico">

	<title>Shartnomalar</title>

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>
<body class="page-body" data-url="http://neon.dev">

<div class="page-container">

	<?php require_once 'addincludes/sidebar.php'; ?>
	<?php require_once 'addincludes/userinfo.php'; ?>
<div>
</div>
	<ol class="breadcrumb">
		<li><a href="javascript:;" style="color: #fff;" onclick="select_id();jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-success">Shartnoma yaratish</a></li>
	</ol>

		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label for="field-3" class="control-label">Shartnoma predmeti</label>
					<?
						$buyer_name=[];
						$sorov = "select * from buyers";
						$func->queryMysql($sorov);
						while($row = $func->result->fetch_array(MYSQL_ASSOC)){
							$id=$row['buyers_id'];
							$buyer_name[$id]=$row['buyers_name'];
							$buyer_tell[$id]=$row['buyers_contact'];
						}
					?>
					<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
						<li class="active" onclick="clickMenu(1)">
							<a href="#news" data-toggle="tab">
								<span class="visible-xs"><i class="entypo-home"></i></span>
								<span class="hidden-xs" style="font-size: 18px;padding-left: 20px;padding-right: 20px;font-weight: bold;">Yangi</span>
							</a>
						</li>
						<li onclick="clickMenu(2)">
							<a href="#active" data-toggle="tab">
								<span class="visible-xs"><i class="entypo-user"></i></span>
								<span class="hidden-xs" style="font-size: 18px;padding-left: 20px;padding-right: 20px;font-weight: bold;">Aktiv</span>
							</a>
						</li>
						<li onclick="clickMenu(3)">
							<a href="#close" data-toggle="tab">
								<span class="visible-xs"><i class="entypo-user"></i></span>
								<span class="hidden-xs" style="font-size: 18px;padding-left: 20px;padding-right: 20px;font-weight: bold;">Yopilgan</span>
							</a>
						</li>
						<li onclick="clickMenu(4)">
							<a href="#cancel" data-toggle="tab">
								<span class="visible-xs"><i class="entypo-user"></i></span>
								<span class="hidden-xs" style="font-size: 18px;padding-left: 20px;padding-right: 20px;font-weight: bold;">Bekor qilingan</span>
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="news">
							<div class="">
								<table class="table table-bordered datatable" id="table-1">
									<thead>
									<tr>
										<th>TR</th>
										<th>Shartnoma sanasi</th>
										<th>Mijoz</th>
										<th>Mijoz turi</th>
										<th>Shartnoma summasi</th>
										<th>Ma’sul shaxs kontakti</th>
										<th>Izoh</th>
<!--										<th>%</th>-->
										<th>*</th>
									</tr>
									</thead>
									<tbody>
									<?
										$sorov = "select * from new_contract WHERE `status`='new' ORDER BY `nc_id` DESC";
										$func->queryMysql($sorov);
										while($row=$func->result->fetch_array(MYSQL_ASSOC)){
											$id=$row['buyer_id'];
									?>
									<tr>
										<td style="vertical-align: middle;"><? echo $row['nc_id']; ?></td>
										<td style="vertical-align: middle;">
											<? echo $row['check_date']; ?>
										</td>
										<td style="vertical-align: middle;"><? echo $buyer_name[$id];?></td>
										<td style="vertical-align: middle;"><?
												if($row['user_type']=="B"){
													echo "Birja";
												}else{
													echo "Ko`cha";
												}
											?></td>
										<td style="vertical-align: middle;"><? echo $row['product_total']+$row['service_total']; ?></td>
										<td style="vertical-align: middle;"><? echo $buyer_tell[$id]; ?></td>
										<td style="vertical-align: middle;"><? echo $row['description']; ?></td>
										<td style="vertical-align: middle;display: flex;">
											<button type="button" value="<? echo $row['nc_id']; ?>" onclick="new_to_active(value)" class="btn btn-success">
												<i class="entypo-check"></i>
											</button>
											<button type="button" value="<? echo $row['nc_id']; ?>" onclick="new_to_cancel(value)" class="btn btn-danger">
												<i class="entypo-cancel"></i>
											</button>
											<a target="_blank" href="/compass/contract/view_info.php?url=<? echo $row['doc_url']; ?>&ID=<? echo $row['nc_id']; ?>" target="_parent" onclick="new_info(value);jQuery('#modal_view').modal('show', {backdrop: 'static'});" class="btn btn-info">
												<i class="entypo-info"></i>
<!--												Ko`rish-->
											</a>
										</td>
									</tr>
									<?}?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="active">
							<table class="table table-bordered datatable" id="table-2">
								<thead>
								<tr>
									<th>TR</th>
									<th>Shartnoma sanasi</th>
									<th>Mijoz</th>
									<th>Mijoz turi</th>
									<th>Shartnoma summasi</th>
									<th>Ma’sul shaxs kontakti</th>
									<th>Izoh</th>
									<th>%</th>
									<th>*</th>
								</tr>
								</thead>

								<tbody>
								<?
								$sorov = "select * from new_contract WHERE `status`='active' ORDER BY `nc_id` DESC";
								$func->queryMysql($sorov);
								while($row=$func->result->fetch_array(MYSQL_ASSOC)){
								$id=$row['buyer_id'];
									$total_sum = $row['product_total']+$row['service_total'];
								?>
								<tr>
									<td style="vertical-align: middle;"><? echo $row['nc_id']; ?></td>
									<td style="vertical-align: middle;">
										<? echo $row['check_date']; ?>
									</td>
									<td style="vertical-align: middle;"><? echo $buyer_name[$id];?></td>
									<td style="vertical-align: middle;"><?
										if($row['user_type']=="B"){
											echo "Birja";
										}else{
											echo "Ko`cha";
										}
										?></td>
									<td style="vertical-align: middle;"><? echo $row['product_total']+$row['service_total']; ?></td>
									<td style="vertical-align: middle;"><? echo $buyer_tell[$id]; ?></td>
									<td style="vertical-align: middle;"><? echo $row['description']; ?></td>
									<td style="vertical-align: middle;">
										<div style="display: flex;">
											<? if($row['shartnoma']==0){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													sh
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													sh
												</div>
											<?}?>
											<? if($row['hisob_faktura']==0){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													hf
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													hf
												</div>
											<?}?>
											<? if($row['akt']==0){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													a
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													a
												</div>
											<?}?>
											<? if($row['yetkazib_berildi']==0){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													eb
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													eb
												</div>
											<?}?>
											<? if($row['ishonchnoma']==0){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													i
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													i
												</div>
											<?}?>
<!--											--><?//echo $row['pay_price']."/".$total_sum;?>
											<? if($row['pay_price']<$total_sum){ ?>
												<div style="margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: yellow;border-radius: 50%;">
													t
												</div>
											<?}else{?>
												<div style="color:white;margin-right: 5px;width:20px;height:20px;text-align:center;padding-top:1px;border: 1px solid black;background: green;border-radius: 50%;">
													t
												</div>
											<?}?>
										</div>
									</td>
									<td style="vertical-align: middle;">
										<div style="display: flex;">
										<? if(isset($buyer_name[$id]) && !empty($buyer_name[$id])){ ?>
											<button type="button" value="<? echo $row['nc_id']; ?>" onclick="status_select(value);jQuery('#modal_change').modal('show', {backdrop: 'static'});" class="btn btn-success">
												<i class="entypo-pencil"></i>
											</button>
										<? }else{ ?>
											<button type="button" value="<? echo $row['nc_id']; ?>" onclick="status_select(value);jQuery('#modal_change_1').modal('show', {backdrop: 'static'});" class="btn btn-success">
												<i class="entypo-pencil"></i>
											</button>
										<? } ?>
											<button onclick="new_to_cancel(value)" type="button" value="<? echo $row['nc_id']; ?>" class="btn btn-danger">
												<i class="entypo-cancel"></i>
											</button>
											<a target="_blank" href="/compass/contract/view_info.php?url=<? echo $row['doc_url']; ?>&ID=<? echo $row['nc_id']; ?>" target="_blank" onclick="new_info(value);jQuery('#modal_view').modal('show', {backdrop: 'static'});" class="btn btn-info">
												<i class="entypo-info"></i>
											</a>
										</div>
									</td>
								</tr>
								<?}?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="close">
							<table class="table table-bordered datatable" id="table-3">
								<thead>
								<tr>
									<th>TR</th>
									<th>Shartnoma sanasi</th>
									<th>Mijoz</th>
									<th>Mijoz turi</th>
									<th>Shartnoma summasi</th>
									<th>Ma’sul shaxs kontakti</th>
									<th>Izoh</th>
<!--									<th>%</th>-->
									<th>*</th>
								</tr>
								</thead>

								<tbody>
								<?
								$sorov = "select * from new_contract WHERE `status`='close' ORDER BY `nc_id` DESC";
								$func->queryMysql($sorov);
								while($row=$func->result->fetch_array(MYSQL_ASSOC)){
									$id=$row['buyer_id'];
									?>
									<tr>
										<td style="vertical-align: middle;"><? echo $row['nc_id']; ?></td>
										<td style="vertical-align: middle;">
											<? echo $row['check_date']; ?>
										</td>
										<td style="vertical-align: middle;"><? echo $buyer_name[$id];?></td>
										<td style="vertical-align: middle;"><?
											if($row['user_type']=="B"){
												echo "Birja";
											}else{
												echo "Ko`cha";
											}
											?></td>
										<td style="vertical-align: middle;"><? echo $row['product_total']+$row['service_total']; ?></td>
										<td style="vertical-align: middle;"><? echo $buyer_tell[$id]; ?></td>
										<td style="vertical-align: middle;"><? echo $row['description']; ?></td>
										<td style="vertical-align: middle;">
											<a target="_blank" href="/compass/contract/view_info.php?url=<? echo $row['doc_url']; ?>&ID=<? echo $row['nc_id']; ?>" target="_blank" onclick="new_info(value);jQuery('#modal_view').modal('show', {backdrop: 'static'});" class="btn btn-info">
												<i class="entypo-info"></i>
											</a>
										</td>
									</tr>
								<?}?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="cancel">
							<table class="table table-bordered datatable" id="table-4">
								<thead>
								<tr>
									<th>TR</th>
									<th>Shartnoma sanasi</th>
									<th>Mijoz</th>
									<th>Mijoz turi</th>
									<th>Shartnoma summasi</th>
									<th>Ma’sul shaxs kontakti</th>
									<th>Izoh</th>
<!--									<th>%</th>-->
									<th>*</th>
								</tr>
								</thead>

								<tbody>
								<?
								$sorov = "select * from new_contract WHERE `status`='cancel' ORDER BY `nc_id` DESC";
								$func->queryMysql($sorov);
								while($row=$func->result->fetch_array(MYSQL_ASSOC)){
									$id=$row['buyer_id'];
									?>
									<tr>
										<td style="vertical-align: middle;"><? echo $row['nc_id']; ?></td>
										<td style="vertical-align: middle;">
											<? echo $row['check_date']; ?>
										</td>
										<td style="vertical-align: middle;"><? echo $buyer_name[$id];?></td>
										<td style="vertical-align: middle;"><?
											if($row['user_type']=="B"){
												echo "Birja";
											}else{
												echo "Ko`cha";
											}
											?></td>
										<td style="vertical-align: middle;"><? echo $row['product_total']+$row['service_total']; ?></td>
										<td style="vertical-align: middle;"><? echo $buyer_tell[$id]; ?></td>
										<td style="vertical-align: middle;"><? echo $row['description']; ?></td>
										<td style="vertical-align: middle;">
											<div style="display: flex;">
													<button onclick="cancel_to_new(<? echo $row['nc_id']; ?>)" type="button" class="btn btn-success">
														<i class="entypo-pencil"></i>
														tiklash
													</button>
												<a target="_blank" href="/compass/contract/view_info.php?url=<? echo $row['doc_url']; ?>&ID=<? echo $row['nc_id']; ?>" target="_blank" onclick="new_info(value);jQuery('#modal_view').modal('show', {backdrop: 'static'});" class="btn btn-info">
													<i class="entypo-info"></i>
												</a>
											</div>
										</td>
									</tr>
								<?}?>
								</tbody>
							</table>
						</div>
					</div>

				</div>

			</div>
		</div>

	<div class="modal fade" id="modal-6">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" onclick="checkType()" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="info">Shartnoma nomeri: <span id="nomer_id"></span></h4>
					<input type="hidden" id="doc_nomer_id" value=""/>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group" style="display: flex; width: 65%;border:1px #ccc solid;border-radius:10px;background:rgba(0,0,0,0);margin: 0px auto;margin-bottom: 15px; align-items: center;padding: 5px 15px;justify-content: space-between;">
								<h4 style="font-weight: bold;">Korxona</h4>
							<div class="btn-group">
								<button type="button" id="compass" value="" onclick="korxona(id)" class="btn btn-green">COMPASS</button>
								<button type="button" id="cowork" value="" onclick="korxona(id)" style="margin: 0px 10px;" class="btn">COWORK</button>
								<button type="button" id="x_korxona" value="" onclick="korxona(id)" class="btn">X-KORXONA</button>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="check_date" class="control-label">Sanani tanlash </label>
								<input type="date" class="form-control" id="check_date" value="<? echo  date('Y-m-d'); ?>" placeholder="John">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="label-switch" class="control-label">Mijoz  turi</label>
								<br/>
								<div>
									<div  id="label-switch" onchange="user_type(id)" class="make-switch"  data-on-label="B" data-off-label="K">
										<input type="checkbox" checked>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<label for="pr_name" class="control-label">Mijoz</label>
							<select name="test" id="pr_name" class="select2">
								<option  value="def">Tanlang</option>
								<?
									$sorov = "select * from buyers";
									$func->queryMysql($sorov);
									while($row = $func->result->fetch_array(MYSQL_ASSOC)){
								?>
									<option value="<? echo $row['buyers_id']; ?>"><? echo $row['buyers_name']; ?></option>
								<?}?>
							</select>
						</div>
					</div>

					<div class="row" id="new_user_add" style="display: none;">
						<div class="col-md-6">
							<label for="new_user_name" class="control-label">Yangi Mijoz</label>
							<input type="text" onkeyup="reset_select()" id="new_user_name" value="" class="form-control">
						</div>
						<div class="col-md-6">
							<label for="new_user_contact" class="control-label">Mijoz contact</label>
							<textarea  id="new_user_contact" cols="30" rows="2"
									  class="form-control"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">

							<div class="form-group">
								<label for="field-3" class="control-label">Shartnoma predmeti</label>

								<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
									<li class="active">
										<a href="#products" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-home"></i></span>
											<span class="hidden-xs">Tovarlar</span>
										</a>
									</li>
									<li>
										<a href="#services" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-user"></i></span>
											<span class="hidden-xs">Xizmatlar</span>
										</a>
									</li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="products">
										<div class="">
											<table class="table table-bordered" id="table_products">
												<thead>
												<tr>
													<th>#</th>
													<th style="width: 30%">Tovar nomi</th>
													<th>Soni</th>
													<th>Narxi</th>
													<th>Summasi</th>
													<th>O`chirish</th>
												</tr>
												</thead>

												<tbody>
												<tr id="tr_prod_id_1">
													<td style="vertical-align: middle;" id="product_id_1">1</td>
													<td><input type="text" id="product_name_1" class="form-control" ></td>
													<td style="vertical-align: middle;"><input onkeyup="realProductSumm()" type="text" id="product_count_1" class="form-control"></td>
													<td style="vertical-align: middle;"><input onkeyup="realProductSumm()" type="text" id="product_price_1" class="form-control"></td>
													<td style="vertical-align: middle;"><input type="text" id="product_summa_1" readonly class="form-control"></td>
													<td style="vertical-align: middle;"><button value="1" id="product_dell_1" onclick="dell_row_product(value)" class="btn btn-danger">-</button></td>
												</tr>
												<tfoot>
												<tr>
													<td colspan="4" style="text-align: right;vertical-align: middle;">Maxsulot Jami summasi:</td>
													<td><input type="text" class="form-control" id="total_p" value="0" readonly></td>
													<td><button id="btnAdd" onclick="clone_div(id)" class="btn btn-success">+</button></td>
												</tr>
												</tfoot>
												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane" id="services">
										<table class="table table-bordered" id="table_services">
											<thead>
											<tr>
												<th>#</th>
												<th style="width: 30%">Xizmat nomi</th>
												<th>Soni</th>
												<th>Narxi</th>
												<th>Summasi</th>
												<th>O`chirish</th>
											</tr>
											</thead>

											<tbody>
											<tr id="tr_ser_id_1">
												<td style="vertical-align: middle;" id="service_id_1">1</td>
												<td><input type="text" id="service_name_1" class="form-control" ></td>
												<td style="vertical-align: middle;"><input onkeyup="realServiceSumm()" type="text" id="service_count_1" class="form-control"></td>
												<td style="vertical-align: middle;"><input onkeyup="realServiceSumm()" type="text" id="service_price_1" class="form-control"></td>
												<td style="vertical-align: middle;"><input type="text" id="service_summa_1" readonly class="form-control"></td>
												<td style="vertical-align: middle;"><button value="1" id="service_dell_1" onclick="dell_row_service(value)" class="btn btn-danger">-</button></td>
											</tr>
											<tfoot>
											<tr>
												<td colspan="4" style="text-align: right;vertical-align: middle;">Xizmat Jami summasi:</td>
												<td><input type="text" class="form-control" id="total_s" value="0" readonly></td>
												<td ><button id="btnAddService" onclick="clone_div(id)" class="btn btn-success">+</button></td>
											</tr>
											</tfoot>
											</tbody>
										</table>
									</div>
									<div style="width: 100%;display: flex;align-items: center;justify-content: flex-end;">
										Jami: &nbsp;<input type="text" id="total_sp" class="form-control" style="width: 100px;" readonly/>
									</div>
								</div>

							</div>
							<div style="display: none;">
								<table id="clone_tr">
									<thead>
									<th>*</th>
									</thead>
									<tbody>
									<tr id="tr_clone_id">
										<td id="clone_id" style="vertical-align: middle;"></td>
										<td><input type="text" id="clone_name" class="form-control" ></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_count" class="form-control"></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_price" class="form-control"></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_summa" readonly class="form-control"></td>
										<td style="vertical-align: middle;"><button id="clone_dell" value="" onclick="dell_row(id)" class="btn btn-danger">-</button></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-12">
							<label for="desc" class="control-label">Izoh</label>
							<textarea  id="desc" style="width: 100%;height: 70px;resize: none;" class="col-md-12"></textarea>
						</div>
					</div>
					<div class="row" style="display: flex;align-items: center;justify-content: space-between;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-4" class="control-label">Shartnoma shablonini tanlang</label>
								<select name="test" id="contract_name" class="form-control">
									<option value="" selected>Tanlang</option>
									<option value="Xizmat_gazna">Xizmat ga’zna</option>
									<option value="Tovar_gazna">Tovar ga’zna</option>
									<option value="Ximzat_kucha">Ximzat ko’cha</option>
									<option value="Tovar_kucha">Tovar ko’cha</option>
								</select>
							</div>
						</div>
						<div class="col-md-6" style="display: flex;justify-content: flex-end; align-items: center;">
							<div class="form-group"><br/>
								<form action="contract/view.php" method="post" target="_alank">
									<input type="hidden" name="values" value="" id="hidden"/>
									<button class="btn btn-success"  onclick="view('view')">Shartnomani ko`rish</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">O`chirish</button>
					<button type="button" class="btn btn-info" onclick="view()">Saqlash</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_view">
		<div class="modal-dialog" style="width: 1000px;">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" onclick="checkType()" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="info">Shartnoma nomeri:120</h4>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="col-md-12">

							<div class="form-group">
								<label for="field-3" class="control-label">Ma`lumot</label>

								<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
									<li class="active">
										<a href="#info" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-home"></i></span>
											<span class="hidden-xs">Shartnoma ma`lumotlari</span>
										</a>
									</li>
									<li>
										<a href="#info_datails" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-user"></i></span>
											<span class="hidden-xs">Shartnoma predmeti</span>
										</a>
									</li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="info">
										<div class="">
											<table class="table table-bordered" id="table_products">
												<thead>
												<tr>
													<th>#</th>
													<th style="width: 30%">Tovar nomi</th>
													<th>Soni</th>
													<th>Narxi</th>
													<th>Summasi</th>
<!--													<th>O`chirish</th>-->
												</tr>
												</thead>
												<tbody id="tbody_info">

												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane" id="info_datails">
										<table class="table table-bordered" id="table_services">
											<thead>
											<tr>
												<th>#</th>
												<th style="width: 30%">Xizmat nomi</th>
												<th>Soni</th>
												<th>Narxi</th>
												<th>Summasi</th>
												<th>O`chirish</th>
											</tr>
											</thead>

											<tbody id="tbody_info_datails">

											</tbody>
										</table>
									</div>
									<div style="width: 100%;display: flex;align-items: center;justify-content: flex-end;">
										Jami: &nbsp;<input type="text" id="total_sp" class="form-control" style="width: 100px;" readonly/>
										<button class="btn btn-success" style="margin-left: 10px;" onclick="view('view')">Shartnomani ko`rish</button>
									</div>
								</div>

							</div>
							<div style="display: none;">
								<table id="clone_tr">
									<thead>
									<th>*</th>
									</thead>
									<tbody>
									<tr id="tr_clone_id">
										<td id="clone_id" style="vertical-align: middle;"></td>
										<td><input type="text" id="clone_name" class="form-control" ></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_count" class="form-control"></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_price" class="form-control"></td>
										<td style="vertical-align: middle;"><input type="text" id="clone_summa" readonly class="form-control"></td>
										<td style="vertical-align: middle;"><button id="clone_dell" value="" onclick="dell_row(id)" class="btn btn-danger">-</button></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
						<div class="col-md-6" style="display: flex;justify-content: flex-end; align-items: center;">
							<div class="form-group"><br/>
								<!--								<label for="field-5" class="control-label"></label>-->
							</div>
						</div>
					<div class="modal-footer">
						<div class="col-sm-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">O`chirish</button>
							<button type="button" class="btn btn-info" onclick="view()">Saqlash</button>
						</div>
					</div>
					</div>
			</div>
			</div>
		</div>
	<div class="modal fade" id="modal_change">
		<div class="modal-dialog" style="width: 1000px;">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" onclick="checkType()" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="info">Shartnoma nomeri: <span id="doc_id"></span> </h4>
					<span>Shartnoma summasi: <span id="doc_summa"></span></span><br/>
					<span>To`langan summa: <span id="payed_summa"></span></span>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="col-md-12">

							<div class="form-group">
								<label for="field-3" class="control-label">STATUS</label>
								<span id="pay_date"></span>
								<span id="pay"></span>
								<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
									<li class="active">
										<a href="#info" data-toggle="tab">
											<span class="visible-xs"><i class="entypo-home"></i></span>
											<span class="hidden-xs">Shartnoma holati</span>
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="info">
										<div class="">
											<table class="table table-bordered" id="table_products">
												<thead>
												<tr>
													<th>Shartnoma</th>
													<th>Hisob Faktura</th>
													<th>Akt</th>
													<th>Yetkazib berildi</th>
													<th>Ishonchnoma</th>
													<th>To`lash muddati</th>
													<th>To`lash summasi</th>
												</tr>
												</thead>
												<tbody id="tbody_info">
													<td>
														<div  id="docx" onclick="changing(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
															<input type="checkbox" checked>
														</div>
													</td>
													<td>
														<div  id="factory" onclick="changing(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
															<input type="checkbox" checked>
														</div>
													</td>
													<td>
														<div  id="akt" onclick="changing(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
															<input type="checkbox" checked>
														</div>
													</td>
													<td>
														<div  id="send" onclick="changing(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
															<input type="checkbox" checked>
														</div>
													</td>
													<td>
														<div  id="trust" onclick="changing(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
															<input type="checkbox" checked>
														</div>
													</td>
													<td>
														<input type="date" value="<? echo date('Y-m-d'); ?>" id="pay_date1" class="form-control" />
													</td>
													<td>
														<input type="text" id="pay_price" class="form-control" onkeyup="min_real(value)" />
													</td>
													<tr>
													<td colspan="7">
														<label for="desc1">Izoh</label>
														<textarea class="form-control" id="desc1" rows="5" style="resize: none;">

														</textarea>
													</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="col-sm-12">
							<button type="button" class="btn btn-default" data-dismiss="modal">O`chirish</button>
							<button type="button" class="btn btn-info" onclick="update_active()" onclick="view()">Tasdiqlash</button>
						</div>
					</div>
					</div>
			</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="modal_change_1">
	<div class="modal-dialog" style="width: 1000px;">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" onclick="checkType()" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="info">Shartnoma nomeri: <span id="doc_id1"></span> </h4>
				<span>Shartnoma summasi: <span id="doc_summa1"></span></span><br/>
				<span>To`langan summa: <span id="payed_summa1"></span></span>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-12">

						<div class="form-group">
							<label for="field-3" class="control-label">STATUS</label>
							<span id="pay_date"></span>
							<span id="pay"></span>
							<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
								<li class="active">
									<a href="#info" data-toggle="tab">
										<span class="visible-xs"><i class="entypo-home"></i></span>
										<span class="hidden-xs">Shartnoma holati</span>
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="info">
									<div class="">
										<label for="user_name1" class="control-label">Tashkilot</label>
										<select name="test" id="user_name1" class="select2">
											<option  value="def">Tanlang</option>
											<?
											$sorov = "select * from buyers";
											$func->queryMysql($sorov);
											while($row = $func->result->fetch_array(MYSQL_ASSOC)){
												?>
												<option value="<? echo $row['buyers_id']; ?>"><? echo $row['buyers_name']; ?></option>
											<?}?>
										</select><br/>
										<div class="row" id="new" style="display: none;">
												<div class="col-sm-6">
													<label for="new_user_nameq"  class="control-label">Tashkilot nomi</label>
													<input type="text" id="new_user_name1" class="form-control">
												</div>
												<div class="col-sm-6">
													<label for="new_user_contactq" class="control-label">Kontakti</label>
													<input type="text" id="new_user_contact1" class="form-control">
												</div>

										</div><br/>
										<div class="row">
											<table class="table table-bordered" id="table_products1">
											<thead>
											<tr>
												<th>Shartnoma</th>
												<th>Hisob Faktura</th>
												<th>Akt</th>
												<th>Yetkazib berildi</th>
												<th>Ishonchnoma</th>
												<th>To`lash muddati</th>
												<th>To`lash summasi</th>
											</tr>
											</thead>
											<tbody id="tbody_info">
										<tr>
											<td>
												<div  id="docx1" onclick="changing1(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
													<input type="checkbox" checked>
												</div>
											</td>
											<td>
												<div  id="factory1" onclick="changing1(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
													<input type="checkbox" checked>
												</div>
											</td>
											<td>
												<div  id="akt1" onclick="changing1(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
													<input type="checkbox" checked>
												</div>
											</td>
											<td>
												<div  id="send1" onclick="changing1(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
													<input type="checkbox" checked>
												</div>
											</td>
											<td>
												<div  id="trust1" onclick="changing1(id)" onchange="status(id)" class="make-switch"  data-on-label="Yes" data-off-label="No">
													<input type="checkbox" checked>
												</div>
											</td>
											<td>
												<input type="date" value="<? echo date('Y-m-d'); ?>" id="pay_date2" class="form-control" />
											</td>
											<td>
												<input type="text" id="pay_price1" class="form-control" onkeyup="min_real1(value)" />
											</td>
										</tr>
											<tr>
												<td colspan="7">
													<label for="desc2">Izoh</label>
														<textarea class="form-control" id="desc2" rows="5" style="resize: none;">

														</textarea>
												</td>
											</tr>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-sm-12">
						<button type="button" class="btn btn-default" data-dismiss="modal">O`chirish</button>
						<button type="button" class="btn btn-info" onclick="update_active1()" onclick="view()">Tasdiqlash</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content tugadi --> <!-- Container tugadi -->
	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
	<link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">
	<link rel="stylesheet" href="assets/js/datatables/datatables.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/select2/select2.min.js"></script>
	<script src="assets/js/bootstrap-tagsinput.min.js"></script>
	<script src="assets/js/typeahead.min.js"></script>
	<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/bootstrap-timepicker.min.js"></script>
	<script src="assets/js/bootstrap-colorpicker.min.js"></script>
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/jquery.multi-select.js"></script>
	<script src="assets/js/icheck/icheck.min.js"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/datatables/datatables.js"></script>
</body>
</html>