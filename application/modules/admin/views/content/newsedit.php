<style>
	.bootstrap-tagsinput {
		display: block;
	}

	.label-info {
		background-color: #007aff;
	}
</style>
<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
						<li><a href="<?=base_url().'admin/news'?>">News</a></li>
						<li class="active"><?=$title?></li>
					</ul>
					<!--breadcrumbs end -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php if ($this->session->flashdata('message')!=null) { ?> 
					<div class="alert alert-success fade in" id="alert">
						<?php echo $this->session->flashdata('message'); ?>
					</div> 
					<?php } else if ($this->session->flashdata('breakmessage')!=null) { ?> 
					<div class="alert alert-block alert-danger fade in" id="alert">
						<?php echo $this->session->flashdata('breakmessage'); ?>
					</div> 
					<?php } ?>
					<section class="panel">
						<header class="panel-heading">
							Edit Form City News
						</header>
						<div class="panel-body">
							<form role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/update_news'?>">
								<!-- row detail -->
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="title">Indonesian Title</label>
											<input type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?=$data_detail->detail[0]->title ?>" required>
										</div>
										<div class="form-group">
											<label for="title_en">English title</label>
											<input type="text" class="form-control" id="title_en" placeholder="English title" name="title_en" value="<?=$data_detail->detail[0]->title_en ?>" required>
										</div>
										<div class="form-group">
											<label for="photo">Video</label>
											<input type="file" id="video" name="video" class="form-control" accept="video/*" />
											<label>Max file size: 5 MB</label><br>
											<input type="checkbox" name="empty_video"<?php echo ($data_detail->detail[0]->type=="3")?'checked':'' ?> id="empty_video"><label> URL link video</label>
										</div>
										<div class="form-group">
											<label for="photo">URL Video</label>
											<input type="text" id="url_video" name="url_video" class="form-control" value="<?php echo ($data_detail->detail[0]->type=="3")?$data_detail->detail[0]->video:''?>" />
										</div>
										
									</div>
									<!-- row detail kanan -->
									<div class="col-lg-6">
										<div class="form-group">
											<label for="subcategory">Category</label>
											<select class="form-control m-bot15" name="idnewscategory" required>
												<?php
													foreach ($subnewscat as $item) {
													?>
													<option <?= $data_detail->detail[0]->idnewscategory == $item->idnewscategory ? "selected" : "" ?> value="<?php echo $item->idnewscategory?>">
														<?php echo $item->newscategory?>
													</option> 	
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="labeltags" >Tags</label>
											<input type="text" class="form-control" id="labeltags" name="labeltags" value="<?php echo $data_detail->detail[0]->tag?>" data-role="tagsinput">
											<label class="control-label">Maks. 10 Tags</label>
										</div>
										<div class="form-group">
											<label for="photo" class="col-lg-2 control-label">Cover</label>
											<input type="file" id="image" name="image" class="form-control" accept="image/*" />
											<input type="checkbox" name="empty_avatar" <?php if($data_detail->detail[0]->avatar==null) echo "checked"; ?>><label> Empty cover</label><br>
											<label>Max: 800 x 800 | Min: 165 x 114<br>Max file size: 2 MB</label>
										</div>
										<div class="row">
											<?php if($data_detail->detail[0]->avatar!=null) { ?>
											<div class="col-lg-2" style="height:100px;width:100px;overflow:hidden;display:flex;justify-content:center;align-items:center">
												<img class="image-responsive" src="<?= $data_detail->detail[0]->avatar ?>" style="height:100%;">
											</div>
											<input type="hidden" class="form-control" id="exist_avatar" name="exist_avatar" placeholder="type" value="<?= $data_detail->detail[0]->avatar ?>">
											<?php } ?>	
										</div>
										<?php if($data_detail->detail[0]->video!=null && $data_detail->detail[0]->type=="2") { ?>
										<br>
										<div class="form-group">
											<label for="photo" class="col-lg-2 control-label">Video</label><br>
											<a href="<?= $data_detail->detail[0]->video?>"><?= $data_detail->detail[0]->video?></a>
											<input type="hidden" class="form-control" id="exist_video" name="exist_video" placeholder="type" value="<?= $data_detail->detail[0]->video ?>">
										</div>
										<?php } ?>
										<input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?= $data_detail->detail[0]->avatar ?>">
										<input type="hidden" class="form-control" id="type" name="type" placeholder="type" value="<?= $data_detail->detail[0]->type ?>">
									</div>
								</div>
								<!-- row ckeditor -->
								<div class="row" style="margin-top:5%">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="description">Indonesian description</label>
											<textarea class="form-control ckeditor" name="description" rows="3"><?=$data_detail->detail[0]->description?></textarea>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="description_en">English description</label>
											<textarea class="form-control ckeditor" name="description_en" rows="3"><?=$data_detail->detail[0]->description_en?></textarea>
										</div>
									</div>
								</div>
								<!-- row save -->
								<div class="row">
									<div class="col-lg-10"></div>
									<div class="col-lg-2">
										<input type="hidden" name="idnews"  value="<?=$data_detail->detail[0]->idnews?>">
										<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
									</div>
								</div>
							</form>
						</div>
					</section>
				</div>

				<div class="col-md-6">
					<section class="panel">
						<header class="panel-heading">
							Gallery
							<div style=" float: right; margin-left : 3%;">
								<a href="#insertgallery" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Photo</a>	
							</div>
							<div style="float: right;">
								<a href="#insertgalleryvideo" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Video</a>
							</div>
							<div style="clear:both"></div>
						</header>
						<table class="table table-striped table-advance table-hover " id="data-table2"> 
							<thead>
								<tr>
									<th><i class="icon_image"></i> Photo</th>
                                    <th><i class="icon_quotations"></i> Caption</th>
									<th><i class="icon_cogs"></i> Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (isset($data_detail->gallery)) {
									foreach ($data_detail->gallery as $item_detail) {
										?>  
										<tr>
											<td style="overflow:hidden;height:90px">
												<?php
												if(strpos($item_detail->avatar, 'video')==true){
													?>
													<h2>Video</h2>
													<?php
												}else if(strpos($item_detail->avatar, 'youtube')==true){
													?>
													<h2>Link Youtube</h2>
													<?php
												}else{
													?>
													<img src="<?=$item_detail->avatar?>" style="height:100%;width:auto">
													<?php
												}
												?>
											</td>
                                            <td>
                                                <?= $item_detail->caption?>
                                            </td>
											<td>
												<div class="btn-group">
													<a data-toggle="modal" class="btn btn-success update-gallerynews" <?php echo (strpos($item_detail->avatar, 'video')==true || strpos($item_detail->avatar, 'youtube')==true)?'href="#editvideo"':'href="#editphoto"' ?> data-id="<?=$item_detail->idnewsgallery?>" data-caption="<?= @$item_detail->caption?>" data-avatar="<?=$item_detail->avatar?>" data-idnews="<?=$item_detail->idnews?>" data-imageurl="<?php echo ($item_detail->type=="3")?$item_detail->avatar:'' ?>"><i class="icon_pencil"></i></a>
													<a data-toggle="modal" class="delete-photo btn btn-danger" href="#deletephoto" data-idgallery="<?=$item_detail->idnewsgallery?>"  data-imageurl="<?=$item_detail->avatar?>"><i class="icon_trash_alt"></i></a>
												</div>
											</td>
										</tr>                         
										<?php }
									} else { ?>
									<tr><td colspan="3">No result found</td></tr>
									<?php } ?>
								</tbody>
							</table>
						</section>
					</div>

				</div>


				<!-- form insert photo gallery -->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertgallery" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h4 class="modal-title">Add Photo</h4>
							</div>
							<div class="modal-body">

								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_gallerynews' ?>">
									<div class="form-group">
										<label for="photo" class="col-lg-2 control-label">Photo</label>
										<div class="col-lg-10">
											<input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
											<label>Max: 800 X 800<br>Max file size: 2 MB</label>
										</div>
									</div>
                                    <div class="form-group">
                                        <label for="photo" class="col-lg-2 control-label">Caption</label>
                                        <div class="col-lg-10">
                                            <input type="text" id="caption" name="caption" value="" maxlength="100" class="form-control" />
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<input type="hidden" class="form-control" id="idnews" name="idnews" value="<?=$data_detail->detail[0]->idnews ?>">
											<input type="hidden" id="pilihan" name="pilihan" value="photo">
											<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- form insert video gallery -->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertgalleryvideo" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h4 class="modal-title">Add Video</h4>
							</div>
							<div class="modal-body">

								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_gallerynews' ?>">
									<div class="form-group">
										<label for="photo" class="col-lg-2 control-label">Video</label>
										<div class="col-lg-10">
											<input type="file" id="video" name="video" class="form-control" accept="video/*" /><br>
											<label>Max file size: 5 MB</label><br>
											<input type="checkbox" name="empty_video" id="empty_video"><label> URL link video</label>
										</div>
									</div>
									<div class="form-group" id="input_url_video">
										<label for="photo" class="col-lg-2 control-label">URL Video</label>
										<div class="col-lg-10">
											<input type="text" id="url_video" name="url_video" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<input type="hidden" class="form-control" id="idnews" name="idnews" value="<?=$data_detail->detail[0]->idnews ?>">
											<input type="hidden" id="pilihan" name="pilihan" value="video" >
											<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- form delete gallery -->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletephoto" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h4 class="modal-title">Delete Photo or Video</h4>
							</div>
							<div class="modal-body">
								<p>Are you sure delete this point?</p>                          
								<form method="post" action="<?= base_url() . 'admin/delete_gallerynews' ?>">
									<input type="hidden" name="imageurl" id="del_imageurl" value="">
									<input type="hidden" name="idnewsgallery" id="del_idgallery" value="">
									<button type="submit" class="btn btn-danger">Sure</button>
									<button class="btn btn-info" data-dismiss="modal">Cancel</button>
								</form>                            
							</div>
						</div>
					</div>
				</div>
				<!-- form update gallery photo-->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editphoto" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h4 class="modal-title">Edit Photo</h4>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_gallerynews' ?>">
									<div class="form-group">
										<label for="photo" class="col-lg-2 control-label">Photo</label>
										<div class="col-lg-10">
											<input type="file" id="photo" onchange="fileChanged(this)" name="photo" class="form-control" accept="image/*" />
											<label>Max: 800 X 800<br>Max file size: 2 MB</label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2"></label>
										<img class="col-lg-7 image-responsive"  src=""  id="u_avatar" name="photo1" style="height:150px;width:auto">
										<input type="hidden" name="photo1" id="u_setavatar" value="">
									</div>
                                    <div class="form-group">
                                        <label for="photo" class="col-lg-2 control-label">Caption</label>
                                        <div class="col-lg-10">
                                            <input type="text" id="u_caption" name="caption" value="" maxlength="100" class="form-control" />
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<input type="hidden" id="u_idgallery" value="" name="idnewsgallery">
											<input type="hidden" id="u_idnews" value="" name="idnews">
											<input type="hidden" id="pilihan" name="pilihan" value="photo">
											<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- form update gallery video-->
				<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editvideo" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
								<h4 class="modal-title">Edit Video</h4>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_gallerynews' ?>">
									<div class="form-group">
										<label for="photo" class="col-lg-2 control-label">Video</label>
										<div class="col-lg-10">
											<input type="file" id="video" name="video" class="form-control" accept="video/*" />
											<label>Max file size: 5 MB</label><br>
											<input type="checkbox" name="empty_video" <?php echo ($data_detail->detail[0]->type=="3")?'checked':'' ?> id="empty_video"><label> URL link video</label>
										</div>
									</div>
									<div class="form-group" id="input_url_video">
										<label for="photo" class="col-lg-2 control-label">URL Video</label>
										<div class="col-lg-10">
											<input type="text" id="uv_link" name="url_video" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<input type="hidden" id="uv_idgallery" value="" name="idnewsgallery">
											<input type="hidden" id="uv_idnews" value="" name="idnews">
											<input type="hidden" id="pilihan" name="pilihan" value="video" >
											<input type="hidden" name="photo1" id="uv_setavatar" value="">
											<button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
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

<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#u_avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function fileChanged(element) {
        readURL(element);
    };

	$('#labeltags').tagsinput({
		confirmKeys: [13, 44],
		maxTags: 10,
		typeahead: {
		afterSelect: function(val) { this.$element.val(""); },
		source: function (query) {
			var result = [];
			$.ajax({
				url: "<?php echo base_api(); ?>News/?action=listnewstag&newstag="+query,
				type: "get",
				dataType: "json",
				async: false,
				success: function(data) {
					data.forEach(function(item){
					result.push(item.newstag)
					})
				} 
			});
			return result;        
		}
		}
	});

	
</script>