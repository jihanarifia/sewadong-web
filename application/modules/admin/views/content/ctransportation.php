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
                  <li class="active">Transportation</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Transportation</h3>
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
                              <option>ID City</option>
                              <option>ID Transportation Category</option>
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
                          <h4 class="modal-title">Insert Transportation</h4>
                        </div>
                        <div class="modal-body">

                          <form class="form-horizontal" role="form">
                            <div class="form-group">
                              <label for="fullname" class="control-label col-lg-2">Transportation Category<span class="required">*</span></label>
                              <div class="col-lg-10">
                                <select class="form-control m-bot15" id="subcategory">
                                  <option>Public Transportation</option>
                                  <option>Train</option>
                                  <option>Bus</option>
                                  <option>Taxi</option>
                                  <option>Car Rental</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="fullname" class="control-label col-lg-2">City<span class="required">*</span></label>
                              <div class="col-lg-10">
                                <select class="form-control m-bot15" id="subcategory">
                                  <option>Malang</option>
                                  <option>Jakarta</option>
                                  <option>Surabaya</option>
                                  <option>Yogyakarta</option>
                                  <option>Semarang</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group ">
                              <label for="address" class="control-label col-lg-2">Name <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="name" name="name" type="text" placeholder="Name">
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
                      <th><i class="icon_star"></i>ID Transportation</th>
                      <th><i class="icon_star"></i>ID Transportation Category</th>
                      <th><i class="icon_pin_alt"></i>ID City</th>
                      <th><i class="icon_profile"></i>Name</th>
                      <th><i class="icon_cogs"></i> Action</th>
                      <tr>
                        <td>1</td>
                        <td>Public Transportation</td>
                        <td>Malang</td>
                        <td>Angkot</td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/ctransportationedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr>                         
                      <tr>
                        <td>2</td>
                        <td>Train</td>
                        <td>Malang</td>
                        <td>Gajayana Train</td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/ctransportationedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr> 
                      <tr>
                        <td>3</td>
                        <td>Bus</td>
                        <td>Malang</td>
                        <td>Restu Panda Bus</td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/ctransportationedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr> 
                      <tr>
                        <td>4</td>
                        <td>Rental Car</td>
                        <td>Malang</td>
                        <td>Avanza Car</td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/ctransportationedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr> 
                      <tr>
                        <td>5</td>
                        <td>Taxi</td>
                        <td>Malang</td>
                        <td>Citra Taxi</td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/ctransportationedit'?>"><i class="icon_pencil"></i></a>
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
