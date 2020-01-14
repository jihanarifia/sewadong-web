<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>

						<?php 
						if ($data_detail->notif[0]->idtenant!="") {?>
						<li><a href="<?= base_url().'admin/tenant/'.$category ?>">Notification <?=$category?></a></li>
						<?php }else{ ?>
						<li><a href="<?= base_url().'admin/notification' ?>">Notification </a></li>
						<?php } ?>
						<li class="active"><?=$title?></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php if ($this->session->flashdata('message')) { ?> 
					<div class="alert alert-success fade in" id="alert">
						<?php echo $this->session->flashdata('message'); ?>
					</div> 
					<?php } else if ($this->session->flashdata('breakmessage')) { ?> 
					<div class="alert alert-block alert-danger fade in" id="alert">
						<?php echo $this->session->flashdata('breakmessage'); ?>
					</div> 
					<?php } ?>
					<div class="row">
						<div class="col-lg-6">
							<div class="panel"> 
								<header class="panel-heading ">
									<h3>Edit form notification</h3>
								</header>
								<div class="panel-body">
									<form role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/update_notif'?>">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label for="title">Title</label>
													<input type="text" class="form-control" name="title" placeholder="Title" value="<?=$data_detail->notif[0]->title ?>" required>
												</div>
												<div class="form-group">
													<label for="description">Description</label>
													<input type="text" class="form-control" name="description" placeholder="Description" value="<?=$data_detail->notif[0]->description ?>" required>	
												</div>
												<div class="form-group">
													<label for="title_en">Title(English)</label>
													<input type="text" class="form-control" name="title_en" placeholder="Title(English)" value="<?=$data_detail->notif[0]->title_en ?>" required>
												</div>
												<div class="form-group">
													<label for="description_en">Description(English)</label>
													<input type="text" class="form-control" name="description_en" placeholder="Description(English)" value="<?=$data_detail->notif[0]->description_en ?>" required>	
												</div>
												<div class="form-group">
													<label for="photo">Avatar</label>
													<input type="file" name="photo" id="photo" class="form-control" accept="image/*" />
													<input type="checkbox" name="empty_avatar" <?php if($data_detail->notif[0]->image==null) echo "checked"; ?>><label>Set empty avatar</label><br>
													<label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
												</div>
												<?php if($data_detail->notif[0]->image!=null) { ?>
												<div class="col-lg-8" style="height:200px;width:200px;overflow:hidden;display:flex;justify-content:center;align-items:center">
													<img class="image-responsive" src="<?= $data_detail->notif[0]->image ?>" style="height:100%;">
												</div>
												<?php } ?>
												<input type="hidden" class="form-control" id="avatar" name="photo1" placeholder="avatar" value="<?=$data_detail->notif[0]->image ?>">
												<?php 
												if ($data_detail->notif[0]->idtenant!="") {?>
												<div class="form-group col-lg-12 ">
													<label for="tenant">Tenant</label>
													<div class="selectContainer">
														<select class="form-control" name="idtenant" required>
															<?php
															foreach ($tenant as $item) {
																?>
																<option <?= $idtenant == $item->idtenant ? "selected" : "" ?> value="<?php echo $item->idtenant ?>">
																	<?php echo $item->tenantsname ?>
																</option>
																<?php } ?>
															</select>
														</div>
													</div> 
													<?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-10"></div>
												<div class="col-lg-2">
													<input type="hidden" class="desc" name="idnotif" id="u_idnotif" value="<?=$data_detail->notif[0]->idnotif ?>">
													<input type="hidden" name="createdate" id="u_createdate" value="<?=$data_detail->notif[0]->createdate ?>">
													<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
												</div>

											</div>
										</form>

									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<section class="panel">
									<header class="panel-heading ">
										<a href="#insertisread" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add account</a>
										<h3>account</h3>


									</header>
									<table class="table table-hover" id="data-table">
										<thead>
											<tr>
												<th><i class="icon_profile"></i> account name</th>
												<th><i class="icon_building"></i> is read</th>
												<th><i class="icon_cogs"></i> Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if (isset($data_detail->account[0])) {
												foreach ($data_detail->account as $item_detail) {
													?>  
													<tr>
														<td><?= $item_detail->name ?></td>
														<td>
															<?php if($item_detail->isread=="f"){
																echo "false";
															}else if ($item_detail->isread=="f") {
																echo "true";
															}  ?>

														</td>
														<td>
															<div class="btn-group">
																<a data-toggle="modal" class="delete-accountread btn btn-danger" href="#deleteaccount"  data-id="<?= $item_detail->idread?>" ><i class="icon_trash_alt"></i></a>
															</div>

														</td>
													</tr> 

													<?php } ?>

													<?php } else { ?>
													<tr><td colspan="6">No result found</td></tr>
													<?php } ?> 
												</tbody>

											</table>
										</section>
									</div>

								</div>
							</div>
						</div>
					</section>
				</section>
			</section>
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteaccount" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Delete Notif Account</h4>
						</div>
						<div class="modal-body">
							<p>Are you sure delete this point?</p>                          
							<form method="post" action="<?=base_url().'admin/delete_isread'?>">
								<input type="hidden" name="idread" id="del_id" value="">
								<button type="submit" class="btn btn-danger">Sure</button>
								<button class="btn btn-info" data-dismiss="modal">Cancel</button>
							</form>                            
						</div>
					</div>
				</div>
			</div>
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertisread" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Insert Notif Account</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_isread'?>">
								<div class="row">
									<div class="col-lg-2"></div>
									<div class="col-lg-8">
										<div class="form-group">
											<label for="photo">Account</label>
											<select name="account[]" multiple id="account">
												<?php 
												foreach ($account as $item) { 
													?>
													<option value="<?php echo $item['idaccount']?>">
														<?php echo $item['fullname']?>
													</option>   
													<?php  } ?> 
												</select>
											</div>
											<div class="row ">
												<div class="col-lg-10"></div>
												<div class="col-lg-2">
													<input type="hidden" name="idnotif" value="<?=$data_detail->notif[0]->idnotif ?>">

													<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
												</div>
											</div>
										</div>
										<div class="col-lg-2"></div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$('.form-group')
						.find('[name="idtenant"]')
						.combobox()
						.end()
					});

							 //delete notif
							 $(".delete-accountread").click(function(){       
							 	var idreadnotif = $(this).attr("data-id"); 
							 	$("#del_id").prop("value", idreadnotif);
							 });
							</script>