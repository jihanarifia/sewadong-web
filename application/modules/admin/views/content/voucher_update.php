<section id="container">
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                        <li><a href="<?=base_url().'admin/'.$link?>"> <?=$prev?></a></li>
                        <li class="active">Edit Voucher</li>
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
                            <form method="post" action="<?=base_url().'admin/voucher/fn_edit'?>"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Title" value="<?= $title ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title_id">Title Indonesia</label>
                                            <input type="text" class="form-control" name="title_id" id="title_id"
                                                placeholder="Title Indonesia" value="<?= $title_id ?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="point">Point</label>
                                                    <input type="number" min="0" class="form-control" id="point"
                                                        name="point" placeholder="Point" value="<?= $point ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="worth">Worth</label>
                                                    <input type="text" class="form-control" name="worth" id="worth"
                                                        placeholder="Worth" value="<?= $worth ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="stock">Stock</label>
                                                    <input type="number" min="0" class="form-control" id="stock"
                                                        name="stock" placeholder="Available" value="<?= $available ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="redeem">Redeemed Voucher</label>
                                                    <input type="number" class="form-control" id="redeem" name="redeem"
                                                        placeholder="redeem" value="<?= $reedem_voucher ?>" readonly>
                                                </div>
                                            </div>
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
                                                        <option <?= $type == $item->type_name ? "selected" : "" ?>
                                                            value="<?php echo $item->id ?>">
                                                            <?php echo $item->type_name ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="stock">OVO Point</label>
                                                    <input type="number" class="form-control" id="ovopoint"
                                                        name="ovopoint" value="<?= $ovopoint ?>"
                                                        placeholder="OVO Point">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="activation_code">Activation Code</label>
                                            <input type="text" class="form-control" name="activation_code"
                                                id="activation_code" placeholder="Activation Code"
                                                value="<?= $activation_code ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="tenantsname">Tenant</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tenantsname"
                                                    name="tenantsname" style="display: flex;" placeholder="Tenant"
                                                    value="<?= $tenantsname ?>" disabled>
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
                                                    placeholder="Expired Date" id="expireddate" min="<?=date("Y-m-d")?>"
                                                    value="<?= $expireddate ?>" required>
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="expiredtime"
                                                        placeholder="Expired Time" id="expiredtime"
                                                        value="<?= $expiredtime ?>" required>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="created">Created Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="createddate"
                                                    placeholder="Created Date" id="createddate"
                                                    value="<?= $createddate ?>" readonly>
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="createdtime"
                                                        placeholder="Created Time" id="createdtime"
                                                        value="<?= $createdtime ?>" readonly>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="avatar">Image</label>
                                            <input type="file" name="image[]" id="image[]" multiple="multiple"
                                                class="form-control image" accept="image/*" />
                                            <label id="lblmaximage">You can upload max 3 image<br>Max: 800 X 800 | Max file size: 2 MB</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="description"
                                                    id="description" rows="2"><?=$description?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="useof">Use of Voucher</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="useof" id="useof"
                                                    rows="2"><?= $howtouse ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="terms">Terms of Voucher</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="terms" id="terms"
                                                    rows="2"><?= $terms ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="description_id">Description Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="description_id"
                                                    id="description_id" rows="2"><?=$description_id?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="useof_id">Use of Voucher Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="useof_id" id="useof_id"
                                                    rows="2"><?= $howtouse_id ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="terms_id">Terms of Voucher Indonesia</label>
                                            <div>
                                                <textarea class="form-control ckeditor" name="terms_id" id="terms_id"
                                                    rows="2"><?= $terms_id ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-offset-10 col-lg-2">
                                        <textarea class="form-control" name="tempimage" id="tempimage" rows="2"
                                            style="display:none;"><?=join(",",$image)?></textarea>
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?=$id?>">
                                        <input type="hidden" class="form-control" id="idtenant" name="idtenant"
                                            value="<?=$idtenant?>">
                                        <input type="hidden" name="title_page" value="<?=$title_page?>">
                                        <input type="hidden" name="ref" id="ref" value="<?=$ref?>">
                                        <button type="submit" name="inserttenant" id="inserttenant"
                                            class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h3>Gallery</h3>
                        </header>
                        <div class="panel-body">
                            <input type="hidden" name="countimage" id="countimage" value="<?=count($image)?>">
                            <?php
                                foreach($image as $img){
                            ?>
                            <img src="<?=$img?>" width="200" heigh="200"> &nbsp;
                            <?php
                                }
                            ?>
                        </div>
                    </section>
                </div>
            </div>

            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalActivationCode"
                class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" id="btnModalActivationCode" data-dismiss="modal" class="close"
                                type="button">×
                            </button>
                            <h4 class="modal-title">Activation Code <?= $title ?></h4>
                        </div>
                        <div class="modal-body">
                            <p>Activation Code : <?= $activation_code?></p>
                        </div>
                    </div>
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

