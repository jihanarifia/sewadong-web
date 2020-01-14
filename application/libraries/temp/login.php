<body class="login-img3-body">

  <div class="container">
    <form method="post" action="<?php echo base_url()."admin/login" ?>" class="login-form" autocomplete="off">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" placeholder="Email or Username" id="email" name="email" required autofocus autocomplete="off">
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" placeholder="Password" id="password" name="password" required autocomplete="off">
        </div>
        <?php
        if($this->session->flashdata('login')){
          ?>
          <p class="pull-left" style="color:red"><?=$this->session->flashdata('login')?></p>
          <?php $this->session->set_flashdata('login', ""); } ?>
          <div class="row">
            <div class="col-sm-12">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
