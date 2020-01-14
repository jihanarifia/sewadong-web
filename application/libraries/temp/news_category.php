<style>
        .bootstrap-tagsinput {
            display: block;
        }

        .label-info {
            background-color: #007aff;
        }
        .bootstrap-tagsinput-max{
          /* background-color: #dddddd; */
          /* pointer-events: none; */
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
                  <li><a href="<?=base_url().'admin/news'?>"></i> News</a></li>
                  <li class="active"><?=$title?></a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> News Category</h3>
                <section class="panel">
                  <header class="panel-heading">
                   <div class="row">
                    <div class="col-lg-8">
                        <a href="<?=base_url().'admin/news'?>" class="btn btn-primary"> <i class="fa fa-chevron-left"></i></a>
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                    </div>
                  </div>
                </header>
                <!-- form delete news -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Delete News</h4>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure delete this point?</p>                          
                        <form method="post" action="<?=base_url().'admin/delete_news_category'?>">
                          <input type="hidden" name="del_idnewscategory" id="del_idnewscategory" value="">
                          <button type="submit" class="btn btn-danger">Sure</button>
                          <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                        </form>                            
                      </div>
                    </div>
                  </div>
                </div>
                <!-- form insert news -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Add News Category</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_news_category'?>">
                          <div class="form-group">
                            <label for="news_category" class="col-lg-3 control-label">News Category</label>
                            <div class="col-lg-9">
                              <input type="text" class="form-control" id="news_category" name="news_category" placeholder="News Category" required>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-9"><input type="hidden" name="idtenant" >
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- form update news -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editform" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Edit News Category</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/edit_news_category'?>">
                            <input type="hidden" name="edit_idnewscategory" id="edit_idnewscategory" value="">
                          <div class="form-group">
                            <label for="news_category" class="col-lg-3 control-label">News Category</label>
                            <div class="col-lg-9">
                              <input type="text" class="form-control" id="edit_newscategory" name="edit_newscategory" placeholder="News Category" required>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-9"><input type="hidden" name="idtenant" >
                              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
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
                      <th><i class="icon_grid-2x2"></i> Category</th>
                      <th><i class="icon_calendar"></i> Cretead On</th>
                      <th><i class="icon_calendar"></i> Modified On</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                    <tr>
                      <td><?=$data_con[$i]['newscategory']?></td>
                      <td><?=date_format(date_create($data_con[$i]['createdon']),"Y-m-d H:i:s") ?></td>
                      <td><?=date_format(date_create($data_con[$i]['modifiedon']),"Y-m-d H:i:s") ?></td>
                      <td>
                        <div class="btn-group">
                          <a data-toggle="modal" class="btn btn-success update-news-category" data-idnewscategory="<?=$data_con[$i]['idnewscategory']?>" data-newscategory="<?=$data_con[$i]['newscategory']?>" href="#editform"><i class="icon_pencil"></i></a>
                          <a data-toggle="modal" class="btn btn-danger delete-news-category" data-idnewscategory="<?=$data_con[$i]['idnewscategory']?>" href="#deleteform"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr>    
                    <?php $i++;} } else { ?>
                    <tr><td colspan="4">No result found</td></tr>
                    <?php } ?>                     
                  </tbody>
                </table>
              </div>
            </section>
          </div> 
        </div>
        <!-- page end-->
      </section>
    </section>
  </section>
  <!--main content end-->
</section>
<!-- container section end -->
<script type="text/javascript">
    //update news category
    $(".update-news-category").click(function(){       
      var idnewscategory = $(this).attr("data-idnewscategory");
      var newscategory = $(this).attr("data-newscategory");

      $("#edit_idnewscategory").prop("value", idnewscategory);
      $("#edit_newscategory").prop("value", newscategory);
    });

    $(".delete-news-category").click(function(){       
      var idnewscategory = $(this).attr("data-idnewscategory");

      $("#del_idnewscategory").prop("value", idnewscategory);
    });
</script>