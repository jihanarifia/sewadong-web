<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/getproperty'?>">Property</a></li>
            <li class="active"><?=$title?></li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
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
          <section class="panel">
            <header class="panel-heading">
              Form Edit
            </header>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Delete Property <?=$title?></h4>
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
              <form role="form" action="<?=base_url().'admin/update_getproperty'?>" method="post" enctype="multipart/form-data" id="formacc">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$data_detail->detail[0]->name?>" autofocus required>
                    </div>
                    <div class="form-group">
                      <label for="name">Type</label>
                      <input type="number" min="0" class="form-control" name="type" placeholder="Type" value="<?=$data_detail->detail[0]->type?>" required>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="name">Building Area</label>
                          <input type="number" class="form-control" name="lb" min="0" placeholder="Building Area" value="<?=$data_detail->detail[0]->lb?>" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="name">Surface Area</label>
                          <input type="number" class="form-control" name="lt" min="0" placeholder="Surface Area" value="<?=$data_detail->detail[0]->lt?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name">Price</label>
                      <input type="number" name="price" class="form-control" min="0" placeholder="Price" value="<?=$data_detail->detail[0]->price?>" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="subcategory">Category</label>
                      <select class="form-control m-bot15" name="idcategory" required>
                        <?php
                        foreach ($subcat as $item) {
                          ?>
                          <option <?= $idcategory == $item->idcategory ? "selected" : "" ?> value="<?php echo $item->idcategory ?>">
                            <?php echo $item->categoryname ?>
                          </option>  
                          <?php } ?>

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" name="image" class="form-control" accept="image/*" />
                        <input type="checkbox" name="empty_avatar" <?php if($data_detail->detail[0]->avatar==null) echo "checked"; ?>><label> Empty avatar</label><br>
                        <label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
                      </div>
                      <?php if($data_detail->detail[0]->avatar!=null) { ?>
                      <div class="col-lg-6" style="height:100px;width:100px;overflow:hidden;display:flex;justify-content:center;align-items:center">
                        <img class="image-responsive" src="<?= $data_detail->detail[0]->avatar ?>" style="height:100%;">
                      </div>
                      <?php } ?>
                      <input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?=$data_detail->detail[0]-> avatar ?>">
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="agent" class="control-label">Agent</label>
                        <div class="selectContainer">
                          <select class="form-control" name="idagent" required >
                            <?php
                            foreach ($agent as $item) {
                              ?>
                              <option <?= $idagent == $item->idagent ? "selected" : "" ?> value="<?php echo $item->idagent ?>">
                                <?php echo $item->name ?>
                              </option>  
                              <?php } ?>

                            </select>
                          </div>
                        </div> 
                        <div class="form-group">
                          <label for="subcategory">Status</label>
                          <select class="form-control m-bot15" name="status" required>
                            <option value="rent" <?php echo ($data_detail->detail[0]->status == 'rent')?'selected':''?>>Rent</option>   
                            <option value="buy" <?php echo ($data_detail->detail[0]->status == 'buy')?'selected':''?>>Buy</option>   
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="description">Indonesian Description</label>
                          <textarea form="formacc" rows="3" class="form-control" name="description" placeholder="Indonesian description" required><?=$data_detail->detail[0]->description?></textarea>
                        </div>
                        <div class="form-group">
                          <label for="description_en">English Description</label>
                          <textarea form="formacc" rows="3" class="form-control" name="description_en" placeholder="English description" required><?=$data_detail->detail[0]->description_en?></textarea>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" class="form-control" id="avatar" name="idproperty" placeholder="avatar" value="<?=$data_detail->detail[0]->idproperty ?>">
                    <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                  </form>
                </div>
              </section>
            </div>
          </div>

          <!-- another detail -->
          <div class="row">
            <!-- room detail -->
            <div class="col-lg-6">
              <section class="panel">
                <header class="panel-heading ">
                  <a href="#insertroom" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Rooms</a>
                  <h3>Rooms</h3>
                </header>
                <table class="table table-striped table-advance table-hover " id="data-table"> 
                  <thead>
                    <tr>
                      <th><i class="icon_profile"></i> Rooms</th>
                      <th><i class="icon_calendar"></i> Quantity</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($data_detail->room[0]->idroom)) {
                      foreach ($data_detail->room as $item_detail) {
                        ?>  
                        <tr>
                          <td><?= $item_detail->name ?></td>
                          <td><?= $item_detail->jumlah ?></td>
                          <td>
                            <div class="btn-group">
                              <a data-toggle="modal" class="btn btn-success update-room" href="#updateroom" data-id="<?= $item_detail->idroom ?>" data-name="<?= $item_detail->name ?>" data-quantity="<?= $item_detail->jumlah ?>"><i class="icon_pencil"></i></a>
                              <a data-toggle="modal" class="delete-room btn btn-danger" href="#deleteroom"  data-id="<?= $item_detail->idroom ?>"><i class="icon_trash_alt"></i></a>
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
              <!-- panel gallery -->
              <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading ">
                    <a href="#insertgallery" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Gallery</a>
                    <h3>Gallery</h3>
                  </header>
                  <table class="table table-striped table-advance table-hover " id="data-table2"> 
                    <thead>
                      <tr>
                        <th><i class="icon_image"></i> Photo</th>
                        <th><i class="icon_quotations"></i> Title</th>
                        <th><i class="icon_cogs"></i> Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($data_detail->gallery)) {
                        foreach ($data_detail->gallery as $item_detail) {
                          ?>  
                          <tr>
                            <td><img height="99px" width="99px" src="<?=$item_detail->image?>"></td>
                            <td><?= $item_detail->title ?></td>
                            <td>
                              <div class="btn-group">
                                <a data-toggle="modal" class="btn btn-success update-galleryproperty" href="#editphoto" data-id="<?=$item_detail->idpropertygallery?>" data-avatar="<?=$item_detail->image?>" data-title="<?=$item_detail->title?>" data-idproperty="<?=$item_detail->idproperty?>"><i class="icon_pencil"></i></a>
                                <a data-toggle="modal" class="delete-photo btn btn-danger" href="#deletephoto" data-idgallery="<?=$item_detail->idpropertygallery?>" data-imageurl="<?=$item_detail->image?>" ><i class="icon_trash_alt"></i></a>
                              </div>
                            </td>
                          </tr>                         
                          <?php }
                        } else { ?>
                        <tr><td colspan="3">No result found</td></tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </section>
                </div>
              </div> 
              <!-- form insert room -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertroom" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Add Room</h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url().'admin/insert_room' ?>">
                        <div class="form-group">
                          <label for="subcategory" class="col-lg-2 control-label">Name</label>
                          <div class="col-lg-10">
                            <select class="form-control m-bot15" name="name" id="name">
                              <option value="bathroom">Bathroom</option>
                              <option value="bedroom">Bedroom</option>
                              <option value="diningroom">Diningroom</option>
                              <option value="garage">Garage</option>
                              <option value="kitchen">Kitchen</option>
                              <option value="livingroom">Livingroom</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-lg-2 control-label">Quantity</label>
                          <div class="col-lg-10">
                            <input type="text" min="0" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required>
                          </div>
                        </div>           
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10"><input type="hidden" name="idproperty" value="<?=$data_detail->detail[0]->idproperty ?>">
                            <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- form update room -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateroom" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Update Room</h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_room' ?>">
                        <div class="form-group">
                          <label for="subcategory" class="col-lg-2 control-label">Name</label>
                          <div class="col-lg-10">
                            <select class="form-control m-bot15" name="name" id="uname">
                              <option value="bathroom">Bathroom</option>
                              <option value="bedroom">Bedroom</option>
                              <option value="diningroom">Diningroom</option>
                              <option value="garage">Garage</option>
                              <option value="kitchen">Kitchen</option>
                              <option value="livingroom">Livingroom</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-lg-2 control-label">Quantity</label>
                          <div class="col-lg-10">
                            <input type="text" min="0" class="form-control" id="uquantity" name="quantity" placeholder="Quantity" required>
                          </div>
                        </div>           
                        <div class="form-group">
                          <input type="hidden" name="idproperty" value="<?=$data_detail->detail[0]->idproperty ?>">
                          <input type="hidden" id="uidroom" value="" name="idroom">
                          <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>

                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- form delete room -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteroom" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Delete Room</h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure delete this point?</p>                          
                      <form method="post" action="<?= base_url() . 'admin/delete_room' ?>">
                        <input type="hidden" name="idroom" id="delidroom" value="">
                        <button type="submit" class="btn btn-danger">Sure</button>
                        <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                      </form>                            
                    </div>
                  </div>
                </div>
              </div>
              <!-- form insert gallery -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertgallery" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Add Photo</h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_galleryproperty' ?>">
                        <div class="form-group">
                          <label for="photo" class="col-lg-2 control-label">Photo</label>
                          <div class="col-lg-10">
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required />
                            <label>Max: 4000 X 4000<br>Max file size: 2 MB</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-lg-2 control-label">Title</label>
                          <div class="col-lg-10">
                            <input type="" class="form-control" id="title" name="title" placeholder="Title" required>
                          </div>
                        </div>              
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" class="form-control" id="idproperty" name="idproperty" value="<?=$data_detail->detail[0]->idproperty ?>" required>
                            <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- form delete gallery -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletephoto" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Delete Photo </h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure delete this point?</p>                          
                      <form method="post" action="<?= base_url() . 'admin/delete_galleryproperty' ?>">
                        <input type="hidden" name="imageurl" id="del_imageurl" value="">
                        <input type="hidden" name="idpropertygallery" id="del_idgallery" value="">
                        <button type="submit" class="btn btn-danger">Sure</button>
                        <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                      </form>                            
                    </div>
                  </div>
                </div>
              </div>
              <!-- form update gallery -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editphoto" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Edit Photo</h4>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_galleryproperty' ?>">
                        <div class="form-group">
                          <label for="photo" class="col-lg-2 control-label">Photo</label>
                          <div class="col-lg-10">
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/*"/ required>
                            <label>Max: 4000 X 4000<br>Max file size: 2 MB</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2"></label>
                          <img class="col-lg-7 image-responsive"  src=""  id="u_avatar" name="photo1" style="height:150px;width:auto">
                          <input type="hidden" name="photo1" id="u_setavatar" value="">
                        </div>
                        <div class="form-group">
                          <label for="title" class="col-lg-2 control-label">Title</label>
                          <div class="col-lg-10">
                            <input type="text" class="form-control" id="u_title" value="" name="title" placeholder="Title" required>
                          </div>
                        </div>  

                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" id="u_idgallery" value="" name="idpropertygallery">
                            <input type="hidden" id="u_idproperty" value="" name="idproperty">
                            <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                          </div>
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
          $(document).ready(function(){
            $('.form-group')
            .find('[name="idagent"]')
            .combobox()
            .end()
          });
        </script>