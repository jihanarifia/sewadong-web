<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="#"><i class="icon_house_alt"></i> Home</a></li>
						<li><a href="#"> Tenant</a></li>
						<li><a href="<?=base_url().'admin/industry'?>"> Industry</a></li>
						<li class="active"> Edit </li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							Edit Form
						</header>
						<div class="panel-body">
							<form role="form">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="name">Name</label>
											<input type="" class="form-control" id="name" placeholder="name">
										</div>
										<div class="form-group">
											<label for="phone">phone</label>
											<input type="" class="form-control" id="phone" placeholder="phone">
										</div>
										<div class="form-group">
											<label for="exampleInputFile">Avatar</label>
											<input type="file" id="exampleInputFile"">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="address">address</label>
											<input type="" class="form-control" id="address" placeholder="address">
										</div>
										<div class="form-group">
											<label for="day">day</label>
											<input type="" class="form-control" id="day" placeholder="day">
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label for="open">open</label>
													<input type="" class="form-control" id="open" placeholder="open">
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label for="close">close</label>
													<input type="" class="form-control" id="close" placeholder="close">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="specialoffer">Special offer</label>
											<input type="" class="form-control" id="specialoffer" placeholder="specialoffer">
										</div>
										<div class="form-group">
											<label for="subcategory">Sub Category</label>
											<select class="form-control m-bot15">
												<option>Sport</option>
												<option>Leisure</option>
												<option>Events</option>
												<option>Beauty</option>
												<option>Art & Culture</option>
											</select>
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
		</div>

	</section>
</section>
</section>