var ref = document.getElementById('ref').value;
var activation_code = document.getElementById('activation_code').value;

var modalAlert = document.getElementById('modalAlert');
var modalActivationCode = document.getElementById('modalActivationCode');
var hasOpen = localStorage.getItem("hasOpen");
if (ref == "1") {
    if (hasOpen == "false") {
        if (activation_code != "" && activation_code != null && activation_code != undefined) {
            modalActivationCode.style.display = "block";
            modalActivationCode.className = "modal fade in";
            modalActivationCode.setAttribute('aria-hidden', 'false');
            localStorage.setItem("hasOpen", true);
        }
    }
}

$("#btnModalActivationCode").click(function() {
    modalActivationCode.style.display = "none";
    modalActivationCode.setAttribute('aria-hidden', 'true');
})

$("#btnModalAlert").click(function() {
    modalAlert.style.display = "none";
    modalAlert.setAttribute('aria-hidden', 'true');
})

var countimage = document.getElementById('countimage').value;
var maximage = 3;
if ((maximage - countimage) == 0) {
    document.getElementById('lblmaximage').innerHTML = 'You can\'t upload a files';
} else {
    document.getElementById('lblmaximage').innerHTML = 'You can upload max ' + (maximage - countimage) +
        ' image<br>Max: 800 X 800 | Max file size: 2 MB';
}

$(document).ready(function() {
    worthSeparator();
});

$("input[type='file']").change(function() {
    var $fileUpload = $("input[type='file']");

    if ((maximage - countimage) == 0) {
        $("#modalAlert #alertMsg").text("You have reached limit to upload image");
        modalAlert.style.display = "block";
        modalAlert.className = "modal fade in";
        modalAlert.setAttribute('aria-hidden', 'false');
        $fileUpload.get(0).value = "";
    } else if (parseInt($fileUpload.get(0).files.length) > (maximage - countimage)) {
        $("#modalAlert #alertMsg").text("You can only upload a maximum of " + (maximage - countimage) + " files");
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
var tempovopoint, tempregpoint;
if (document.getElementById('type').value == "1") {
    ovopoint.disabled = false;
    ovopoint.required = true;
    tempovopoint = ovopoint.value;
} else {
    ovopoint.disabled = true;
    ovopoint.required = false;
    tempregpoint = ovopoint.value;
}

$("#type").change(function() {
    if (document.getElementById('type').value == "1") {
        ovopoint.value = tempovopoint;
        ovopoint.disabled = false;
        ovopoint.required = true;
    } else {
        ovopoint.value = tempregpoint;
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

function worthSeparator(event) {
    $this = $("#worth");
    var input = $this.val();

    if (input !== 0)
        input = input.replace(/[\D\s\._\ - ] +/g, "");

    input = input ? parseInt(input, 10) : 0;
    $this.val(function() {
        return (input === 0) ? "0" : input.toLocaleString("en-US");
    });
}

function addtenant(idtenant, tenantsname, categoryname) {
    document.getElementById("idtenant").value = idtenant;
    document.getElementById("tenantsname").value = unescape(tenantsname);
    $('#addtenants').modal('toggle');
}
</script>