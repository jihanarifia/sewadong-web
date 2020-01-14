    <!--sidebar start haha-->
    <aside>
      <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li>
            <a href="<?=base_url().'admin/dashboard'?>">
              <i class="icon_house_alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_group" ></i>
              <span>Account</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/account'?>">Account Data</a></li>
            </ul>
          </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_group" ></i>
              <span>Rental</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/category'?>">Category</a></li>
            </ul>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
