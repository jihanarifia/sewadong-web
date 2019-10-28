<script type="text/javascript">
$(function(){
  $.material.init();

  //===============Form login=================
  $(".form-group select").dropdown();                        

  // Calling Login Form
  $("#login_form").click(function(){
    $(".social_login").hide();
    $(".user_login").show();
    return false;
  });

  // Calling Login Form
  $(".forgot_password").click(function(){
    $(".user_login").hide();
    $(".forgot").show();
    return false;
  });            

  // Going back to Social Forms
  $("#bck_social").click(function(){
    $(".user_login").hide();                
    $(".social_login").show();                
    return false;
  });

  // Going back to Login Forms
  $("#bck_login").click(function(){
    $(".forgot").hide();
    $(".user_login").show();              
    return false;
  });

  //===============Rating content=================
  $('.bs-component [data-toggle="tooltip"]').tooltip();

  $(".bs-component").hover(function () {
    $(this).append($button);
    $button.show();
  }, function () {
    $button.hide();
  });
});    		
</script>