<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>            
            <li><a href="#"> City</a></li>
            <li class="active"> Terms </li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <section class="panel">
            <header class="panel-heading">
              <div class="row">
                <div class="col-lg-8">
                  <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i>&nbsp;Add</a>
                </div>
              </div>
            </header>
            <!-- form insert file -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Insert File</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" action="<?=base_url().'admin/insert_terms'?>" method="post" enctype="multipart/form-data" id="formacc">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="name">Title</label>
                            <select class="form-control m-bot15" name="title">
                              <option value="kebijakan_privasi">kebijakan_privasi</option>
                              <option value="syarat_ketentuan">syarat_ketentuan</option>
                              <option value="tentang">tentang</option>
                            </select>
                            <input class="othername" type="checkbox" name="othername" value="1" onchange="valueChanged()"/><label>Set another title</label>
                            <input type="text" class="answer form-control" name="othertitle" placeholder="Title" autofocus>
                          </div>
                          <div class="form-group">
                            <label for="avatar">File</label>
                            <input type="file" name="file" class="form-control" accept=".html" required />
                            <label>Just receive HTML file</label>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- form update file -->
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateform" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Update File</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" action="<?=base_url().'admin/update_terms'?>" method="post" enctype="multipart/form-data" id="formacc">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="utitle" name="title" placeholder="Name" autofocus required>
                          </div>
                          <div class="form-group">
                            <label for="avatar">File</label>
                            <input type="file" name="file" class="form-control" accept=".html" />
                            <label>Just receive HTML file</label>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" name="linkfile" id="ulinkfile" value="">
                      <input type="hidden" name="idcity" id="uidcity" value="">
                      <input type="hidden" name="idterms" id="uidterms" value="">
                      <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
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
              <table class="table table-striped table-advance table-hover" id="data-table">
                <thead>
                  <tr>
                    <th><i class="icon_id"></i> Title</th>
                    <th><i class="icon_link"></i> Link File</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </div>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                <tr>
                  <td><?=$data_con[$i]['title']?></td>
                  <td><?php if($data_con[$i]['linkfile']!=""){ ?>
                    <a class="form-control" target="_blank" href="<?=base_url().'admin/termsdownload?title='.$data_con[$i]['title'].'&linkfile='.$data_con[$i]['linkfile']?>">Download file</a>
                    <?php } ?></td>
                    <td style="width:100px">
                      <div class="btn-group">
                        <a data-toggle="modal" class="update-terms btn btn-success" href="#updateform" data-title="<?=$data_con[$i]['title']?>" data-linkfile="<?=$data_con[$i]['linkfile']?>" data-id="<?=$data_con[$i]['idterms']?>" data-idcity="<?=$data_con[$i]['idcity']?>"><i class="icon_pencil" ></i></a>
                        <a data-toggle="modal" class="open-delete btn btn-danger" href="#deleteform" data-avatar="<?=$data_con[$i]['linkfile']?>" data-id="<?=$data_con[$i]['idterms']?>"><i class="icon_trash_alt"></i></a>
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
      <!-- delete form file -->
      <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="deleteform" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h4 class="modal-title">Delete File</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure delete this point?</p>                          
              <form method="post" action="<?=base_url().'admin/delete_terms'?>">
                <input type="hidden" name="id" id="del_id" value="">
                <input type="hidden" name="avatar" id="del_avatar" value="">
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
  function valueChanged()
  {
    if($('.othername').is(":checked"))   
      $(".answer").show();
    else
      $(".answer").hide();
  }
  $(document).ready(function(){
   $(".answer").hide(); 
 });
         //update terms
         $(".update-terms").click(function(){       
          var idterms = $(this).attr("data-id");
          var title = $(this).attr("data-title");
          var linkfile = $(this).attr("data-linkfile");
          var idcity = $(this).attr("data-idcity");
          $("#uidterms").prop("value", idterms);
          $("#uidcity").prop("value", idcity);
          $("#ulinkfile").prop("value", linkfile);
          $("#utitle").prop("value", title);
        });
      </script>