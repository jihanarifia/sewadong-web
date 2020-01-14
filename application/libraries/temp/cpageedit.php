<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="#"><i class="icon_house_alt"></i> Home</a></li>
						<li><a href="#"> City</a></li>
						<li><a href="<?=base_url().'admin/cpage'?>"> Page</a></li>
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
											<label for="subcategory">City</label>
											<select class="form-control m-bot15">
												<option>Malang</option>
												<option>Jakarta</option>
												<option>Surabaya</option>
												<option>Yogyakarta</option>
												<option>Semarang</option>
											</select>
										</div>
										<div class="form-group">
											<label for="name">Title</label>
											<input type="" class="form-control" id="name" placeholder="Title">
										</div>
									</div>
									<div class="col-sm-8">
										<div class="col-lg-12">
											<section class="panel">
												<div class="panel-body">
													<div class="form">
														<form action="#" class="form-horizontal">
															<div class="form-group">
																<label class="control-label col-sm-2">Content</label>
																<div class="col-sm-10">
																	<textarea class="form-control ckeditor" name="editor1" rows="6"></textarea>
																</div>
															</div>
														</form>
													</div>
												</div>
											</section>
										</div>
										<div class="col-lg-10"></div>
										<div class="col-lg-2">
											<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Simpan</button>
										</div>
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