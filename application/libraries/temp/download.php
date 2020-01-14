<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>						
						<li><a href="#"> City</a></li>
						<li class="active"> Download </li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<div class="row">
								<div class="col-lg-8">
									<a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i>&nbsp;Add</a>
								</div>
								<div class = "col-sm-4">
									<div class="pull-right">
										<div class="row">
											<div class="col-lg-4">
												<h5>Filter by</h5>
											</div>
											<div class="col-lg-8">
												<div class="pull-right">
													<select class="form-control m-bot15" id="filter" onChange="download(this)" name="idcategory">
														<option id="idcategory" value="">All</option>
														<?php
														foreach ($subcat as $item) {
															?>
															<option <?=$this->input->get('subcat')==$item->idcategory ? "selected" : ""?> id="idcategory" value="<?php echo $item->idcategory?>">
																<?php echo $item->categoryname?>
															</option>
															<?php } ?>
														</select>
													</div>
												</div>                              
											</div>
										</div>
									</div>
								</div>
							</header>
							<!-- form insert file -->
							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h4 class="modal-title">Insert File</h4>
										</div>
										<div class="modal-body">
											<form role="form" action="<?=base_url().'admin/insert_file'?>" method="post" enctype="multipart/form-data" id="formacc">
												<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															<label for="name">Title</label>
															<input type="text" class="form-control" id="title" name="title" placeholder="Name" autofocus required>
														</div>
														<div class="form-group">
															<label for="subcategory">Category</label>
															<select class="form-control m-bot15" name="idcategory" required>
																<?php
																foreach ($subcat as $item) {
																	?>
																	<option value="<?php echo $item->idcategory?>">
																		<?php echo $item->categoryname?>
																	</option>   
																	<?php } ?>
																</select>
															</div>
															<div class="form-group">
																<label for="avatar">Avatar</label>
																<input type="file" name="avatar" class="form-control" accept="image/*" />
																<input type="checkbox" name="empty_avatar" ><label> Empty avatar</label>
															</div>
															<div class="form-group">
																<label for="avatar">File</label>
																<input type="file" name="file" class="form-control" accept=".pdf" />
																<label>Just receive PDF file</label>
															</div>
														</div>
													</div>
													<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<!-- form update file -->
								<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateform" class="modal fade">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
												<h4 class="modal-title">Update File</h4>
											</div>
											<div class="modal-body">
												<form role="form" action="<?=base_url().'admin/update_file'?>" method="post" enctype="multipart/form-data" id="formacc">
													<div class="row">
														<div class="col-lg-12">
															<div class="form-group">
																<label for="name">Title</label>
																<input type="text" class="form-control" id="utitlefile" name="title" placeholder="Name" autofocus required>
															</div>
															<div class="form-group">
																<label for="subcategory">Category</label>
																<select class="form-control m-bot15" name="idcategory" id="uidcategory" required>
																	<?php
																	foreach ($subcat as $item) {
																		?>
																		<option value="<?php echo $item->idcategory?>">
																			<?php echo $item->categoryname?>
																		</option>   
																		<?php } ?>
																	</select>
																</div>
																<div class="form-group">
																	<label for="avatar">Avatar</label>
																	<input type="file" name="avatar" class="form-control" accept="image/*" /><br>
																	<input id="u_ceknullavatar" type="checkbox" name="empty_avatar" checked="false"><label>Set empty avatar</label><br><br>
																	<center><img class="image-responsive" height="75px" src="" id="uavatarfile"></center>
																	<input type="hidden" id="usetavatarfile" name="uavatar" value="">

																</div>
																<div class="form-group ">
																	<label for="file">File</label>
																	<input type="file" id="linkcatalog" class="form-control" name="linkfile" accept="application/pdf">
																	<input type="hidden" id="ulinkfile" name="ulinkfile" value="" >
																	<input type="text" name="filename" id="ufilename" value="" class="form-control" readonly>
																	<input id="u_ceknullfile" type="hidden" name="empty_file" checked="false">
																</div>
															</div>
														</div>
														<input type="hidden" name="iddownload" id="uidfile" value="">
														<input type="hidden" name="filesize" id="ufilesize" value="">
														<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
													</form>
												</div>
											</div> 
										</div>
									</div>
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
										<table class="table table-striped table-advance table-hover" id="data-table">
											<thead>
												<tr>
													<th><i class="icon_image"></i> Avatar</th>
													<th><i class="icon_quotations"></i> Title</th>
													<th><i class="icon_tag_alt"></i> Category</th>
													<th><i class="icon_link"></i> Link File</th>
													<th><i class="icon_tools"></i> Action</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
												<tr>
													<td style="width:100px;height:auto"><img class="col-lg-12 image-responsive" src="<?=$data_con[$i]['avatar']?>"></td>
													<td><?=$data_con[$i]['title']?></td>
													<td><?=$data_con[$i]['categoryname']?></td>
													<td><?php if($data_con[$i]['linkfile']!=""){ ?>
														<a class="form-control" download href="<?= $data_con[$i]['linkfile'] ?>">Download file</a>
														<?php } ?></td>
														<td>
															<div class="btn-group">
																<a data-toggle="modal"  href="#updateform" class="btn btn-success update-downloadfile" data-id="<?=$data_con[$i]['iddownload']?>"
																	data-idcategory="<?=$data_con[$i]['idcategory']?>"
																	data-title="<?=$data_con[$i]['title']?>" 
																	data-idtenant="<?=$data_con[$i]['idtenant']?>" data-avatar="<?=$data_con[$i]['avatar']?>" data-linkfile="<?=$data_con[$i]['linkfile']?>" data-filename="<?=$data_con[$i]['filename']?>" data-filesize="<?=$data_con[$i]['filesize']?>"   ><i class="icon_pencil"></i></a>
																	<a data-toggle="modal" class="delete-downloadfile btn btn-danger" href="#deleteform" data-id="<?=$data_con[$i]['iddownload']?>" data-avatar="<?=$data_con[$i]['avatar']?>" data-linkfile="<?=$data_con[$i]['linkfile']?>" data-filesize="<?=$data_con[$i]['filesize']?>" data-filename="<?=$data_con[$i]['filename']?>"   >
																		<i class="icon_trash_alt"></i></a>
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
									<!-- delete form file -->
									<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
													<h4 class="modal-title">Delete File</h4>
												</div>
												<div class="modal-body">
													<p>Are you sure delete this point?</p>                          
													<form method="post" action="<?=base_url().'admin/delete_file'?>">
														<input type="hidden" name="iddownload" id="del_iddownload" value="">
														<input type="hidden" name="avatar" id="del_avatar" value="">
														<input type="hidden" name="linkfile" id="del_file" value="">
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

