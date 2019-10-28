<section id="container">
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
            <li><a href="<?=base_url().'admin/dashboard'?>"><i class="icon_house_alt"></i> Home</a></li> 
            <li class="active"> City </li>
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
              <section>
            <!-- <header>
              Cikarang City
            </header> -->
            <div>
              <form method="post" action="<?= base_url() . 'admin/cityupdate' ?>" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="panel">
                      <div class="panel-heading">
                        <h3>Area</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="name">City Name</label>
                          <input type="text" class="form-control" name="cityname" placeholder="City" value="<?=$data_detail[0]->cityname?>" required>
                        </div>
                        <div class="form-group">
                          <label for="name">City Area</label>
                          <input type="number" min="0" class="form-control" name="cityarea" placeholder="City" value="<?=$data_detail[0]->cityarea?>" required>
                        </div>
                        <hr>
                        <div class="form-group">
                          <label for="phone">Time Zone</label>
                          <input type="text" class="form-control" name="timezone" placeholder="Time Zone" required value="<?=$data_detail[0]->timezone?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Area Code's</label>
                          <input type="text" class="form-control" name="areacode" placeholder="Code Area" required value="<?=$data_detail[0]->areacode?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Vehicle Registration</label>
                          <input type="text" class="form-control" name="vehicle" placeholder="Vehicle Registration" required value="<?=$data_detail[0]->vehicleregistration?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Website</label>
                          <input type="text" class="form-control" name="website" placeholder="Website" required value="<?=$data_detail[0]->website?>">
                        </div>
                      </div>
                    </div>  
                  </div>
                  <div class="col-lg-4">
                    <div class="panel">
                      <div class="panel-heading">
                        <h3>Population</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="phone">Resident</label>
                          <input type="number" min="0" class="form-control" id="resident" name="resident" placeholder="Resident" required value="<?=$data_detail[0]->residentpopulation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Employment</label>
                          <input type="number" min="0" class="form-control" id="employment" name="employment" placeholder="Employment" required value="<?=$data_detail[0]->employmentpopulation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Jobs</label>
                          <input type="number" min="0" class="form-control" name="jobspopulation" placeholder="Jobs" required value="<?=$data_detail[0]->jobspopulation?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="panel">
                      <div class="panel-heading">
                        <h3>Information</h3>
                      </div>
                      <div class="panel-body">
                        <div class="form-group">
                          <label for="phone">Jobs</label>
                          <input type="number" min="0" class="form-control" name="jobsinformation" placeholder="Jobs" required value="<?=$data_detail[0]->jobsinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Trees</label>
                          <input type="number" min="0" class="form-control" id="trees" name="trees" placeholder="Trees" required value="<?=$data_detail[0]->treesinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Roads</label>
                          <input type="number" min="0" class="form-control" id="roads" name="roads" placeholder="Roads" required value="<?=$data_detail[0]->roadinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">House</label>
                          <input type="number" min="0" class="form-control" id="house" name="house" placeholder="House" required value="<?=$data_detail[0]->houseinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Shop House</label>
                          <input type="number" min="0" class="form-control" id="shophouse" name="shophouse" placeholder="Shop House" required value="<?=$data_detail[0]->shophouseinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">School</label>
                          <input type="number" min="0" class="form-control" id="school" name="school" placeholder="School" required value="<?=$data_detail[0]->schoollinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">School International</label>
                          <input type="number" min="0" class="form-control" name="schoolinternational" placeholder="School International" required value="<?=$data_detail[0]->internationalschoollinformation?>">
                        </div>
                        <div class="form-group">
                          <label for="phone">Service Apartment</label>
                          <input type="number" min="0" class="form-control" id="serviceapartment" name="serviceapartment" placeholder="Service Apartment" required value="<?=$data_detail[0]->serviceapartmentinformation?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-10"></div>
                  <div class="col-lg-2">
                    <input type="hidden" name="idcity" value="<?=$data_detail[0]->idcity?>">
                    <button type="submit" name="inserttenant"  class="btn btn-primary"><i class="icon_floppy"></i>&nbsp;Save</button>
                  </div>
                </div>
              </form>

            </div>
          </section>
        </div>
      </div>
    </section>
  </section>
</section>