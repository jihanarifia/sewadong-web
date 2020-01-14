<?php

header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=Data_Transaction.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<h3 align="center">Data Transaction from <?php echo date("d/m/Y",strtotime($parameter['startDate']));?> to <?php echo date("d/m/Y",strtotime($parameter['endDate']));?></h3>
<div class="table-responsive">
  <table class="table table-striped table-advance table-hover" id="data-table">
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
        <td><?php echo '="'.$data_con[$i]['MerchantTransactionID'].'"';?></td>
        <td><?=$data_con[$i]['Amount']?></td>
        <td><?php echo '="'.$data_con[$i]['PSCode'].'"';?></td>
        <td><?=$data_con[$i]['SiteID']?></td>
        <td><?=$data_con[$i]['BillingPaid']?></td>
        <td><?=$data_con[$i]['Status']?></td>
        <td><?=$data_con[$i]['OVOTransactionID']?></td>
        <td><?php echo '="'.$data_con[$i]['OVOPhoneNumber'].'"';?></td>
        <td><?=$data_con[$i]['OVOTransactionAmount']?></td>
      </tr>  
      <?php } else { ?>
      <td><?=$data_con[$i]['CreatedOn']?></td>
      <td><?=$data_con[$i]['Email']?></td>
      <td><?php echo '="'.$data_con[$i]['MerchantTransactionID'].'"';?></td>
      <td><?=$data_con[$i]['Amount']?></td>
      <td><?php echo '="'.$data_con[$i]['PSCode'].'"';?></td>
      <td><?=$data_con[$i]['SiteID']?></td>
      <td><?=$data_con[$i]['BillingPaid']?></td>
      <td><?=$data_con[$i]['Status']?></td>
      <td><?=$data_con[$i]['OVOTransactionID']?></td>
      <td><?php echo '="'.$data_con[$i]['OVOPhoneNumber'].'"';?></td>
      <td><?=$data_con[$i]['OVOTransactionAmount']?></td>
    </tr>
  <?php } ?>
  <?php $i++;} } else { ?>
  <tr><td colspan="8">No result found</td></tr>
  <?php } ?>
  </tbody>
</table>
</div>