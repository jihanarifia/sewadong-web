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
                  <li class="active">Page</a></li>
                </ul>
                <!--breadcrumbs end -->
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3> Page </h3>
                <section class="panel">
                  <header class="panel-heading">
                    <div class="row">
                      <div class="col-lg-8">
                        <a href="#insertform" class="btn btn-primary" data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                      </div>
                      <div class="col-lg-4">
                        <div class="row">
                          <div class="col-lg-5">
                            <select class="form-control">
                              <option>Title</option>
                              <option>Content</option>
                              <option>ID City</option>
                              <option>ID Page</option>
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
                          <h4 class="modal-title">Insert Page</h4>
                        </div>
                        <div class="modal-body">

                          <form class="form-horizontal" role="form">
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
                              <label for="address" class="control-label col-lg-2">Title <span class="required">*</span></label>
                              <div class="col-lg-10">
                                <input class=" form-control" id="name" name="name" type="text" placeholder="Title">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-2">Content</label>
                              <div class="col-sm-10">
                                <textarea class="form-control ckeditor" name="editor1" rows="6"></textarea>
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
                      <th><i class="icon_id"></i>ID Page</th>
                      <th><i class="icon_pin_alt"></i>ID City</th>
                      <th><i class="icon_id-2"></i>Title</th>
                      <th><i class="icon_document"></i>Content</th>
                      <th><i class="icon_cogs"></i> Action</th>
                      <tr>
                        <td>1</td>
                        <td>Malang</td>
                        <td>About us</td>
                        <td>
                          Time zone WIB (UTC+7)<br>
                          Area code(s) +62 21<br>
                          Vehicle registration B<br>
                          Website www.lippo-cikarang.co.id
                        </td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/cpageedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr>                          
                      <tr>
                        <td>2</td>
                        <td>Malang</td>
                        <td>Terms</td>
                        <td>
                          Time zone WIB (UTC+7)<br>
                          Area code(s) +62 21<br>
                          Vehicle registration B<br>
                          Website www.lippo-cikarang.co.id
                        </td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/cpageedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr>      
                      <tr>
                        <td>3</td>
                        <td>Malang</td>
                        <td>Privacy</td>
                        <td>
                          Time zone WIB (UTC+7)<br>
                          Area code(s) +62 21<br>
                          Vehicle registration B<br>
                          Website www.lippo-cikarang.co.id
                        </td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/cpageedit'?>"><i class="icon_pencil"></i></a>
                            <a class="btn btn-danger" href="#"><i class="icon_trash_alt"></i></a>
                          </div>
                        </td>
                      </tr>      
                      <tr>
                        <td>4</td>
                        <td>Malang</td>
                        <td>Policy</td>
                        <td>
                          Time zone WIB (UTC+7)<br>
                          Area code(s) +62 21<br>
                          Vehicle registration B<br>
                          Website www.lippo-cikarang.co.id
                        </td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-success" href="<?=base_url().'admin/cpageedit'?>"><i class="icon_pencil"></i></a>
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
