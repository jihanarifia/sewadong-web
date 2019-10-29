<!-- bootstrap -->
<script src="<?php echo base_url().'assets/back/js/bootstrap.min.js'?>"></script>
<script src="<?php echo base_url().'assets/back/js/bootstrap-combobox.js'?>"></script>

<!-- nice scroll -->
<script src="<?php echo base_url().'assets/back/js/jquery.scrollTo.min.js'?>"></script>
<script src="<?php echo base_url().'assets/back/js/jquery.nicescroll.js'?>" type="text/javascript"></script>

<!-- charts scripts -->
<script src="<?php echo base_url().'assets/back/assets/jquery-knob/js/jquery.knob.js';?>"></script>
<script src="<?php echo base_url().'assets/back/js/jquery.sparkline.js" type="text/javascript'?>"></script>
<script src="<?php echo base_url().'assets/back/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js';?>"></script>

<script src="<?php echo base_url().'assets/back/js/jquery.tagsinput.js'?>" ></script>
<!-- <script src="<?php echo base_url().'assets/back/js/form-component.js'?>" ></script> -->
<script src="<?php echo base_url().'assets/back/js/owl.carousel.js'?>" ></script>
<!-- custom select -->
<script src="<?php echo base_url().'assets/back/js/jquery.customSelect.min.js'?>" ></script>
<!--custome script for all page-->
<script src="<?php echo base_url().'assets/back/js/scripts.js';?>"></script>
<!-- custom script for this page-->
<script src="<?php echo base_url().'assets/back/js/sparkline-chart.js'?>"></script>
<script src="<?php echo base_url().'assets/back/js/easy-pie-chart.js'?>"></script>
<!-- data table jihan -->
<script src="<?php echo base_url().'assets/back/datatable/js/jquery.dataTables.js'?>"></script>
<script src="<?php echo base_url().'assets/back/datatable/js/dataTables.bootstrap.js'?>"></script>

<!-- MultiSelect With Select All Option with search  -->
<script src="<?php echo base_url().'assets/back/js/jquery.multiselect.js';?>"></script>

<script type="text/javascript">
  $('#accountall').multiselect({
    columns: 1,
    placeholder: 'Select All Account',
    search: true,
    selectAll: true
  });

  $('#accountres').multiselect({
    columns: 1,
    placeholder: 'Select Resident Account',
    search: true,
    selectAll: true
  });

  $('#accountvis').multiselect({
    columns: 1,
    placeholder: 'Select Visitor Account',
    search: true,
    selectAll: true
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $("#data-table").dataTable();
    $("#data-tablertsp").dataTable();
    $("#data-table2").dataTable();
    $("#data-table3").dataTable();
    $("#data-table4").dataTable();
  });
</script>


<script>
//knob
$(function() {
  $(".knob").knob({
    'draw' : function () {
      $(this.i).val(this.cv + '%')
    }
  })
});

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation : true,
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem : true

        });
      });

      //custom select box

      $(function(){
        $('select.styled').customSelect();
      });

    //delete tenant function
    $(".open-delete").click(function(){
      var avatar = $(this).attr("data-avatar");
      var idtenant = $(this).attr("data-id");
      $("#del_avatar").prop("value", avatar);
      $("#del_id").prop("value", idtenant);

    });

    //dropdown acoount notification
    $("#resident_dd").hide();
    $("#visitor_dd").hide(); 
    $("#all_dd").hide();                                           
    $("#privilege").on("change", function(){
      var v = $(this).val();
      if (v == "resident") {
        $("#visitor_dd").hide();
        $("#all_dd").hide();                                                                   
        $("#resident_dd").show();
      } else if (v == "visitor"){
        $("#resident_dd").hide();
        $("#all_dd").hide();                                                           
        $("#visitor_dd").show();        
      } else if (v == "all"){
        $("#resident_dd").hide();
        $("#visitor_dd").hide();
        $("#all_dd").show();                                                                           
      }
    });

    //close modal
    $("#close_modal").click(function(){
      $("#resident_dd").hide();
      $("#visitor_dd").hide(); 
      $("#all_dd").hide(); 
    })



  //delete hashtag
  $(".delete-hashtag").click(function(){
    var id_hashtag = $(this).attr("data-idhashtag");
    console.log(id_hashtag)

    $("#d_idhashtag").prop('value',id_hashtag);

  });

  //update hashtag
  $(".update-hashtag").click(function(){
    var idhashtag = $(this).attr("data-id");
    var tag = $(this).attr("data-tag");
    var description = $(this).attr("data-description");
    $("#u_idhashtag").prop("value", idhashtag);
    $("#u_hashtag").prop("value", tag);
    $("#u_desc").prop("value", description);
  });

