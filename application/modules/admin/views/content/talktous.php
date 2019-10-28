<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li> 
            <li class="active"> Talk To Us </li>
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
                  <form method="post" action="<?= base_url() . 'admin/talktous_update' ?>" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="panel">
                          <div class="panel-body">
                            <div class="form-group">
                              <label for="name">Header</label>
                              <input type="text" class="form-control" name="header" placeholder="Header" value="<?=$data_detail[0]->header?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name">Description Header</label>
                              <textarea class="form-control" name="description" required placeholder="Description header"><?=$data_detail[0]->description?></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                              <label for="phone">Call Center</label>
                              <input type="tel" class="form-control" name="callcenter" placeholder="Call Center" required value="<?=$data_detail[0]->callcenter?>">
                            </div>
                            <div class="form-group">
                              <label for="phone">Emergency Call</label>
                              <input type="tel"class="form-control" name="emergencycall" placeholder="Emergency Call" required value="<?=$data_detail[0]->emergencycall?>">
                            </div>
                            <hr>
                            <div class="form-group">
                              <label for="phone">Heading 1</label>
                              <input type="text" class="form-control" name="heading1" placeholder="Heading 1" required value="<?=$data_detail[0]->heading1?>">
                            </div>
                            <div class="form-group">
                              <label for="phone">Heading 2</label>
                              <input type="text" class="form-control" name="heading2" placeholder="Heading 2" required value="<?=$data_detail[0]->heading2?>">
                            </div>
                          </div>
                        </div>  
                      </div>
                      <div class="col-lg-4">
                        <div class="panel">
                          <div class="panel-body">
                            <div class="form-group">
                              <label for="phone">Content 1</label>
                              <textarea class="form-control" name="content1" placeholder="Content 1" required ><?=$data_detail[0]->content1?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="phone">Content 2</label>
                              <textarea class="form-control" name="content2" placeholder="Content 2" required ><?=$data_detail[0]->content2?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="phone">Content 3</label>
                              <textarea class="form-control" name="content3" placeholder="Content 3" required ><?=$data_detail[0]->content3?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="phone">Content 4</label>
                              <textarea class="form-control" name="content4" placeholder="Content 4" required ><?=$data_detail[0]->content4?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="phone">Content 5 </label>
                              <textarea class="form-control" name="content5" placeholder="Content 5" required ><?=$data_detail[0]->content5?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="panel">
                          <div class="panel-heading">
                            <h3>Preview</h3>
                          </div>
                          <img src="<?=base_img().'talktous.jpg'?>" class="img-responsive">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <input type="hidden" name="idtalktous" value="<?=$data_detail[0]->idtalktous?>">
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