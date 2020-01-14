<section id="container">
	<section id="main-content">
		<section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--breadcrumbs start -->
					<ul class="breadcrumb">
						<li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>						
						<li><a href="<?=base_url().'admin/'.$link?>"> <?=$title_page?></a></li>
						<li class="active">Create rule</li>
					</ul>
					<!--breadcrumbs end -->
				</div>
            </div>
            <?php if($this->session->flashdata('disabledate')) { ?> 
                <div class="alert alert-success fade in" id="alert">
                    <?php echo $this->session->flashdata('disabledate'); ?>
                </div> 
            <?php } ?>
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<?=$title?>
						</header>
						<div class="panel-body">
							<form method="post" action="<?=base_url().'admin/rule/fn_insert_point_rule'?>" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="title">Title</label>
											<input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
                                        </div>
                                        <div class="form-group">
											<label for="title_id">Title Indonesia</label>
											<input type="text" class="form-control" name="title_id" id="title_id" placeholder="Title Indonesia" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea rows="4" cols="50" id="description" class="form-control" name="description" required></textarea>
                                        </div>
                                        <div class="form-group">
											<label for="description_id">Description Indonesia</label>
                                            <textarea rows="4" cols="50" id="description_id" class="form-control" name="description_id" required></textarea>
										</div>
										<div class="form-group">
											<label for="point">Point</label>
											<input type="number" min="0"  class="form-control"  id="point" name="point" placeholder="Point" required>
										</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="active">Active</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="active" value="true" checked required>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="active" value="false" required>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select class="form-control m-bot15" name="type" required>
                                                <?php
                                                    foreach ($objType as $item) {
                                                        ?>
                                                        <option value="<?php echo $item->idtype?>">
                                                            <?php echo $item->type?>
                                                        </option> 	
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="validfrom">Valid From</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="validfromdate" placeholder="Valid From Date" id="validfromdate">
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="validfromtime" placeholder="Valid From Time" id="validfromtime">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="validuntil">Valid Until</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="validuntildate" placeholder="Valid Until Date" id="validuntildate">
                                                <span class="input-group-btn">
                                                    <input type="time" class="form-control" name="validuntiltime" placeholder="Valid Until Time" id="validuntiltime">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" style="width: 2vw; height: 2.5vh;" id="disable_date" name="disable_date" >
                                            <label>Valid all the time</label>
                                        </div>
                                        <div class="form-group limit_rule" style="display:none">
                                            <label for="limit">Limit</label>
											<input type="number" min="1" value="1" class="form-control" id="limit" name="limit" placeholder="Rule limit" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" style="width: 2vw; height: 2.5vh;" id="limit_rule" name="is_limit_rule" >
                                            <label>Limit rule</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="uniqueCode">Unique Code</label>
                                            <input type="text" class="form-control" name="uniqueCode" id="uniqueCode" placeholder="Unique Code" value="<?= $uniqueCode ?>" disabled>
                                        </div>
                                        <input type="hidden" class="form-control" name="idtenant" id="idtenant"  value="">
                                        <input type="hidden" class="form-control" name="uniquecode" id="uniquecode" value="<?= $uniqueCode ?>">
                                    </div>
                                <div class="row">
                                    <div class="col-lg-offset-10 col-lg-2">
                                        <input type="hidden" name="title_page" value="<?=$title_page?>">
                                        <button type="submit" name="inserttenant" id="inserttenant" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            
						</section>
					</div>
                </div>
                <div class="row">
				    <div class="col-lg-6">
                        <header class="panel-heading">
							Add Tenant
                        </header>
					    <section class="panel">
						    <div class="panel-body">
                                <div class="form-group" style="margin:5px;">
                                    <label for="keyword">Keyword</label>
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword" required>                           
                                </div>
                                <div class="row">
                                    <div class="col-lg-9"></div>
                                    <div class="col-lg-2">
                                        <button name="btnkeyword" class="btn btn-primary btnkeyword"><i class="icon_search"></i>&nbsp;Search</button>
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
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <header class="panel-heading">
							Tenant
						</header>
					    <section class="panel">
						    <div class="panel-body">
                                <div class="tenantgroup" name="starttenantgroup[]">
                                    <input type="text" class="form-control" name="starttenant[]" id="starttenant[]"  value="" disabled>
                                </div>
                            </div>
						</section>

                        <header class="panel-heading">
                            Generate QR Code
                        </header>
                        <section class="panel">
                            <div class="panel-body">
                                <div class="row" style="margin: 5px;">
                                    <label >If you need QR Code, please Generate QR Code first in below</label>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <a id="generateqrcode" name="generateqrcode" class="btn btn-primary " style="margin-bottom: 10px;"><i class="icon_grid-2x2"></i>&nbsp;Generate QR Code</a>
                                            <div id="downloadallqr">
                                                
                                            </div>
                                            <div id="qrcode">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
						</section>
					</div>
                </div>
            </div>
        </div>
	</section>
</section>
</section>
<script type="text/javascript">
    var arrayTenant = [];
    var arrayidTenant = [];
    $(".tenantgroup").hide();
    // $("#qrcode").hide();
    // $("#downloadallqr").hide();
    $("#generateqrcode").click(function() {  
        $("#qrcode").empty();
        $("#downloadallqr").empty();
        var uniquecode = document.getElementById('uniqueCode');
        var allidtenant = [];
        var alltenantname = [];
        var width = 250;
        var height = 250;
        if(arrayTenant.length > 0){
            for(var i=0;i<arrayTenant.length;i++){
                var divrow = document.createElement("div");
                divrow.className = "row tenants";
                
                var divcol1 = document.createElement("div");
                divcol1.className = "col-lg-6";
                var img = document.createElement("img");
                var url = btoa('{"uniqueCode":"'+uniquecode.value+'","tenant":"'+arrayTenant[i].idtenant+'"}');
                img.src = 'http://chart.apis.google.com/chart?chs='+width+'x'+height+'&cht=qr&chld=L|2&chl='+url;
                divcol1.appendChild(img);

                var divcol2 = document.createElement("div");
                divcol2.className = "col-lg-5";

                var divrowtenant1 = document.createElement("div");
                divrowtenant1.className = "row";
                divrowtenant1.innerHTML = arrayTenant[i].tenantsname;

                var divrowtenant2 = document.createElement("div");
                divrowtenant2.className = "row";
                var divrowa = document.createElement("a");
                divrowa.className = "btn btn-primary";
                divrowa.style.marginBottom  = "10px";
                divrowa.innerHTML = "Download QR Code ";
                divrowa.href = "<?php echo base_url(); ?>admin/rule/forceDownloadQR?dataqrcode="+uniquecode.value+"&tenant="+arrayTenant[i].idtenant+"&tenantsname=\""+encodeURIComponent(arrayTenant[i].tenantsname)+"\""
                var divrowi = document.createElement("i");
                divrowi.className = "icon_download";

                divrowa.appendChild(divrowi);
                divrowtenant2.appendChild(divrowa);

                divcol2.appendChild(divrowtenant1);
                divcol2.appendChild(divrowtenant2);

                divrow.appendChild(divcol1);
                divrow.appendChild(divcol2);
                var qrcode = document.getElementById("qrcode");
                qrcode.appendChild(divrow);

                allidtenant.push(arrayTenant[i].idtenant)
                alltenantname.push(arrayTenant[i].tenantsname)
            }
            
            var divallqr = document.createElement("a");
            divallqr.className = "btn btn-primary";
            divallqr.innerHTML = "Download All QR Code ";
            divallqr.href = "<?php echo base_url(); ?>admin/rule/downloadAllQR?dataqrcode="+uniquecode.value+"&tenant="+allidtenant+"&tenantsname="+encodeURIComponent(alltenantname.join(';'))+"";
            var downloadallqr = document.getElementById("downloadallqr");
            downloadallqr.appendChild(divallqr);
        }else{
            var divrow = document.createElement("div");
            divrow.className = "row tenants";
            
            var divcol1 = document.createElement("div");
            divcol1.className = "col-lg-6";
            var img = document.createElement("img");
            var url = btoa('{"uniqueCode":"'+uniquecode.value+'"}');
            img.src = 'http://chart.apis.google.com/chart?chs='+width+'x'+height+'&cht=qr&chld=L|2&chl='+url;
            divcol1.appendChild(img);

            var divcol2 = document.createElement("div");
            divcol2.className = "col-lg-5";

            var divrowtenant1 = document.createElement("div");
            divrowtenant1.className = "row";

            var divrowtenant2 = document.createElement("div");
            divrowtenant2.className = "row";
            var divrowa = document.createElement("a");
            divrowa.className = "btn btn-primary";
            divrowa.style.marginBottom  = "10px";
            divrowa.href = "<?php echo base_url(); ?>admin/rule/forceDownloadQR?dataqrcode="+uniquecode.value+"&tenant=&tenantsname=";
            divrowa.innerHTML = "Download QR Code ";
            var divrowi = document.createElement("i");
            divrowi.className = "icon_download";

            divrowa.appendChild(divrowi);
            divrowtenant2.appendChild(divrowa);

            divcol2.appendChild(divrowtenant1);
            divcol2.appendChild(divrowtenant2);

            divrow.appendChild(divcol1);
            divrow.appendChild(divcol2);
            var qrcode = document.getElementById("qrcode");
            qrcode.appendChild(divrow);
        }
        
        // $("#qrcode").show();
        // $("#downloadallqr").show();
    });
    
    // var validuntil = document.getElementById("validuntil");
    // var validfrom = document.getElementById("validfrom");

    var validfromdate = document.getElementById('validfromdate');
    var validfromtime = document.getElementById('validfromtime');
    var validuntildate = document.getElementById('validuntildate');
    var validuntiltime = document.getElementById('validuntiltime');
    
    $("#disable_date").click(function() {
        var cb = document.querySelectorAll('input[name="disable_date"]:checked');
        if(cb.length > 0){
            // validuntil.disabled = true;
            // validfrom.disabled = true;
            // validuntil.value = null;
            // validfrom.value = null;
            
            validfromdate.disabled = true;
            validfromtime.disabled = true;
            validfromdate.value = null;
            validfromtime.value = null;
            
            validuntildate.disabled = true;
            validuntiltime.disabled = true;
            validuntildate.value = null;
            validuntiltime.value = null;

            // validuntil.required = false;
            // validfrom.required = false;
        }else{
            // validuntil.disabled = false;
            // validfrom.disabled = false;
            
            validfromdate.disabled = false;
            validfromtime.disabled = false;
            validuntildate.disabled = false;
            validuntiltime.disabled = false;

            // validuntil.required = true;
            // validfrom.required = true;
        }
    });

    $("#limit_rule").click(function() {
        var cb = document.querySelectorAll('input[name="is_limit_rule"]:checked');
        if(cb.length > 0){
            $(".limit_rule").show();
        }else{
            $(".limit_rule").hide();
        }
    });

    $(".btnkeyword").click(function(){
        var keyword = document.getElementById('keyword').value;
        var url = encodeURI("<?php echo base_api(); ?>Tenant/?action=listalltenant&keyword="+keyword+"&pagenumber=1&pagesize=1000");
        var data_key = [];
        $("#data-table").dataTable().fnDestroy();

        $.ajax({
            type:"get",
            url: decodeURI(url),
            success: function (data) {
                var html = '';
                if(data[0].status != "failed"){
                    data_key =  {
                        "draw": 1,
                        "recordsTotal": data.length,
                        "recordsFiltered": 10,
                        "data": data
                    };

                    var tr;
                    for (var i = 0; i < data_key.data.length; i++) {
                        html += '<tr>'+
                                    '<td>'+data_key.data[i].tenantsname+'</td>'+
                                    '<td>'+data_key.data[i].categoryname+'</td>'+
                                    '<td >'+
                                        '<a class="btn btn-primary addtenant" onclick="addtenant('+data_key.data[i].idtenant+',\''+escape(data_key.data[i].tenantsname)+'\',\''+data_key.data[i].categoryname+'\')" style="margin-top: 5px"><i class="icon_plus"></i></a>'+
                                    '</td>'+
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

    function addtenant(idtenant,tenantsname,categoryname){
        
        $("#qrcode").empty();
        $("#downloadallqr").empty();
        var type = 'start';
        var idn = arrayidTenant.indexOf(idtenant);
        if(idn == -1) {
            arrayidTenant.push(idtenant);
            arrayTenant.push({
                "idtenant": idtenant,
                "categoryname" : categoryname,
                "tenantsname" : unescape(tenantsname)
            })
            document.getElementById('idtenant').value = arrayidTenant;
            
            var selector = $('div[name="' + type + 'tenantgroup[]"]');
            selector.last().after('<div style="margin-top: 12px">' +
                '</div><div class="input-group" name="' + type + 'tenantgroup[]" value="'+idtenant+'"><input type="text" class="form-control" name="' + type + 'tenant[]"  value="'+unescape(tenantsname)+'" disabled><span class="input-group-btn">' +
                '<button type="button" onclick="deltenant_(this.parentNode.parentNode,'+idtenant+')" class="btn btn-danger" name="deltenant__' + type + '[]"><i class="icon_trash"></i></button>' +
                '</span></div>');
            var selector1 = $('input[name="' + type + 'tenant[]"]');
            selector1.last().hide();
            selector1.last().slideDown("fast", function(){});
            var selector2 = $('button[name="deltenant_' + type + '[]"]');
            selector2.last().hide();
            selector2.last().slideDown("fast", function(){});
        }else{
            alert("Tenant sudah ada");
        }
    }
    
    function deltenant_(el,tenant) {
        $("#qrcode").empty();
        $("#downloadallqr").empty();
        var index = arrayidTenant.indexOf(tenant); 
        if (index > -1) {
            arrayidTenant.splice(index, 1);
            document.getElementById('idtenant').value = arrayidTenant;
        }

        var idxTenant = arrayTenant.findIndex(x=>x.idtenant === tenant)
        if (idxTenant > -1) {
            arrayTenant.splice(idxTenant, 1);
        }
        $(el).remove();
    }
</script>
