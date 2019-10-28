<section id="container" class="">
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                        <li class="active">
                            <?= $title?>
                                </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h3>
                        <?= $title?>
                    </h3>
                    <section class="panel">
                        <?php if ($this-> session-> flashdata('message')) {?>
                        <div class="alert alert-success fade in" id="alert">
                            <?php echo $this-> session-> flashdata('message'); ?> </div>
                        <?php }?>
                        <?php if ($this-> session-> flashdata('breakmessage')) {?>
                        <div class="alert alert-block alert-danger fade in" id="alert">
                            <?php echo $this-> session-> flashdata('breakmessage'); ?> </div>
                        <?php }?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th> Payment Type Name</th>
                                        <th> Payment Type Code</th>
                                        <th> Amount</th>
                                        <th> Description</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data_con) != false && empty($data_con) == false) {$i=0; foreach($data_con as $data_con[]) {?>
                                    <tr>
                                        <td>
                                            <?= $data_con[$i]['name']?>
                                        </td>
                                        <td>
                                            <?= $data_con[$i]['payment_type']?>
                                        </td>
                                        <td>
                                            <?= $data_con[$i]['format_charge']?>
                                        </td>
                                        <td>
                                            <?= $data_con[$i]['description']?>
                                        </td>
                                        <td>
                                            <div class="btn-group"> <a data-toggle="modal" class="btn btn-success update-form" href="#updateform" data-id="<?=$data_con[$i]['id']?>" data-isPct="<?=$data_con[$i]['isPct'] ? 'true' : 'false' ?>" data-name="<?=$data_con[$i]['name']?>" data-charge="<?=$data_con[$i]['charge']?>"
                                                    data-description="<?=$data_con[$i]['description']?>" data-iconImage="<?=$data_con[$i]['icon']?>" data-paymenttype="<?=$data_con[$i]['payment_type']?>" data-guidefile="<?=$data_con[$i]['guide_file']?>"><i class="icon_pencil"></i></a>                                     
                                        </td>
                                    </tr>
                                    <?php $i++; }}else {?>
                                    <tr>
                                        <td colspan="6"> No result found</td>
                                    </tr>
                                    <?php }?> </tbody>
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
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"> <button aria-hidden="true" data-dismiss="modal" class="close" type="button"> ×</button>
                            <h4 class="modal-title"> Insert
                                <?= $title?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?=base_url().'admin/insert_chargepayment'?>">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="form-group"> <label for="name"> Payment Type Name<span style="color:red;">  * </span> </label> <input type="" class="form-control" name="payment_type_name" placeholder="Payment Type Name" value="" required> </div>
                                        <div class="form-group">
                                            <label for="name"> Payment Type Code<span style="color:red;">  * </span> </label> <input type="number" min="0" class="form-control" name="payment_type_code" placeholder="Payment Type Code" value="" required> </div>
                                        <div class="form-group">
                                            <label for="name"> Charge<span style="color:red;">  * </span></label> <input type="number" min="0" class="form-control charge" name="charge" placeholder="Charge" value="" required> </div>
                                        <div class="form-group">
												<label for="isPct">Percentage</label>
												<select class="form-control m-bot15 select-isPct" name="isPct">
													<option value="false">No</option>
													<option value="true">Yes</option>
												</select>
											</div>   
                                            <div class="form-group"> <label for="phone"> Description</label> <textarea class="form-control" name="description" rows="2"></textarea> </div>
                                        <div class="form-group"> <label for="name"> Attach icon</label> <input type="file" class="form-control" accept=".png,.jpg,.jpeg,.gif" name="icon" /> <input type="checkbox" name="empty_icon"><label> Set empty icon</label><br> <label>
                                            <!--Max:800 X 800 | Min:165 X 114<br> -->
                Max file size:2 MB</label> </div>
                                        <div class="form-group"> <label for="name"> Attach Guide File</label> <input type="file" class="form-control" accept=".png,.jpg,.jpeg,.gif,.pdf,.doc,.docx" name="guide_file" /> <input type="checkbox" name="empty_guide_file"><label> Set empty Guide File</label><br>                                            <label> Min:165 X 114<br> Max file size:2 MB</label> </div>
                                        <div class="row ">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2"> <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp; Save</button> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateform" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"> <button aria-hidden="true" data-dismiss="modal" class="close" type="button"> ×</button>
                            <h4 class="modal-title"> Update
                                <?= $title?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?=base_url().'admin/update_chargepayment'?>">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-10">
                                        <div class="form-group"> <label for="name"> Payment Type Name<span style="color:red;">  * </span> </label> <input type="" class="form-control" id="u_name" name="payment_type_name" placeholder="Payment Type Name" value="" required> </div>
                                        <div class="form-group"> <label for="name"> Payment Type Code<span style="color:red;">  * </span> </label> <input type="number" class="form-control" id="u_paymenttype2" min="0" readonly placeholder="Payment Type Code" value="" required>                                            </div>
                                        <div class="form-group"> <label for="name"> Charge<span style="color:red;">  * </span></label> <input type="number" min="0" id="u_charge" class="form-control charge" name="charge" placeholder="Charge" value="" required> </div>
                                        <div class="form-group">
												<label for="isPct">Percentage</label>
												<select class="form-control m-bot15 select-isPct"  id="u_isPct" name="isPct">
													<option value="false">No</option>
													<option value="true">Yes</option>
												</select>
											</div>   
                                        <div class="form-group">
                                            <label for="phone"> Description</label> <textarea class="form-control" id="u_description" name="description" rows="2"></textarea> </div>
                                        <div class="form-group"> <label for="name"> Attach icon</label> <input type="file" class="form-control" accept=".png,.jpg,.jpeg,.gif" name="icon" /> <input type="hidden" id="u_icon" class="form-control" name="icon_old" /> <input type="checkbox"
                                                id="u_icon2" name="empty_icon"><label> Set empty icon</label><br> <label> <!--Max:800 X 800 | Min:165 X 114<br> -->
                Max file size:2 MB</label><br> <img id="img_icon" src "" height="115"> </div>
                                        <div class="form-group "> <label for="name"> Attach Guide File</label> <input type="file" class="form-control" accept=".png,.jpg,.jpeg,.gif,.pdf,.doc,.docx" name="guide_file" /> <input type="hidden" id="u_guidefile" class="form-control"
                                                name="guide_file_old" /> <input type="checkbox" name="empty_guide_file"><label> Set empty Guide File</label><br> <label> <!--Max:800 X 800 | Min:165 X 114<br> -->
                Max file size:2 MB</label><br>
                                            <div class="attach-file"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-11"> 
                                            <input type="hidden" id="u_id" name="idchargepayment" value=""> 
                                            <input type="hidden" id="u_paymenttype" name="payment_type_code" value="">
                                            <button type="submit" class="btn btn-primary pull-right"><i class="icon_floppy"></i>&nbsp; Save</button> 
                                         </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"> <button aria-hidden="true" data-dismiss="modal" class="close" type="button"> ×</button>
                            <h4 class="modal-title"> Delete
                                <?= $title?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p> Are you sure delete this point?</p>
                            <form method="post" action="<?=base_url().'admin/delete_chargepayment'?>"> <input type="hidden" name="idchargepayment" id="del_id" value=""> <button type="submit" class="btn btn-danger"> Sure</button> <button class="btn btn-info" data-dismiss="modal"> Cancel</button> </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>
