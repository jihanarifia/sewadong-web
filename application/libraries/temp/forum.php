      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
            <div class="row">
              <div class="col-lg-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                  <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                  <li class="active">Forum</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Forum</h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i>&nbsp;Add</a>
                      </div>
                    </div>
                  </header>
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteforum" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Delete Forum</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure delete this point?</p>                          
                          <form method="post" action="<?=base_url().'admin/delete_forum'?>">
                            <input type="hidden" name="idforums" id="del_id" value="">
                            <button type="submit" class="btn btn-danger">Sure</button>
                            <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                          </form>                            
                        </div>
                      </div>
                    </div>
                  </div>
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Insert Forum</h4>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="<?=base_url().'admin/foruminsert'?>" method="post" enctype="multipart/form-data" id="formacc">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="name">Title</label>
                                  <input type="text" class="form-control" id="title" name="title" placeholder="Title" autofocus required>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="subcategory">Author</label>
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
                              </div>
                              <div class="row">
                                <div class="col-lg-12" >
                                  <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea class="form-control" name="description" id="caption" rows="5"></textarea>
                                  </div> 
                                </div>
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="name">Attach image</label>
                                    <input type="file" required class="form-control" accept=".png,.jpg,.jpeg,.gif" name="userfile" multiple/>
                                  </div>
                                </div>
                              </div>
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
                           <th><i class=" icon_quotations"></i> Title</th>
                           <th><i class=" icon_profile"></i> Author</th>
                           <th><i class="icon_calendar"></i> Date Post</th>
                           <th><i class="icon_profile"></i> Viewer</th>
                           <th><i class="icon_tag"></i> Status</th>
                           <th><i class="icon_comment_alt"></i> Comment</th>
                           <th><i class="icon_profile"></i> Approved By</th>
                           <th><i class="icon_calendar"></i> Approved Date</th>   
                           <th><i class="icon_tools"></i> Action</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                         <tr>
                           <td><?=$data_con[$i]['title']?></td>
                           <td><?=$data_con[$i]['fullname']?></td>
                           <td><?=$data_con[$i]['createdate']?></td>
                           <td><?=$data_con[$i]['viewer']?></td> 
                           <td><?php
                              if($data_con[$i]['typeforum'] == 1){
                                echo "Waiting for Approval";
                              } else if ($data_con[$i]['typeforum'] == 2) {
                                echo "Approved";
                              } else if ($data_con[$i]['typeforum'] == 3){
                                echo "Rejected";
                              } else {
                                echo "Undefined";
                              }
                              ?></td>
                           <td><?=$data_con[$i]['comment']?></td>
                           <td><?=$data_con[$i]['approvedby']?></td>
                           <td><?=$data_con[$i]['approveddate']?></td>                           
                           <td>
                            <div class="btn-group">
                              <a class="btn btn-success" href="<?=base_url().'admin/forumdetail?id='.$data_con[$i]['idforums']?>" data><i class="icon_pencil" ></i></a>
                              <a data-toggle="modal" class="open-delete btn btn-danger" href="#deleteforum" data-id="<?=$data_con[$i]['idforums']?>"><i class="icon_trash_alt"></i></a>
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
            <!-- page end-->
          </section>
        </section>
      </section>
      <!--main content end-->
    </section>
    <!-- container section end -->
  </body>
  </html>