//link video news
// if ($("#empty_video").checked = true){  
//   console.log("cek 1");
//   $('#input_url_video').removeAttr("hidden");
// }
// else{
//   $('#input_url_video').setAttribute("hidden");
// }
if($('#empty_video').checked) {
  $('#video').attr("readonly");
  //$('#url_video').attr("readonly");
  console.log("1cek");
} else {
  $('#url_video').attr("readonly");
}


    //update cctv function
    $(".update-cctv").click(function(){
      var idcctv = $(this).attr("data-id");
      var label = $(this).attr("data-label");
      var ipaddress = $(this).attr("data-ipaddress");
      var port = $(this).attr("data-port");
      var username = $(this).attr("data-username");
      var password = $(this).attr("data-password");
      var channel = $(this).attr("data-channel");
      var idcity = $(this).attr("data-idcity");
      $("#u_label").prop("value", label);
      $("#u_ipaddress").prop("value", ipaddress);
      $("#u_port").prop("value", port);
      $("#u_username").prop("value", username);
      $("#u_password").prop("value", password);
      $("#u_channel").prop("value", channel);
      $("#u_idcctv").prop("value", idcctv);
      $("#u_idcity").prop("value", idcity);
    });

    //update cctv rtsp function
    $(".update-cctvrtsp").click(function(){
      var idcctv = $(this).attr("data-id");
      var label = $(this).attr("data-label");
      var link = $(this).attr("data-link");
      $("#u_labelrtsp").prop("value", label);
      $("#u_link").prop("value", link);
      $("#u_idcctvrtsp").prop("value", idcctv);
    });

    //delete tenant
    $(".delete-tenant").click(function(){
      var avatar = $(this).attr("data-avatar");
      var idtenant = $(this).attr("data-id");
      var logo = $(this).attr("data-logo");
      $("#del_avatar").prop("value", avatar);
      $("#del_id").prop("value", idtenant);
      $("#del_logo").prop("value", logo);
    });
    //delete cctv rtsp
    $(".delete-rtsp").click(function(){
      var idcctv = $(this).attr("data-id");
      $("#del_idrtsp").prop("value", idcctv);
    });
    //delete history
    $(".deletehistory").click(function(){
      var idmenu = $(this).attr("data-id");
      $("#del_id").prop("value", idmenu);
    });
    //delete bookmark
    $(".delbook").click(function(){
      var idbookmark = $(this).attr("data-id");
      $("#delid").prop("value", idbookmark);
    });
    //delete menu
    $(".delete-menu").click(function(){
      var idmenu = $(this).attr("data-id");
      var linkcatalog = $(this).attr("data-linkcatalog");
      $("#del_id").prop("value", idmenu);
      $("#del_linkcatalog").prop("value", linkcatalog);
    });
    //update menu
    $(".update-menu").click(function(){
      var idmenu = $(this).attr("data-id");
      var menu = $(this).attr("data-menu");
      var price = $(this).attr("data-price");
      var linkcatalog = $(this).attr("data-linkcatalog");
      $("#u_idmenu").prop("value", idmenu);
      $("#u_menu").prop("value", menu);
      $("#u_price").prop("value", price);
      $("#u_linkcatalog").prop("value", linkcatalog);
    });
    //delete photo gallery tenant
    $(".delete-photo").click(function(){
      var imageurl = $(this).attr("data-imageurl");
      var idgallery = $(this).attr("data-idgallery");
      $("#del_imageurl").prop("value", imageurl);
      $("#del_idgallery").prop("value", idgallery);
    });

    //update photo gallery tenant
    $(".update-photo").click(function(){
      var idgallery = $(this).attr("data-id");
      var imageurl = $(this).attr("data-imageurl");
      var title = $(this).attr("data-title");

      $("#u_idgallery").prop("value", idgallery);
      $("#u_photo").prop("src", imageurl);
      $("#u_setphoto").prop("value", imageurl);
      $("#u_title").prop("value", title);
    });
    //delete photo discount coupon tenant
    $(".delete-discountcoupon").click(function(){
      var imageurldc = $(this).attr("data-imageurldc");
      var iddiscountcoupondc = $(this).attr("data-iddiscountcoupon");
      var fileurldc = $(this).attr("data-fileurldc");
      $("#del_imageurldc").prop("value", imageurldc);
      $("#del_iddiscountcoupondc").prop("value", iddiscountcoupondc);
      $("#del_fileurldc").prop("value", fileurldc);
    });
    //delete room
    $(".delete-room").click(function(){
      var idroom = $(this).attr("data-id");
      $("#delidroom").prop("value", idroom);
    });
    //update room
    $(".update-room").click(function(){
      var idroom = $(this).attr("data-id");
      var name = $(this).attr("data-name");
      var jumlah = $(this).attr("data-quantity");
      $("#uquantity").prop("value", jumlah);
      $("#uname").prop("value", name);
      $("#uidroom").prop("value", idroom);
    });

    //delete comment
    $(".delete-comment").click(function(){
      var idcomment = $(this).attr("data-id");
      $("#delidcomment").prop("value", idcomment);
    });
    //update comment
    $(".update-comment").click(function(){
      var idforum = $(this).attr("data-idforum");
      var idcomment = $(this).attr("data-id");
      var idaccount = $(this).attr("data-idaccount");
      var comment = $(this).attr("data-comment");
      $("#uidforum").prop("value", idforum);
      $("#ucomment").prop("value", comment);
      $("#uidaccount").prop("value", idaccount);
      $("#uidcomment").prop("value", idcomment);
    });

    //delete history
    $(".delete-history").click(function(){
      var idhistory = $(this).attr("data-id");
      $("#del_id").prop("value", idhistory);
    });

    //update file
    $(".update-currency").click(function(){
      var idcurrency = $(this).attr("data-id");
      var flag = $(this).attr("data-flag");
      var country = $(this).attr("data-country");
      var code = $(this).attr("data-code");
      var value = $(this).attr("data-value");
      $("#uidcurrency").prop("value", idcurrency);
      $("#uflag").prop("value", flag);
      $("#ucountry").prop("value", country);
      $("#ucode").prop("value", code);
      $("#uvalue").prop("value", value);
    });


    //delete news
    $(".delete-news").click(function(){
      var idnews = $(this).attr("data-id");
      $("#del_id").prop("value", idnews);
    });

    //update discountcoupon  tenant
    $(".update-discountcoupon").click(function(){
      var iddiscountcoupon = $(this).attr("data-iddiscountcoupon");
      var imageurldc = $(this).attr("data-imageurldc");
      var titledc = $(this).attr("data-titledc");
      var captiondc =  $(this).attr("data-captiondc");
      var fileurl =  $(this).attr("data-fileurl");
      var filename =  $(this).attr("data-filename");
      var filesize =  $(this).attr("data-filesize");

      if(imageurldc.length==0) {
        $("#u_ceknullavatar").prop('checked', true);
      } else if(imageurldc.length!=0) {
        $("#u_ceknullavatar").prop('checked', false);
      }
      if(fileurl.length==0) {
        $("#u_ceknullfile").prop('checked', true);
      } else if(fileurl.length!=0) {
        $("#u_ceknullfile").prop('checked', false);
      }

      $("#u_iddiscountcoupon").prop("value", iddiscountcoupon);
      $("#u_photodc").prop("src", imageurldc);
      $("#u_setphotodc").prop("value", imageurldc);
      $("#u_titledc").prop("value", titledc);
      CKEDITOR.instances.u_captiondc.setData(captiondc);
      $("#u_fileurl").prop("value", fileurl);
      $("#u_filename").prop("value", filename);
      $("#u_filesize").prop("value", filesize);
    });
    //delete photo gallery city
    $(".delete-gallerycity").click(function(){
      var imageurl = $(this).attr("data-imageurl");
      var idgallery = $(this).attr("data-idgallery");
      $("#del_imageurl").prop("value", imageurl);
      $("#del_idgallery").prop("value", idgallery);
    });

    //update photo gallery city
    $(".update-gallerycity").click(function(){
      var idgallery = $(this).attr("data-id");
      var avatar = $(this).attr("data-avatar");
      var title = $(this).attr("data-title");
      $("#u_idgallery").prop("value", idgallery);
      $("#u_avatar").prop("src", avatar);
      $("#u_setavatar").prop("value", avatar);
      $("#u_title").prop("value", title);
    });

    //update photo gallery property
    $(".update-galleryproperty").click(function(){
      var idgallery = $(this).attr("data-id");
      var avatar = $(this).attr("data-avatar");
      var title = $(this).attr("data-title");
      var idproperty = $(this).attr("data-idproperty");
      $("#u_idgallery").prop("value", idgallery);
      $("#u_avatar").prop("src", avatar);
      $("#u_setavatar").prop("value", avatar);
      $("#u_title").prop("value", title);
      $("#u_idproperty").prop("value", idproperty);
    });


    //update photo gallery news
    $(".update-gallerynews").click(function(){
      var idgallery = $(this).attr("data-id");
      var avatar = $(this).attr("data-avatar");
      var idnews = $(this).attr("data-idnews");
      var linkurl = $(this).attr("data-imageurl");
      var caption = $(this).attr("data-caption");
      $("#u_idgallery").prop("value", idgallery);
      $("#u_avatar").prop("src", avatar);
      $("#u_setavatar").prop("value", avatar);
      $("#u_idnews").prop("value", idnews);

      $("#uv_idgallery").prop("value", idgallery);
      $("#uv_avatar").prop("src", avatar);
      $("#uv_link").prop("value", linkurl);
      $("#uv_setavatar").prop("value", avatar);
      $("#uv_idnews").prop("value", idnews);
      $("#u_caption").prop("value", caption);
    });

      //delete rating user->tenant
      $(".delete-rating").click(function(){
        var idrating = $(this).attr("data-idrating");
        $("#del_idrating").prop("value", idrating);
      });

    //update rating user->tenant
    $(".update-rating").click(function(){
      var idrating = $(this).attr("data-idrating");
      var username = $(this).attr("data-username");
      var iduser = $(this).attr("data-iduser");
      var rating = $(this).attr("data-rating");
      var createdate = $(this).attr("data-createdate");
      $("#u_idrating").prop("value", idrating);
      $("#u_username").prop("value", username);
      $("#u_iduser").prop("value", iduser);
      $("#u_rating").prop("value", rating);
      $("#u_createdate").prop("value", createdate);
    });

    //delete Download file city
    $(".delete-downloadfile").click(function(){
      var iddownload = $(this).attr("data-id");
      var avatar = $(this).attr("data-avatar");
      var file = $(this).attr("data-linkfile");
      $("#del_iddownload").prop("value", iddownload);
      $("#del_avatar").prop("value", avatar);
      $("#del_file").prop("value", file);
    });
    //update Download file city
    $(".update-downloadfile").click(function(){
      var idfile = $(this).attr("data-id");
      var idcat = $(this).attr("data-idcategory");
      var title = $(this).attr("data-title");
      var avatar = $(this).attr("data-avatar");
      var linkfile = $(this).attr("data-linkfile");
      var filename = $(this).attr("data-filename");
      var filesize = $(this).attr("data-filesize");
      var idtenant = $(this).attr("data-idtenant");

      if(avatar.length==0) {
        $("#u_ceknullavatar").prop('checked', true);
      } else if(avatar.length!=0) {
        $("#u_ceknullavatar").prop('checked', false);
      }
      if(linkfile.length==0) {
        $("#u_ceknullfile").prop('checked', true);
      } else if(linkfile.length!=0) {
        $("#u_ceknullfile").prop('checked', false);
      }

      $("#uidfile").prop("value", idfile);
      $("#uidcategory").prop("value", idcat);
      $("#utitlefile").prop("value", title);
      $("#usetavatarfile").prop("value", avatar);
      $("#uavatarfile").prop("src", avatar);
      $("#ulinkfile").prop("value", linkfile);
      $("#ufilename").prop("value", filename);
      $("#ufilesize").prop("value", filesize);
      $("#uidtenant").prop("value", idtenant);
    });

    //alert duration
    setTimeout(function(){ $("#alert").hide(); <?php $this->session->set_flashdata('message', "");$this->session->set_flashdata('breakmessage', ""); ?> }, 7000);
    setTimeout(function(){ $("#alertrtsp").hide(); <?php $this->session->set_flashdata('message_rtsp', "");$this->session->set_flashdata('breakmessage_rtsp', ""); ?> }, 7000);
    setTimeout(function(){ $("#alertopenhour").hide() <?php $this->session->set_flashdata('messagehour', "");$this->session->set_flashdata('breakmessagehour', ""); ?> }, 7000);
    //filter function
    function GetSelectedTextValue(filter) {
      var selectedText = filter.options[filter.selectedIndex].innerHTML;
      var selectedValue = filter.value;

      window.location.replace("<?=base_url()."admin/tenant/".$title."?subcat="?>"+selectedValue);

    }

    //filter property
    function GetProperty(filter) {
      var selectedText = filter.options[filter.selectedIndex].innerHTML;
      var selectedValue = filter.value;

      window.location.replace("<?=base_url()."admin/getproperty?subcat="?>"+selectedValue);
    }

    function download(filter) {
      var selectedText = filter.options[filter.selectedIndex].innerHTML;
      var selectedValue = filter.value;

      window.location.replace("<?=base_url()."admin/download?subcat="?>"+selectedValue);

    }
  </script>
  <!-- quicksearch combobox */ -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#couponForm')
      /* Using Combobox for color and size select elements */
      .find('[name="color"]')
      .combobox()
      .end()
    });
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCr_MHRq3r-aIxVLa1M7RLcrznk2C0CDw8&v=3.exp"></script>
  <script type="text/javascript">

  </script>


