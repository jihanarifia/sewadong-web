      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content">

          <section class="wrapper">
            <div class="row">
              <div class="col-lg-12">
                <h3> <?=$title?> Tenant</h3>
                <section class="panel">
                  <header class="panel-heading">
                    <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus_alt2"></i>  Add</a>
                  </header>                  
                  <?php if($this->session->flashdata('succmessage')) { ?> 
                    <div class="alert alert-success fade in">
                      <?php echo $this->session->flashdata('succmessage'); ?>
                    </div> 
                    <?php } ?>
                    <?php if($this->session->flashdata('errmessage')) { ?> 
                      <div class="alert alert-block alert-danger fade in">
                        <?php echo $this->session->flashdata('errmessage'); ?>
                      </div> 
                      <?php } ?>
                      <div class="table-responsive">
                        <table id="data-table" data-plugin="DataTable" class="table table-striped table-responsive" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th><i class="icon_star"></i>Rating</th>
                              <th><i class="icon_profile"></i>Name</th>
                              <th><i class="icon_phone"></i>Phone</th>
                              <th><i class="icon_pin_alt"></i>Address</th>
                              <th><i class=""></i>Day</th>
                              <th><i class=""></i>Open</th>
                              <th><i class=""></i>Close</th>
                              <th><i class=""></i>Sub Category</th>
                              <th><i class="icon_cogs"></i> Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i=0; foreach($data_con as $data_con[]) { ?>  
                              <tr>
                                <td><?=$data_con[$i]['rating']?></td>
                                <td><?=$data_con[$i]['name']?></td>
                                <td><?=$data_con[$i]['phone']?></td>
                                <td><?=$data_con[$i]['address']?></td>
                                <td><?=$data_con[$i]['open']?></td>
                                <td><?=$data_con[$i]['openHour']?></td>
                                <td><?=$data_con[$i]['closeHour']?></td>
                                <td><?=$data_con[$i]['subcategory']?></td>
                                <td>
                                  <div class="btn-group">
                                    <a class="btn btn-success" href="#"><i class="icon_pencil" data-link="<?=base_url().'admin/edit_tenant?id='.$data_con[$i]['idTenant']?>"></i></a>
                                    <a data-toggle="modal" class="open-delete btn btn-danger" href="#deleteform" data-link="<?=base_url().'admin/delete_tenant?id='.$data_con[$i]['idTenant']?>"><i class="icon_trash_alt"></i></a>
                                  </div>
                                </td>
                              </tr>                         
                              <?php $i++;}  ?>
                            </tbody>
                          </table>
                        </div>
                      </section>
                    </div>
                  </div>

                  <!-- modal delete -->
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Delete Tenant <?=$title?></h4>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure delete this point?</p>                          
                          <a id="accept_delete" href="#" class="btn btn-danger">Sure</a>
                          <a href="#" class="btn btn-info" data-dismiss="modal">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal insert -->
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Insert Tenant <?=$title?></h4>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" role="form">
                            <div class="form-group">
                              <label for="exampleInputFile" class="col-lg-2 control-label">Avatar</label>
                              <div class="col-lg-10">
                                <input type="file" class="" id="exampleInputFile">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="fullname" class="control-label col-lg-2">Name <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="Name" name="name" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="fullname" class="control-label col-lg-2">Phone <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="fullname" name="fullname" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Address <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="address" name="address" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Day<span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="address" name="address" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Open <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="address" name="address" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Close <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="address" name="address" type="text">
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Special offer <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="address" name="address" type="text">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="fullname" class="control-label col-lg-2">Sub category <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <select class="form-control m-bot15" id="subcategory">
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info">Simpan</button>
                              </div>
                            </div>
                          </form>

                        </div>

                      </div>
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
