      <style>
        .bootstrap-tagsinput {
            display: block;
        }

        .label-info {
            background-color: #007aff;
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
                  <li class="active"><?=$title?></a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> News </h3>
                <section class="panel">
                  <header class="panel-heading">
                   <div class="row">
                    <div class="col-lg-8">
                      <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add News</a>
                      <a class="btn btn-primary" href="<?=base_url().'admin/news_category'?>"> <i class="icon_plus"></i> Add News Category</a>
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
                        <form method="post" action="<?=base_url().'admin/delete_news'?>">
                          <input type="hidden" name="id" id="del_id" value="">
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
                        <h4 class="modal-title">Add News</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/insert_news'?>">
                          <div class="form-group">
                            <label for="photo" class="col-lg-2 control-label">Avatar</label>
                            <div class="col-lg-10">
                              <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                              <input type="checkbox" name="empty_avatar"><label> Empty avatar</label><br>
                              <label>Max: 800 x 800 | Min: 165 x 114<br>Max file size: 2 MB</label>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="photo" class="col-lg-2 control-label">Video</label>
                            <div class="col-lg-10">
                              <input type="file" id="video" name="video" class="form-control" accept="video/*" /><br>
                              <label>Max file size: 5 MB</label><br>
                              <input type="checkbox" name="empty_video" id="empty_video"><label> URL link video</label>
                            </div>
                          </div>
                          <div class="form-group" id="input_url_video">
                            <label for="photo" class="col-lg-2 control-label">URL Video</label>
                            <div class="col-lg-10">
                              <input type="text" id="url_video" name="url_video" class="form-control" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Indonesian title</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="title" name="title" placeholder="Indonesian title" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="title_en" class="col-lg-2 control-label">English title</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" id="title_en" name="title_en" placeholder="English title" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="subcategory" class="col-lg-2 control-label">Category</label>
                            <div class="col-lg-10">
                            <select class="form-control m-bot15" name="idnewscategory" required>
                            <?php
                            foreach ($subnewscat as $item) {
                              ?>
                              <option value="<?php echo $item->idnewscategory?>">
                                <?php echo $item->newscategory?>
                              </option> 	
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="labeltags" class="col-lg-2 control-label">Tags</label>
                          <div class="col-lg-10">
                            <input type="text" class="form-control" id="labeltags" name="labeltags" data-role="tagsinput">
                            <label class="control-label">Maks. 10 Tags</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="description" class="col-lg-2 control-label">Indonesian description</label>
                          <div class="col-lg-10">
                            <textarea class="form-control ckeditor" name="description" id="description" rows="2"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="description_en" class="col-lg-2 control-label">English description</label>
                          <div class="col-lg-10">
                            <textarea class="form-control ckeditor" name="description_en" id="description_en" rows="2"></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10"><input type="hidden" name="idtenant" >
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
                    <th><i class="icon_building"></i> Title</th>
                    <th><i class="icon_calendar"></i> Date Post</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                  <tr>
                    <td><?=$data_con[$i]['title']?></td>
                    <td><?=$data_con[$i]['createdate']?></td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-success" href="<?=base_url().'admin/newsdetail?id='.$data_con[$i]['idnews']?>"><i class="icon_pencil"></i></a>
                        <a data-toggle="modal" class="btn btn-danger delete-news" data-id="<?=$data_con[$i]['idnews']?>" data-avatar="<?=$data_con[$i]['avatar']?>" href="#deleteform"><i class="icon_trash_alt"></i></a>
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
  $('#labeltags').tagsinput({
    confirmKeys: [13, 44],
    maxTags: 10,
    freeInput: true,
    typeahead: {
      afterSelect: function(val) { this.$element.val(""); },
      source: function (query) {
        var result = [];
        $.ajax({
            url: "<?php echo base_api(); ?>News/?action=listnewstag&newstag="+query,
            type: "get",
            dataType: "json",
            async: false,
            success: function(data) {
                data.forEach(function(item){
                  result.push(item.newstag);
                })
            } 
        });
        return result;        
      }
    }
  });
  
</script>