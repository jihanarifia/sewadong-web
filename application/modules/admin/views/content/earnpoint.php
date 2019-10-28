<style>
  label {
    color: grey;
  }
</style>
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
            <li class="active">Earn Point</a></li>
        </ul>
      <!--breadcrumbs end -->
      </div>
    </div>
  <div class="row">
    <div class="col-lg-12">
      <h3> Earn Point</h3>
      <section class="panel">
        <header class="panel-heading">
          <div class="row">
            <div class="col col-lg-12">
              <form role="form" action="<?=base_url().'admin/show_earnpoint'?>" method="post" id="myform">
                <table>
                  <tr>
                    <td style="padding-left:20px; padding-top:5px;"> <label>View Transaction from : </label></td>
                    <td style="padding-left:12px;"> <input onfocus="(this.type='date')" value="<?php echo $parameter['startDate'];?>" id="startdate" name="startdate" class="form-control" placeholder="Start Date" min="2017-09-05" max="<?php echo date('Y-m-d');?>" ></td>
                    <td style="padding-left:15px;  padding-top:5px;"> <label>to : </label></td>
                    <td style="padding-left:12px;"> <input onfocus="(this.type='date')" value="<?php echo $parameter['endDate'];?>" id="enddate" name="enddate" class="form-control" placeholder="End Date" min="2017-09-05" max="<?php echo date('Y-m-d');?>" ></td>
                    <td style="padding-left:15px;  padding-top:5px;"></td>
                    <td style="padding-left:15px;"><input type="submit" class="btn" id="btn_submit" disabled="disabled" name="btn_submit" value="Submit" style="color:white"/></td>
                    </form>
                    <td style="padding-left:15px;">
                      <button class="btn" disabled="disabled" id="btn_export">
                        <a style="text-decoration:none; color:white" id="textExport">
                          Export to Excel
                        </a>
                      </button>
                    </td>
                  </tr>
                </table>    
            </div>  
          </div>
        </header>
      <div class="table-responsive">
        <table class="table table-striped table-advance table-hover" id="data-table" name="data-table">
          <thead>
            <tr>
              <th>Transaction Date</th>
              <th>Email</th>
              <th>Loyalty Points Redeemed</th>
              <th>Status</th>
              <th>OVO ID</th>
              <th>OVO Points Received</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?> 
            <?php if ($data_con[$i]['IsDuplicate'] == 0) { ?>
            <tr>
              <td data-sort="<?=$data_con[$i]['transactionDateOld']?>"><?=$data_con[$i]['transactionDate']?></td>
              <td><?=$data_con[$i]['email']?></td>
              <td><?=$data_con[$i]['point']?></td>
              <td><?=$data_con[$i]['status']?></td>
              <td><?=$data_con[$i]['ovoid']?></td>
              <td><?=$data_con[$i]['ovopoint']?></td>
            </tr>  
            <?php } else { ?>
              <td><?=$data_con[$i]['transactionDate']?></td>
              <td><?=$data_con[$i]['email']?></td>
              <td><?=$data_con[$i]['point']?></td>
              <td><?=$data_con[$i]['status']?></td>
              <td><?=$data_con[$i]['ovoid']?></td>
              <td><?=$data_con[$i]['ovopoint']?></td>
          </tr>
        <?php } ?>
        <?php $i++;} } else { ?>
        <tr><td colspan="11">No result found</td></tr>
        <?php } ?>
        </tbody>
      </table>
  </div>
  <p id="baseurl" value="<?php echo base_api() ?>" hidden><?php echo base_api()?></p>
  <!-- page end-->
</section>
</section>
</section>
<!--main content end-->
</section>
<!-- container section end -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type='text/javascript'>

  var st = document.getElementById('startdate');
  var en = document.getElementById('enddate');
  // var ty = document.getElementById('type');
  var sbm = document.getElementById('btn_submit');
  var ex = document.getElementById('btn_export');
  validateForm();

  st.addEventListener('change', validateForm);
  en.addEventListener('change', validateForm);
  // ty.addEventListener('change', validateForm);


  if(st.value != "" && en.value != ""){
    sbm.disabled = false;
    ex.disabled = false;
  }
  function validateForm(){
    var sbm = document.getElementById('btn_submit');
    var ex = document.getElementById('btn_export');
    var df = document.getElementById('startdate').value;
    var dt = document.getElementById('enddate').value;
    // var dy = document.getElementById('type').value;
    if(df==="" || dt===""){
      ex.disabled = true
      sbm.disabled = true
    } else {
      sbm.disabled = false;
      ex.disabled = false;
      $('#btn_export').addClass("btn-primary")
      $('#btn_submit').addClass("btn-primary")
    }
  }
  
  $("#btn_export").hover(function(){
    $("#textExport").css( "color", "blue" );
  }).mouseleave(function(){
    $("#textExport").css( "color", "white");
  });

  $("#btn_submit").hover(function(){
    $("#btn_submit").css( "color", "blue" );
  }).mouseleave(function(){
    $("#btn_submit").css( "color", "white");
  });

  $("#enddate").change(function () {
          var startDate = document.getElementById("startdate").value;
          var endDate = document.getElementById("enddate").value;    
          var now = Date.now();
          if((Date.parse(endDate)) > now){
            alert("End date shouldn't be greater than now");
              document.getElementById("enddate").value = "";
          }
          if ((Date.parse(startDate) > Date.parse(endDate))) {
              alert("End date should be greater than start date or same with start date");
              document.getElementById("enddate").value = "";
          }
        });

  $("#btn_export").click(function() {
    // alert(stringDownload);
    var dts = document.getElementById('startdate').value;
    var dte = document.getElementById('enddate').value;
    var baseurl = $('#baseurl').html();
    var stringDownload = baseurl+'Voucher/download?startDate='+dts+'&endDate='+dte;
    
    if(dte!=''){
      window.open(stringDownload, '_blank');
    }
    
  });
</script>
</body>
</html>
