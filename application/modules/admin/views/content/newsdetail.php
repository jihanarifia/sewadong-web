
<div class="container con_overview">  
  <div class="row">
    <div class="col-sm-12">
      <ul class="breadcrumb">
        <li><a href="<?=base_url()?>">Home</a></li>                     
        <li><a href="<?=base_url().'user/news'?>">News</a></li>
        <li class="active"><?=$data_detail->detail[0]->title?></li>
      </ul>
    </div>
    <div class="col-sm-10 mb10">
      <h2><b><?=$title?></b></h2>
    </div>

    <div class="col-md-9">
      <div class="panel panel-default detail">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="img-prev">        
                <img class="img-responsive" src="<?=$data_detail->detail[0]->avatar?>" alt="">   
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <h5 class="pull-right"><?=date("d F Y - H:i", strtotime($data_detail->detail[0]->createdate))?></h5>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <p class="justify">
                <?=$data_detail->detail[0]->description?>
              </p>
            </div>
          </div>               
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="recomended-title">Latest News</div>      
      <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
       <div class="panel panel-default latest-news" style="background-image: url('<?=$data_con[$i]['avatar']?>');">
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 desc">
              <div class="row">
                <div class="col-xs-12 truncate">
                  <a href="<?=base_url().'user/newsdetail/'.$data_con[$i]['idnews']?>" class="title nowrap"><b><?=$data_con[$i]['title']?></b></a><br>
                  <span class="date"><?=$data_con[$i]['createdate']?></span><br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php $i++;} } else { ?>
       <div class="list-group-item"> No result found</div>
       <?php } ?>

     </div>

   </div>
   <!-- /.row -->
 </div>
<!-- /.container -->