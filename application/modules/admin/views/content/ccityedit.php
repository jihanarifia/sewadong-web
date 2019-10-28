<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="#"><i class="icon_house_alt"></i> Home</a></li>
						<li><a href="#"> City</a></li>
						<li><a href="<?=base_url().'admin/ccity'?>"> City Data</a></li>
						<li class="active"> Edit </li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							Edit Form City Data
						</header>
						<div class="panel-body">
							<form role="form">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="name">City Name</label>
											<input type="" class="form-control" id="name" name="" placeholder="City Name">
										</div>
										<div class="form-group">
		 									<label for="phone">City Area</label>
											<input type="" class="form-control" id="phone" placeholder="City Area">
										</div>
										<div class="form-group">
											<label for="phone">Metro Area</label>
											<input type="" class="form-control" id="phone" placeholder="Metro Area">
										</div>
										<div class="form-group">
											<label for="phone">Resident Population</label>
											<input type="" class="form-control" id="phone" placeholder="Resident Population">
										</div>
										<div class="form-group">
											<label for="phone">Employment Population</label>
											<input type="" class="form-control" id="phone" placeholder="Employment Population">
										</div>
										<div class="form-group">
											<label for="phone">Jobs Population</label>
											<input type="" class="form-control" id="phone" placeholder="Jobs Population">
										</div>
										
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="phone">Jobs Information</label>
											<input type="" class="form-control" id="phone" placeholder="Jobs Information">
										</div>
										<div class="form-group">
											<label for="address">Trees Information</label>
											<input type="" class="form-control" id="address" placeholder="Trees Information">
										</div>
										<div class="form-group">
											<label for="day">Roads Information</label>
											<input type="" class="form-control" id="day" placeholder="Roads Information">
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label for="open">House Information</label>
													<input type="" class="form-control" id="open" placeholder="House Information">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label for="close">Area Code</label>
													<input type="" class="form-control" id="close" placeholder="Area Code">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="specialoffer">Shop House Information</label>
											<input type="" class="form-control" id="specialoffer" placeholder="Shop House Information">
										</div>
										<div class="form-group">
											<label for="specialoffer">School Information</label>
											<input type="" class="form-control" id="specialoffer" placeholder="School Information">
										</div>
									</div>
									<div class="col-lg-4">
										
										<div class="form-group">
											<label for="specialoffer">International School Information</label>
											<input type="" class="form-control" id="specialoffer" placeholder="International School Information">
										</div>
										<div class="form-group">
											<label for="specialoffer">Service Apartement Information</label>
											<input type="" class="form-control" id="specialoffer" placeholder="Service Apartement Information">
										</div>
										<div class="form-group">
											<label for="specialoffer">Roads Information</label>
											<input type="" class="form-control" id="specialoffer" placeholder="Roads Information">
										</div>
										<div class="form-group">
											<label for="specialoffer">Vehicle Registration</label>
											<input type="" class="form-control" id="specialoffer" placeholder="Vehicle Registration">
										</div>


									</div>
								</div>
								<div class="row">
									<div class="col-lg-10"></div>
									<div class="col-lg-2">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Simpan</button>
									</div>
									
								</div>
							</form>

						</div>
					</section>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<section class="panel">
						<header class="panel-heading">
							<a href="#insertphoto" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus_alt2"></i>  Add Photo</a>
						</header>
						<table class="table table-striped table-advance table-hover">
							<tbody>
								<div class="row">
									<div
								</div>
								<tr>
									<th><i class="icon_profile"></i> Photo</th>
									<th><i class="icon_calendar"></i> title</th>
									<th><center><i class="icon_cogs"></i> Action</th></center>
								</tr>
								<tr>
									<td><center><img height="99px" width="99px" src="<?=base_img().'gallery/lippo-cikarang-city-walk.jpg'?>"  ></td>
								</center>
								<td>Foto Keren</td>
								<td>
									<center>
										<div class="btn-group">
											<a class="btn btn-success" href="#editphoto" data-toggle="modal"><i class="icon_pencil"></i></a>
											<a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
										</div>
									</center>
								</td>
							</tr>          

						</tbody>
					</table>
				</section>
			</div>
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

					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="exampleInputFile" class="col-lg-2 control-label">Photo</label>
							<div class="col-lg-10">
								<input type="file" class="" id="exampleInputFile">
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-lg-2 control-label">Title</label>
							<div class="col-lg-10">
								<input type="" class="form-control" id="inputEmail4" placeholder="Title">
							</div>
						</div>	
						<div class="form-group">
							<label for="price" class="col-lg-2 control-label">Caption</label>
							<div class="col-lg-10">
								<textarea class="form-control ckeditor" name="editor1" rows="6"></textarea>
							</div>
						</div>						
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Simpan</button>
							</div>
						</div>
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

					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="exampleInputFile" class="col-lg-2 control-label">Photo</label>
							<div class="col-lg-10">
								<input type="file" class="" id="exampleInputFile">
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-lg-2 control-label">Title</label>
							<div class="col-lg-10">
								<input type="" class="form-control" id="inputEmail4" placeholder="Title">
							</div>
						</div>	
						<div class="form-group">
							<label for="price" class="col-lg-2 control-label">Caption</label>
							<div class="col-lg-10">
								<textarea class="form-control ckeditor" name="editor1" rows="6"></textarea>
							</div>
						</div>						
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
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