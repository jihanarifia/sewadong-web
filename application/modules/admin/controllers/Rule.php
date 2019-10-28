<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule extends MX_Controller {

  /**
* Index Page for this controller.
*
* Maps to the following URL
*     http://example.com/index.php/welcome
* - or -
*     http://example.com/index.php/welcome/index
* - or -
* Since this controller is set as the default controller in
* config/routes.php, it's displayed at http://example.com/
*
* So any other public methods not prefixed with an underscore will
* map to /indesx.php/welcome/<method_name>
* @see https://codeigniter.com/user_guide/general/urls.html
*/

  function __construct(){
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
      die();
    }
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    date_default_timezone_set('Asia/Jakarta');

    $get = $this->session->userdata('sc_sess');
    $privilege = $get[0]['privilege'];
    
    if(isset($privilege)) {
      if($privilege!='marketing') {
        $this->session->unset_userdata('sc_sess');
        $this->session->sess_destroy();
        redirect(base_url().'admin/');
      }
    }
  }

  public function index(){
    $url = base_api().'Rules/listall';
    $parser = $this->my_lib->native_curl($url); //call function
    
    $data['data_con'] = array();
    $arrParser = (array)$parser;

    foreach($arrParser as $value){
        if($value->validfrom != "" && $value->validfrom != null){
            $datevalidfrom = date("d/m/Y H:i:s",strtotime($value->validfrom));
        }else{
            $datevalidfrom = $value->validfrom;
        }

        if($value->validuntil != "" && $value->validuntil != null){
            $datevaliduntil = date("d/m/Y H:i:s",strtotime($value->validuntil));
        }else{
            $datevaliduntil = $value->validuntil;
        }

        array_push($data['data_con'], array(
            "id" => $value->id,
            "title" => $value->title,
            "title_id" => $value->title_id,
            "description" => $value->description,
            "description_id" => $value->description_id,
            "point" => $value->point,
            "active" => $value->active,
            "type" => $value->type,
            "uniqueCode" => $value->uniqueCode,
            "validfrom" => $datevalidfrom,
            "validuntil" => $datevaliduntil
        ));
    }

    $data['title'] = "Master Rule";
    $data['content'] = "point_rule";
    $this->load->view('admin/main', $data);
  }

  public function create(){
    $url = base_api().'Rules/genuniquecode';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['uniqueCode'] = $parser->uniqueCode;
    // $data['uniqueCode'] = "JSKS";

    $typeArray = array();  
    $typeArray[] = (object) array("idtype"=>"1","type"=>"General"); 
    $typeArray[] = (object) array("idtype"=>"2","type"=>"Event");
    $data['objType'] = $typeArray;
    
    $data['title_page'] = "Master Rule";
    $data['link'] = "rule";
    $data['title'] = "Create Rule";
    $data['content'] = "point_rule_insert";

    $this->load->view('admin/main', $data);
  }

  public function fn_insert_point_rule(){
      if($this->input->post('is_limit_rule') != null) { $limit = $this->input->post('limit'); }
      else { $limit = null; }
      
      $validfromdate = $this->input->post('validfromdate', TRUE);
      $validfromtime = $this->input->post('validfromtime', TRUE);
      $joinvalidfrom = $validfromdate ." ".$validfromtime;

      $validuntildate = $this->input->post('validuntildate', TRUE);
      $validuntiltime = $this->input->post('validuntiltime', TRUE);
      $joinvaliduntil = $validuntildate ." ".$validuntiltime;
      
      if($joinvalidfrom != "" && $joinvalidfrom != null && $joinvalidfrom != " "){
        $datevalidfrom = date("Y-m-d H:i:s",strtotime($joinvalidfrom));
      }else{
        $datevalidfrom = NULL;
      }

      if($joinvaliduntil != "" && $joinvaliduntil != null && $joinvaliduntil != " "){
        $datevaliduntil = date("Y-m-d H:i:s",strtotime($joinvaliduntil));
      }else{
        $datevaliduntil = NULL;
      }

      $data = array(
        "title" => $this->input->post('title', TRUE),
        "title_id" => $this->input->post('title_id', TRUE),
        "description" => $this->input->post('description', TRUE),
        "description_id" => $this->input->post('description_id', TRUE),
        "point" => $this->input->post('point', TRUE),
        "active" => $this->input->post('active', TRUE),
        "idtype" => $this->input->post('type', TRUE),
        "idtenant" => $this->input->post('idtenant', TRUE),
        "uniqueCode" => $this->input->post('uniquecode', TRUE),
        "validfrom" => $datevalidfrom,
        "validuntil" => $datevaliduntil,
        "stock" => $limit
      );

    $url = base_api().'Rules/create';
    $parser = $this->my_lib->native_curl($url,$data);
    
    if ($parser->statusCode  == "10") {
      $this->session->set_flashdata('message', $parser->message);
    } else {
      $this->session->set_flashdata('breakmessage', $parser->message);
    }

    redirect(base_url('admin/rule'));
  }

  public function edit(){
    $id = $this->input->get('id', TRUE);
    $url = base_api().'Rules/detail/'.$id;
    $parser = $this->my_lib->native_curl($url); //call function

    if($parser->validfrom != NULL){
      $validfrom = explode(" ",$parser->validfrom);
      $validfromdate = date("Y-m-d",strtotime($validfrom[0]));
      $validfromtime = date("H:i:s",strtotime($validfrom[1]));
    }
    
    if($parser->validuntil != NULL){
      $validuntil = explode(" ",$parser->validuntil);
      $validuntildate = date("Y-m-d",strtotime($validuntil[0]));
      $validuntiltime = date("H:i:s",strtotime($validuntil[1]));
    }

    $typeArray = array();  
    $typeArray[] = (object) array("idtype"=>"1","type"=>"General"); 
    $typeArray[] = (object) array("idtype"=>"2","type"=>"Event");
    $data['objType'] = $typeArray;
    
    $data['id'] = $parser->id;
    $data['title'] = $parser->title;
    $data['title_id'] = $parser->title_id;
    $data['description'] = $parser->description;
    $data['description_id'] = $parser->description_id;
    $data['point'] = $parser->point;
    $data['active'] = $parser->active;
    $data['type'] = $parser->type;
    $data['uniqueCode'] = $parser->uniquecode;
    $data['validfromdate'] = $validfromdate;
    $data['validfromtime'] = $validfromtime;
    $data['validuntildate'] = $validuntildate;
    $data['validuntiltime'] = $validuntiltime;
    $data['tenant'] = $parser->tenant;
    $data['limit'] = $parser->stock;
    
    $data['title_page'] = "Edit Rule";
    $data['prev_page'] = "Master Rule";
    $data['link'] = "rule";
    $data['content'] = "point_rule_update";

    $this->load->view('admin/main', $data);
  }

  public function fn_update_point_rule(){
    if($this->input->post('is_limit_rule') != null) { $limit = $this->input->post('limit'); }
    else { $limit = null; }

    $validfromdate = $this->input->post('validfromdate', TRUE);
    $validfromtime = $this->input->post('validfromtime', TRUE);
    $joinvalidfrom = $validfromdate ." ".$validfromtime;

    $validuntildate = $this->input->post('validuntildate', TRUE);
    $validuntiltime = $this->input->post('validuntiltime', TRUE);
    $joinvaliduntil = $validuntildate ." ".$validuntiltime;
    
    if($joinvalidfrom != "" && $joinvalidfrom != null && $joinvalidfrom != " "){
      $datevalidfrom = date("Y-m-d H:i:s",strtotime($joinvalidfrom));
    }else{
      $datevalidfrom = NULL;
    }

    if($joinvaliduntil != "" && $joinvaliduntil != null && $joinvaliduntil != " "){
      $datevaliduntil = date("Y-m-d H:i:s",strtotime($joinvaliduntil));
    }else{
      $datevaliduntil = NULL;
    }

    $data = array(
      "id" => $this->input->post('id', TRUE),
      "title" => $this->input->post('title', TRUE),
      "title_id" => $this->input->post('title_id', TRUE),
      "description" => $this->input->post('description', TRUE),
      "description_id" => $this->input->post('description_id', TRUE),
      "point" => $this->input->post('point', TRUE),
      "active" => $this->input->post('active', TRUE),
      "idtype" => $this->input->post('type', TRUE),
      "idtenant" => $this->input->post('idtenant', TRUE),
      "validfrom" => $datevalidfrom,
      "validuntil" => $datevaliduntil,
      "stock" => $limit
    );
    
    $url = base_api().'Rules/update';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser->statusCode  == "10") {
      $this->session->set_flashdata('message', $parser->message);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', $parser->message);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete(){
    $data = array(
      'id' => $this->input->post('id', TRUE)
    );

    $url = base_api().'Rules/delete';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser->statusCode  == "10") {
      $this->session->set_flashdata('message', $parser->message);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', $parser->message);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function generateqrcodepage(){
    $dataqrcode = $this->input->get('dataqrcode', TRUE);  
    $tenant = $this->input->get('tenant', TRUE);  
    
    $this->load->library('ciqrcode');
    header("Content-Type: image/png");
    $params['level'] = 'L';
    $params['size'] = 7;
    $params['savename'] = false;

    if($tenant == "" || $tenant == null) {
      $qrCode = base64_encode('{"uniqueCode":"'.$dataqrcode.'"}');
      $params['data'] = $qrCode;
      $this->ciqrcode->generate($params);
    }else{
      $qrCode = base64_encode('{"uniqueCode":"'.$dataqrcode.'","tenant":"'.$tenant.'"}');
      $params['data'] = $qrCode;
      $this->ciqrcode->generate($params);
    }
  }

  public function forceDownloadQR(){
    $dataqrcode = $this->input->get('dataqrcode', TRUE);  
    $tenant = $this->input->get('tenant', TRUE);  
    $tenantsname = $this->input->get('tenantsname', TRUE); 

    $width = 500;
    $height = 500;
    if($tenant == "" || $tenant == null) {
      $url = base64_encode('{"uniqueCode":"'.$dataqrcode.'"}');
      $filename = "qrcode";
    }else{
      $url = base64_encode('{"uniqueCode":"'.$dataqrcode.'","tenant":"'.$tenant.'"}');
      $filename = "qrcode-".$tenantsname;
    }
    $image  = 'http://chart.apis.google.com/chart?chs='.$width.'x'.$height.'&cht=qr&chld=L|2&chl='.$url;
    $file = file_get_contents($image);
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$filename.".png");
    header("Cache-Control: public");
    header("Content-length: " . strlen($file)); // tells file size
    header("Pragma: no-cache");
    echo $file;
    die;
  }

  public function downloadAllQR(){
    $dataqrcode = $this->input->get('dataqrcode', TRUE);
    $tenant = $this->input->get('tenant', TRUE);
    $tenantsname = $this->input->get('tenantsname', TRUE);
    $id = explode (",", $tenant);
    $name = explode (";", $tenantsname);
    $arr = (array)$id;

    $width = 500;
    $height = 500;

    $files = array();
    for($i=0;$i < count($arr);$i++){
      if($tenant == "" || $tenant == null) {
        $url = base64_encode('{"uniqueCode":"'.$dataqrcode.'"}');
        $filename = "qrcode";
      }else{
        $url = base64_encode('{"uniqueCode":"'.$dataqrcode.'","tenant":"'.$id[$i].'"}');
        $filename = "qrcode-".$name[$i];
      }
      $image  = 'http://chart.apis.google.com/chart?chs='.$width.'x'.$height.'&cht=qr&chld=L|2&chl='.$url;
      array_push($files, array(
        "qrcode"=> $image,
        "filename"=> $filename
      ));
    }
    # create new zip object
    $zip = new ZipArchive();

    # create a temp file & open it
    $tmp_file = tempnam('.', '');
    $zip->open($tmp_file, ZipArchive::CREATE);

    # loop through each file
    foreach ($files as $file) {
        # download file
        $download_file = file_get_contents($file["qrcode"]);

        #add it to the zip
        $zip->addFromString(basename($file["filename"]).".png", $download_file);
    }
    # close zip
    $zip->close();

    # send the file to the browser as a download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="file.zip"');
    readfile($tmp_file);
    unlink($tmp_file);
    die();
  }

}   //=== Class closer ===