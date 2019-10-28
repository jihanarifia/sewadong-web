<?php

header("Content-type: application/vnd-ms-excel");

header("Content-Disposition: attachment; filename=Mobile LC rate & feedback.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<?php 
if($parameter['startDate'] != NULL && $parameter['endDate'] != NULL){ ?>
  <h3 align="center">Mobile LC rate & feedback </h3>
  <p align="center">From <?php echo date("d/m/Y",strtotime($parameter['startDate']));?> to <?php echo date("d/m/Y",strtotime($parameter['endDate']));?></p>
<?php } else { ?>
  <h3 align="center">Mobile LC rate & feedback </h3>
  <p align="center">From : -</p>
<?php } ?>
<?php 
if($parameter['rate'] != NULL){ ?>
  <p align="center">Rating : <?php echo $parameter['rate'];?></p>
<?php } else { ?>
  <p align="center">Rating : -</p></div>
<?php } ?>
  
<div class="table-responsive">
  <table border="1" id="data-table" style="border-collapse:collapse;width:100%">
    <thead>
      <tr>
        <th>Rating</th>
        <th>CreatedOn</th>
        <th>Username</th>
        <th>Email</th>
        <th>Feedback</th>
      </tr>
    </thead>
    <tbody>
        <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?> 
        <?php if ($data_con[$i]['IsDuplicate'] == 0) { ?>
        <tr>
        <td align="center"><?=$data_con[$i]['rate']?></td>
        <td align="left"><?=$data_con[$i]['createdOn']?></td>
        <td><?=$data_con[$i]['fullname']?></td>
        <td><?=$data_con[$i]['email']?></td>
        <td><?=$data_con[$i]['feedback']?></td>
        </tr>  
        <?php } else { ?>
        <tr>
        <td align="center"><?=$data_con[$i]['rate']?></td>
        <td align="left"><?=$data_con[$i]['createdOn']?></td>
        <td><?=$data_con[$i]['fullname']?></td>
        <td><?=$data_con[$i]['email']?></td>
        <td><?=$data_con[$i]['feedback']?></td>
        </tr>
  <?php } ?>
  <?php $i++;} } else { ?>
  <tr><td colspan="8">No result found</td></tr>
  <?php } ?>
  </tbody>
</table>
</div>