<script type="text/javascript">
    //delete publictransport
    $(".delete-publictransport").click(function() {
        var id = $(this).attr("data-id");
        $("#del_id").prop("value", id);
    });
    $('.select-isPct').on('change', function (e) {
        var charge = $(this).attr("data-charge");
        
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if(valueSelected =="t"){        
            $("input[name='charge']").prop('min',0);
            $("input[name='charge']").prop('max',100);
        }else{        
            $("input[name='charge']").prop('min',0);
            $("input[name='charge']").prop('max',100000000000);
        }
    });

    $(".delete-publictransport").click(function() {
        var id = $(this).attr("data-id");
        $("#del_id").prop("value", id);
    });
    //update publictransport
    $(".update-form").click(function() {
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var paymenttype = $(this).attr("data-paymenttype");
        var charge = $(this).attr("data-charge");
        var description = $(this).attr("data-description");
        var icon = $(this).attr("data-iconImage");
        var guidefile = $(this).attr("data-guidefile");
        var isPct = $(this).attr("data-isPct");

        $("#img_icon").prop("src", icon);
        if (icon == "") {
            $("#u_icon2").prop("value", true);
            $("#img_icon").prop("src", "");
        }

        if (guidefile != "") {
            $("#u_guidefile_old").prop("href", guidefile);
            $(".attach-file").html('<a id="u_guidefile_old" href="' + guidefile + '">Download Here</a>');
        }
        $("#u_id").prop("value", id);
        $("#u_name").prop("value", name);
        $("#u_paymenttype").prop("value", paymenttype);
        $("#u_paymenttype2").prop("value", paymenttype);
        $("#u_charge").prop("value", charge);
        $("textarea#u_description").html(description);
        $("#u_icon").prop("value", icon);
        $("#u_guidefile").prop("value", guidefile);
        $("#u_isPct").val(isPct);        
    });
</script>