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
                  <li><a href="#"> City</a></li>
                  <li class="active">Transportation Category</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Transportation Category</h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus_alt2"></i>  Add</a>
                      </div>
                      <div class="col-lg-4">
                        <div class="row">
                          <div class="col-lg-5">
                            <select class="form-control">
                              <option>Name</option>
                            </select>
                            
                          </div>
                          <div class="col-lg-7">
                            <form class="navbarsearch">
                              <input class="form-control" placeholder="Search" type="text">
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </header>
                  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="insertform" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 class="modal-title">Insert Transportation Category</h4>
                        </div>
                        <div class="modal-body">

                          <form class="form-horizontal" role="form">
                            <div class="form-group ">
                              <label for="fullname" class="control-label col-lg-2">Name <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="Name" name="name" type="text">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info">Simpan</button>
                              </div>
                            </div>
                          </form>

                        </div>

                      </div>
                    </div>
                  </div>
                  <table class="table table-striped table-advance table-hover">
                   <tbody>
                    <tr>
                      <th><i class=""></i>ID</th>
                      <th><i class="icon_profile"></i>Name</th>
                      <th><i class="icon_cogs"></i> Action</th>
                    </tr>  
                    <tr>
                      <td>1</td>
                      <td>Public Transportation</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success" href="<?=base_url().'admin/ctransportationcategoryedit'?>"><i class="icon_pencil"></i></a>
                          <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr>                         
                    <tr>
                      <td>2</td>
                      <td>Train</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success" href="<?=base_url().'admin/ctransportationcategoryedit'?>"><i class="icon_pencil"></i></a>
                          <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr> 
                    <tr>
                      <td>3</td>
                      <td>Bus</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success" href="<?=base_url().'admin/ctransportationcategoryedit'?>"><i class="icon_pencil"></i></a>
                          <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr> 
                    <tr>
                      <td>4</td>
                      <td>Rental Car</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success" href="<?=base_url().'admin/ctransportationcategoryedit'?>"><i class="icon_pencil"></i></a>
                          <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr> 
                    <tr>
                      <td>5</td>
                      <td>Taxi</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success" href="<?=base_url().'admin/ctransportationcategoryedit'?>"><i class="icon_pencil"></i></a>
                          <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                        </div>
                      </td>
                    </tr> 
                  </tbody>
                </table>
                <ul class="pagination pull-right">
                  <li><a href="#">«</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">»</a></li>
                </ul>
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
</body>
</html>
