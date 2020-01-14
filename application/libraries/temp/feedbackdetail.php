<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
            <li><a href="<?=base_url().'admin/feedback'?>"> User Feedback</a></li>
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
                  User Feedback Detail
                </header>
                <div class="panel-body feedback">
                    <div class="row">
                        <div class="col-md-8">
                            <p><b><?=$data_detail->fullname ?> | <?=$data_detail->email ?></b></p>
                        </div>
                        <div class="col-md-4 text-right">
                            <b><?php 
                              $date = strtotime($data_detail->createdon);
                              echo date('d F Y | H:i:s', $date);
                              ?></b>
                        </div>
                    </div>
                    <div class="demo-table">
                      <ul>
                        <?php
                        $a=0;
                        for($a=1;$a<=5;$a++) {
                        $selected = "";
                        if(!empty($data_detail->rate) && $a<=$data_detail->rate) {
                        $selected = "selected";
                        }
                        ?>
                        <li class='<?php echo $selected; ?>';>&#9733;</li>
                        <?php }  ?>
                      <ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-justify">
                            <p><?=$data_detail->feedback ?></p>                            
                        </div>
                    </div>
                    <nav aria-label="Page navigation" style="text-align:right">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="<?=base_url().'admin/feedbackdetail?id='.$prev?>"><</a></li>
                            <li class="page-item"><a class="page-link" href="<?=base_url().'admin/feedback'?>">Back to List</a></li>
                            <li class="page-item"><a class="page-link" href="<?=base_url().'admin/feedbackdetail?id='.$next?>">></a></li>
                        </ul>
                    </nav>
                </div>
                </section>

                <!-- sukses update -->
                </section>
            </section>
            </section>