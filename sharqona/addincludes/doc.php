<ol class="breadcrumb">
	<li><a href="" style="color: white" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-center" role="button" id="dropdownMenuLink">Shartnoma yaratish</a></li>
</ol>
<table class="table table-bordered table-striped datatable" id="table-3">
<!--<div class="container">-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel with-nav-tabs panel-success">
				<div class="panel-heading">
					<ul class="nav nav-tabs">
						<? if(isset($_GET['menu']) && !empty($_GET['menu'])){ ?>
						<? if($_GET['menu']==1){ ?>
								<li class="active"><a href="/sharqona/list_page.php?menu=1">Yangi shartnomalar</a></li>
						<?}else{?>
								<li><a href="/sharqona/list_page.php?menu=1">Yangi shartnomalar</a></li>
						<?}?>
						<?}else{?>
							<li class="active"><a href="/sharqona/list_page.php?menu=1">Yangi shartnomalar</a></li>
						<?}?>
						<? if($_GET['menu']==2){ ?>
							<li class="active"><a href="/sharqona/list_page.php?menu=2">Active</a></li>
						<?}else{?>
							<li><a href="/sharqona/list_page.php?menu=2">Active</a></li>
						<?}?>
						<? if($_GET['menu']==3){ ?>
							<li class="active"><a href="/sharqona/list_page.php?menu=3">Yopilgan</a></li>
						<?}else{?>
							<li><a href="/sharqona/list_page.php?menu=3">Yopilgan</a></li>
						<?}?>
						<? if($_GET['menu']==4){ ?>
							<li class="active"><a href="/sharqona/list_page.php?menu=4">Bekor qilingan</a></li>
						<?}else{?>
							<li><a href="/sharqona/list_page.php?menu=4">Bekor qilingan</a></li>
						<?}?>
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<? if($_GET['menu']==1){ ?>
							<div class="tab-pane fade in active" id="tab1success">Success 1</div>
						<? }elseif($_GET['menu']==2){ ?>
							<div class="tab-pane fade in active" id="tab1success">Success 2</div>
						<? }elseif($_GET['menu']==3){ ?>
							<div class="tab-pane fade in active" id="tab1success">Success 3</div>
						<? }elseif($_GET['menu']==4){ ?>
							<div class="tab-pane fade in active" id="tab1success">Success 4</div>
						<?}else{?>
							<div class="tab-pane fade in active" id="tab1success">Success 5</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
<!--	</div>-->
</div>
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
								<td>Sanani tanlash</td>
								<td>
									<input type="date"  class="form-control" required id="reg_date">
								</td>
								<td>Mijoz  turi</td>
								<td>
									<select name="" class="form-control" id="user_type">
										<option value="birja">Birja</option>
										<option value="kucha">Ko`cha</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Mijoz</td>
								<td>
									<select name="" id="pr_name">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</td>
								<td>Shartnoma predmeti</td>
								<td>
									<select name="" class="form-control" id="user_good">
										<option value="tovarlar">Tovarlar</option>
										<option value="xizmatlar">Xizmatlar</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Shartnoma shablonini tanlash</td>
								<td>
									<input type="text" class="form-control" required id="inline-car_num">
								</td>
								<td>Shartnomani ko’rish </td>
								<td>
									<input type="text" class="form-control" required id="inline-car_name">
								</td>
							</tr>
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