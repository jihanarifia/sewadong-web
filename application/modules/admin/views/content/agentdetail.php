<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/agent'?>">Agent</a></li>
            <li class="active"><?=$title?></li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <!-- sukses update -->
          <?php if($this->session->flashdata('messageu')) { ?> 
          <div class="alert alert-success fade in" id="alert">
            <?php echo $this->session->flashdata('messageu'); ?>
          </div> 
          <?php } else if($this->session->flashdata('breakmessageu')) { ?>
          <div class="alert alert-block alert-danger fade in" id="alert">
            <?php echo $this->session->flashdata('breakmessageu'); ?>
          </div> 
          <?php } ?>
          <section class="panel">
           <header class="panel-heading">
            Form Edit
          </header>
          <div class="panel-body">
            <form role="form" action="<?=base_url().'admin/update_agent'?>" method="post" enctype="multipart/form-data" id="formacc">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$data_detail[0]->name?>" autofocus required>
                  </div>
                  <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" min="0" class="form-control" name="email" placeholder="Type" value="<?=$data_detail[0]->email?>" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Phone</label>
                    <input type="tel" name="phone" class="form-control" min="0" placeholder="Price" value="<?=$data_detail[0]->phone?>" required>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" name="image" class="form-control" accept="image/*" />
                    <input type="checkbox" name="empty_avatar" <?php if($data_detail[0]->avatar==null) echo "checked"; ?>><label> Empty avatar</label><br>
                    <label>Max: 800 X 800 | Min: 165 X 114<br>Max file size: 2 MB</label>
                  </div>
                  <?php if($data_detail[0]->avatar!=null) { ?>
                  <div class="col-lg-6" style="height:100px;width:100px;overflow:hidden;display:flex;justify-content:center;align-items:center">
                    <img class="image-responsive" src="<?= $data_detail[0]->avatar ?>" style="height:100%;">
                  </div>
                  <?php } ?>
                  <input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?=$data_detail[0]->avatar ?>">
                </div>
              </div>
              <input type="hidden" name="idagent" value="<?=$data_detail[0]->idagent ?>">
              <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
            </form>
          </div>
        </section>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <section class="panel">
          <header class="panel-heading">
            <div class="row">
              <div class="col-lg-8">

                <h3> List Property </h3>
              </div>
            </header>

            <div class="table-responsive">
              <table class="table table-hover" id="data-table">
                <thead>
                  <tr>
                    <th><i class="icon_building"></i> Name</th>
                    <th><i class="icon_mail_alt"></i> avatar</th>
                    <th><i class="icon_cogs"></i> Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                  <tr>
                    <td><?=$data_con[$i]['name']?></td>
                    <td><img height="99px" width="99px"  class="image-responsive" src="<?= $data_con[$i]['avatar'] ?>"></td>
                    <td><center>
                      <a class="btn btn-info" href="<?= base_url() . 'admin/detail_getproperty?id='.$data_con[$i]['idproperty'] ?>"><i class="icon_pencil" ></i></a></center>

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

    </section>
  </section>
</section>