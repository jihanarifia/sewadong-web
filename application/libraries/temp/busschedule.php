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
                <table class="table table-responsive" id="data-table">
                  <thead>
                    <tr>
                      <th><i class="fa fa-bus"></i> Bus Route</th>
                      <th><i class="fa fa-bus"></i> Subroute</th>
                      <th><i class="fa fa-calendar-o"></i> Schedule</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($data_con)!=false && empty($data_con)==false) { $idroute = 0; $idsubroute = 0; foreach($data_con as $data) { ?>
                    <tr>
                      <?php if ($idroute + ' ' + $idsubroute !== $data->idroute + ' ' + $data->idsubroute) {?>
                          <td rowspan="<?= $data->daycount ?>"><?=$data->routename?></td>
                          <td rowspan="<?= $data->daycount ?>"><?=$data->subroutename?></td>
                      <?php }?>
                      <td><?=$data->dayname?><br><?= implode(' ', json_decode($data->array_departure))?></td>
                      <td>
                        <div class="btn-group">
                          <a data-toggle="modal" class="btn btn-success update-publictransport" href="#insertform" data-id="<?=$data->idbusschedule?>" data-idroute="<?=$data->idroute?>" data-dayname="<?=$data->dayname?>" data-iddayschedule="<?=$data->iddayschedule?>" data-route="<?=$data->routename?>" data-departure='<?= $data->array_departure?>' data-arrival='<?= $data->array_arrival?>' data-idsubroute="<?= $data->idsubroute?>" data-subroutename="<?= $data->subroutename?>" data-timecount="<?= $data->timecount?>"><i class="icon_pencil" ></i></a>
                          <a data-toggle="modal" class="delete-publictransport btn btn-danger" href="#deleteform"  data-idroute="<?=$data->idroute?>" data-iddayschedule="<?= $data->iddayschedule?>" data-idsubroute="<?=$data->idsubroute?>"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr>                         
                    <?php $idroute = $data->idroute; $idsubroute = $data->idsubroute; } } else { ?>
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
        <button aria-hidden="true" data-dismiss="modal" class="close" id="closebus" type="button">×</button>
        <h4 class="modal-title">Insert <?=$title?></h4>
      </div>
      <div class="modal-body">                       
        <form class="form-horizontal" id="busScheduleForm" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_bus'?>">
          <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
              <div class="form-group">
                <label for="name">Bus Route</label>
                <!-- <input type="" class="form-control" name="busroute" placeholder="Bus Route" value="" required> -->
                <select name="busroute" id="busroute" required class="form-control">
                  <option value="" selected disabled>Select Route</option>                                      
                  <?php
                  $i=0; foreach ($data_route as $item[]) { ?>
                    <option value="<?php echo $item[$i]['idroute']?>">
                      <?php echo $item[$i]['routename']?>
                    </option>   
                  <?php $i++;} ?>
                </select>   
              </div>
              <div class="form-group" id="subroute">
                <label for="name">Sub Route</label>
                <input type="text" class="form-control" name="subroute"  value="">
              </div>
              <div class="form-group" id="days">
                <label for="name">Days</label>
                <select class="form-control" name="days" required id="days">
                  <option value="" selected disabled>Select Days</option>                
                  <option value="1">MON-FRI</option>
                  <option value="2">SAT-SUN</option>
                </select>
              </div>
              <div class="form-group">
                <label for="name">Time</label>
                  <div name="starttimegroup[]">
                      <input type="time" class="form-control" name="starttime[]"  value="" required>
                  </div>
                <a href="javascript:void(0);" class="btn btn-primary" id="addtime_start" style="margin-top: 5px"><i class="icon_plus"></i></a>
              </div>
              <div class="form-group" id="end_time">
                <label for="name">End Time</label>
                  <div name="endtimegroup[]">
                      <input type="time" class="form-control" name="endtime[]"  value="">
                  </div>
                <a href="javascript:void(0);" class="btn btn-primary" id="addtime_end" style="margin-top: 5px"><i class="icon_plus"></i></a>
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

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Delete <?=$title?></h4>
      </div>
      <div class="modal-body">
        <p>Are you sure delete this point?</p>                          
        <form method="post" action="<?=base_url().'admin/delete_bus'?>">
          <input type="hidden" name="iddayschedule" id="del_iddayschedule" value="">
          <input type="hidden" name="idroute" id="del_idroute" value="">
          <input type="hidden" name="idsubroute" id="del_idsubroute" value="">
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
    var scheduleTimeCount = 0;
    function initializeCreateModal() {
        scheduleTimeCount = 0;
        $('#busroute').replaceWith("<select name='busroute' id='busroute' required class='form-control'><option value='' selected disabled>Select Route</option><?php foreach ($data_route as $item) { ?><option value='<?= $item['idroute']?>'><?= $item['routename']?></option><?php } ?></select>");
        $('#days').show();
        $('#busScheduleForm').attr('action', '<?=base_url() . 'admin/insert_bus'?>');

        $("#end_time").hide();
        $("#subroute").hide();
        $("#busroute").on("change", function(){
            var v = $(this).val();
            if (v == 4) {
                $("#end_time").show();
                $("#subroute").show();
            } else {
                $("#end_time").hide();
                $("#subroute").hide();
            }
        });

        $("#closebus").click(function(){
            $("#end_time").hide();
        });
    }


    //delete publictransport
    $(".delete-publictransport").click(function(){
      var idroute = $(this).attr("data-idroute");
      var iddayschedule = $(this).attr("data-iddayschedule");
      var idsubroute = $(this).attr("data-idsubroute");
      $("#del_idroute").prop("value", idroute);
      $("#del_iddayschedule").prop("value", iddayschedule);
      $("#del_idsubroute").prop("value", idsubroute);
    });
    //update publictransport
    $(".update-publictransport").click(function(){
      var idroute = $(this).attr("data-idroute");
      var iddayschedule = $(this).attr("data-idayschedule");
      var route = $(this).attr("data-route");
      var departure = JSON.parse($(this).attr("data-departure"));
      var arrival = JSON.parse($(this).attr("data-arrival"));
      var idsubroute = $(this).attr('data-idsubroute');
      var dayTimeCount = arrival.length;
      scheduleTimeCount = $(this).attr('data-timecount') - dayTimeCount;

      $('#busScheduleForm').attr('action', '<?=base_url() . 'admin/update_bus'?>');
      $('#insertform .modal-title').html('Edit ' + route);
      $('#busroute').replaceWith('<div id="busroute"><input type="text" class="form-control" value="' + route + '" readonly>' +
          '<input type="hidden" name="busroute" value="' + idroute + '"/><input type="hidden" name="idsubroute" value="' + idsubroute + '" /></div>');
      $('#days').hide();
      $('select[name="days"]').val($(this).attr("data-iddayschedule"));
      $('input[name="starttime[]"]').eq(0).val(departure[0]);
      for(var i = 1 ; i < departure.length ; i++) {
          addTime('start');
          $('input[name="starttime[]"]').eq(i).val(departure[i]);
      }
      if (idroute == 4) {
          $("#end_time").show();
          $("#subroute").show();
          $('input[name="subroute"]').val($(this).attr("data-subroutename"));

          $('input[name="endtime[]"]').eq(0).val(arrival[0]);
          for(var i = 1 ; i < arrival.length ; i++) {
              addTime('end');
              $('input[name="endtime[]"]').eq(i).val(arrival[i]);
          }
      }
    });
    $("#addtime_start").click(function() {
       addTime('start');
    });
    $("#addtime_end").click(function() {
        addTime('end');
    });

    function addTime(type = 'start') {
        var selector = $('div[name="' + type + 'timegroup[]"]');
        selector.last().after('<div style="margin-top: 12px">' +
            '</div><div class="input-group" name="' + type + 'timegroup[]"><input type="time" class="form-control" name="' + type + 'time[]"  value=""><span class="input-group-btn">' +
            '<button type="button" onclick="deltime(this.parentNode.parentNode)" class="btn btn-danger" name="deltime_' + type + '[]"><i class="icon_trash"></i></button>' +
            '</span></div>');
        var selector1 = $('input[name="' + type + 'time[]"]');
        selector1.last().hide();
        selector1.last().slideDown("fast", function(){});
        var selector2 = $('button[name="deltime_' + type + '[]"]');
        selector2.last().hide();
        selector2.last().slideDown("fast", function(){});
    }

    var validator = null;

    $('#insertform').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $("div[name=\"starttimegroup[]\"]:gt(0)").remove();
        $("div[name=\"endtimegroup[]\"]:gt(0)").remove();
        $('#insertform .modal-title').html('Insert <?=$title?>');
        validator.resetForm();
        initializeCreateModal();
    });

    $(document).ready(function() {
        var checktime = function() {
            var valid = true;
            var starttimelength = $('div[name="starttimegroup[]"]').length;
            if ($('#end_time').is(":visible")) {
                var endtimelength = $('div[name="endtimegroup[]"]').length;
                if (starttimelength > endtimelength) {
                    swal("Invalid form!", "End time missing!", "error");
                    return false;
                }
                if (starttimelength < endtimelength) {
                    swal("Invalid form!", "Start time missing!", "error");
                    return false;
                }
                $.each($('input[name="starttime[]"]'), function(i, val) {
                    if ($('input[name="endtime[]"]').get(i).value === '') {
                        valid = false;
                        swal("Invalid form!", "End time is required!", "error");
                    }
                });
                if ($('input[name="subroute"]').val() === '') {
                    valid = false;
                    swal('Invalid form!', "Subroute missing!", 'error');
                }
            }
            if (starttimelength /*+ scheduleTimeCount*/ > 48) {
                valid = false;
                swal('Invalid form!', "Time can't be more than 48", 'error');
            }


            return valid;
        };

        initializeCreateModal();

        validator = $('#busScheduleForm').validate({
            rules: {
                "starttime[]": "required"
            },
            messages: {
                "starttime[]": "Please enter start time",
            },
            submitHandler: function(form) {
                if (checktime()) {
                    form.submit();
                }
            }
        });
    });


    function deltime(el) {
        $(el).remove();
    }


</script>