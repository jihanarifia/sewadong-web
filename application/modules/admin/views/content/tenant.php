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
            <li class="active"><?=$title?></a></li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <h3> <?=$title?>  Tenant</h3>
          <section class="panel">
            <header class="panel-heading">
              <div class="row">
                <div class="col-lg-8">
                  <a href="<?=base_url().'admin/insert?id='.$idTCat.'&name='.$title?>" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                </div>
                <div class = "col-sm-4">
                  <div class="pull-right">
                    <div class="row">
                      <div class="col-lg-4">
                        <h5>Filter by</h5>
                      </div>
                      <div class="col-lg-8">
                        <div class="pull-right">
                          <select class="form-control m-bot15" id="filter" onChange="GetSelectedTextValue(this)" name="idcategory">
                            <option id="idcategory" value="">All</option>
                            <?php
                            foreach ($subcat as $item) {
                              ?>
                              <option <?=$this->input->get('subcat')==$item->idcategory ? "selected" : ""?> id="idcategory" value="<?php echo $item->idcategory?>">
                                <?php echo $item->categoryname?>
                              </option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </header>
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteformtenant" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Delete Tenant <?=$title?></h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure delete this point?</p>
                      <form method="post" action="<?=base_url().'admin/delete_tenant'?>">
                        <input type="hidden" name="logo" id="del_logo" value="">
                        <input type="hidden" name="avatar" id="del_avatar" value="">
                        <input type="hidden" name="id" id="del_id" value="">
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
              <?php } else if($this->session->flashdata('breakmessage')) { ?>
              <div class="alert alert-block alert-danger fade in" id="alert">
                <?php echo $this->session->flashdata('breakmessage'); ?>
              </div>
              <?php } ?>
              <div class="table-responsive">
                <table class="table table-hover" id="data-table">
                  <thead>
                    <tr>
                      <th><i class="icon_id"></i> Name</th>
                      <th><i class="icon_pin_alt"></i> Address</th>
                      <th><i class="icon_phone"></i> Phone</th>
                      <th><i class="icon_pin_alt"></i> LongLat</th>
                      <th><i class="icon_tag_alt"></i> Category</th>
                      <th><i class="icon_like"></i> Recommended</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </div>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_conten[]) { ?>
                  <tr>
                    <td><?=$data_conten[$i]['tenantsname']?></td>
                    <td><?=$data_conten[$i]['address']?></td>
                    <td><?=$data_conten[$i]['phone']?></td>
                    <td><?=$data_conten[$i]['longlat']?></td>
                    <td><?=$data_conten[$i]['categoryname']?></td>
                    <td>
                      <?php
                      if($data_conten[$i]['premium']=="1")echo "Yes";
                      else if($data_conten[$i]['premium']=="0")echo "No";
                      ?>
                    </td>
                    <td style="width:100px">
                      <div class="btn-group">
                        <a class="btn btn-success" href="<?=base_url().'admin/detail_edit_tenant?id='.$data_conten[$i]['idtenant'].'&cat='.$idTCat.'&name='.$title?>"><i class="icon_pencil" ></i></a>
                        <a data-toggle="modal" class="delete-tenant btn btn-danger" href="#deleteformtenant" data-avatar="<?=$data_conten[$i]['avatar']?>" data-id="<?=$data_conten[$i]['idtenant']?>" data-logo="<?=$data_conten[$i]['logo']?>"><i class="icon_trash_alt"></i></a>
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
    </div>
  </div>
</div>
</div>
</div>
<div class="row">
  <div class="col-lg-6">
    <h3> Notification <?=$title?> </h3>
    <section class="panel">
      <header class="panel-heading">
        <div class="row">
          <div class="col-lg-8">
            <a href="#insertformnotif" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
          </div>
        </header>
        <div class="table-responsive">
          <table class="table table-hover" id="data-table2">
            <thead>
              <tr>
                <th><i class="icon_building"></i> Title</th>
                <th><i class="icon_phone"></i> Decription</th>
                <th><i class="icon_building"></i> Tenant name</th>
                <th><i class="icon_cogs"></i> Action</th>

              </tr>
            </thead>
            <tbody>
              <?php if(isset($data_notif)!=false && empty($data_notif)==false) { $i=0; foreach($data_notif as $data_notif[]) { ?>
              <tr>
                <td><?=$data_notif[$i]['title']?></td>
                <td><?=$data_notif[$i]['description']?></td>
                <td><?=$data_notif[$i]['tenantsname']?></td>
                <td>
                  <div class="btn-group">
                    <a data-toggle="modal" class="btn btn-info update-notif" href="<?=base_url().'admin/notificationdetail?id='.$data_notif[$i]['idnotif'].'&cat='.$idTCat.'&name='.$title?>" ><i class="icon_info" ></i></a>
                    <a data-toggle="modal" class="delete-notif btn btn-danger" href="#deletenotifform"  data-id="<?=$data_notif[$i]['idnotif']?>"  data-avatar="<?=$data_notif[$i]['avatar']?>" ><i class="icon_trash_alt"></i></a>
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
    <div class="col-lg-6">
      <h3> Advertise <?=$title?> </h3>
      <section class="panel">
        <header class="panel-heading">
          <div class="row">
            <div class="col-lg-8">
              <a href="#insertadvertiseform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
            </div>
          </header>
          <div class="table-responsive">
            <table class="table table-hover" id="data-table2">
              <thead>
                <tr>
                  <th><i class="icon_building"></i> Tenant name</th>
                  <th><i class="icon_building"></i> Full Advertise</th>
                  <th><i class="icon_building"></i> Small Advertise</th>
                  <th><i class="icon_cogs"></i> Action</th>

                </tr>
              </thead>
              <tbody>
                <?php if(isset($data_advertise)!=false && empty($data_advertise)==false) { $i=0; foreach($data_advertise as $data_advertise[]) { ?>
                <tr>
                  <td>
                    <select class="form-control m-bot15" name="idcategory" disabled>
                      <?php
                      foreach ($tenant as $item) {
                        ?>
                        <option <?= $data_advertise[$i]['idtenant'] == $item->idtenant ? "selected" : "" ?> value="<?php echo $item->idtenant ?>">
                          <?php echo $item->tenantsname ?>
                        </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td style="width:150px;height:auto"><img class="col-lg-12 image-responsive" src="<?=$data_advertise[$i]['advertise']?>"></td>
                    <td style="width:150px;height:auto"><img class="col-lg-12 image-responsive" src="<?=$data_advertise[$i]['smalladvertise']?>"></td>
                    <td>
                      <div class="btn-group">
                        <a data-toggle="modal" class="btn btn-success update-advertise" href="<?=base_url().'admin/advertisedetail?id='.$data_advertise[$i]['idadvertise'].'&subcat='.$idTCat.'&name='.$title.'&type=tenant'?> " ><i class="icon_pencil"></i></a>
                        <a data-toggle="modal" class="delete-advertise btn btn-danger" href="#deleteadvertiseform"  data-id="<?=$data_advertise[$i]['idadvertise']?>"  data-advertise="<?=$data_advertise[$i]['advertise']?>" data-smalladvertise="<?=$data_advertise[$i]['smalladvertise']?>" ><i class="icon_trash_alt"></i></a>
                      </div>
                    </td>
                  </tr>
                  <?php $i++;} } else { ?>
                  <tr><td colspan="2">No result found</td></tr>
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


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertformnotif" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Push <?=$title?> Notification</h4>
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
                <input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
                <label>Max: 800 X 800 | Min: 165 X 114 | Max file size: 2 MB</label><br>
              </div>
              <div class="form-group">
                <label for="tenant" class="control-label">Tenant</label>
                <div class="selectContainer">
                  <select class="form-control" name="idtenant" required >
                    <option value="">Choose a tenant</option>
                    <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_conten[]) { ?>
                    <option value="<?=$data_conten[$i]['idtenant']?>">
                      <?=$data_conten[$i]['tenantsname']?>
                    </option>
                    <?php $i++;} } ?>

                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="photo">Account</label>
                <select name="account[]" multiple id="account" required>
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
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletenotifform" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          <h4 class="modal-title">Delete Notification in <?=$title?></h4>
        </div>
        <div class="modal-body">
          <p>Are you sure delete this point?</p>
          <form method="post" action="<?=base_url().'admin/delete_notif'?>">
            <input type="hidden" name="idnotif" id="del_idnotif" value="">
            <input type="hidden" name="avatar" id="del_avatarnotif" value="">
            <button type="submit" class="btn btn-danger">Sure</button>
            <button class="btn btn-info" data-dismiss="modal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- advertise -->
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertadvertiseform" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          <h4 class="modal-title">Insert <?=$title?> Advertise</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_advertise'?>">
            <div class="row">
              <div class="col-lg-2"></div>
              <div class="col-lg-8">
                <div class="form-group">
                  <label for="title">Tenant</label>
                  <select id="tenant" class="form-control m-bot15" name="tenantid" required>
                    <?php
                    $i=0;
                    foreach ($i_tenant as $a[]) {
                      ?>
                      <option value="<?=$a[$i]['idtenant']?>" data-category = "<?=$a[$i]['idcategory']?>"><?=$a[$i]['tenantsname']?></option>
                      <?php
                      $i++;
                    }
                    ?>
                  </select>

                  <input type="hidden" class="form-control" id="i_idcategory" name="idcategory" value="">
                </div>
                <div class="form-group">
                  <label for="photo">Full Advertise</label>
                  <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required />
                  <label>Max: 800 x 1334 | Min: 200 x 334 | Best: 450x750 | Max file size: 2 MB</label><br>
                </div>
                <div class="form-group">
                  <label for="photo">Small Advertise</label>
                  <input type="file" id="smallphoto" name="smallphoto" class="form-control" accept="image/*" required />
                  <label>Max: 750 x 129 | Min: 100 x 17 | Best: 350x60 | Max file size: 2 MB</label><br>
                </div>
                <div class="row ">
                  <div class="col-lg-10"></div>
                  <div class="col-lg-2">
                  <input type="hidden" value="tenant" name="type" />
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
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteadvertiseform" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          <h4 class="modal-title">Delete Advertise in <?=$title?></h4>
        </div>
        <div class="modal-body">
          <p>Are you sure delete this point?</p>
          <form method="post" action="<?=base_url().'admin/delete_advertise'?>">
            <input type="hidden" name="idadvertise" id="del_idadvertise" value="">
            <input type="hidden" name="advertise" id="del_advertise" value="">
            <input type="hidden" name="smalladvertise" id="del_smalladvertise" value="">
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
                      $("#del_idnotif").prop("value", idnotif);
                      $("#del_avatarnotif").prop("value", avatar);
                    });

                    //delete advertise
                    $(".delete-advertise").click(function(){
                      var idadvertise = $(this).attr("data-id");
                      var advertise = $(this).attr("data-advertise");
                      var smalladvertise = $(this).attr("data-smalladvertise");
                      $("#del_idadvertise").prop("value", idadvertise);
                      $("#del_advertise").prop("value", advertise);
                      $("#del_smalladvertise").prop("value", smalladvertise);
                    });


                    $( "#tenant" )
                    .change(function () {
                      var idcategory = $(this).find('option:selected').attr("data-category");
                      $("#i_idcategory").prop("value", idcategory);
                    })
                    .change();

                  </script>
