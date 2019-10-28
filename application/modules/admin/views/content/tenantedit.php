<section id="container">
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                        <li><a href="<?= base_url().'admin/tenant/'.$category ?>"><?=$category?></a></li>
                        <li class="active"><?=$title?></li>
                    </ul>
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
                            Edit Form
                        </header>
                        <div class="panel-body">
                            <form method="post" action="<?= base_url() . 'admin/update_tenant' ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="name" value="<?= $data_detail->detail[0]->name ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="tel" maxlength="12" class="form-control" id="phone" name="phone" placeholder="phone" value="<?= $data_detail->detail[0]->phone ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Avatar</label>
                                            <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                                            <input type="checkbox" name="empty_avatar" <?php if($data_detail->detail[0]->avatar==null) echo "checked"; ?>><label>Set empty avatar</label><br>
                                            <label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
                                        </div>
                                        <?php if($data_detail->detail[0]->avatar!=null) { ?>
                                        <div class="col-lg-8" style="height:200px;width:200px;overflow:hidden;display:flex;justify-content:center;align-items:center">
                                            <img class="image-responsive" src="<?= $data_detail->detail[0]->avatar ?>" style="height:100%;">
                                        </div>
                                        <?php } ?>
                                        <input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?= $data_detail->detail[0]->avatar ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="address" value="<?= $data_detail->detail[0]->address ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Link</label>
                                            <input type="text" class="form-control" id="link" name="link" placeholder="link" value="<?= $data_detail->detail[0]->link ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory">Category</label>
                                            <select class="form-control m-bot15" name="idcategory">
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
                                            <label for="subcategory">Premium</label>
                                            <select class="form-control m-bot15" name="premium" id="premium">
                                                <option <?php if ($data_detail->detail[0]->premium == '1') echo "selected" ?> value="1">Yes</option>
                                                <option <?php if ($data_detail->detail[0]->premium == '0') echo "selected" ?> value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="validfrom">Valid From</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="validfromdate" placeholder="Valid From Date" id="validfromdate" value="<?= $validfromdate ?>">
                                                <input type="hidden" class="form-control" name="validfromdatetemp" placeholder="Valid From Date" id="validfromdatetemp" value="<?= $validfromdate ?>">
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="validfromtime" placeholder="Valid From Time" id="validfromtime" value="<?= $validfromtime ?>">
                                                    <input type="hidden" class="form-control" name="validfromtimetemp" placeholder="Valid From Time" id="validfromtimetemp" value="<?= $validfromtime ?>">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="validuntil">Valid Until</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="validuntildate" placeholder="Valid Until Date" id="validuntildate" value="<?= $validuntildate ?>">
                                                <input type="hidden" class="form-control" name="validuntildatetemp" placeholder="Valid Until Date" id="validuntildatetemp" value="<?= $validuntildate ?>">
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="validuntiltime" placeholder="Valid Until Time" id="validuntiltime" value="<?= $validuntiltime ?>">
                                                    <input type="hidden" class="form-control" name="validuntiltimetemp" placeholder="Valid Until Time" id="validuntiltimetemp" value="<?= $validuntiltime ?>">
                                                </span>
                                            </div>
                                        </div>
										<div class="form-group" style="margin-top: -2vh;">
											<input type="checkbox" id="validalltime" name="validalltime" <?= !$validuntil?"checked":"" ?>>
											<label>Valid all the time</label>
										</div>
                                        <div class="form-group">
                                            <label for="name">Color</label>
                                            <input type="color" class="form-control" id="name" name="color" placeholder="Color" value="<?=$data_detail->detail[0]->color?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Logo</label>
                                            <input type="file" name="logo" id="image" class="form-control" accept="image/*" />
                                            <label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
                                            <?php if($data_detail->detail[0]->logo!=null) { ?>
                                            <div class="col-lg-4" style="overflow:hidden;display:flex;justify-content:center;align-items:center">
                                                <!-- <div class="col-sm-4 container"> -->
                                                <img class="col-sm-12 image-responsive" src="<?= $data_detail->detail[0]->logo ?>" style="height:100%;">
                                            </div>
                                            <?php } ?>
                                            <input type="hidden" name="oldlogo" id="oldlogo" value="<?= $data_detail->detail[0]->logo ?>" class="form-control" accept="image/*" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="map">PinPoint</label><br>
                                            <div id="map" class="image-responsive" ></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" name='latitude' id='latitude' placeholder="latitude" class="form-control" value="<?= $latitude ?>" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" name='longitude' id='longitude' value="<?= $longitude ?>" placeholder="longitude" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 ">
                                    <input type="hidden" class="form-control" name="idtenant" value="<?= $data_detail->detail[0]->idtenant ?>">
                                    <input type="hidden" name="category" value="<?= $category ?>">
                                    <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                </div>
                        </div>
                        </form>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading ">
                            <a href="#insertmenu" class="btn btn-primary pull-right" data-toggle="modal" > <i class="icon_plus"></i> Add Menu</a>
                            <h3>Menu</h3>
                        </header>
                        <table class="table table-striped table-advance table-hover " id="data-table">
                            <thead>
                                <tr>
                                    <th><i class=""></i> Menu</th>
                                    <th><i class="icon_currency"></i> Price</th>
                                    <th><i class="icon_link_alt"></i> LinkCatalog</th>
                                    <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data_detail->menu[0])) {
                                    foreach ($data_detail->menu as $item_detail) {
                                    	?>  
                                <tr>
                                    <td><?= $item_detail->menu ?></td>
                                    <td><?= $item_detail->price ?></td>
                                    <td>
                                        <?php if($item_detail->linkcatalog!=""){ ?>
                                        <a class="form-control" target="_blank" href="<?= $item_detail->linkcatalog ?>">Download file</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a data-toggle="modal" class="btn btn-success update-menu" href="#updatemenu" data-id="<?= $item_detail->idmenu ?>" data-menu="<?= $item_detail->menu ?>" data-price="<?= $item_detail->price ?>" data-linkcatalog="<?= $item_detail->linkcatalog ?>"><i class="icon_pencil"></i></a>
                                            <a data-toggle="modal" class="delete-menu btn btn-danger" href="#deletemenu"  data-id="<?= $item_detail->idmenu ?>" data-linkcatalog="<?= $item_detail->linkcatalog ?>"><i class="icon_trash_alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }
                                    } else { ?>
                                <tr>
                                    <td colspan="6">No result found</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                </div>
                <!-- Gallery -->
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            <a href="#insertphoto" class="btn btn-primary pull-right" data-toggle="modal"><i class="icon_plus"></i> Add Photo</a>
                            <h3>Gallery</h3>
                        </header>
                        <table class="table table-striped table-advance table-hover" id="data-table2">
                            <thead>
                                <tr >
                                    <th><i class="icon_image"></i> Photo</th>
                                    <th><i class="icon_quotations"></i> Title</th>
                                    <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data_detail->gallery[0])) {
                                    foreach ($data_detail->gallery as $item_gallery) {
                                    	?>   
                                <tr>
                                    <td><img height="99px" width="99px" src="<?= $item_gallery->avatar ?>"></td>
                                    <td><?= $item_gallery->title ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a data-toggle="modal" class="btn btn-success update-photo" href="#updatephoto" data-id="<?= $item_gallery->idgallery ?>" data-imageurl="<?= $item_gallery->avatar ?>" data-title="<?= $item_gallery->title ?>"><i class="icon_pencil"></i></a>
                                            <a data-toggle="modal" class="delete-photo btn btn-danger" href="#deletephoto" data-idgallery="<?= $item_gallery->idgallery ?>" data-imageurl="<?= $item_gallery->avatar ?>" ><i class=" icon_trash_alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }
                                    } else { ?>
                                <tr>
                                    <td colspan="6">No result found</td>
                                </tr>
                                <?php } ?>       
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="row">
                <!-- Discount Coupon -->
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            <a href="#insertdiscountcoupon" class="btn btn-primary pull-right" data-toggle="modal"><i class="icon_plus"></i> Add coupon</a>
                            <h3>Discount coupon</h3>
                        </header>
                        <table class="table table-striped table-advance table-hover" id="data-table3">
                            <thead>
                                <tr>
                                    <th><i class="icon_image"></i> Photo</th>
                                    <th><i class="icon_calendar"></i> Title</th>
                                    <th><i class="icon_link_alt"></i> File</th>
                                    <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($data_detail->discountcoupon[0])) {
                                    foreach ($data_detail->discountcoupon as $item_discountcoupon) {
                                    	?>   
                                <tr>
                                    <td>
                                        <?php if($item_discountcoupon->imageurl!=""){ ?>
                                        <img height="99px" width="99px" src="<?= $item_discountcoupon->imageurl ?>">
                                        <?php } ?>
                                    </td>
                                    <td><?= $item_discountcoupon->title ?></td>
                                    <td><?php if($item_discountcoupon->fileurl!=""){ ?>
                                        <a class="form-control"  target="_blank" href="<?= $item_discountcoupon->fileurl ?>">Download file</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a data-toggle="modal" class="btn btn-success update-discountcoupon" href="#updatediscountcoupon" data-iddiscountcoupon="<?= $item_discountcoupon->iddiscountcoupon ?>" data-imageurldc="<?= $item_discountcoupon->imageurl ?>" data-titledc="<?= $item_discountcoupon->title ?>" data-captiondc="<?= $item_discountcoupon->caption ?>" data-fileurl="<?= $item_discountcoupon->fileurl ?>" data-filename="<?= $item_discountcoupon->filename ?>" data-filesize="<?= $item_discountcoupon->filesize ?>"><i class="icon_pencil"></i></a>
                                            <a data-toggle="modal" class="delete-discountcoupon btn btn-danger" href="#deletediscountcoupon" data-iddiscountcoupon="<?= $item_discountcoupon->iddiscountcoupon ?>" data-imageurldc="<?= $item_discountcoupon->imageurl ?>" data-fileurldc="<?= $item_discountcoupon->fileurl ?>" ><i class="icon_trash_alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }
                                    } else { ?>
                                <tr>
                                    <td colspan="6">No result found</td>
                                </tr>
                                <?php } ?>       
                            </tbody>
                        </table>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            <a class="btn btn-primary pull-right" ><i class="icon_star"></i> Rating</a>
                            <h3>Rating</h3>
                        </header>
                        <table class="table table-striped table-advance table-hover" id="data-table3">
                            <thead>
                                <tr>
                                    <th><i class="icon_id-2"></i> Username</th>
                                    <th><i class="icon_star"></i> Rating</th>
                                    <th><i class="icon_calendar"></i> Createdate</th>
                                    <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // if (isset($data_detail->discountcoupon[0])) {
                                    // 	foreach ($data_detail->discountcoupon as $item_discountcoupon) {
                                    ?>   
                                <!-- <tr>
                                    <td><img height="99px" width="99px" src="<?= $item_discountcoupon->imageurl ?>"></td>
                                    <td><?= $item_discountcoupon->title ?></td>
                                    <td>
                                    	<div class="btn-group">
                                    		<a data-toggle="modal" class="btn btn-success update-rating" href="#updaterating" data-idrating="<?= $item_discountcoupon->iddiscountcoupon ?>" data-username="<?= $item_discountcoupon->imageurl ?>" data-iduser="<?= $item_discountcoupon->title ?>" data-rating="<?= $item_discountcoupon->caption ?>" data-createdate="<?= $item_discountcoupon->caption ?>" ><i class="icon_pencil"></i></a>
                                    		<a data-toggle="modal" class="delete-rating btn btn-danger" href="#deleterating" data-idrating="<?= $item_discountcoupon->iddiscountcoupon ?>" ><i class="icon_trash_alt"></i></a>
                                    	</div>
                                    </td>
                                    </tr>  -->
                                <?php 
                                    // }
                                    // } else { ?>
                                <tr>
                                    <td colspan="6">No result found</td>
                                </tr>
                                <?php // } ?>       
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <!-- Rating -->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h3>Open Hour</h3>
                        </header>
                        <table class="table table-striped table-advance table-hover" >
                            <thead>
                                <tr>
                                    <th><i class="icon_calendar"></i> Day</th>
                                    <th><i class="icon_clock_alt"></i> Open </th>
                                    <th><i class="icon_clock_alt"></i> Close </th>
                                    <th><i class="icon_clock"></i> Status</th>
                                </tr>
                            </thead>
                            <form method="post" action="<?= base_url() . 'admin/update_openhour' ?>" >
                                <tbody>
                                    <?php if(isset($hour_con)!=false && empty($hour_con)==false) { $i=0; foreach($hour_con as $data_con[]) { ?>  
                                    <tr>
                                        <td>
                                            <?= $data_con[$i]['dayname'] ?>
                                            <input type="hidden" class="form-control" name="dayname<?=$i?>" value="<?= $data_con[$i]['dayname']  ?>">
                                            <input type="hidden" class="form-control" name="idopenhour<?=$i?>" value="<?= $data_con[$i]['idopenhour']  ?>">
                                            <input type="hidden" class="form-control" name="idtenant<?=$i?>" value="<?= $idtenant ?>">
                                        </td>
                                        <td><input type="time" class="form-control" name="openhour<?=$i?>" value="<?= $data_con[$i]['dopenhour']  ?>"></td>
                                        <td><input type="time" class="form-control" name="closehour<?=$i?>" value="<?= $data_con[$i]['dclosehour']  ?>"></td>
                                        <td>
                                            <select class="form-control " name="open<?=$i?>" >
                                                <option <?php if ($data_con[$i]['dopen']  =='1') echo "selected"; ?> value="1">Open</option>
                                                <option <?php if ($data_con[$i]['dopen']  =='0') echo "selected"; ?> value="0">Close</option>
                                            </select>
                                        </td>
                                        <?php $i++;} } else { ?>
                                    <tr>
                                        <td colspan="" >No Result Found</td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <input type="hidden" name="count" value="<?=--$i?>">
                                        <td colspan="4"><button type="submit" class="btn btn-primary"><i class="icon_floppy"></i> Save</button></td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                    </section>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertmenu" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Insert Menu</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_menu' ?>">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="menu">Menu</label>
                                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" placeholder="Price">
                                        </div>
                                        <div class="form-group">
                                            <label for="linkcatalog">LinkCatalog</label>
                                            <input type="file" class="form-control" id="linkcatalog" name="linkcatalog" placeholder="Linkcatalog" accept="application/pdf">
                                            <label>Max file size: 5 MB</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2">
                                                <input type="hidden" name="idtenant" value="<?= $idtenant ?>">
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
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatemenu" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update Menu</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_menu' ?>">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="name">Menu</label>
                                            <input type="text" class="form-control" id="u_menu" name="menu" placeholder="Menu" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Price</label>
                                            <input type="number" class="form-control" id="u_price" name="price" placeholder="Price" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">LinkCatalog</label>
                                            <input type="file" id="linkcatalog" class="form-control" name="linkcatalog" placeholder="Linkcatalog" accept="application/pdf">
											<input type="text" class="form-control" id="u_linkcatalog" name="linkcatalog1" placeholder="LinkCatalog" value="" readonly> 
											<label>Max file size: 5 MB</label>
                                        </div>
                                        <div class="row ">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2">
                                                <input type="hidden" name="idmenu" id="u_idmenu" value="">
                                                <input type="hidden" name="idtenant" value="<?= $data_detail->detail[0]->idtenant ?>">
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
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletemenu" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete Menu</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this point?</p>
                            <form method="post" action="<?= base_url() . 'admin/delete_menu' ?>">
                                <input type="hidden" name="idmenu" id="del_id" value="">
                                <input type="hidden" name="linkcatalog" id="del_linkcatalog" value="">
                                <button type="submit" class="btn btn-danger">Sure</button>
                                <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertphoto" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Add Photo</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_gallery' ?>">
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">Photo</label>
                                    <div class="col-lg-10">
                                        <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required />
                                        <label>Max: 800 x 800 | Min: 150 x 150<br>Max file size: 2 MB</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-lg-2 control-label">Title</label>
                                    <div class="col-lg-10">
                                        <input type="" class="form-control" id="title" name="title" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10"><input type="hidden" name="idtenant" value="<?= $idtenant ?>">
                                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletephoto" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete Photo </h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this point?</p>
                            <form method="post" action="<?= base_url() . 'admin/delete_gallery' ?>">
                                <input type="hidden" name="imageurl" id="del_imageurl" value="">
                                <input type="hidden" name="idgallery" id="del_idgallery" value="">
                                <button type="submit" class="btn btn-danger">Sure</button>
                                <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatephoto" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Gallery</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_gallery' ?>">
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">Photo</label>
                                    <div class="col-lg-10">
                                        <input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
                                        <label>Max: 800 x 800 | Min: 150 x 150<br>Max file size: 2 MB</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2"></label>
                                    <img class="col-lg-7 image-responsive"  src=""  id="u_photo" name="photo1">
                                    <input type="hidden" name="photo1" id="u_setphoto" value="">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-lg-2 control-label">Title</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="u_title" value="" name="title" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="hidden" name="idtenant" value="<?= $idtenant ?>">
                                        <input type="hidden" id="u_idgallery" value="" name="idgallery">
                                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertdiscountcoupon" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Add Discount Coupon</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/insert_discountcoupon' ?>">
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">Photo</label>
                                    <div class="col-lg-10">
										<input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
										<input type="checkbox" name="empty_avatar"><label>Set empty avatar</label><br>
										<label>Max: 800 x 800 | Min: 150 x 150 | Max file size: 2 MB</label>
									</div>
									
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-lg-2 control-label">Title</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="caption" class="col-lg-2 control-label">Caption</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control ckeditor" name="caption" id="caption" rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="avatar" class="col-lg-2 control-label ">File</label>
                                    <div class="col-lg-10">
                                        <input type="file" name="file" class="form-control" accept=".pdf" />
                                        <input type="checkbox" name="empty_file"><label>Set empty file</label><br>
                                        <label>Max file size: 5 MB | *Just receive PDF file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10"><input type="hidden" name="idtenant" value="<?= $idtenant ?>">
                                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deletediscountcoupon" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete Discount Coupon </h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this point?</p>
                            <form method="post" action="<?= base_url() . 'admin/delete_discountcoupon' ?>">
                                <input type="hidden" name="imageurl" id="del_imageurldc" value="">
                                <input type="hidden" name="fileurl" id="del_fileurldc" value="">
                                <input type="hidden" name="iddiscountcoupon" id="del_iddiscountcoupondc" value="">
                                <button type="submit" class="btn btn-danger">Sure</button>
                                <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatediscountcoupon" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Discount Coupon</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_discountcoupon' ?>">
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">Photo</label>
                                    <div class="col-lg-10">
                                        <input type="file" id="photo" name="photo" class="form-control" accept="image/*" />
										<input id="u_ceknullavatar" type="checkbox" name="empty_avatar" checked="false"><label>Set empty avatar</label><br>
										<label>Max: 800 x 800 | Min: 150 x 150 | Max file size: 2 MB</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2"></label>
                                    <img class="col-lg-7 image-responsive"  src=""  id="u_photodc">
                                    <input type="hidden" name="photo1" id="u_setphotodc" value="">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-lg-2 control-label">Title</label>
                                    <div class="col-lg-10">
                                        <input type="" class="form-control" id="u_titledc" value="" name="title" placeholder="Title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="caption" class="col-lg-2 control-label">Caption</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control ckeditor" name="caption" id="u_captiondc"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">File</label>
                                    <div class="col-lg-10">
                                        <input type="file" id="fileurl" name="fileurl" class="form-control" accept="application/pdf" />
                                        <input id="u_ceknullfile" type="checkbox" name="empty_file" checked="false"><label>Set empty file</label><br>
                                        <input type="text" id="u_filename" name="u_filename" class="form-control" readonly/>
                                        <input type="hidden" id="u_fileurl" name="u_fileurl" class="form-control"/>
										<input type="hidden" id="u_filesize" name="u_filesize" class="form-control"  />
										<label>Max file size: 5 MB | *Just receive PDF file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
										<input type="hidden" name="idtenant" value="<?= $idtenant ?>">
										<input type="hidden" name="idcategory" value="<?= $idcategory ?>">
                                        <input type="hidden" id="u_iddiscountcoupon" value="" name="iddiscountcoupon">
                                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updaterating" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Edit Rating User</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?= base_url() . 'admin/update_rating' ?>">
                                <div class="form-group">
                                    <label for="photo" class="col-lg-2 control-label">Username</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="username" id="u_username" value="" readonly>
                                        <input type="text" name="iduser" id="u_iduser" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-lg-2 control-label">Rating</label>
                                    <div class="col-lg-10">
                                        <input type="" class="form-control" id="u_rating" value="" name="rating" placeholder="Rating">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="caption" class="col-lg-2 control-label">Create Date</label>
                                    <div class="col-lg-10">
                                        <input type="" class="form-control" id="u_createdate" value="" name="createdate" placeholder="Date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="hidden" name="idtenant" value="<?= $idtenant ?>">
                                        <input type="hidden" id="u_idrating" value="" name="idrating">
                                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleterating" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete Rating </h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this point?</p>
                            <form method="post" action="<?= base_url() . 'admin/delete_rating' ?>">
                                <input type="hidden" name="idrating" id="del_idrating" value="">
                                <button type="submit" class="btn btn-danger">Sure</button>
                                <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete form file -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteformfile" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete File</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this point?</p>
                            <form method="post" action="<?=base_url().'admin/delete_file'?>">
                                <input type="hidden" name="iddownload" id="del_iddownload" value="">
                                <input type="hidden" name="avatar" id="del_avatar" value="">
                                <input type="hidden" name="linkfile" id="del_file" value="">
                                <button type="submit" class="btn btn-danger">Sure</button>
                                <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- form update file -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateformfile" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Update File</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" action="<?=base_url().'admin/update_file'?>" method="post" enctype="multipart/form-data" id="formacc">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Title</label>
                                            <input type="text" class="form-control" id="utitlefile" name="title" placeholder="Name" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <label for="avatar">Avatar</label>
                                            <input type="file" name="avatar" class="form-control" accept="image/*" /><br>
                                            <input id="u_ceknullavatar" type="checkbox" name="empty_avatar" checked="false"><label>Set empty avatar</label><br><br>
                                            <center><img class="image-responsive" height="75px" src="" id="uavatarfile"></center>
                                            <input type="hidden" id="usetavatarfile" name="uavatar" value="">
                                        </div>
                                        <div class="form-group ">
                                            <label for="file">File</label>
                                            <input type="file" id="linkcatalog" class="form-control" name="linkfile" accept="application/pdf">
                                            <input type="hidden" id="ulinkfile" name="ulinkfile" value="" >
                                            <input type="text" name="filename" id="ufilename" value="" class="form-control" readonly>
                                            <input id="u_ceknullfile" type="hidden" name="empty_file" checked="false">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="iddownload" id="uidfile" value="">
                                <input type="hidden" name="idtenant" id="uidtenant" value="">
                                <input type="hidden" name="filesize" id="ufilesize" value="">
                                <input type="hidden" name="idcategory" id="uidcategory" value="">
                                <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
<script type="text/javascript">
    var validalltime = document.getElementById('validalltime');
    var validfromdate = document.getElementById('validfromdate');
    var validfromtime = document.getElementById('validfromtime');
    var validfromdatetemp = document.getElementById('validfromdatetemp');
    var validfromtimetemp = document.getElementById('validfromtimetemp');
    var validuntildate = document.getElementById('validuntildate');
    var validuntiltime = document.getElementById('validuntiltime');
    var validuntildatetemp = document.getElementById('validuntildatetemp');
    var validuntiltimetemp = document.getElementById('validuntiltimetemp');
    var premium = document.getElementById('premium');

    $('#premium').change(function(){
		if(premium.value == 1){
			validalltime.disabled = false;
			validfromdate.disabled = false;
            validfromtime.disabled = false;
            validuntildate.disabled = false;
            validuntiltime.disabled = false;
            
            validfromdate.value = validfromdatetemp.value;
            validfromtime.value = validfromtimetemp.value;
            validuntildate.value = validuntildatetemp.value;
            validuntiltime.value = validuntiltimetemp.value;

            if(validalltime.checked){
                validuntildate.disabled = true;
                validuntiltime.disabled = true;
                validuntildate.value = null;
                validuntiltime.value = null;
            }
		}else{
			validalltime.disabled = true;
			validfromdate.disabled = true;
			validfromtime.disabled = true;
			validfromdate.value = null;
			validfromtime.value = null;
			
			validuntildate.disabled = true;
			validuntiltime.disabled = true;
			validuntildate.value = null;
			validuntiltime.value = null;
		}
	})

    if(premium.value == 0){
        validfromdate.disabled = true;
        validfromtime.disabled = true;
        validuntildate.disabled = true;
        validuntiltime.disabled = true;
		validalltime.disabled = true;
    }

    if(validfromdate.value != "" && validuntildate.value == "" ){
        validalltime.checked = true
        validuntildate.disabled = true;
        validuntiltime.disabled = true;
    } else {
        validalltime.checked = false;
    }

    $("#validalltime").click(function() {
        var cb = document.querySelectorAll('input[name="validalltime"]:checked');
        if(cb.length > 0){
            validuntildate.disabled = true;
            validuntiltime.disabled = true;
            validuntildate.value = null;
            validuntiltime.value = null;
        }else{
            validuntildate.disabled = false;
            validuntiltime.disabled = false;
            validuntildate.value = validuntildatetemp.value;
            validuntiltime.value = validuntiltimetemp.value;
        }
    });
</script>