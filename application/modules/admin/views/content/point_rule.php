      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content"> 
          <section class="wrapper">          
            <div class="row">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                  <li class="active"><?=$title?></a></li>
                </ul>
              </div>
            </div>

            <div class="row">

              <div class="col-md-12">
                <h3> <?=$title?> </h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-md-8">
                        <a href="<?=base_url().'admin/rule/create'?>" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                      </div>
                    </header>
                    
                    
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Delete <?=$title?></h4>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure delete this point?</p>                          
                            <form method="post" action="<?=base_url().'admin/rule/delete'?>">
                              <input type="hidden" name="id" id="del_id" value="">
                              <button type="submit" class="btn btn-danger">Sure</button>
                              <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                            </form>                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- sukses update -->
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
                            <th><i class="icon_tag_alt"></i> Title</th>
                            <th><i class="icon_link"></i> Point</th>
                            <th><i class="icon_drive"></i> Type</th>
                            <th><i class="icon_calendar"></i> Valid From</th>
                            <th><i class="icon_calendar"></i> Valid Until</th>
                            <th><i class="icon_calendar"></i> Status</th>
                            <th><i class="icon_cogs"></i> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                          <tr>
                            <td><?=$data_con[$i]['title']?></td>
                            <td><?=$data_con[$i]['point']?></td>
                            <td><?=$data_con[$i]['type']?></td>
                            <td><?=$data_con[$i]['validfrom']==null?"-":$data_con[$i]['validfrom']?></td>
                            <td><?=$data_con[$i]['validuntil']==null?"-":$data_con[$i]['validuntil']?></td>
                            <td><?=$data_con[$i]['active']=="t"?"Active":"Inactive"?></td>
                            <td>
                              <div class="btn-group">
                                <a data-toggle="modal" class="btn btn-success update-point-rule" href="<?=base_url().'admin/rule/edit?id='.$data_con[$i]['id']?>"  ><i class="icon_pencil" ></i></a>
                                <a data-toggle="modal" class="delete-phone btn btn-danger" href="#deleteform"  data-id="<?=$data_con[$i]['id']?>"><i class="icon_trash_alt"></i></a>
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
    </div>         


  </section>
</section>
<!--main content end-->
</section>
    <!-- container section end -->