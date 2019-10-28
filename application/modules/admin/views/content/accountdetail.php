<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/account'?>"> Account</a></li>
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
              <?php } ?>
              <section class="panel">
                <header class="panel-heading">
                  Form Edit
                </header>
                <div class="panel-body">
                  <form role="form" action="<?=base_url().'admin/update_account'?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                           <label for="name">Username</label>
                          <input type="text" required class="form-control" id="name" name="username" placeholder="Username" autofocus value="<?=$data_detail['username'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Gender</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="gender" id="gender" value="M" <?php echo ($data_detail['gender'] == 'M')?'checked':'' ?> >
                              Male
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="gender" id="gender" value="F" <?php echo ($data_detail['gender'] == 'F')?'checked':'' ?> >
                              Female
                            </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="name">Phone</label>
                          <input type="tel" name="phone_number" class="form-control" maxlength="15" placeholder="Phone" value="<?=$data_detail['phone_number'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="image">Avatar</label>
                          <input type="file" name="image" id="image" class="form-control" accept="image/*"  />
                          <input type="checkbox" name="empty_avatar" <?php if($data_detail['image']==null) echo "checked"; ?>><label> Empty avatar</label><br>
                          <label>Max: 800 X 800 | Min: 150 X 150<br>Max file size: 2 MB</label>
                        </div>
                        <?php if($data_detail['image']!=null) { ?>
                          <div class="col-lg-8" style="height:200px;width:200px;overflow:hidden;display:flex;justify-content:center;align-items:center">
                            <img class="image-responsive" src="<?= $data_detail['image'] ?>" style="height:100%;">
                          </div>
                          <?php } ?>
                          <input type="hidden" class="form-control" id="avatar" name="avatar" placeholder="avatar" value="<?= $data_detail['image'] ?>">
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="subcategory">Privilege</label>
                            <select class="form-control m-bot15" name="privilege" disabled>
                              <!-- <option value="3" <?php echo ($data_detail['role_id'] == '3')?'selected':'' ?>>Administrator</option> -->
                              <option value="1" <?php echo ($data_detail['role_id'] == '1')?'selected':'' ?>>Tenant</option>
                              <option value="2" <?php echo ($data_detail['role_id'] == '2')?'selected':'' ?>>Regular User</option>
                            </select>
                            <input type="hidden" name="privilege" value="<?=$data_detail['role_id']?>">
                          </div>
                          <div class="form-group">
                            <label for="address">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Email" value="<?=$data_detail['email'] ?>">
                          </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label for="name">Address</label>
                              <input type="text" class="form-control" id="address" name="address" value="<?=$data_detail['address'] ?>">
                            </div>
                            <div class="form-group">
                              <label for="name">Create Date</label>
                              <input type="date" readonly class="form-control" id="createdate" name="createdate" value="<?=$createdate ?>">
                            </div>
                          </div>
                            <div class="row">
                              <div class="container">
                                <div class="col-lg-12 ">
                                  <input type="hidden" class="form-control" name="user_id" value="<?=$data_detail['user_id']?>">
                                  <button type="submit" class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                                </div>
                              </div>
                            </div>
                          </form>

                        </div>
                      </section>
                    </section>
                  </section>
                </section>