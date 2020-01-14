<section id="container">
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                        <li><a href="<?=base_url().'admin/'.$link?>"> <?=$prev?></a></li>
                        <li class="active">Create Voucher</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <?php if ($this->session->flashdata('activationcode')) { ?>
            <div class="alert alert-success fade in" id="alert">
                <?php echo $this->session->flashdata('activationcode'); ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-success fade in" id="alert">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('breakmessage')) { ?>
            <div class="alert alert-block alert-danger fade in" id="alert">
                <?php echo $this->session->flashdata('breakmessage'); ?>
            </div>
            <?php } ?>

            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addtenants"
                class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Add Tenant</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="margin:5px;">
                                <label for="keyword">Keyword</label>
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    placeholder="Search tenant in here..." required>
                            </div>
                            <div class="row">
                                <div class="col-lg-9"></div>
                                <div class="col-lg-2">
                                    <button name="btnkeyword" class="btn btn-primary btnkeyword"><i
                                            class="icon_search"></i>&nbsp;Search</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="data-table">
                                    <thead>
                                        <tr>
                                            <th><i class="icon_tag_alt"></i> Tenant</th>
                                            <th><i class="icon_link"></i> Category</th>
                                            <th><i class="icon_cogs"></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?=$title_page?>
                        </header>
                        <div class="panel-body">
                            <form method="post" action="<?=base_url().'admin/voucher/fn_create'?>"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_id">Title Indonesia</label>
                                            <input type="text" class="form-control" name="title_id" id="title_id"
                                                placeholder="Title Indonesia" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="point">Point</label>
                                            <input type="number" min="0" class="form-control" id="point" name="point"
                                                placeholder="Point" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" min="0" class="form-control" id="stock" name="stock"
                                                placeholder="Stock" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tenantsname">Tenant</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tenantsname"
                                                    name="tenantsname" style="display: flex;" placeholder="Tenant"
                                                    disabled>
                                                <span class="input-group-btn">
                                                    <a href="#addtenants" data-toggle="modal" type="button"
                                                        class="btn btn-primary" name="searchtenant"
                                                        style="display: inline-block;">
                                                        <i class="icon_search"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="expired">Expired Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="expireddate"
                                                    placeholder="Expired Date" min="<?=date("Y-m-d")?>" id="expireddate"
                                                    required>
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="expiredtime"
                                                        placeholder="Expired Time" id="expiredtime" required>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="avatar">Image</label>
                                            <input type="file" name="image[]" id="image[]" multiple="multiple" max="3"
                                                class="form-control image" accept="image/*" required />
                                            <label id="lblmaximage">You can upload max 3 image<br>Max: 800 X 800 | Max file size: 2 MB</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select style="text-transform: uppercase;"
                                                        class="form-control m-bot15" name="type" id="type" required>
                                                        <?php
                                                            foreach ($objType as $item) {
                                                                ?>
                                                        <option value="<?php echo $item->id?>">
                                                            <?php echo $item->type_name?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="ovopoint">OVO Point</label>
                                                    <input type="number" min="1" class="form-control" id="ovopoint"
                                                        name="ovopoint" placeholder="OVO Point">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="description"
                                                    id="description" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="useof">Use of Voucher</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="useof" id="useof"
                                                    rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="terms">Terms of Voucher</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="terms" id="terms"
                                                    rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="description_id">Description Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="description_id"
                                                    id="description_id" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="useof_id">Use of Voucher Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="useof_id" id="useof_id"
                                                    rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="terms_id">Terms of Voucher Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="terms_id" id="terms_id"
                                                    rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-offset-10 col-lg-2">
                                        <input type="hidden" class="form-control" id="idtenant" name="idtenant">
                                        <input type="hidden" name="title_page" value="<?=$title_page?>">
                                        <button type="submit" name="inserttenant" id="inserttenant"
                                            class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <div aria-hidden="true" aria-labelledby="alertModal" role="dialog" tabindex="-1" id="modalAlert"
                class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" id="btnModalAlert" data-dismiss="modal" class="close"type="button">×</button>
                            <h4 class="modal-title">Warning!</h4>
                        </div>
                        <div class="modal-body">
                            <p id="alertMsg">Sorry, there's something wrong</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
</section>

<script type="text/javascript">
$("form").submit(function() {
    var descriptionLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
    var description_idLength = CKEDITOR.instances['description_id'].getData().replace(/<[^>]*>/gi, '').length;
    var useofLength = CKEDITOR.instances['useof'].getData().replace(/<[^>]*>/gi, '').length;
    var useof_idLength = CKEDITOR.instances['useof_id'].getData().replace(/<[^>]*>/gi, '').length;
    var termsLength = CKEDITOR.instances['terms'].getData().replace(/<[^>]*>/gi, '').length;
    var terms_idLength = CKEDITOR.instances['terms_id'].getData().replace(/<[^>]*>/gi, '').length;
    if (!descriptionLength || !description_idLength) {
        alert('Please enter a description voucher');
        return false;
    } else if (!useofLength || !useof_idLength) {
        alert('Please enter a use of voucher');
        return false;
    } else if (!termsLength || !terms_idLength) {
        alert('Please enter a term of voucher');
        return false;
    }
})

var hasOpen = localStorage.getItem("hasOpen");
localStorage.setItem("hasOpen", false);

var modalAlert = document.getElementById('modalAlert');
$("#btnModalAlert").click(function() {
    modalAlert.style.display = "none";
    modalAlert.setAttribute('aria-hidden', 'true');
})

$("input[type='file']").change(function() {
    var $fileUpload = $("input[type='file']");

    if (parseInt($fileUpload.get(0).files.length) > 3) {
        $("#modalAlert #alertMsg").text("You have reached limit to upload image");
        modalAlert.style.display = "block";
        modalAlert.className = "modal fade in";
        modalAlert.setAttribute('aria-hidden', 'false');
        $fileUpload.get(0).value = "";
    } else {
        var _URL = window.URL || window.webkitURL;
        var file = $(this)[0].files[0];

        img = new Image();
        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 800;
        var maxheight = 800;

        img.src = _URL.createObjectURL(file);
        img.onload = function() {
            imgwidth = this.width;
            imgheight = this.height;
        
            if(imgwidth >= maxwidth || imgheight >= maxheight){
                $("#modalAlert #alertMsg").text("Image dimensions must be under 800 x 800 pixels");
                modalAlert.style.display = "block";
                modalAlert.className = "modal fade in";
                modalAlert.setAttribute('aria-hidden', 'false');
                $fileUpload.get(0).value = "";
            }
        }
    }
});

var ovopoint = document.getElementById("ovopoint");
ovopoint.required = true;
ovopoint.disabled = false;
$("#type").change(function() {

    var typeVoucher = document.getElementById('type').value;
    if (typeVoucher === "1") {
        ovopoint.disabled = false;
        ovopoint.required = true;
    } else {
        ovopoint.disabled = true;
        ovopoint.required = false;
    }
})

$(".btnkeyword").click(function() {
    var keyword = document.getElementById('keyword').value;
    var url = encodeURI("<?php echo base_api(); ?>Tenant/?action=listalltenant&keyword=" + keyword +
        "&pagenumber=1&pagesize=1000");
    var data_key = [];
    $("#data-table").dataTable().fnDestroy();

    $.ajax({
        type: "get",
        url: decodeURI(url),
        success: function(data) {
            var html = '';
            if (data[0].status != "failed") {
                data_key = {
                    "draw": 1,
                    "recordsTotal": data.length,
                    "recordsFiltered": 10,
                    "data": data
                };

                var tr;
                for (var i = 0; i < data_key.data.length; i++) {
                    html += '<tr>' +
                        '<td>' + data_key.data[i].tenantsname + '</td>' +
                        '<td>' + data_key.data[i].categoryname + '</td>' +
                        '<td >' +
                        '<a class="btn btn-primary addtenant" onclick="addtenant(' + data_key.data[
                            i].idtenant + ',\'' + escape(data_key.data[i].tenantsname) + '\',\'' +
                        data_key.data[i].categoryname +
                        '\')" style="margin-top: 5px"><i class="icon_plus"></i></a>' +
                        '</td>' +
                        '</tr>';
                }
                $("#show_data").html(html);
            }

            $('#data-table').dataTable({
                processing: true,
                paging: true
            });
        }
    });
})

function addtenant(idtenant, tenantsname, categoryname) {
    document.getElementById("idtenant").value = idtenant;
    document.getElementById("tenantsname").value = unescape(tenantsname);
    $('#addtenants').modal('toggle');
}
</script>