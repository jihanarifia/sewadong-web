<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div id="containerHolder">
        <div id="container" style="background:#FFF;">

          <div id="main" style="padding-top:5px;">  

            <?php echo form_label('<b>Header Banner</b>', 'title',array('style' =>'font-size:20px;')); ?>
            <br /><br />
            <span class="largefont">
              <?php echo validation_errors(); ?>
              <?php echo $this->session->flashdata('upload_message'); ?>
            </span>
            <?php echo form_open_multipart("admin/banneruploaded/",array('name' => 'frm_headerbanner', 'id' => 'frm_headerbanner')); ?>

            <fieldset>

              <p>
                <?php echo form_label('<b>Banner:</b>', 'title',array('style' =>'font-size:18px')); ?>  

                <?php echo form_upload(array('name' =>'banner','id'=>'banner','style' =>'width:500px')); ?>
              </p>
              <img src="<?php echo base_url();?>cssjsimages/images/headerimage.jpg" width="400" height="100" />
              <br />                            
              <div align="right">                             
                <?php echo form_submit(array('name' =>'upload','id'=>'upload','value'=>'Upload','class'=>'button large blue')); ?>
                <br /><br />Please Upload images size less than 1MB 
              </div>
            </fieldset>
            <?php echo form_close(''); ?>
            <br />


          </div>

          <div class="clear"></div>
        </div>
        <!-- // #container -->
      </div>
    </section>
  </section>
</section>
