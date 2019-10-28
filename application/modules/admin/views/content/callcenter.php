<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li> 
            <li class="active"> Call Center </li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <?php if ($this->session->flashdata('message')) { ?> 
            <div class="alert alert-success fade in" id="alert">
              <?php echo $this->session->flashdata('message'); ?>
            </div> 
            <?php } else if ($this->session->flashdata('breakmessage')) { ?> 
              <div class="alert alert-block alert-danger fade in" id="alert">
                <?php echo $this->session->flashdata('breakmessage'); ?>
              </div> 
              <?php } ?>
              <section>
                <div>
                  <form method="post" action="<?= base_url() . 'admin/callcenter_update' ?>" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="panel">
                          <div class="panel-body">
                            <div class="form-group">
                              <label for="name">Title</label>
                              <input type="text" class="form-control" name="title" placeholder="Title" value="<?=$data_detail[0]->title?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name">Title Indonesia</label>
                              <input type="text" class="form-control" name="title_id" placeholder="Title" value="<?=$data_detail[0]->title_id?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name">Description</label>
                              <textarea class="form-control" rows="7" name="description" required placeholder="Description"><?=$data_detail[0]->description?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="name">Description Indonesia</label>
                              <textarea class="form-control" rows="7" name="description_id" required placeholder="Description"><?=$data_detail[0]->description_id?></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                              <label for="phone">Phone</label>
                              <input type="tel" class="form-control" name="phone" placeholder="Phone" required value="<?=$data_detail[0]->phone?>">
                            </div>
                          </div>
                        </div>  
                      </div>
                      <div class="col-lg-4">
                        <div class="panel">
                          <div class="panel-heading">
                            <h3>Preview</h3>
                          </div>
                          <img src="<?=base_img().'callcenter.jpg'?>" class="img-responsive">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <input type="hidden" name="idcallcenter" value="<?=$data_detail[0]->idcallcenter?>">
                        <input type="hidden" name="idcity" value="<?=$data_detail[0]->idcity?>">
                        <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                      </div>
                    </div>
                  </form>

                </div>
              </section>
            </div>
          </div>
        </section>
      </section>
    </section>