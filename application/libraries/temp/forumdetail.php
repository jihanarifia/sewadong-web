<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/forum'?>">Forum</a></li>
            <li class="active"><?=$title?></li>
          </ul>
          <!--breadcrumbs end -->
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
          <section class="panel">
            <header class="panel-heading">
              Form Edit
            </header>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Delete Forum</h4>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure delete this point?</p>                          
                    <form method="post" action="<?=base_url().'admin/delete_tenant'?>">
                      <input type="hidden" name="id" id="del_id" value="">
                      <button type="submit" class="btn btn-danger">Sure</button>
                      <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </form>                            
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <form role="form" action="<?=base_url().'admin/update_forum'?>" method="post" enctype="multipart/form-data" id="formacc">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?=$data_detail->detail[0]->title?>" autofocus required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="subcategory">Author</label>
                      <select disabled class="form-control m-bot15" name="idaccount">
                        <?php
                        foreach ($account as $item) {
                          ?>
                          <option <?= $idaccount == $item->idaccount ? "selected" : "" ?> value="<?php echo $item->idaccount ?>">
                            <?php echo $item->fullname ?>
                          </option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="subcategory">Status <?php echo $typeforum ?></label>
                     <select class="form-control m-bot15" name="typeforum">            
                      <option <?= $typeforum == 1 ? "selected" : ""?> value="1">Waiting for Approval</option>
                      <option  <?= $typeforum == 2 ? "selected" : ""?> value="2">Approved</option>
                      <option  <?= $typeforum == 3 ? "selected" : ""?> value="3">Rejected</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="app_by" name="app_by" placeholder="Approved By" value="<?=$this->session->userdata('sc_sess')[0]['username']?>" autofocus required>
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-lg-12" >
                      <div class="form-group">
                        <label for="name">Description</label>
                        <textarea class="form-control" name="description" id="caption" rows="5"><?=$data_detail->detail[0]->description?></textarea>
                      </div> 
                    </div>
                  </div>
                  <input type="hidden" name="viewer" value="<?=$data_detail->detail[0]->viewer?>">
                  <input type="hidden" name="idforums" value="<?=$data_detail->detail[0]->idforums?>">
                  <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                </form>
              </div>
            </section>
          </div>
        </div>

        <!-- another detail -->
        <div class="row">
          <div class="col-lg-6">
            <section class="panel">
              <header class="panel-heading ">
                <a href="#insertcomment" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Comments</a>
                <h3>Comments</h3>
              </header>
              <table class="table table-striped table-advance table-hover " id="data-table"> 
                <thead>
                  <tr>
                    <th><i class="icon_profile"></i> Commentator</th>
                    <th><i class="icon_calendar"></i> Date Time</th>
                    <th><i class="icon_document_alt"></i> Comment</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (isset($data_detail->comment[0])) {
                    foreach ($data_detail->comment as $item_detail) {
                      ?>  
                      <tr>
                        <td><?=$item_detail->fullname?></td>
                        <td><?=date("Y-m-d H:i A", strtotime($item_detail->createdate))?></td>
                        <td><?=$item_detail->comment?></td>
                        <td>
                          <div class="btn-group">
                            <a data-toggle="modal" class="btn btn-success update-comment" data-id="<?=$item_detail->idcomment?>" data-idforum="<?=$data_detail->detail[0]->idforums?>" data-idaccount="<?=$item_detail->idaccount?>" data-comment="<?=$item_detail->comment?>" href="#updatecomment" href="#updatecomment"><i class="icon_pencil"></i></a>
                            <a data-toggle="modal" class="delete-comment btn btn-danger" href="#deletecomment" data-id="<?=$item_detail->idcomment?>"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr>
                      <?php }
                    } else { ?>
                    <tr><td colspan="6">No result found</td></tr>
                    <?php } ?>
                  </tbody>
                </table>
              </section>
            </div>
            <div class="col-lg-6">
              <section class="panel">
                <header class="panel-heading ">
                  <a href="#insertphoto" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add photo</a>
                  <h3>Gallery Forum</h3>
                </header>
                <table class="table table-striped table-advance table-hover " id="data-table"> 
                  <thead>
                    <tr>
                      <th><i class="icon_profile"></i> Avatar</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($data_detail->galleryforums[0])) {
                      foreach ($data_detail->galleryforums as $item_detail) {
                        ?>  
                        <tr>
                          <td><img height="99px" width="99px" src="<?= $item_detail->avatar ?>"></td>
                          <td>
                            <div class="btn-group">
                              <a data-toggle="modal" class="btn btn-success update-galleryforums" data-id="<?=$item_detail->idgalleryforums?>" data-idforums="<?=$item_detail->idforums?>" data-avatar="<?=$item_detail->avatar?>" href="#updatephoto"><i class="icon_pencil"></i></a>
                              <a data-toggle="modal" class="delete-galleryforums btn btn-danger" href="#deletephoto" data-id="<?=$item_detail->idgalleryforums?>" data-avatar="<?=$item_detail->avatar?>"><i class="icon_trash_alt"></i></a>
                            </div>
                          </td>
                        </tr>
                        <?php }
                      } else { ?>
                      <tr><td colspan="6">No result found</td></tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </section>
              </div>
            </div> 
            <!-- form insert comment -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertcomment" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Add Comment</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url().'admin/insert_comment' ?>">
                      <div class="form-group">
                        <label for="subcategory" class="col-lg-2 control-label">Commentator</label>
                        <div class="col-lg-10">
                          <select class="form-control m-bot15" name="idaccount" >
                            <?php
                            foreach ($account as $item) {
                              ?>
                              <option value="<?php echo $item->idaccount?>">
                                <?php echo $item->fullname?>
                              </option>   
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-lg-2 control-label">Comment</label>
                          <div class="col-lg-10">
                            <textarea class="form-control" name="comment" id="caption" rows="2"></textarea>
                          </div>
                        </div>           
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="idforums" value="<?=$data_detail->detail[0]->idforums?>">
                            <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- form update comment -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatecomment" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Update Comment</h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url().'admin/update_comment' ?>">
                        <div class="form-group">
                          <label for="subcategory" class="col-lg-2 control-label">Commentator</label>
                          <div class="col-lg-10">
                            <select disabled class="form-control m-bot15" id="uidaccount" name="idaccount">
                              <?php
                              foreach ($account as $item) {
                                ?>
                                <option <?= $idaccount == $item->idaccount ? "selected" : "" ?> value="<?php echo $item->idaccount ?>">
                                  <?php echo $item->fullname ?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Comment</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" name="comment" id="ucomment" value="">
                              <!-- <textarea class="form-control" name="comment" id="ucomment" rows="2"></textarea> -->
                            </div>
                          </div>           
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <input type="hidden" name="idforums" id="uidforum" value="">
                              <input type="hidden" name="idcomment" id="uidcomment" value="">
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- form delete comment -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletecomment" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Delete Comment</h4>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure delete this point?</p>                          
                        <form method="post" action="<?= base_url() . 'admin/delete_comment' ?>">
                          <input type="hidden" name="idcomment" id="delidcomment" value="">
                          <button type="submit" class="btn btn-danger">Sure</button>
                          <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                        </form>                            
                      </div>
                    </div>
                  </div>
                </div>

                <!-- form insert photo -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertphoto" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add photo</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_galleryforums' ?>">
                          <div class="form-group">
                            <label for="photo" class="col-lg-2 control-label">Photo</label>
                            <div class="col-lg-10">
                              <input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
                            </div>
                          </div>      
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <input type="hidden" name="idforums" value="<?=$data_detail->detail[0]->idforums?>">
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- delete photo  -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletephoto" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Delete photo </h4>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure delete this point?</p>                          
                        <form method="post" action="<?= base_url() . 'admin/delete_galleryforums' ?>">
                          <input type="hidden" name="idgalleryforums" id="del_idgalleryforums" value="">
                          <input type="hidden" name="avatar" id="del_avatar" value="">
                          <button type="submit" class="btn btn-danger">Sure</button>
                          <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                        </form>                            
                      </div>
                    </div>
                  </div>
                </div>
                <!-- form update photo -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatephoto" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title"> Update Photo</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_galleryforums' ?>">
                          <div class="form-group">
                            <label for="photo" class="col-lg-2 control-label">Photo</label>
                            <div class="col-lg-10">
                              <input type="file" id="photo" name="photo" class="form-control" accept="image/*" /><br>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-2"></label>
                              <img class="col-lg-7 image-responsive"  src=""  id="u_avatar">
                              <input type="hidden" name="photo1" id="u_setavatar" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <input type="hidden" name="idgalleryforums" id="u_idgalleryforums" value="">
                              <input type="hidden" name="idforums" id="u_idforums" value="">
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
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
                       //update gallery  forums
                       $(".update-galleryforums").click(function(){       
                        var idgalleryforums = $(this).attr("data-id");
                        var idforums = $(this).attr("data-idforums");
                        var avatar = $(this).attr("data-avatar");
                        $("#u_idgalleryforums").prop("value", idgalleryforums);
                        $("#u_idforums").prop("value", idforums);
                        $("#u_avatar").prop("src", avatar);
                        $("#u_setavatar").prop("value", avatar);
                      });
                       //delete gallery forums
                       $(".delete-galleryforums").click(function(){       
                        var idgalleryforums = $(this).attr("data-id");
                        var avatar = $(this).attr("data-avatar");
                        $("#del_idgalleryforums").prop("value", idgalleryforums);
                        $("#del_avatar").prop("value", avatar);
                      });
                    </script>