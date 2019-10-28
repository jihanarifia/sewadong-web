      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content"> 
          <section class="wrapper">          
            <div class="row">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                  <li class="active"><?=$title?></a></li>
                </ul>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">
                <h3> <?=$title?> </h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-md-8">
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                      </div>
                    </header>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Insert <?=$title?></h4>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" action="<?=base_url().'admin/insert_cctv'?>">
                              <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label for="label">Label</label>
                                    <input type="text" class="form-control" id="label" name="label" placeholder="Label" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="ipaddress">IP Address</label>
                                    <input type="text" id="ipaddress" class="form-control" name="ipaddress" placeholder="IP Address" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="port">Port</label>
                                    <input type="number" class="form-control" id="port" name="port" placeholder="Port">
                                  </div>
                                  <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control" name="username" placeholder="Username">
                                  </div>
                                  <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                    <label for="channel">Channel</label>
                                    <input type="text" id="channel" class="form-control" name="channel" placeholder="Channel">
                                  </div>
                                  <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2"></div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateform" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update <?=$title?></h4>
                          </div>
                          <div class="modal-body">                       
                            <form class="form-horizontal" role="form" method="post" action="<?=base_url().'admin/update_cctv'?>">
                              <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label for="u_label">Label</label>
                                    <input type="text" class="form-control" id="u_label" name="label" placeholder="Label" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="u_ipaddress">IP Address</label>
                                    <input type="text" id="u_ipaddress" class="form-control" name="ipaddress" placeholder="IP Address" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="u_port">Port</label>
                                    <input type="number" class="form-control" id="u_port" name="port" placeholder="Port">
                                  </div>
                                  <div class="form-group">
                                    <label for="u_username">Username</label>
                                    <input type="text" id="u_username" class="form-control" name="username" placeholder="Username">
                                  </div>
                                  <div class="form-group">
                                    <label for="u_password">Password</label>
                                    <input type="password" class="form-control" id="u_password" name="password" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                    <label for="u_channel">Channel</label>
                                    <input type="text" id="u_channel" class="form-control" name="channel" placeholder="Channel">
                                  </div>

                                  <div class="row ">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                      <input type="hidden" name="idcctv" id="u_idcctv" value="">
                                      <input type="hidden" name="idcity" id="u_idcity" value="">
                                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2"></div>
                              </div>
                            </form>                          
                          </div>
                        </div>
                      </div>
                    </div>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete <?=$title?></h4>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure delete this point?</p>                          
                            <form method="post" action="<?=base_url().'admin/delete_cctv'?>">
                              <input type="hidden" name="idcctv" id="del_id" value="">
                              <button type="submit" class="btn btn-danger">Sure</button>
                              <button class="btn btn-info" data-dismiss="modal">Cancel</button>
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
                      <table class="table table-hover" id="data-table">
                        <thead>
                          <tr>
                            <th><i class="icon_tag_alt"></i> Label</th>
                            <th><i class="icon_link"></i> IP Address</th>
                            <th><i class="icon_drive"></i> Port</th>
                            <th><i class="icon_cogs"></i> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                          <tr>
                            <td><?=$data_con[$i]['label']?></td>
                            <td><?=$data_con[$i]['ipaddress']?></td>
                            <td><?=$data_con[$i]['port']?></td>
                            <td>
                              <div class="btn-group">
                                <a data-toggle="modal" class="btn btn-success update-cctv" href="#updateform" data-id="<?=$data_con[$i]['idcctv']?>" data-label="<?=$data_con[$i]['label']?>" data-ipaddress="<?=$data_con[$i]['ipaddress']?>" data-port="<?=$data_con[$i]['port']?>" data-username="<?=$data_con[$i]['username']?>" data-password="<?=$data_con[$i]['password']?>" data-channel="<?=$data_con[$i]['channel']?>" data-idcity="<?=$data_con[$i]['idcity']?>" ><i class="icon_pencil" ></i></a>
                                <a data-toggle="modal" class="delete-phone btn btn-danger" href="#deleteform"  data-id="<?=$data_con[$i]['idcctv']?>"><i class="icon_trash_alt"></i></a>
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

                <div class="col-md-6">
                <h3> <?=$title?> RTSP for iOS </h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-md-8">
                        <a href="#insertformrtsp" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                      </div>
                    </header>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertformrtsp" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Insert <?=$title?> RTSP for iOS</h4>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" action="<?=base_url().'admin/insert_rtsp'?>">
                              <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label for="labelrtsp">Label</label>
                                    <input type="text" class="form-control" id="labelrtsp" name="label" placeholder="Label" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" id="link" class="form-control" name="link" placeholder="Link" required>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2"></div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateformrtsp" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update <?=$title?> RTSP for iOS</h4>
                          </div>
                          <div class="modal-body">                       
                            <form class="form-horizontal" role="form" method="post" action="<?=base_url().'admin/update_rtsp'?>">
                              <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                  <div class="form-group">
                                    <label for="u_labelrtsp">Label</label>
                                    <input type="text" class="form-control" id="u_labelrtsp" name="label" placeholder="Label" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="u_link">Link</label>
                                    <input type="text" id="u_link" class="form-control" name="link" placeholder="Link" required>
                                  </div>

                                  <div class="row ">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                      <input type="hidden" name="idcctv" id="u_idcctvrtsp" value="">
                                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2"></div>
                              </div>
                            </form>                          
                          </div>
                        </div>
                      </div>
                    </div>
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteformrtsp" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete <?=$title?> RTSP for iOS</h4>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure delete this CCTV?</p>                          
                            <form method="post" action="<?=base_url().'admin/delete_rtsp'?>">
                              <input type="hidden" name="idcctv" id="del_idrtsp" value="">
                              <button type="submit" class="btn btn-danger">Sure</button>
                              <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- sukses update -->
                    <?php if($this->session->flashdata('message_rtsp')) { ?> 
                    <div class="alert alert-success fade in" id="alertrtsp">
                      <?php echo $this->session->flashdata('message_rtsp'); ?>
                    </div> 
                    <?php } ?>
                    <?php if($this->session->flashdata('breakmessage_rtsp')) { ?> 
                    <div class="alert alert-block alert-danger fade in" id="alertrtsp">
                      <?php echo $this->session->flashdata('breakmessage_rtsp'); ?>
                    </div> 
                    <?php } ?>

                    <div class="table-responsive">
                      <table class="table table-hover" id="data-tablertsp">
                        <thead>
                          <tr>
                            <th style="width:220px"><i class="icon_tag_alt"></i> Label</th>
                            <th style="width:140px"><i class="icon_link"></i> Link</th>
                            <th><i class="icon_cogs"></i> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($data_conrtsp)!=false && empty($data_conrtsp)==false) { $i=0; foreach($data_conrtsp as $data_conrtsp[]) { ?>  
                          <tr>
                            <td><?=$data_conrtsp[$i]['label']?></td>
                            <td><?=$data_conrtsp[$i]['link']?></td>
                            <td>
                              <div class="btn-group">
                                <a data-toggle="modal" class="btn btn-success update-cctvrtsp" href="#updateformrtsp" data-id="<?=$data_conrtsp[$i]['idcctv']?>" data-label="<?=$data_conrtsp[$i]['label']?>" data-link="<?=$data_conrtsp[$i]['link']?>"><i class="icon_pencil" ></i></a>
                                <a data-toggle="modal" class="delete-rtsp btn btn-danger" href="#deleteformrtsp"  data-id="<?=$data_conrtsp[$i]['idcctv']?>"><i class="icon_trash_alt"></i></a>
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

              </div>
            </div>
          </div>
        </div> 
      </div>  
    </div>         


  </section>
</section>
<!--main content end-->
</section>
    <!-- container section end -->