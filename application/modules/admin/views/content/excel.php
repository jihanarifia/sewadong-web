
 <?php
 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Account1.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>

<h3 align="center">Data Account</h3>
<table class="table table-striped table-advance table-hover" id="data-table">
  <thead>
    <tr>
      <th><i class="icon_id"></i> Email</th>
      <th><i class="icon_profile"></i> Privilege</th>
      <th><i class="icon_calendar"></i> Created at</th>
      <th><i class="icon_tools"></i> Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($data_con) && !empty($data_con)) { $i=0; foreach($data_con as $data_con[]) { ?>  
    <tr>
      <td><?=$data_con[$i]['email']?></td>
      <td><?=$data_con[$i]['privilege']?></td>
      <td><?=$data_con[$i]['createdate']?></td>
    </tr>  
    <?php $i++;} } else { ?>
    <tr><td colspan="5">No result found</td></tr>
    <?php } ?>
  </tbody>
</table>