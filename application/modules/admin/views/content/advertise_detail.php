<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <?php
            if($category == "Get Property"){
              ?>
              <li><a href="<?=base_url().'admin/getproperty'?>"><?=$category?></a></li>
              <?php
            } else {
              ?>
              <li><a href="<?=base_url().'admin/tenant/'.$category?>"><?=$category?></a></li>
              <?php
            }
            ?>
            <li class="active"><?=$title?></li>
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
          <?php } else if ($this->session->flashdata('halfmessage')) { ?>
          <div class="alert alert-block alert-warning fade in" id="alert">
            <?php echo $this->session->flashdata('halfmessage'); ?>
          </div>
          <?php } ?>
          <section class="panel">
            <header class="panel-heading">
              Edit Form Advertise
            </header>
            <div class="panel-body">
              <form role="form" method="post" enctype="multipart/form-data"  action="<?=base_url().'admin/update_advertise'?>">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label for="name"><?=ucwords($type)?> Name</label>
                      <?php
                      if($type=="tenant"){
                          $name = "tenantid";
                        }elseif($type=="property"){
                          $name = "idproperty";
                        }
                      ?>
                      <select id="tenant" class="form-control m-bot15" name="<?=$name?>" required>
                        <?php
                        if($type=="tenant"){
                          $idadv = $data_detail[0]->idtenant;
                        }elseif($type=="property"){
                          $idadv = $data_detail[0]->idproperty;
                        }
                        $old_tenant = $idadv;
                        var_dump($old_tenant);
                        $i=0;
                        foreach ($i_tenant as $a[]) {
                          ?>
                          <option <?= $old_tenant == $a[$i]['idtenant'] ? "selected" : "" ?> value="<?=$a[$i]['idtenant']?>"><?=$a[$i]['tenantsname']?></option>
                          <?php
                          $i++;
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-group">
                      <label for="photo" class="col-lg-2 control-label">Full Advertise</label>
                      <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                      <label>Max: 800 x 1334 | Min: 200 x 334 | Best: 450x750<br>Max file size: 2 MB</label>
                    </div>
                    <div style="height:200px;width:100%;overflow:hidden">
                      <img style="max-height:200px;max-width:100%;height:auto" class="image-responsive" src="<?= $data_detail[0]->advertise ?>">
                    </div>
                    <input type="hidden" class="form-control" id="avatar" name="old_advertise" placeholder="avatar" value="<?= $data_detail[0]->advertise ?>">
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="photo" class="col-lg-2 control-label">Small Advertise</label>
                      <input type="file" id="smallimage" name="smallimage" class="form-control" accept="image/*" />
                      <label>Max: 750 x 129 | Min: 100 x 17 | Best: 350x60<br>Max file size: 2 MB</label>
                    </div>
                    <div style="height:200px;width:100%;overflow:hidden">
                      <img style="max-height:200px;max-width:100%;width:auto" class="image-responsive" src="<?= $data_detail[0]->smalladvertise ?>">
                    </div>
                    <input type="hidden" class="form-control" id="avatar" name="old_smalladvertise" placeholder="avatar" value="<?= $data_detail[0]->smalladvertise ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-10"></div>
                  <div class="col-lg-2">
                  <input type="hidden" value="<?=$type?>" name="type" />
                    <input type="hidden" name="idadvertise"  value="<?=$data_detail[0]->idadvertise?>">
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