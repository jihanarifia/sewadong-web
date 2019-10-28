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
                  <li class="active">Account</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Account</h3>
                <section class="panel">
                  <header class="panel-heading">
                   <div class="row">
                    <div class="col-lg-8">
                      <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                    </div>
                  </div>
                </header>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Delete Account</h4>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure delete this point?</p>                          
                        <form method="post" action="<?=base_url().'admin/delete_account'?>">
                          <input type="hidden" name="id" id="del_id" value="">
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
                        <h4 class="modal-title">Insert Account</h4>
                      </div>
                      <div class="modal-body">
                        <form role="form" action="<?=base_url().'admin/insert_account'?>" method="post" enctype="multipart/form-data" >
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label for="name">Fullname</label>
                                <input type="text" class="form-control" id="name" name="fullname" placeholder="Fullname" autofocus required>
                              </div>
                              <div class="form-group">
                                <label for="subcategory">Privilege</label>
                                <select class="form-control m-bot15" onchange="myFunction()" name="privilege" id="mySelect" >
                                  <option value="resident">Resident</option>
                                  <option value="visitor">Visitor</option>
                                  <option value="administrator">Administrator</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="phone">Gender</label>
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="gender" id="gender" value="M" required>
                                    Male
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="gender" id="gender" value="F" required>
                                    Female
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="close">Date of Birth</label>
                                <input type="date" class="form-control" id="Date of Birth" name="dateofbirth" placeholder="Date of Birth" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="tel" name="phone" class="form-control" min="0" maxlength="15" placeholder="Phone" required>
                              </div>
                              <div class="form-group">
                                <label for="address">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                              </div>
                              <div class="form-group">
                                <label for="day">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                              </div>
                              <div class="form-group">
                                <label for="name">PsCode</label>
                                <input type="text" class="form-control" id="name" name="pscode" placeholder="PsCode" autofocus>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary" id="validate_submit"><i class="icon_floppy"></i>&nbsp;Save</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- salert sukses CRUD -->
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
                          <th><i class="icon_id"></i> Email</th>
                          <th><i class="icon_profile"></i> Privilege</th>
                          <th><i class="icon_calendar"></i> Created at</th>
                          <th><i class="icon_tools"></i> Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                         <tr>
                          <td><?=$data_con[$i]['email']?></td>
                          <td><?=$data_con[$i]['privilege']?></td>
                          <td><?=$data_con[$i]['createdate']?></td>
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-success" href="<?=base_url().'admin/accountdetail?id='.$data_con[$i]['idaccount']?>"><i class="icon_pencil" ></i></a>
                              <!-- <a data-toggle="modal" class="open-delete btn btn-danger" href="#deleteform" data-id="<?=$data_con[$i]['idaccount']?>"><i class="icon_trash_alt"></i></a> -->
                            </div>
                          </td>
                        </tr>  
                        <?php $i++;} } else { ?>
                          <tr><td colspan="5">No result found</td></tr>
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
