
                                    
                                                                
      <!-- container section start -->
      <section id="container" class="">
        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
            <div class="row">
              <div class="col-lg-12">
                <!--breadcrumbs start -->
                  <ul class="breadcrumb">
                      <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li>
                      <li class="active">User Feedback</a></li>
                  </ul>
                </div>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <!-- <h3> User Feedback</h3> -->
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                        <button type="button" id="more" class="btn btn-default" data-toggle="collapse" data-target="#about">
                          Show advanced filters <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>
                      </div>
                      <form role="form" action="<?=base_url().'admin/feedback'?>" method="post" enctype="multipart/form-data" id="myForm">
                      <div class="col-lg-4 text-right">
                        <button type="submit" class="btn btn-primary" id="btn_export" name="btn_export" value="Export to Excel"><i class="icon_documents_alt"></i>&nbsp;Export to Excel</button>
                        <a href="<?=base_url().'admin/feedback'?>" class="btn btn-primary"><i class="icon_refresh"></i>&nbsp; Refresh</a>
                      </div>
                    </div>
                  </header>
                  <div id="advance-filters">
                    <div class="row">
                      <!-- Form open tag -->
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label for="rate">Rating</label>
                              <input type="hidden" value="<?php echo $parameter['rate'];?>" id="rateexport" name="rateexport" class="form-control">
                              <div>                                
                                <fieldset class="rating">
                                  <input type="radio" id="star5" name="rate" value="5" /><label class = "full" for="star5" title="5"></label>
                                  <input type="radio" id="star4" name="rate" value="4" /><label class = "full" for="star4" title="4"></label>
                                  <input type="radio" id="star3" name="rate" value="3" /><label class = "full" for="star3" title="3"></label>
                                  <input type="radio" id="star2" name="rate" value="2" /><label class = "full" for="star2" title="2"></label>
                                  <input type="radio" id="star1" name="rate" value="1" /><label class = "full" for="star1" title="1"></label>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-9 row" style="padding-right:5px;">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Start Date</label>
                                <input onfocus="(this.type='date')" value="<?php echo $parameter['startDate'];?>" id="startdate" name="startdate" class="form-control" placeholder="Start Date" >
                              </div>
                            </div>
                            <div class="col-lg-6" style="padding:0;">
                              <div class="form-group">
                                <label>End Date</label>
                                <input onfocus="(this.type='date')" value="<?php echo $parameter['endDate'];?>" id="enddate" name="enddate" class="form-control" placeholder="End Date" >
                              </div>
                            </div>
                          </div>
                        
                        
                          <div class="col-lg-12">
                            <div class="button row">
                              <div class="col-lg-5">
                              </div>
                              <div class="col-lg-5">
                              </div>
                              <div class="col-lg-2" style="padding:0;">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                              </div>
                            </div>
                          </div>
                        
                        </form>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-advance table-hover demo-table" id="data-table">
                        <thead>
                         <tr>
                          <th><i class="icon_star"></i> Rating</th>
                          <th width="130px;"><i class="icon_calendar"></i> Created On</th>
                          <th><i class="icon_profile"></i> Username</th>
                          <th><i class="icon_id"></i> Email</th>
                          <th width="350px;"><i class="icon_book"></i> Feedback</th>
                          <th><i class="icon_tools"></i> Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                        <tr>
                          <td>
                            <span class="hidden"><?=$data_con[$i]['rate']?></span>
                            <ul>
                              <?php
                              $a=0;
                              for($a=1;$a<=5;$a++) {
                              $selected = "";
                              if(!empty($data_con[$i]['rate']) && $a<=$data_con[$i]['rate']) {
                              $selected = "selected";
                              }
                              ?>
                              <li class='<?php echo $selected; ?>';">&#9733;</li>
                              <?php }  ?>
                            <ul>
                          </td>
                          <td><?=$data_con[$i]['createdOn']?></td>
                          <td><?=$data_con[$i]['fullname']?></td>
                          <td><?=$data_con[$i]['email']?></td>
                          <td class="text-justify"><?=substr($data_con[$i]['feedback'], 0, 95) .((strlen($data_con[$i]['feedback']) > 95) ? '...' : '')?></td>
                          <td>
                            <a class="btn btn-warning" href="<?=base_url().'admin/feedbackdetail?id='.$data_con[$i]['id']?>"><i class="fa fa-eye" ></i></a>
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
              <!-- page end-->
            </section>
          </section>
        </section>
        <!--main content end-->
      </section>
      <!-- container section end -->

      <script>
        $("#startdate").change(function () {
          var startDate = document.getElementById("startdate").value;    
          var endDate = document.getElementById("enddate").value;    
          var now = Date.now();
          if((Date.parse(startDate)) > now){
            alert("Start date shouldn't be greater than now");
              document.getElementById("startdate").value = "";
          }
          if ((Date.parse(startDate) > Date.parse(endDate))) {
              alert("End date should be greater than start date or same with start date");
              document.getElementById("enddate").value = "";
          }
        });
      </script>
      <script>
        $("#enddate").change(function () {
          var startDate = document.getElementById("startdate").value;
          var endDate = document.getElementById("enddate").value;    
          var now = Date.now();
          if((Date.parse(endDate)) > now){
            alert("End date shouldn't be greater than now");
              document.getElementById("enddate").value = "";
          }
          if ((Date.parse(startDate) > Date.parse(endDate))) {
              alert("End date should be greater than start date or same with start date");
              document.getElementById("enddate").value = "";
          }
        });
      </script>

      <script>
        $('#more').click(function () {
        var x = document.getElementById("advance-filters");
        if($('button span').hasClass('glyphicon-chevron-right'))
        {
            $('#more').html('Hide advanced filters <span class="glyphicon glyphicon-chevron-down"></span>'); 
            x.style.display = "block";
        }
        else
        {      
            $('#more').html('Show advanced filters <span class="glyphicon glyphicon-chevron-right"></span>'); 
            x.style.display = "none";
        }
        }); 
      </script>
      <script>
        Vue.component('star-rating', VueStarRating.default)

        new Vue({
          el: '#app',
          methods: {
            setRating: function(rating) {
              this.rating = "You have Selected: " + rating + " stars";
            },
            showCurrentRating: function(rating) {
              this.currentRating = (rating === 0) ? this.currentSelectedRating : "Click to select " + rating + " stars"
            },
            setCurrentSelectedRating: function(rating) {
              this.currentSelectedRating = "You have Selected: " + rating + " stars";
            }
          },
          data: {
            rating: "No Rating Selected",
            currentRating: "No Rating",
            currentSelectedRating: "No Current Rating",
            boundRating: 3,
          }
        });

      </script>
      <script type="text/javascript">                                     
                                     function rate(rate){
                                      var r = rate;                         
                                       document.getElementById("star" + r).checked = true;
                                     }
                                     </script>
                                  <?php                                  
                                  $rate = 0;
                                  for($a=1;$a<=5;) {                                                                    
                                    if($a == $parameter['rate']){
                                      $rate = $a;                                      
                                      echo "<script type='text/javascript'>
     rate('$rate');
     </script>"
;
                                    }$a++;                                       
                                     }?>                                       
