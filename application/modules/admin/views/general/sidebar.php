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
          <!-- <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_desktop"></i>
              <span>Tenant</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/tenant/Entertainment'?>">Entertainment</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Dining'?>">Dining</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Accomodation'?>">Accomodation</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Shopping'?>">Shopping</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Public Services'?>">Public services</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Education'?>">Education</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Health Care'?>">Health Care</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Industry'?>">Industry</a></li>
            </ul>
          </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_globe-2" ></i>
              <span>Transportation</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/publictransportation'?>">Public Transportation</a></li>
              <li><a class="" href="<?=base_url().'admin/tenant/Rental Cars'?>">Rental Cars</a></li>
              <li><a class="" href="<?=base_url().'admin/busschedule'?>">Bus Schedule</a></li>
            </ul>
          </li> -->
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_group" ></i>
              <span>Account</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/account'?>">Account Data</a></li>
              <!-- <li><a class="" href="<?=base_url().'admin/forum'?>">Forum</a></li>
              <li><a class="" href="<?=base_url().'admin/transaction'?>">Transaction</a></li>
              <li><a class="" href="<?=base_url().'admin/chargepayment'?>">Charge Payment</a></li> -->
            </ul>
          </li>
          <!-- <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
            <a href="#">
              <i class="icon_documents_alt"></i>
              <span>City</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="<?=base_url().'admin/city'?>">About Us</a></li>
              <li><a class="" href="<?=base_url().'admin/news'?>">News</a></li>
              <li><a class="" href="<?=base_url().'admin/notification'?>">Notification</a></li>
              <li><a class="" href="<?=base_url().'admin/getproperty'?>">Property Market</a></li>
              <li><a class="" href="<?=base_url().'admin/agent'?>">Agent</a></li>
              <li><a class="" href="<?=base_url().'admin/gallery'?>">Gallery</a></li>
              <li><a class="" href="<?=base_url().'admin/phonenumber'?>">Phone Number</a></li>
              <li><a class="" href="<?=base_url().'admin/download'?>">Download</a></li>
              <li><a class="" href="<?=base_url().'admin/talktous'?>">Talk to Us</a></li>
              <li><a class="" href="<?=base_url().'admin/callcenter'?>">Call Center</a></li>
              <li><a class="" href="<?=base_url().'admin/terms'?>">Terms</a></li>
              <li><a class="" href="<?=base_url().'admin/cctv'?>">CCTV</a></li>
              <li><a class="" href="<?=base_url().'admin/privacy'?>">Privacy Policy</a></li>
              <li><a class="" href="<?=base_url().'admin/currency'?>">Currency</a></li>
            </ul>
          </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='administrator'?'hide':''?>">
              <a href="<?=base_url().'admin/feedback'?>">
                <i class="icon_star"></i>
                <span>User Feedback</span>
              </a>
            </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='marketing'?'hide':''?>">
                <a href="<?=base_url().'admin/earnpoint'?>">
                    <i class="icon_star"></i>
                    <span>Earn Point</span>
                </a>
          </li>
          <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='marketing'?'hide':''?>">
          <a href="<?=base_url().'admin/rule'?>">
              <i class="icon_folder-open_alt"></i>
              <span>Master Rule</span>
            </a>
          </li>
            <li class="sub-menu <?=$this->session->userdata('sc_sess')[0]['privilege']!='marketing'?'hide':''?>">
                <a href="<?=base_url().'admin/voucher'?>">
                    <i class="icon_tag_alt"></i>
                    <span>Master Voucher</span>
                </a>
            </li>
             -->
          <!-- <li class="sub-menu">
            <a href="<?=base_url().'admin/forum'?>">
              <i class="icon_chat_alt"></i>
              <span>Forum</span>
            </a>
          </li> -->
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
