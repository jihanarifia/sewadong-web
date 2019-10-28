<!-- container section start -->
<section id="container" class="">
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="#"><i class="icon_house_alt"></i> Home</a></li>
            <li class="active"><?=$title?></a></li>
          </ul>
          <!--breadcrumbs end -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <h3> <?=$title?></h3>
          <section class="panel">
            <header class="panel-heading">
            </header>
            <table class="table table-hover table-responsive" id="data-table">
              <thead>
                <tr>                  
                  <th><i class="icon_star"></i> ID</th>
                  <th><i class="icon_profile"></i> Name</th>                  
                </tr>
              </thead>
              <tbody>
               <?php if(isset($data_con)!=false && empty($data_con)==false) { $i=0; foreach($data_con as $data_con[]) { ?>  
                <tr>
                  <td><?=$data_con[$i]['id_tenant_category']?></td>
                  <td><?=$data_con[$i]['tenant_category']?></td>
                </tr>                         
                <?php $i++;} } else { ?>
                  <tr><td colspan="6">No result found</td></tr>
                  <?php } ?>
                </tbody>
              </table> 
            </section>
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
