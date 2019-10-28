<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li> 
            <li><a href="<?=base_url().'admin/terms'?>">Terms</a></li>
            <li class="active"> <?=$title?> </li>
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
                  <form method="post" action="<?= base_url() . 'admin/update_terms' ?>" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="panel">
                          <div class="panel-heading">
                            <h3>Content of <?=$title?></h3>
                          </div>
                          <div class="panel-body">
                            <textarea class="form-control ckeditor" name="terms" rows="10"><?=$terms?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <input type="hidden" name="filename" value="<?=$filename?>">
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
