<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>						
						<li><a href="<?=base_url().'admin/tenant/'.$title?>"> <?=$title?></a></li>
						<li class="active">Insert tenant</li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<?=$title?> Form
						</header>
						<div class="panel-body">
							<form method="post" action="<?=base_url().'admin/insert_tenant'?>" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="name">Name</label>
											<input type="text" class="form-control" name="name" id="name" placeholder="name" required>
										</div>
										<div class="form-group">
											<label for="phone">Phone</label>
											<input maxlength="12" type="tel" class="form-control"  id="phone" name="phone" placeholder="phone" required>
										</div>
										<div class="form-group">
											<label for="address">Address</label>
											<input type="textarea" class="form-control" id="address" name="address" placeholder="address" required>
										</div>
										<div class="form-group">
											<label for="link">Link</label>
											<input type="text" class="form-control" name="link" id="link" placeholder="link">
										</div>
										<div class="form-group">
											<label for="subcategory">Premium</label>
											<select class="form-control m-bot15" name="premium" id="premium">
												<option  value="1">Yes</option>
												<option selected value="0">No</option>
											</select>
										</div>
										<div class="form-group">
											<label for="validfrom">Valid From</label>
											<div class="input-group">
												<input type="date" class="form-control" name="validfromdate" placeholder="Valid From Date" id="validfromdate" required>
												<span class="input-group-btn">
													<input type="time" class="form-control" name="validfromtime" placeholder="Valid From Time" id="validfromtime" required>
												</span>
											</div>
										</div>
										<div class="form-group">
											<label for="validuntil">Valid Until</label>
											<div class="input-group">
												<input type="date" class="form-control" name="validuntildate" placeholder="Valid Until Date" id="validuntildate" required>
												<span class="input-group-btn">
													<input type="time" class="form-control" name="validuntiltime" placeholder="Valid Until Time" id="validuntiltime" required>
												</span>
											</div>
										</div>
										<div class="form-group" style="margin-top: -2vh;">
											<input type="checkbox" id="validalltime" name="validalltime" >
											<label>Valid all the time</label>
										</div>
										<div class="form-group">
											<label for="subcategory">Category</label>
											<select class="form-control m-bot15" name="idcategory" >
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
												<input type="file" name="avatar" class="form-control" accept="image/*"/>
												<input type="checkbox" name="empty_avatar"><label>Set empty avatar</label><br>
												<label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
											</div>
										</div>
										<div class="col-lg-1"></div>
										<div class="col-lg-5">
											<div class="form-group">
												<label for="phone">PinPoint</label><br>
												<div id="map"></div>
											</div>
											<div class="form-group">
												<label for="name">Latitude</label>
												<input type="text" name='latitude' id='latitude' placeholder="latitude" class="form-control" value="" required>
											</div>
											<div class="form-group">
												<label for="phone">Longitude</label>
												<input type="text" class="form-control" name='longitude' id='longitude' value="" placeholder="longitude" required >
											</div>
											<div class="form-group">
												<label for="image">Logo</label>
												<input type="file" name="logo" id="image" class="form-control" accept="image/*" required />
												<label>Max: 800 X 800 | Min: 80 X 80<br>Max file size: 2 MB</label>
											</div>
											<div class="form-group">
												<label for="name">Color</label>
												<input type="color" class="form-control" id="color" name="color" placeholder="Color" value="#ff0000">
											</div>
										</div>
										<div class="col-lg-2"></div>
									</div>
									<div class="row">
										<div class="col-lg-10"></div>
										<div class="col-lg-2">
											<input type="hidden" name="title" value="<?=$title?>">
											<button type="submit" name="inserttenant"  class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
										</div>
									</div>
								</form>

							</div>
						</section>
					</div>
				</div>
				<!-- MOdal crop -->
				<div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreviewLabel" aria-hidden="true" data-backdrop="static"
				data-keyboard="false" >
				<div class="modal-dialog" style="width:635px;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close cancelCrop" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="imagePreviewLabel">Sesuaikan gambar</h4>
						</div>
						<div class="modal-body text-center">
							<img src="#" alt="" id="imageArea" class="target" style="display:none">

						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success confirmCrop" disabled="disabled">Crop</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</section>
</section>
<script type="text/javascript">
	var validfromdate = document.getElementById('validfromdate');
    var validfromtime = document.getElementById('validfromtime');
    var validuntildate = document.getElementById('validuntildate');
    var validuntiltime = document.getElementById('validuntiltime');
    var validalltime = document.getElementById('validalltime');
    var premium = document.getElementById('premium');
	if(premium.value == 1){
		validfromdate.disabled = false;
		validfromtime.disabled = false;
		validuntildate.disabled = false;
		validuntiltime.disabled = false;
		validalltime.disabled = false;
	}else{
		validalltime.disabled = true;
		validfromdate.disabled = true;
		validfromtime.disabled = true;
		validfromdate.value = null;
		validfromtime.value = null;
		
		validuntildate.disabled = true;
		validuntiltime.disabled = true;
		validuntildate.value = null;
		validuntiltime.value = null;
	}

	$('#premium').change(function(){
		if(premium.value == 1){
			validfromdate.disabled = false;
            validfromtime.disabled = false;
            validuntildate.disabled = false;
            validuntiltime.disabled = false;
			validalltime.disabled = false;
		}else{
			validalltime.disabled = true;
			validfromdate.disabled = true;
			validfromtime.disabled = true;
			validfromdate.value = null;
			validfromtime.value = null;
			
			validuntildate.disabled = true;
			validuntiltime.disabled = true;
			validuntildate.value = null;
			validuntiltime.value = null;
		}
	})
    
    $("#validalltime").click(function() {
        var cb = document.querySelectorAll('input[name="validalltime"]:checked');
        if(cb.length > 0){
			validuntildate.disabled = true;
			validuntiltime.disabled = true;
			validuntildate.value = null;
			validuntiltime.value = null;
        }else{
            validuntildate.disabled = false;
            validuntiltime.disabled = false;
        }
    });
</script>
