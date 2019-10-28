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
                  <li class="active">Get Property</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Property</h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                       <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i>&nbsp;Add</a>
                     </div>
                     <div class = "col-sm-4">
                      <div class="pull-right">
                        <div class="row">
                          <div class="col-lg-4">
                            <h5>Filter by</h5>
                          </div>
                          <div class="col-lg-8">
                            <div class="pull-right">
                              <select class="form-control m-bot15" id="filter" onChange="GetProperty(this)" name="idcategory">
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
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Delete Property</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure delete this point?</p>
                          <form method="post" action="<?=base_url().'admin/delete_getproperty'?>">
                            <input type="hidden" name="avatar" id="del_avatar" value="">
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
                          <h4 class="modal-title">Insert Property</h4>
                        </div>
                        <div class="modal-body">
                          <form role="form" action="<?=base_url().'admin/insert_getproperty'?>" method="post" enctype="multipart/form-data" id="formacc">
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name" name="name" placeholder="Name" autofocus required>
                                </div>
                                <div class="form-group">
                                  <label for="name">Type</label>
                                  <input type="number" min="0" class="form-control" name="type" placeholder="Type" required>
                                </div>
                                <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label for="name">Building Area</label>
                                      <input type="number" class="form-control" name="lb" min="0" placeholder="Building Area" required>
                                    </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label for="name">Surface Area</label>
                                      <input type="number" class="form-control" name="lt" min="0" placeholder="Surface Area" required>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="name">Price</label>
                                  <input type="number" name="price" class="form-control" min="0" placeholder="Price" required>
                                </div>
                                <div class="form-group">
                                  <label for="agent" class="control-label">Agent</label>
                                  <div class="selectContainer">
                                    <select class="form-control" name="idagent" required >
                                      <option value="">Choose a agent</option>
                                      <?php
                                      foreach ($agent as $item) {
                                        ?>
                                        <option value="<?php echo $item->idagent?>">
                                          <?php echo $item->name?>
                                        </option>
                                        <?php } ?>

                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="subcategory">Category</label>
                                    <select class="form-control m-bot15" name="idcategory" required>
                                      <?php
                                      foreach ($subcat as $item) {
                                        ?>
                                        <option value="<?php echo $item->idcategory?>">
                                          <?php echo $item->categoryname?>
                                        </option>
                                        <?php } ?>

                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="avatar">Avatar</label>
                                      <input type="file" name="image" class="form-control" accept="image/*" /><br>
                                      <label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
                                    </div>
                                    <div class="form-group">
                                      <label for="subcategory">Status</label>
                                      <select class="form-control m-bot15" name="status" required>
                                        <option value="rent">Rent</option>
                                        <option value="buy">Buy</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="description">Indonesian Description</label>
                                      <textarea form="formacc" rows="3" class="form-control" name="description" placeholder="Indonesian Description" required></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="description_en">English Description</label>
                                      <textarea form="formacc" rows="3" class="form-control" name="description_en" placeholder="English Description" required></textarea>
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
                                 <th><i class="icon_id"></i> Name</th>
                                 <th><i class=" icon_quotations"></i> Type</th>
                                 <th><i class="icon_id"></i> LB/LT</th>
                                 <th><i class="icon_currency"></i> Price (IDR)</th>
                                 <th><i class="icon_tag_alt"></i> Category</th>
                                 <th><i class="icon_tag_alt"></i> status</th>
                                 <th><i class="icon_tools"></i> Action</th>
                               </tr>
                             </thead>
                             <tbody>
                               <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>
                                 <tr>
                                   <td><?=$data_con[$i]['name']?></td>
                                   <td><?=$data_con[$i]['type']?></td>
                                   <td><?=$data_con[$i]['lblt']?></td>
                                   <td><?=$data_con[$i]['price']?></td>
                                   <td><?=$data_con[$i]['categoryname']?></td>
                                   <td><?=$data_con[$i]['status']?></td>
                                   <td>
                                    <div class="btn-group">
                                      <a class="btn btn-success" href="<?=base_url().'admin/detail_getproperty?id='.$data_con[$i]['idproperty']?>"><i class="icon_pencil" ></i></a>
                                      <a data-toggle="modal" class="open-delete btn btn-danger" href="#deleteform" data-avatar="<?=$data_con[$i]['avatar']?>" data-id="<?=$data_con[$i]['idproperty']?>"><i class="icon_trash_alt"></i></a>
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
                      <!-- advertise -->
                      <div class="row">
                      <div class="col-lg-12">
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
                  <th><i class="icon_building"></i> Property name</th>
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
                      foreach ($property as $item) {
                        ?>
                        <option <?= $data_advertise[$i]['idproperty'] == $item->idproperty ? "selected" : "" ?> value="<?php echo $item->idproperty ?>">
                          <?php echo $item->name ?>
                        </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td style="width:150px;height:auto"><img class="col-lg-12 image-responsive" src="<?=$data_advertise[$i]['advertise']?>"></td>
                    <td style="width:150px;height:auto"><img class="col-lg-12 image-responsive" src="<?=$data_advertise[$i]['smalladvertise']?>"></td>
                    <td>
                      <div class="btn-group">
                        <a data-toggle="modal" class="btn btn-success update-advertise" href="<?=base_url().'admin/advertisedetail?id='.$data_advertise[$i]['idadvertise'].'&subcat='.$idTCat.'&name='.$title.'&type=property'?> " ><i class="icon_pencil"></i></a>
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
                      <!-- page end-->

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
                  <label for="title">Property</label>
                  <select id="tenant" class="form-control m-bot15" name="idproperty" required>
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
                    <input type="hidden" value="property" name="type" />
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

                    </section>
                  </section>
                </section>
                <!--main content end-->
              </section>
              <!-- container section end -->
            </body>
            </html>
            <script type="text/javascript">
              $(document).ready(function(){
                $('.form-group')
                .find('[name="idagent"]')
                .combobox()
                .end()
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