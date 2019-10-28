<section id="container" class="">
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
                      <th><i class="icon_globe"></i> Public Transport Code</th>
                      <th><i class="icon_map_alt"></i> Route</th>
                      <th><i class="icon_cogs"></i> Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                    <tr>
                      <td><?=$data_con[$i]['publictransportcode']?></td>
                      <td><?=$data_con[$i]['route']?></td>
                      <td>
                        <div class="btn-group">
                          <a data-toggle="modal" class="btn btn-success update-publictransport" href="#updateform" data-id="<?=$data_con[$i]['idpublictransportation']?>" data-idcity="<?=$data_con[$i]['idcity']?>" data-publictransportcode="<?=$data_con[$i]['publictransportcode']?>" data-route="<?=$data_con[$i]['route']?>" ><i class="icon_pencil" ></i></a>
                          <a data-toggle="modal" class="delete-publictransport btn btn-danger" href="#deleteform"  data-id="<?=$data_con[$i]['idpublictransportation']?>"><i class="icon_trash_alt"></i></a>
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
      </div>
    </div> 
  </div> 
</div>  
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Insert <?=$title?></h4>
      </div>
      <div class="modal-body">                       
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_publictransportation'?>">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <div class="form-group">
                <label for="name">Public Transport Code</label>
                <input type="" class="form-control" name="publictransportcode" placeholder="Public Transport Code" value="" required>
              </div>
              <div class="form-group">
                <label for="phone">Route</label>
                <textarea class="form-control" name="route" rows="2"></textarea>
                <label>Example : Aa - Bb - Cc</label>
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
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateform" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Update <?=$title?></h4>
      </div>
      <div class="modal-body">                       
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/update_publictransportation'?>">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <div class="form-group">
                <label for="name">Public Transport Code</label>
                <input type="" class="form-control" id="upublictransportcode" name="publictransportcode" placeholder="Public Transport Code" value="" required>
              </div>
              <div class="form-group">
                <label for="phone">Route</label>
                <textarea class="form-control" name="route" id="uroute" rows="2"></textarea>
                <label>Example : Aa - Bb - Cc</label>
              </div>
              <div class="row ">
                <div class="col-lg-10"></div>
                <div class="col-lg-2">
                  <input type="hidden" id="uidpublictransportation" name="idpublictransportation" value="">
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
        <form method="post" action="<?=base_url().'admin/delete_publictransportation'?>">
          <input type="hidden" name="idpublictransportation" id="del_id" value="">
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
<script type="text/javascript">
  //delete publictransport
  $(".delete-publictransport").click(function(){       
    var idpublictransportation = $(this).attr("data-id");
    $("#del_id").prop("value", idpublictransportation);
  });
    //update publictransport
    $(".update-publictransport").click(function(){       
      var idpublictransportation = $(this).attr("data-id");
      var idcity = $(this).attr("data-idcity");
      var publictransportcode = $(this).attr("data-publictransportcode");
      var route = $(this).attr("data-route");
      $("#uidpublictransportation").prop("value", idpublictransportation);
      $("#uidcity").prop("value", idcity);
      $("#upublictransportcode").prop("value", publictransportcode);
      $("textarea#uroute").html(route)
    });
  </script>