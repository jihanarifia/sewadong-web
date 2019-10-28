<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
						<li class="active"> <?=$title?></li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>

			<!--HASHTAG	-->
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<a href="#inserthashtag" class="btn btn-primary" data-toggle="modal"><i class="icon_plus"></i> Add</a>
						</header>
						<!-- sukses update -->
						<?php if($this->session->flashdata('message_hashtag')) { ?> 
						<div class="alert alert-success fade in" id="alert">
							<?php echo $this->session->flashdata('message_hashtag'); ?>
						</div> 
						<?php } ?>
						<?php if($this->session->flashdata('breakmessage_hashtag')) { ?> 
						<div class="alert alert-block alert-danger fade in" id="alert">
							<?php echo $this->session->flashdata('breakmessage_hashtag'); ?>
						</div> 
						<?php } ?>

						<div class="table-responsive">
							<table class="table table-hover" id="data-table">
								<thead>
									<tr>
										<th><i class="icon_image"></i> Hashtag</th>
										<th><i class="icon_hashtag"></i> Description</th>
										<th><i class="icon_cogs"></i> Action</th>

									</tr>
								</thead>
								<tbody>
									<?php if(isset($data_hash)!=false && empty($data_hash)==false) { $i=0; foreach($data_hash as $data_hash[]) { ?>  
									<tr>
										<td><?=$data_hash[$i]['tag']?></td>
										<td><?=$data_hash[$i]['description']?></td>

										<td>
											<div class="btn-group">
												<a  data-toggle="modal" class="btn btn-success update-hashtag" href="#edithashtag" data-id="<?=$data_hash[$i]['idhashtag']?>" data-tag="<?=$data_hash[$i]['tag']?>" data-description="<?=$data_hash[$i]['description']?>"><i class="icon_pencil"></i></a>
												<a  data-toggle="modal" class="delete-hashtag btn btn-danger" href="#deletehashtag" data-idhashtag="<?=$data_hash[$i]['idhashtag']?>" ><i class="icon_trash_alt"></i></a>
								
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
		
			<!--PHOTO-->
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<a href="#insertphoto" class="btn btn-primary" data-toggle="modal"><i class="icon_plus"></i> Add</a>
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
										<th><i class="icon_image"></i> Photo</th>
										<th><i class="icon_quotations"></i> Title</th>
										<th><i class="icon_cogs"></i> Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
									<tr>
										<td><img height="99px" width="99px" src="<?=$data_con[$i]['avatar']?>"></td>
										<td><?=$data_con[$i]['title']?></td>
										<td>
											<div class="btn-group">
												<a data-toggle="modal" class="btn btn-success update-gallerycity" href="#editphoto" data-id="<?=$data_con[$i]['idcitygallery']?>" data-avatar="<?=$data_con[$i]['avatar']?>" data-title="<?=$data_con[$i]['title']?>"><i class="icon_pencil"></i></a>
												<a data-toggle="modal" class="delete-photo btn btn-danger" href="#deletephoto" data-idgallery="<?=$data_con[$i]['idcitygallery']?>" data-imageurl="<?=$data_con[$i]['avatar']?>" ><i class="icon_trash_alt"></i></a>
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

			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertphoto" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Add Photo</h4>
						</div>
						<div class="modal-body">

							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_gallerycity' ?>">
								<div class="form-group">
									<label for="photo" class="col-lg-2 control-label">Photo</label>
									<div class="col-lg-10">
										<input type="file" id="photo" name="photo" class="form-control" accept="image/*" required />
										<div class="row">
											<div class="col-lg-6">
												<label>Max: 2000 X 2000 px<br>Max file size: 2 MB</label>
											</div>
											<div class="col-lg-6">
												<label>Min: 150 X 150 px<br></label>
											</div>
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label for="title" class="col-lg-2 control-label">Title</label>
									<div class="col-lg-10">
										<input type="" class="form-control" id="title" name="title" placeholder="Title" required>
									</div>
								</div>							
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletephoto" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Delete Photo </h4>
						</div>
						<div class="modal-body">
							<p>Are you sure delete this point?</p>                          
							<form method="post" action="<?= base_url() . 'admin/delete_gallerycity' ?>">
								<input type="hidden" name="imageurl" id="del_imageurl" value="">
								<input type="hidden" name="idgallery" id="del_idgallery" value="">
								<button type="submit" class="btn btn-danger">Sure</button>
								<button class="btn btn-info" data-dismiss="modal">Cancel</button>
							</form>                            
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editphoto" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Edit Photo</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_gallerycity' ?>">
								<div class="form-group">
									<label for="photo" class="col-lg-2 control-label">Photo</label>
									<div class="col-lg-10">
										<input type="file" id="photo" name="photo" class="form-control" accept="image/*"/ required>
										<label>Max: 4000 X 4000<br>Max file size: 2 MB</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2"></label>
									<img class="col-lg-7 image-responsive"  src=""  id="u_avatar" name="photo1" style="height:150px;width:auto">
									<input type="hidden" name="photo1" id="u_setavatar" value="">
								</div>
								<div class="form-group">
									<label for="title" class="col-lg-2 control-label">Title</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" id="u_title" value="" name="title" placeholder="Title" required>
									</div>
								</div>	

								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<input type="hidden" id="u_idgallery" value="" name="idgallery">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<!--Hashtag-->
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="inserthashtag" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Add Hashtag</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_hashtag' ?>">
								<div class="form-group">
									<label for="hashtag" class="col-lg-2 control-label">Hashtag</label>
									<div class="col-lg-10">
										<input type="" class="form-control" id="hashtag" name="tag" placeholder="Hashtag" required>										
									</div>
								</div>
								<div class="form-group">
									<label for="title" class="col-lg-2 control-label">Description</label>
									<div class="col-lg-10">
										<input type="" class="form-control" id="desc" name="description" placeholder="Description" required>
									</div>
								</div>							
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edithashtag" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Edit Hashtag</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_hashtag' ?>">
								<input type="hidden" name="idhashtag" id="u_idhashtag" value="">
								<div class="form-group">
									<label for="hashtag" class="col-lg-2 control-label">Hashtag</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" id="u_hashtag" value="" name="tag" placeholder="Hashtag" required>										
									</div>
								</div>
								<div class="form-group">
									<label for="title" class="col-lg-2 control-label">Description</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" id="u_desc" value="" name="description" placeholder="Description" required>
									</div>
								</div>	
								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<input type="hidden" id="u_idgallery" value="" name="idgallery">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletehashtag" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
							<h4 class="modal-title">Delete Hashtag </h4>
						</div>
						<div class="modal-body">
							<p>Are you sure delete this point?</p>                          
							<form method="post" action="<?= base_url() . 'admin/delete_hashtag' ?>">
								<input type="hidden" name="idhashtag" id="d_idhashtag" value="">
								<button type="submit" class="btn btn-danger">Sure</button>
								<button class="btn btn-info" data-dismiss="modal">Cancel</button>
							</form>                            
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>
</section>