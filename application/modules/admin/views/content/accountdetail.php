<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/account'?>"> Account</a></li>
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
                <div class="panel-body">
                  <form role="form" action="<?=base_url().'admin/update_account'?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="name">Fullname</label>
                          <input type="text" required class="form-control" id="name" name="fullname" placeholder="Fullname" autofocus value="<?=$data_detail->account[0]->fullname ?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Gender</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="gender" id="gender" value="M" <?php echo ($data_detail->account[0]->gender == 'M')?'checked':'' ?> >
                              Male
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="gender" id="gender" value="F" <?php echo ($data_detail->account[0]->gender == 'F')?'checked':'' ?> >
                              Female
                            </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="name">Phone</label>
                          <input type="tel" name="phone" class="form-control" maxlength="15" placeholder="Phone" value="<?=$data_detail->account[0]->phone ?>">
                        </div>
                        <div class="form-group">
                          <label for="image">Avatar</label>
                          <input type="file" name="image" id="image" class="form-control" accept="image/*"  />
                          <input type="checkbox" name="empty_avatar" <?php if($data_detail->account[0]->avatar==null) echo "checked"; ?>><label> Empty avatar</label><br>
                          <label>Max: 800 X 800 | Min: 150 X 150<br>Max file size: 2 MB</label>
                        </div>
                        <?php if($data_detail->account[0]->avatar!=null) { ?>
                          <div class="col-lg-8" style="height:200px;width:200px;overflow:hidden;display:flex;justify-content:center;align-items:center">
                            <img class="image-responsive" src="<?= $data_detail->account[0]->avatar ?>" style="height:100%;">
                          </div>
                          <?php } ?>
                          <input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?= $data_detail->account[0]->avatar ?>">
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="subcategory">Privilege</label>
                            <select class="form-control m-bot15" name="privilege" disabled>
                              <option value="resident" <?php echo ($data_detail->account[0]->privilege == 'resident')?'selected':'' ?>>Resident</option>
                              <option value="visitor" <?php echo ($data_detail->account[0]->privilege == 'visitor')?'selected':'' ?>>Visitor</option>
                              <option value="administrator" <?php echo ($data_detail->account[0]->privilege == 'administrator')?'selected':'' ?>>Administrator</option>
                            </select>
                            <input type="hidden" name="privilege" value="<?=$data_detail->account[0]->privilege?>">
                          </div>
                          <div class="form-group">
                            <label for="address">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Email" value="<?=$data_detail->account[0]->email ?>">
                          </div>
                          <?php
                          if(($data_detail->account[0]->privilege == 'resident'))
                          {
                            ?>
                            <div class="form-group">
                              <label for="close">Date of Birth</label>
                              <input type="date" class="form-control" id="dateofbirth" name="dateofbirth" value="<?=$dateofbirth?>" >
                            </div>
                            <?php } ?>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="name">Address</label>
                              <input type="text" class="form-control" id="address" name="address" value="<?=$data_detail->account[0]->address ?>">
                            </div>
                            <div class="form-group">
                              <label for="name">Create Date</label>
                              <input type="date" readonly class="form-control" id="createdate" name="createdate" value="<?=$createdate ?>">
                            </div>
                            <?php
                            if(($data_detail->account[0]->privilege == 'resident'))
                            {
                              ?>
                              <div class="form-group">
                                <label for="name">PsCode</label>
                                <input type="text" class="form-control" id="name" name="pscode" placeholder="PsCode" value="<?=$data_detail->account[0]->pscode ?>" >
                              </div>
                              <?php } ?>
                            </div>
                            <div class="row">
                              <div class="container">
                                <div class="col-lg-12 ">
                                  <input type="hidden" class="form-control" name="idaccount" value="<?=$data_detail->account[0]->idaccount?>">
                                  <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                </div>
                              </div>
                            </div>
                          </form>

                        </div>
                      </section>
                      <section class="panel">
                        <!-- form delete history -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletehistory" class="modal fade">
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
                        <!-- form delete bookmark -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletebookmark" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Delete Bookmark</h4>
                              </div>
                              <div class="modal-body">
                                <p>Are you sure delete this point?</p>                          
                                <form method="post" action="<?=base_url().'admin/delete_bookmark'?>">
                                  <input type="hidden" name="id" id="delid" value="">
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
                                    <div class="col-lg-12">
                                      <div class="form-group">
                                        <label for="name">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Title" required>
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
                                  <input type="hidden" class="form-control" name="idaccount" value="<?=$data_detail->account[0]->idaccount?>">
                                  <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>

                      <!-- sukses update -->
                      <div class="row">
                        <div class="col-lg-6">
                          <section class="panel">
                            <header class="panel-heading">
                              <h3>History</h3>
                            </header>
                            <div class="table-responsive">
                              <table class="table table-striped table-advance table-hover" id="data-table">
                                <thead>
                                 <tr>
                                   <th><i class="icon_document_alt"></i> Activities</th>
                                   <th><i class="icon_calendar"></i> Date</th>
                                   <th><i class="icon_tools"></i> Action</th>
                                 </tr>
                               </thead>
                               <tbody>

                                <?php if (isset($data_detail->history)) {
                                  foreach ($data_detail->history as $item_history) {
                                    ?>
                                    <tr>
                                      <td><?= $item_history->activities ?></td>
                                      <td><?= $item_history->visitdate ?></td>
                                      <td>
                                        <div class="btn-group">
                                          <a data-toggle="modal" class="deletehistory btn btn-danger" href="#deletehistory"  data-id="<?= $item_history->idhistory?>"><i class="icon_trash_alt"></i></a>
                                        </div>
                                      </td>
                                    </tr>                         
                                    <?php }
                                  } else { ?>
                                    <tr><td colspan="6">No result found</td></tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </section> 
                            <!-- end panel history -->
                          </div>
                          <!-- bookmark -->
                          <div class="col-lg-6">
                            <section class="panel">
                              <header class="panel-heading">
                                <h3>Bookmark</h3>
                              </header>
                              <div class="table-responsive">
                                <table class="table table-striped table-advance table-hover" id="data-table2">
                                  <thead>
                                   <tr>
                                     <th><i class="icon_building"></i> Name Tenant</th>
                                     <th><i class="icon_tools"></i> Action</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <?php if(!isset($data_bookmark[0]->status)) {

                                    foreach ($data_bookmark as $item) {  
                                      ?>
                                      <tr>
                                        <td><?=$item->tenantname?></td>
                                        <td>
                                          <div class="btn-group">
                                           <a data-toggle="modal" class="delbook btn btn-danger" href="#deletebookmark"  data-id="<?=$item->idbookmark?>"><i class="icon_trash_alt"></i></a>
                                         </div>
                                       </td>
                                     </tr>                         
                                     <?php }
                                   } else { ?>
                                    <tr><td colspan="6">No result found</td></tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </section> 
                            <!-- end panel history -->
                          </div>
                        </div>
                      </section>
                    </section>
                  </section>