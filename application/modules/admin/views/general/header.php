 <section id="container" class="">

   <header class="header white-bg">
    <div class="toggle-nav">
      <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
    </div>

    <!--logo start-->
    <!-- <a href="index.html" class="logo">Karm<span>anta</span> <span class="lite">Lite</span></a> -->
    <a class="logo "  href="<?=base_url()?>"><img src="<?=base_url()."assets/back/img/logo.png"?>" style="height: 40px"></a>
    <!--logo end-->

    <div class="top-nav notification-row">
      <!-- notificatoin dropdown start-->
      <ul class="nav pull-right top-menu">
        <?php if(isset($this->session->userdata('sc_sess')[0]['username'])) { ?>
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="<?=base_url().'user/profile/'.$this->session->userdata('sc_sess')[0]['idaccount']?>">
              <span class="profile-ava">
                <img alt="" src="<?=base_img().'account/avatardefault.jpg'?>">
              </span>
              <span class="username"><?=$this->session->userdata('sc_sess')[0]['username']?></span>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <li>
                <a href="<?=base_url().'admin/logout'?>"><i class="icon_key_alt"></i> Log Out</a>
              </li>
            </ul>
          </li>
          <?php } else{
            redirect(base_url('admin/'));
          } ?>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>      
    <!--header end-->
  </section>