      <!-- container section start -->
      <section id="container" class="">
            <!--main content start-->
            <section id="main-content"> 
                  <section class="wrapper">          
                        <div class="row">
                              <div class="col-lg-12">
                                    <ul class="breadcrumb">
                                          <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                                          <li class="active"><?=$title?></a></li>
                                    </ul>
                              </div>
                        </div>

                        <div class="row">
                              <div class="col-lg-12">
                                   <h3> <?=$title?> </h3>
                                   <section class="panel">
                                    <header class="panel-heading">
                                          <div class="row">
                                                <div class="col-lg-8">
                                                      <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                                                </div>
                                          </header>

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
                                                                  <th><i class="icon_building"></i> Title</th>
                                                                  <th><i class="icon_phone"></i> Decription</th>
                                                                  <th><i class="icon_cogs"></i> Action</th>

                                                            </tr>
                                                      </thead>
                                                      <tbody>
                                                            <?php if(isset($data_notif)!=false && empty($data_notif)==false) { $i=0; foreach($data_notif as $data_notif[]) { ?>  
                                                            <tr>
                                                                  <td><?=$data_notif[$i]['title']?></td>
                                                                  <td><?=$data_notif[$i]['description']?></td>
                                                                  <td>
                                                                        <div class="btn-group">
                                                                              <a data-toggle="modal" class="btn btn-info update-notif" href="<?=base_url().'admin/notificationdetail?id='.$data_notif[$i]['idnotif']?>"><i class="icon_info" ></i></a>
                                                                              <a data-toggle="modal" class="delete-notif btn btn-danger" href="#deleteform"  data-id="<?=$data_notif[$i]['idnotif']?>" data-avatar="<?=$data_notif[$i]['avatar']?>" ><i class="icon_trash_alt"></i></a>
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

                  </section>
            </section>
      </section>


      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
            <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                              <button aria-hidden="true" data-dismiss="modal" class="close" type="button" id="close_modal">×</button>
                              <h4 class="modal-title">Push <?=$title?></h4>
                        </div>
                        <div class="modal-body">
                              <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_notif'?>">
                                    <div class="row">
                                          <div class="col-lg-2"></div>
                                          <div class="col-lg-8">
                                                <div class="form-group">
                                                      <label for="title">Title</label>
                                                      <input type="text" class="form-control" id="title" name="title" placeholder="title" required>
                                                </div>
                                                <div class="form-group">
                                                      <label for="description">Description</label>
                                                      <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                                                </div>
                                                <div class="form-group">
                                                      <label for="title_en">Title(English)</label>
                                                      <input type="text" class="form-control" id="title_en" name="title_en" placeholder="Title(English)" required>
                                                </div>
                                                <div class="form-group">
                                                      <label for="description_en">Description(English)</label>
                                                      <input type="text" class="form-control" id="description_en" name="description_en" placeholder="Description(English)" required>
                                                </div>
                                                <div class="form-group">
                                                      <label for="photo">Photo</label>
                                                      <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required/>
                                                      <label>Max: 800 X 800 | Min: 165 X 114 | Max file size: 2 MB</label><br>
                                                </div>

                                                <div class="form-group">
                                                      <label>Account</label>
                                                      <select name="privilige" id="privilege" class="form-control" required>
                                                            <option value="">Select Privilege</option>
                                                            <option value="all">All</option>
                                                            <option value="resident">Resident</option>
                                                            <option value="visitor">Visitor</option>                                                                                                                        
                                                      </select>                                          
                                                </div>

                                                <div class="form-group" id="resident_dd">
                                                      <label>Resident</label>
                                                            <select name="accountres[]" multiple id="accountres" class="form-control">
                                                            <?php
                                                            foreach ($account_resident as $item) {
                                                                  ?>
                                                                  <option value="<?php echo $item->idaccount?>">
                                                                        <?php echo $item->fullname?>
                                                                  </option>   
                                                                  <?php } ?>
                                                            </select>                              
                                                </div>

                                                <div class="form-group" id="visitor_dd">
                                                      <label>Visitor</label>
                                                            <select name="accountvis[]" multiple id="accountvis" class="form-control">
                                                            <?php
                                                            foreach ($account_visitor as $item_visitor) {
                                                                  ?>
                                                                  <option value="<?php echo $item_visitor->idaccount?>">
                                                                        <?php echo $item_visitor->fullname?>
                                                                  </option>   
                                                                  <?php } ?>
                                                            </select>                              
                                                </div>

                                                <div class="form-group" id="all_dd">
                                                      <label>All Account</label>
                                                            <select name="accountall[]" multiple id="accountall" class="form-control">
                                                            <?php
                                                            foreach ($account as $item) {
                                                                  ?>
                                                                  <option value="<?php echo $item->idaccount?>">
                                                                        <?php echo $item->fullname?>
                                                                  </option>   
                                                                  <?php } ?>
                                                            </select>                              
                                                </div>

                                                <div class="row ">
                                                      <div class="col-lg-10"></div>
                                                      <div class="col-lg-2">
                                                            <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-lg-2"></div>
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
                                    <form method="post" action="<?=base_url().'admin/delete_notif'?>">
                                          <input type="hidden" name="idnotif" id="del_id" value="">
                                          <input type="hidden" name="avatar" id="del_avatar" value="">
                                          <button type="submit" class="btn btn-danger">Sure</button>
                                          <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                                    </form>                            
                              </div>
                        </div>
                  </div>
            </div>


            <script type="text/javascript">
                  $(document).ready(function(){
                        $('.form-group')
                        .find('[name="idtenant"]')
                        .combobox()
                        .end()
                  });

      //delete notif
      $(".delete-notif").click(function(){       
            var idnotif = $(this).attr("data-id"); 
            var avatar = $(this).attr("data-avatar");
            $("#del_id").prop("value", idnotif);
            $("#del_avatar").prop("value", avatar);
      });
</script>
