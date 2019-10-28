<html>
    <head>
        <link href="<?php echo base_url().'assets/front/css/bootstrap-material-design.min.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url().'assets/front/css/bootstrap-theme.min.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url().'assets/front/css/bootstrap.min.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url().'assets/front/css/ripples.min.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url().'assets/front/css/snackbar.min.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url().'assets/front/css/style.css';?>" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal">
                      <fieldset>
                        <legend>Legend</legend>
                        <div class="form-group">
                          <label for="inputEmail" class="col-md-2 control-label">Email</label>

                          <div class="col-md-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword" class="col-md-2 control-label">Password</label>

                          <div class="col-md-10">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Password">

                            <!--
                            <div class="checkbox">
                              <label>
                                <input type="checkbox"> Checkbox
                              </label>
                              <label>
                                <input type="checkbox" disabled> Disabled Checkbox
                              </label>
                            </div>
                            <br>

                            <div class="togglebutton">
                              <label>
                                <input type="checkbox" checked> Toggle button
                              </label>
                            </div>
                            -->
                          </div>
                        </div>
                        <div class="form-group" style="margin-top: 0;"> <!-- inline style is just to demo custom css to put checkbox below input above -->
                          <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox"> Checkbox
                              </label>
                              <label>
                                <input type="checkbox" disabled=""> Disabled Checkbox
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-offset-2 col-md-10">
                            <div class="togglebutton">
                              <label>
                                <input type="checkbox" checked=""> Toggle button
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputFile" class="col-md-2 control-label">File</label>

                          <div class="col-md-10">
                            <input type="text" readonly="" class="form-control" placeholder="Browse...">
                            <input type="file" id="inputFile" multiple="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="textArea" class="col-md-2 control-label">Textarea</label>

                          <div class="col-md-10">
                            <textarea class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label">Radios</label>

                          <div class="col-md-10">
                            <div class="radio radio-primary">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                Option one is this
                              </label>
                            </div>
                            <div class="radio radio-primary">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                Option two can be something else
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="select111" class="col-md-2 control-label">Select</label>

                          <div class="col-md-10">
                            <select id="select111" class="form-control">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="select222" class="col-md-2 control-label">Select Multiple</label>

                          <div class="col-md-10">
                            <select id="select222" multiple="" class="form-control">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-10 col-md-offset-2">
                            <button type="button" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url().'assets/front/js/bootstrap.min.js';?>" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/front/js/snackbar.min.js';?>" type="text/javascript"></script>
    <script src="<?php echo base_url().'assets/front/js/material.min.js';?>" type="text/javascript"></script>    
    <script src="<?php echo base_url().'assets/front/js/ripples.min.js';?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $.material.init();
        });
    </script>
</html>