      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
            <div class="row">
              <div class="col-lg-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                  <li><a href="#"><i class="icon_house_alt"></i> Home</a></li>
                  <li>Account</a></li>
                  <li class="active">History</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> History</h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i>&nbsp;Add</a>
                      </div>
                    </div>
                  </header>
                  <!-- form delete history -->
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Delete History</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure delete this point?</p>                          
                          <form method="post" action="<?=base_url().'admin/delete_history'?>">
                            <input type="hidden" name="id" id="del_id" value="">
                            <button type="submit" class="btn btn-danger">Sure</button>
                            <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                          </form>                            
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- form insert history -->
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Insert History</h4>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="<?=base_url().'admin/insert_history'?>" method="post" enctype="multipart/form-data" id="formacc">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="name">Title</label>
                                  <input type="text" name="title" class="form-control" placeholder="Title" required>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="subcategory">Account</label>
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
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea name="title" class="form-control" rows="3" placeholder="Description" required></textarea>
                                  </div>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- form update history -->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatehistory" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update History</h4>
                          </div>
                          <div class="modal-body">
                            <form role="form" action="<?=base_url().'admin/update_history'?>" method="post" enctype="multipart/form-data" id="formacc">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" id="utitle" name="title" class="form-control" placeholder="Title" required>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="subcategory">Account</label>
                                    <select class="form-control m-bot15" id="uidaccount" name="idaccount" >
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
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <label for="name">Description</label>
                                      <textarea name="description" id="udescription" class="form-control" rows="3" placeholder="Description" required></textarea>
                                    </div>
                                  </div>
                                </div>
                                <input type="hidden" id="uidhistory" name="idhistory">
                                <input type="hidden" id="ucreatedate" name="createdate">
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
                                 <th><i class="icon_profile"></i> Account</th>
                                 <th><i class=" icon_quotations"></i> Title</th>
                                 <th><i class="icon_document_alt"></i> Description</th>
                                 <th><i class="icon_calendar"></i> Create Date</th>
                                 <th><i class="icon_clock_alt"></i> Last Update</th>
                                 <th><i class="icon_tools"></i> Action</th>
                               </tr>
                             </thead>
                             <tbody>
                               <tr>
                                 <td>Shynta Ayu</td>
                                 <td>Road</td>
                                 <td>the road continues to the next task</td>
                                 <td>27-07-2016 11:38 AM</td>
                                 <td>1 minutes ago</td>
                                 <td>
                                  <div class="btn-group">
                                    <a data-toggle="modal" class="btn btn-success update-history" data-id="1" data-idaccount="34" data-title="Road" data-desc="the road continues to the next task" data-createdate="27-07-2016 11:38 AM" href="#updatehistory"><i class="icon_pencil"></i></a>
                                    <a data-toggle="modal" class="delete-history btn btn-danger" href="#deleteform" data-id="1"><i class="icon_trash_alt"></i></a>
                                  </div>
                                </td>
                              </tr>  
                              <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                               <tr>
                                 <td><?=$data_con[$i]['name']?></td>
                                 <td><?=$data_con[$i]['type']?></td>
                                 <td><?=$data_con[$i]['lblt']?></td>
                                 <td><?=$data_con[$i]['price']?></td>
                                 <td><?=$data_con[$i]['categoryname']?></td>
                                 <td>
                                  <div class="btn-group">
                                    <a data-toggle="modal" class="btn btn-success update-history" data-id="1" data-idaccount="34" data-title="Road" data-desc="the road continues to the next task" data-createdate="27-07-2016 11:38 AM" href="#updatehistory"><i class="icon_pencil"></i></a>
                                    <a data-toggle="modal" class="delete-history btn btn-danger" href="#deleteform" data-id="1"><i class="icon_trash_alt"></i></a>
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
