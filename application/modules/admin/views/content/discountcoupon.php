<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>						
						<li class="active"><?=$title?></li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<a href="#insertcoupon" class="btn btn-primary pull-right" data-toggle="modal"><i class="icon_plus_alt2"></i>  Add Coupon</a>
							<h3>Coupon</h3>
						</header>
						<!-- sukses update -->
						<?php if($this->session->flashdata('message')) { ?> 
							<div class="alert alert-success fade in" id="alert">
								<?php echo $this->session->flashdata('message'); ?>
							</div> 
							<?php } ?>
							<?php if($this->session->flashdata('breakmessage')) { ?> 
								<div class="alert alert-block alert-danger fade in" id="alert">
									<?php echo $this->session->flashdata('breakmessage'); ?>
								</div> 
								<?php } ?>

								<div class="table-responsive">
									<table class="table table-hover" id="data-table">
										<thead>
											<tr>
												<th><i class="icon_building"></i>Name</th>
												<th><i class="icon_phone"></i>Phone Number</th>
												<th><i class="icon_cogs"></i> Action</th>

											</tr>
										</thead>
										<tbody>
											<?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
												<tr>
													<td><?=$data_con[$i]['name']?></td>
													<td><?=$data_con[$i]['phonenumber']?></td>
													<td>
														<div class="btn-group">
															<a data-toggle="modal" class="btn btn-success update-phone" href="#updateform" data-id="<?=$data_con[$i]['idphonenumber']?>" data-name="<?=$data_con[$i]['name']?>" data-phone="<?=$data_con[$i]['phonenumber']?>" ><i class="icon_pencil" ></i></a>
															<a data-toggle="modal" class="delete-phone btn btn-danger" href="#deleteform"  data-id="<?=$data_con[$i]['idphonenumber']?>"><i class="icon_trash_alt"></i></a>
														</div>
													</td>
												</tr>                         
												<?php $i++;} } else { ?>
													<tr><td colspan="6">No result found</td></tr>
													<?php } ?>
												</tbody>
											</table> 
										</div>
									</section>
								</div>
							</div>

							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertcoupon" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h4 class="modal-title">Add Discount Coupon</h4>
										</div>
										<div class="modal-body">
											<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_discountcoupon'?>" id="couponForm">
												<div class="form-group">
													<label for="photo" class="col-lg-2 control-label">Photo</label>
													<div class="col-lg-10">
														<input type="file" id="photo" name="photo" class="form-control" accept="image/*" required />
													</div>
												</div>
												<div class="form-group">
													<label for="title" class="col-lg-2 control-label">Title</label>
													<div class="col-lg-10">
														<input type="" class="form-control" id="title" name="title" placeholder="Title">
													</div>
												</div>
												<div class="form-group">
													<label for="caption" class="col-lg-2 control-label">Caption</label>
													<div class="col-lg-10">
														<textarea class="form-control ckeditor" name="caption" id="caption" rows="6"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label for="tenant" class="col-lg-2 control-label">Tenant</label>
													<div class="col-lg-10 selectContainer">
														<select class="form-control" name="color">
															<option value="">Choose a color</option>
															<option value="black">Black</option>
															<option value="green">Green</option>
															<option value="red">Red</option>
															<option value="yellow">Yellow</option>
															<option value="white">White</option>
														</select>
													</div>
												</div>						
												<div class="form-group">
													<div class="col-lg-offset-2 col-lg-10"><input type="hidden" name="idtenant" value="<?=$idtenant?>">
														<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Simpan</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>


						</section>
					</section>
				</section>