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
            <li class="active">Transaction</a></li>
        </ul>
      <!--breadcrumbs end -->
      </div>
    </div>
  <div class="row">
    <div class="col-lg-12">
      <h3> Transaction</h3>
      <section class="panel">
        <header class="panel-heading">
          <div class="row">
            <form role="form" action="<?=base_url().'admin/show_transaction'?>" method="post" id="myform">
              <table>
                <tr>
                  <td style="padding-left:10px"><select id="type" name="type" class="form-control">
                    <option value="">Transaction Type</option>
                    <option value="3" <?php if ($parameter['PaymentTypeID'] == '3') echo 'selected="selected"'; ?>>OVO</option>
                    </select></td>

                  <td style="padding-left:20px; padding-top:5px;"> <label>View Transaction from : </label></td>
                  <td style="padding-left:12px;"> <input onfocus="(this.type='date')" value="<?php echo $parameter['startDate'];?>" id="startdate" name="startdate" class="form-control" placeholder="Start Date" min="2017-09-05" max="<?php echo date('Y-m-d');?>" ></td>
                  <td style="padding-left:15px;  padding-top:5px;"> <label>to : </label></td>
                  <td style="padding-left:12px;"> <input onfocus="(this.type='date')" value="<?php echo $parameter['endDate'];?>" id="enddate" name="enddate" class="form-control" placeholder="End Date" min="2017-09-05" max="<?php echo date('Y-m-d');?>" ></td>
                  <td style="padding-left:15px;  padding-top:5px;"></td>
                  <td style="padding-left:15px;"><input type="submit" class="btn btn-primary" id="btn_submit" disabled="disabled" name="btn_submit" value="Submit"/></td>
                  <td style="padding-left:10px;"><input type="submit" class="btn btn-primary" disabled="disabled" id="btn_export" name="btn_submit" value="Export to Excel"/></td>
                </form>
              </tr>
            </table>
          </div>
        </header>
      <div class="table-responsive">
        <table class="table table-striped table-advance table-hover" id="data-table" name="data-table">
          <thead>
            <tr>
              <th>Transaction Date</th>
              <th>Email</th>
              <th>Merchant Transaction ID</th>
              <th>Amount</th>
              <th>PSCode</th>
              <th>SiteID</th>
              <th>Billing Paid</th>
              <th>Status</th>
              <th>OVO Transaction ID</th>
              <th>OVO Phone Number</th>
              <th>OVO Transaction Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?> 
            <?php if ($data_con[$i]['IsDuplicate'] == 0) { ?>
            <tr>
              <td><?=$data_con[$i]['CreatedOn']?></td>
              <td><?=$data_con[$i]['Email']?></td>
              <td><?=$data_con[$i]['MerchantTransactionID']?></td>
              <td><?=$data_con[$i]['Amount']?></td>
              <td><?=$data_con[$i]['PSCode']?></td>
              <td><?=$data_con[$i]['SiteID']?></td>
              <td><?=$data_con[$i]['BillingPaid']?></td>
              <td><?=$data_con[$i]['Status']?></td>
              <td><?=$data_con[$i]['OVOTransactionID']?></td>
              <td><?=$data_con[$i]['OVOPhoneNumber']?></td>
              <td><?=$data_con[$i]['OVOTransactionAmount']?></td>
            </tr>  
            <?php } else { ?>
            <td><?=$data_con[$i]['CreatedOn']?></td>
            <td><?=$data_con[$i]['Email']?></td>
            <td><?=$data_con[$i]['MerchantTransactionID']?></td>
            <td><?=$data_con[$i]['Amount']?></td>
            <td><?=$data_con[$i]['PSCode']?></td>
            <td><?=$data_con[$i]['SiteID']?></td>
            <td><?=$data_con[$i]['BillingPaid']?></td>
            <td><?=$data_con[$i]['Status']?></td>
            <td><?=$data_con[$i]['OVOTransactionID']?></td>
            <td><?=$data_con[$i]['OVOPhoneNumber']?></td>
            <td><?=$data_con[$i]['OVOTransactionAmount']?></td>
          </tr>
        <?php } ?>
        <?php $i++;} } else { ?>
        <tr><td colspan="11">No result found</td></tr>
        <?php } ?>
        </tbody>
      </table>
  </div>
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
  var ty = document.getElementById('type');
  var sbm = document.getElementById('btn_submit');
  var ex = document.getElementById('btn_export');


  st.addEventListener('change', validateForm);
  en.addEventListener('change', validateForm);
  ty.addEventListener('change', validateForm);


  if(st.value != "" && en.value != "" && ty.value != ""){
    sbm.disabled = false;
    ex.disabled = false;
  }
  function validateForm(){
    var sbm = document.getElementById('btn_submit');
    var ex = document.getElementById('btn_export');
    var df = document.getElementById('startdate').value;
    var dt = document.getElementById('enddate').value;
    var dy = document.getElementById('type').value;
    (df==="" || dt==="" || dy === "")?(sbm.disabled = true):(sbm.disabled = false);
    (df==="" || dt==="" || dy === "")?(ex.disabled = true):(ex.disabled = false);
  }

  // $(document).ready(function() {
  //  var span = 1;
  //  var prevTD = "";
  //  var prevTDVal = "";
  //  $("#data-table tr td:first-child, td:first-child+1").each(function() { //for each first td in every tr
  //     var $this = $(this);
  //     if ($this.text() == prevTDVal) { // check value of previous td text
  //        span++;
  //        if (prevTD != "") {
  //           prevTD.attr("rowspan", span); // add attribute to previous td
  //           $this.remove(); // remove current td
  //        }
  //     } else {
  //        prevTD     = $this; // store current td 
  //        prevTDVal  = $this.text();
  //        span       = 1;
  //     }
  //  });

  //});
</script>
</body>
</html>
