<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

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
    $privilege = $get['role_id'];
    
    if(isset($privilege)) {
      if($privilege!='administrator') {
        $this->session->unset_userdata('sc_sess');
        $this->session->sess_destroy();
        redirect(base_url().'admin/');
      }
    }
  }

  public function sendmailactivation() {
    $email = $this->input->get('email', TRUE);
    $name = $this->input->get('name', TRUE);

    $url = base_third_api_emailvalidate();
    $data = array(
      'email' => $email,
      'name' => $name
    );
    $payload = json_encode($data);
    $result = $this->my_lib->email_curl($url,$payload);

    redirect(base_url().'admin/returnemail');
  }

  public function returnemail() {
    $a= array(['status' => true, 'message' => "success"]);

    $b = json_encode($a, JSON_PRETTY_PRINT);

    header('Content-Type: application/json');
    echo $b;
  }

  public function sendmailforget() {
    $message = $this->input->get('message', TRUE);
    $email = $this->input->get('email', TRUE);
    $url = base_third_api_emailforget();
    $data = array(
      'to' => [$email],
      'cc' => [$email],
      'subjectemail' => "Email password request: Reset Your LiveIn Account Password",
      'bodyemail' => "<div>".$message."</div>"
    );
    $payload = json_encode(  $data );
    $result = $this->my_lib->email_curl($url,$payload);
  }

  public function index()
  {
    $get = $this->session->userdata('sc_sess');
    if(isset($get)) {
      $privilege = $get['role_id'];
      if($privilege=='1') {
        redirect(base_url().'admin/dashboard');
      }
    } 

    $data['title'] = "Login";
    $data['content']="login";
    $this->load->view('admin/mainlogin',$data);
  }

  public function exec_curl($url, $data, $method){
    $content = json_encode($data);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); 
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-type: application/json",'Content-Length: ' . strlen($content)));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);
    $response = json_decode($json_response, true);
    return $response;
  }

  public function login() {
    $data = array(
      'identifier' => $this->input->post('email', TRUE),
      'password' => $this->input->post('password', TRUE)
    );
    $url = base_api().'user/login/';
    $res = $this->exec_curl($url,$data, "POST");
    $result = $res['result'];
    if(isset($result)){
      $user=array();
      $role = $result['role_id'] =="1" || $result['role_id'] =="2" ? 'administrator' : 'User';
      array_push($user, array(
        "idaccount"=> $result['user_id'],
        "email" => $result['email'],
        "username" => $result['username']!=null?$result['username']:"Admin",
        "privilege"=> $role
      )); 
      $this->session->set_userdata('sc_sess', $user); //make session
      redirect(base_url('admin/dashboard'));
     } else {
      $this->session->set_flashdata('login', "Invalid email/password");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function logout(){
    $this->session->unset_userdata('sc_sess');
    $this->session->sess_destroy();

    $this->load->library('user_agent');
    redirect(base_url('admin/'));
  }

  public function dashboard()
  {
    //get pagenumber for paging
    // $data['pagenumber'] = $this->uri->segment(3)=="page" ? $this->uri->segment(4) : 1;
    $url = base_api().'News/?action=listnews&pagenumber=1&pagesize=5';
    $parser = $this->my_lib->native_curl($url); //call function

    $data['news'] = array();
    if(isset($parser[0]->status)==true) {
      $data['news'] = array();
      $count = count($parser);
      for($i=0; $i<$count-1; $i++) {
        array_push($data['news'], array(
          "idnews" => $parser[$i]->idnews,
          "avatar" => $parser[$i]->avatar,
          "createdate" => date("d F Y - H:i", strtotime($parser[$i]->createdate)),
          "title" => $parser[$i]->title,
          "time_elapsed" => $this->my_lib->humanTiming(strtotime($parser[$i]->createdate))
        ));
      }
    }

    // //get count for paging
    // $url = base_api().'News/?action=listnews&pagenumber=1&pagesize=1000';
    // $parser = $this->my_lib->native_curl($url); //call function

    // $data['count_paging'] = floor(count($parser)/$this->limitgrid) + ((count($parser)%$this->limitgrid)>0?1:0);
    // //----------------------------------------------------


    $data['title'] = "Dashboard";
    $data['content'] = "dashboard";
    $this->load->view('admin/main', $data);
  }

  public function tenant()
  {
    $category = $this->my_lib->linkspace($this->uri->segment(3));
    switch (strtolower($category)) {
      case 'entertainment':
        $idTCat = 11;
        break;
      case 'dining':
        $idTCat = 12;
        break;
      case 'accomodation':
        $idTCat = 13;
        break;
      case 'shopping':
        $idTCat = 14;
        break;
      case 'health care':
        $idTCat = 69;
        break;
      case 'transportation':
        $idTCat = 15;
        break;
      case 'public services':
        $idTCat = 72;
        break;
      case 'industry':
        $idTCat = 82;
        break;
      case 'education':
        $idTCat = 65;
        break;
      case 'rental cars':
        $idTCat = 106;
        break;
      default:
        $idTCat = 11;
        break;
    }

    //---- get by category ----

    $subcat = $this->input->get('subcat', TRUE)?$this->input->get('subcat', TRUE):$idTCat;
    $url = base_api().'Tenant/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=10000';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['tenant'] = $parser;

    $data['data_con'] = array();
    if(isset($parser[0]->status)!=true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idcategory" => $parser[$i]->idcategory,
          "categoryname" => $parser[$i]->categoryname,
          "level" => $parser[$i]->level,
          "idtenant" => $parser[$i]->idtenant,
          "avatar" => $parser[$i]->avatar,
          "tenantsname" => $parser[$i]->tenantsname,
          "address" => $parser[$i]->address,
          "longlat" => $parser[$i]->longlat,
          "premium" => $parser[$i]->premium,
          "phone" => $parser[$i]->phone,
          "logo" => $parser[$i]->logo,
          "link" => $parser[$i]->link));
      }
    }

    //---- get sub category ----
    $url              = base_api()."Category/?action=listallchild&idcategory=".$idTCat;
    $data['subcat']   = $this->my_lib->native_curl($url);

    //----notif-------
    $url = base_api().'Notif/?action=listnotifbycategory&idcategory='.$idTCat;
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_notif'] = array();
    $count = count($parser);

    if(isset($parser[0]->status)!=true) {
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_notif'], array(
          "idnotif" => $parser[$i]->idnotif,
          "title" => $parser[$i]->title,
          "description" => $parser[$i]->description,
          "idtenant" => $parser[$i]->idtenant,
          "tenantsname" => $parser[$i]->tenantname,
          "createdate" => $parser[$i]->createdate,
          "avatar" => $parser[$i]->image
        ));
      }
    }
    //----ADVERTISE-------
    $url = base_api().'Advertise/?action=listbycategory&idcategory='.$idTCat.'&pagenumber=1&pagesize=1000';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['adv'] = $parser;
    $data['data_advertise'] = array();
    $count = count($parser);

    if(isset($parser[0]->status)!=true) {
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_advertise'], array(
          "idadvertise" => $parser[$i]->idadvertise,
          "idtenant" => $parser[$i]->idtenant,
          "advertise" => $parser[$i]->advertise,
          "smalladvertise" => $parser[$i]->smalladvertise,
            "expired" => $parser[$i]->expired
        ));
      }
    }

    $data['tenantfull'] = array();
    $countf = count($data['tenant']);
    for($i=0; $i<=($countf-1); $i++) {
      array_push($data['tenantfull'], array(
        'idtenant' => $data['tenant'][$i]->idtenant,
        'tenantsname' => $data['tenant'][$i]->tenantsname,
        'idcategory' => $data['tenant'][$i]->idcategory
      ));
    }
    $data['tenantadv'] = array();
    $countf = count($data['adv']);
    for($i=0; $i<=($countf-1); $i++) {
      array_push($data['tenantadv'], array(
        'idtenant' => $data['adv'][$i]->idtenant
      ));
    }

    $data['i_tenant'] = array();

    for($i=0; $i<count($data['tenantfull']); $i++) {
        array_push($data['i_tenant'], array(
            "idtenant" => $data['tenantfull'][$i]['idtenant'],
            "tenantsname" => $data['tenantfull'][$i]['tenantsname'],
            'idcategory' => $data['tenant'][$i]->idcategory
        ));
    }
    // var_dump($data['i_tenant']);
    // list account
    $url = base_api().'Account/?action=listaccount';
    $data['account']   = $this->my_lib->native_curl($url);


    $data['idTCat']    = $idTCat;
    $data['title'] = ucwords(strtolower($category));
    $data['content']  = "tenant";
    $this->load->view('admin/main', $data);


  }

  public function insert_tenant()
  {
    $title = $this->input->post('title');
    $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($title)));
    $config1['upload_path']          = 'assets/img/content/'.$catlink;
    $config1['allowed_types']        = 'gif|jpg|png|jpeg';
    $config1['max_size']             = 2000;
    $config1['max_width']            = 350;
    $config1['max_height']           = 40;
    $config1['min_width']            = 200;
    $config1['min_height']           = 30;
    $config1['file_name']            = 'logo-'.trim(str_replace(" ","",date('dmYHisu')));
    if(!is_dir($config1['upload_path'])) {
      mkdir($config1['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config1['upload_path'], 0777))) {
      chmod($config1['upload_path'], 0777);
    }
    $this->load->library('upload', $config1);
    $this->upload->initialize($config1);
    $upload_file = $this->upload->do_upload('logo');
    $uplogo = $this->upload->data();
    $logo = base_img().'content/'.$catlink.'/'.$uplogo['file_name'];

    if($this->input->post('empty_avatar')!=null){
      $avatar = null;
    }else{
      $config['upload_path']          = 'assets/img/content/'.$catlink;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = $catlink.'-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('avatar');

      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        redirect(base_url('admin/tenant/'.$title));
      }else if($upload_img){
        $photo = $this->upload->data();
        $avatar = base_img().'content/'.$catlink.'/'.$photo['file_name'];
      }
    }

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
      'action' => 'insert_tenant',
      'name' => $this->input->post('name', TRUE),
      'logo' => $logo,
      'avatar' =>  $avatar,
      'idcategory' => $this->input->post('idcategory', TRUE),
      'longlat' => $this->input->post('latitude').",".$this->input->post('longitude'),
      'phone' => $this->input->post('phone', TRUE),
      'link' => $this->input->post('link', TRUE),
      'color' => $this->input->post('color', TRUE),
      'address' => $this->input->post('address', TRUE),
      'premium' => $this->input->post('premium', TRUE),
      "validfrom" => $datevalidfrom,
      "validuntil" => $datevaliduntil
    );

    $url = base_api().'Tenant/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      redirect(base_url('admin/tenant/'.$title));
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      redirect(base_url('admin/tenant/'.$title));
    }

  }

  public function insert()
  {
    $subcat = $this->input->get('id', TRUE);
    $data['title'] = $this->my_lib->linkspace($this->input->get('name', TRUE));
    $url              = base_api()."Category/?action=listallchild&idcategory=".$subcat;

    $data['subcat'] = $this->my_lib->native_curl($url);
    $data['content'] = "tenantinsert";
    $this->load->view('admin/main', $data);
  }

  //update tenant retrieve get
  public function detail_edit_tenant(){
    $idtenant = $this->input->get('id', TRUE);
    $idcategory = $this->input->get('cat', TRUE);
    $url = base_api()."Tenant/?action=retrieve_get&idtenant=".$idtenant;
    $data['data_detail'] = $this->my_lib->native_curl($url);
    $data['idtenant'] = $idtenant;
    $data['idcategory'] = $data['data_detail']->detail[0]->idcategory;
    $data['openhour'] = date("h:i A", strtotime($data['data_detail']->detail[0]->openhour));
    $data['closehour'] = date("h:i A", strtotime($data['data_detail']->detail[0]->closehour));
    $a = explode(",",preg_replace("/[()]+/", "", $data['data_detail']->detail[0]->longlat));
    $data['latitude'] = $a[0];
    $data['longitude'] = $a[1];

    if($data['data_detail']->detail[0]->validfrom != NULL){
      $validfrom = explode(" ",$data['data_detail']->detail[0]->validfrom);
      $validfromdate = date("Y-m-d",strtotime($validfrom[0]));
      $validfromtime = date("H:i:s",strtotime($validfrom[1]));
    }
    
    if($data['data_detail']->detail[0]->validuntil != NULL){
      $validuntil = explode(" ",$data['data_detail']->detail[0]->validuntil);
      $validuntildate = date("Y-m-d",strtotime($validuntil[0]));
      $validuntiltime = date("H:i:s",strtotime($validuntil[1]));
    }

    $data['validfromdate'] = $validfromdate;
    $data['validfromtime'] = $validfromtime;
    $data['validuntildate'] = $validuntildate;
    $data['validuntiltime'] = $validuntiltime;

    $data['hour_con'] = array();
    if(isset($data['data_detail']->status)==false) {
      $count = count($data['data_detail']->openhour);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['hour_con'], array(
          "idopenhour" => $data['data_detail']->openhour[$i]->idopenhour,
          "dayname" => $data['data_detail']->openhour[$i]->dayname,
          "dopenhour" => $data['data_detail']->openhour[$i]->openhour,
          "dclosehour" => $data['data_detail']->openhour[$i]->closehour,
          "dopen" => $data['data_detail']->openhour[$i]->open,
          "idtenant" => $data['data_detail']->openhour[$i]->idtenant,
        ));

      }
    }
    
    //---- get sub category ----
    $url = base_api().'Category/?action=listallchild&idcategory='.$idcategory;
    $data['subcat'] = $this->my_lib->native_curl($url);

    $data['content'] = "tenantedit";
    $data['category']=$this->input->get('name', TRUE);
    $data['title']=$data['data_detail']->detail[0]->name;
    $this->load->view('admin/main', $data);
  }

  public function unlinkimage() {
    // connect and login to FTP server
    $ftp_server = "innodev.vnetcloud.com";
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, "sysadmin", "Password1!");

    $file = "LiveInWeb/assets/img/content/discountcoupon/111/111-04082016061538000000.JPG";

    // try to delete file
    if (ftp_delete($ftp_conn, $file))
    {
      echo "$file deleted";
    }
    else
    {
      echo "Could not delete $file";
    }

    // close connection
    ftp_close($ftp_conn);
  }

  public function update_tenant(){

    if($this->input->post('empty_avatar')==null) {
      //upload avatar
      $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($this->input->post('category'))));
      $config['upload_path']          = 'assets/img/content/'.$catlink;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = $catlink.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('image');
      if (!$upload_img) {
        $avatartenant = $this->input->post('avatar', TRUE);
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('avatar');
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);

        $photo = $this->upload->data();

        $cek = $photo['upload_path'].$photo['file_name'];
        if(!(chmod($cek, 0777))) {
          chmod($cek, 0777);
        }

        $avatartenant = base_img().'content/'.$catlink.'/'.$photo['file_name'];
      }

    }else {
      //delete old image if have new image
      $avatar = $this->input->post('avatar');
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);

      $avatartenant = null;
    }
    $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($this->input->post('category'))));
    //upload logo
    $config1['upload_path']          = 'assets/img/content/'.$catlink;
    $config1['allowed_types']        = 'gif|jpg|png|jpeg';
    $config1['max_size']             = 2000;
    $config1['max_width']            = 800;
    $config1['max_height']           = 800;
    $config1['min_width']            = 80;
    $config1['min_height']           = 80;
    $config1['file_name']            = 'logo-'.trim(str_replace(" ","",date('dmYHisu')));
    if(!is_dir($config1['upload_path'])) {
      mkdir($config1['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config1['upload_path'], 0777))) {
      chmod($config1['upload_path'], 0777);
    }
    $this->load->library('upload', $config1);
    $this->upload->initialize($config1);
    $upload_file = $this->upload->do_upload('logo');
    $logo = $this->upload->data();

    if (!$upload_file) {
      $logo = $this->input->post('oldlogo', TRUE); //old logo
    }else{
      $logo = base_img().'content/'.$catlink.'/'.$logo['file_name'];  //new logo
    }

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
      'action' => 'update_tenant',
      'idtenant' => $this->input->post('idtenant',TRUE),
      'name' => $this->input->post('name', TRUE),
      'avatar' =>  $avatartenant,
      'logo' => $logo,
      'idcategory' => $this->input->post('idcategory', TRUE),
      'phone' => $this->input->post('phone', TRUE),
      'link' => $this->input->post('link', TRUE),
      'address' => $this->input->post('address', TRUE),
      'premium' => $this->input->post('premium', TRUE),
      'color' => $this->input->post('color', TRUE),
      'longlat' => $this->input->post('latitude').",".$this->input->post('longitude'),
      "validfrom" => $datevalidfrom,
      "validuntil" => $datevaliduntil
    );

    $url = base_api().'Tenant/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message== "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_tenant()
  {
    $data = array(
      'action' => 'delete_tenant',
      'idtenant' => $this->input->post('id', TRUE));

    $url = base_api().'Tenant/';
    $parser = $this->my_lib->native_curl($url,$data);


    $data['message'] = $parser[0]->message;

    $avatar = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$avatar);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    $logo = $this->input->post('logo', TRUE);
    $imagelogo =  str_replace('/','\\',$logo);
    $ava =  str_replace(array('http:','https:'),'',$imagelogo);
    unlink($avalogo);

    $idtenant = $this->input->post('id', TRUE);
    $config['delete_folder_gallery']          = 'assets/img/content/gallery/'.$idtenant;
    rmdir($config['delete_folder_gallery'], 0777, TRUE);
    $config['delete_folder_discount']          = 'assets/img/content/discountcoupon/'.$idtenant;
    rmdir($config['delete_folder_discount'], 0777, TRUE);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_openhour(){
    for($i=0; $i<=$this->input->post('count', TRUE); $i++) {
      $data = array(
        'action' => 'update_openhour',
        'dayname' => $this->input->post('dayname'.$i, TRUE),
        'openhour' => $this->input->post('openhour'.$i, TRUE),
        'closehour' => $this->input->post('closehour'.$i, TRUE),
        'idtenant' => $this->input->post('idtenant'.$i, TRUE),
        'idopenhour' => $this->input->post('idopenhour'.$i, TRUE),
        'open' => $this->input->post('open'.$i, TRUE));

      $url = base_api().'Openhour/';
      $parser = $this->my_lib->native_curl($url,$data);
    }

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function cctv(){
    $url = base_api().'Cctv/?action=listnew&idcity=1&pagenumber=1&pagesize=1000';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_con'] = array();
    $count = count($parser);
    for($i=0; $i<=($count-1); $i++) {
      array_push($data['data_con'], array(
        "idcctv" => $parser[$i]->idcctv,
        "idcity" => $parser[$i]->idcity,
        "ipaddress" => $parser[$i]->ipaddress,
        "port" => $parser[$i]->port,
        "username" => $parser[$i]->username,
        "password" => $parser[$i]->password,
        "channel" => $parser[$i]->channel,
        "label" => $parser[$i]->label));
    }

    $url = base_api().'Cctv/?action=list_rtsp&idcity=1&pagenumber=1&pagesize=1000';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_conrtsp'] = array();
    $count = count($parser);
    for($i=0; $i<=($count-1); $i++) {
      array_push($data['data_conrtsp'], array(
        "idcctv" => $parser[$i]->idcctv,
        "link" => $parser[$i]->link,
        "label" => $parser[$i]->name));
    }

    $data['title'] = "CCTV";
    $data['content'] = "cctv";
    $this->load->view('admin/main', $data);
  }

  public function insert_cctv(){
    $idcity = $this->input->post('idcity', TRUE)?$this->input->post('idcity', TRUE):'1';
    $data = array(
      'action' => 'insert_cctv',
      'idcity' => $idcity,
      'link' => $this->input->post('ipaddress', TRUE),
      'port' => $this->input->post('port', TRUE),
      'username' => $this->input->post('username', TRUE),
      'password' => $this->input->post('password', TRUE),
      'channel' => $this->input->post('channel', TRUE),
      'name' => $this->input->post('label', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Insert success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_cctv(){
    $idcity = $this->input->post('idcity', TRUE)?$this->input->post('idcity', TRUE):'1';
    $data = array(
      'action' => 'update_cctv',
      'idcity' => $idcity,
      'idcctv' => $this->input->post('idcctv', TRUE),
      'link' => $this->input->post('ipaddress', TRUE),
      'port' => $this->input->post('port', TRUE),
      'username' => $this->input->post('username', TRUE),
      'password' => $this->input->post('password', TRUE),
      'channel' => $this->input->post('channel', TRUE),
      'name' => $this->input->post('label', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Update success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function delete_cctv(){
    $data = array(
      'action' => 'delete_cctv',
      'idcctv' => $this->input->post('idcctv', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_rtsp(){
    $idcity = $this->input->post('idcity', TRUE)?$this->input->post('idcity', TRUE):'1';
    $data = array(
      'action' => 'insert_rtsp',
      'idcity' => $idcity,
      'link' => $this->input->post('link', TRUE),
      'name' => $this->input->post('label', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_rtsp', 'Insert success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage_rtsp', 'Can\'t be inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_rtsp(){
    $idcity = $this->input->post('idcity', TRUE)?$this->input->post('idcity', TRUE):'1';
    $data = array(
      'action' => 'update_rtsp',
      'idcctv' => $this->input->post('idcctv', TRUE),
      'link' => $this->input->post('link', TRUE),
      'name' => $this->input->post('label', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_rtsp', 'Update success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage_rtsp', 'Can\'t be updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_rtsp(){
    $data = array(
      'action' => 'delete_rtsp',
      'idcctv' => $this->input->post('idcctv', TRUE));

    $url = base_api().'Cctv/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_rtsp', 'Delete success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage_rtsp', 'Can\'t be deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_menu(){
    $idtenant = $this->input->post('idtenant', TRUE);
    $config['upload_path']          = 'assets/file/tenant/'.$idtenant;
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 5000;
    $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_file = $this->upload->do_upload('linkcatalog');

    if (!$upload_file){
      $data = array(
        'action' => 'insert_menu',
        'idtenant' => $this->input->post('idtenant', TRUE),
        'menu' => $this->input->post('menu', TRUE),
        'price' => $this->input->post('price', TRUE));
    } else {
      // if all condition $config file is true
      $file = $this->upload->data();
      $data = array(
        'action' => 'insert_menu',
        'idtenant' => $this->input->post('idtenant', TRUE),
        'menu' => $this->input->post('menu', TRUE),
        'linkcatalog' => base_url().$config['upload_path'].'/'.$file['file_name'],
        'filename' => $file['file_name'],
        'filesize' => round($file['file_size']*1024),
        'price' => $this->input->post('price', TRUE));

        $url = base_api().'Menu/';
        $parser = $this->my_lib->native_curl($url,$data);
    }

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_menu(){
    $idtenant = $this->input->post('idtenant', TRUE);
    $config['upload_path']          = 'assets/file/tenant/'.$idtenant;
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 5000;
    $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_file = $this->upload->do_upload('linkcatalog');

    if (!$upload_file){
      $data = array(
        'action' => 'update_menu',
        'idtenant' => $this->input->post('idtenant', TRUE),
        'idmenu' => $this->input->post('idmenu', TRUE),
        'menu' => $this->input->post('menu', TRUE),
        'price' => $this->input->post('price', TRUE),
        'linkcatalog' => $this->input->post('linkcatalog1', TRUE));
    } else {
      //delete old image if have new image
      $avatar = $this->input->post('linkcatalog1', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);

      $file = $this->upload->data();
      $data = array(
        'action' => 'update_menu',
        'idtenant' => $this->input->post('idtenant', TRUE),
        'idmenu' => $this->input->post('idmenu', TRUE),
        'menu' => $this->input->post('menu', TRUE),
        'price' => $this->input->post('price', TRUE),
        'linkcatalog' => base_url().'assets/file/tenant/'.$idtenant.'/'.$file['file_name'],
        'filename' => $file['file_name'],
        'filesize' => round($file['file_size']*1024));
    }

    $url = base_api().'Menu/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully update');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be update.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_menu(){
    $data = array(
      'action' => 'delete_menu',
      'idmenu' => $this->input->post('idmenu', TRUE));

    $url = base_api().'Menu/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    $photo = $this->input->post('linkcatalog', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }

  }

  public function insert_gallery()
  {
    $idtenant = $this->input->post('idtenant', TRUE);
    $config['upload_path']          = 'assets/img/content/gallery/'.$idtenant;
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');
    if (!$upload_img){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessage', $error['error']);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }else{
      $photo = $this->upload->data();
      $data = array(
        'action' => 'insert_gallery',
        'idtenant' => $this->input->post('idtenant', TRUE),
        'avatar' =>  base_img().'content/gallery/'.$idtenant.'/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'Gallerytenant/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Inserted');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }
  public function delete_gallery()
  {
    $data = array(
      'action' => 'delete_gallery',
      'idgallery' => $this->input->post('idgallery', TRUE));

    $url = base_api().'Gallerytenant/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('imageurl', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }


  public function update_gallery(){
    $idtenant = $this->input->post('idtenant', TRUE);
    $config['upload_path']          = 'assets/img/content/gallery/'.$idtenant;
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');

    if (!$upload_img){
      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_gallery',
        'idgallery' => $this->input->post('idgallery', TRUE),
        'avatar' =>  $this->input->post('photo1', TRUE),
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'Gallerytenant/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }else{
      //delete old image if have new image
      $avatar = $this->input->post('photo1', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      var_dump($ava);
      unlink($ava);

      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_gallery',
        'idgallery' => $this->input->post('idgallery', TRUE),
        'avatar' =>  base_img().'content/gallery/'.$idtenant.'/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'Gallerytenant/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }

  public function insert_discountcoupon()
  {
    $idtenant = $this->input->post('idtenant', TRUE);

    $imageurl =  null;
    $fileurl =  null;
    $filename = null;
    $filesize =  null;
    $saveImage = null;
    $saveFile = null;

    if (($this->input->post('empty_avatar', TRUE)==null)){
      $config['upload_path']          = 'assets/img/content/discountcoupon/'.$idtenant;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('photo');
      $photo = $this->upload->data();
      chmod($photo['full_path'], 0777);

      if($upload_img){
        $imageurl =  base_img().'content/discountcoupon/'.$idtenant.'/'.$photo['file_name'];
        $saveImage = true;
      }else{
        $saveImage = false;
      }
    }

    if ($this->input->post('empty_file')==null){

      $config1['upload_path']          = 'assets/img/content/discountcoupon/'.$idtenant;
      $config1['allowed_types']        = 'pdf';
      $config1['max_size']             = 5000;
      $config1['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_file = $this->upload->do_upload('file');
      $file = $this->upload->data();
      chmod($file['full_path'], 0777);

      if ($upload_file) {
        $fileurl =  base_img().'content/discountcoupon/'.$idtenant.'/'.$file['file_name'];
        $filename = $file['file_name'];
        $filesize =  round($file['file_size']*1024);
        $saveFile = true;
      }else{
        $saveFile = false;
      }
    }

    $data = array(
      'action' => 'insert_discountcoupon',
      'idtenant' => $this->input->post('idtenant', TRUE),
      'imageurl' =>  $imageurl,
      'title' => $this->input->post('title', TRUE),
      'caption' => $this->input->post('caption', TRUE),
      'fileurl' => $fileurl,
      'filename' => $filename,
      'filesize' => $filesize);

    if($saveImage == true || $saveImage === null){
      if($saveFile == true || $saveFile === null){
        $url = base_api().'Discountcoupon/';
        $parser = $this->my_lib->native_curl($url,$data);
      }
    }

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function delete_discountcoupon()
  {
    $data = array(
      'action' => 'delete_discountcoupon',
      'iddiscountcoupon' => $this->input->post('iddiscountcoupon', TRUE));

    $url = base_api().'Discountcoupon/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('imageurl', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    $fileurl = $this->input->post('fileurl', TRUE);
    $fileurl2 =  str_replace('/','\\',$fileurl);
    $fileurl3 =  str_replace(array('http:','https:'),'',$fileurl2);
    unlink($fileurl3);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }


  public function update_discountcoupon(){
    $idtenant = $this->input->post('idtenant', TRUE);
    $idcategory = $this->input->post('idcategory', TRUE);

    $imageurl = null;
    $fileurl = null;
    $filename = null;
    $filesize = null;

    if ($this->input->post('empty_avatar', TRUE)==null){
      $config['upload_path']          = 'assets/img/content/discountcoupon/'.$idtenant;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('photo');
      $photo = $this->upload->data();
      // chmod($photo['full_path'], 0777);

      if(!$upload_img){
        $imageurl =  $this->input->post('photo1', TRUE);
      }else{
        $avatar = $this->input->post('photo1', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $imageurl =  base_img().'content/discountcoupon/'.$idtenant.'/'.$photo['file_name'];
      }
    }

    if ($this->input->post('empty_file')==null){
      $config1['upload_path']          = 'assets/img/content/discountcoupon/'.$idtenant;
      $config1['allowed_types']        = 'pdf';
      $config1['max_size']             = 5000;
      $config1['file_name']            = $idtenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_file = $this->upload->do_upload('fileurl');
      $file = $this->upload->data();
      // chmod($file['full_path'], 0777);

      if (!$upload_file) {
        $fileurl = $this->input->post('u_fileurl', TRUE);
        $filename = $this->input->post('u_filename', TRUE);
        $filesize = $this->input->post('u_filesize', TRUE);
      }else{
        if ($this->input->post('u_fileurl', TRUE)!="") {
          $linkfile1 = $this->input->post('u_fileurl', TRUE);
          $linkfile2 =  str_replace('/','\\',$linkfile1);
          $linkfile3 =  str_replace(array('http:','https:'),'',$linkfile2);
          unlink($linkfile3);
        }
        $fileurl =  base_img().'content/discountcoupon/'.$idtenant.'/'.$file['file_name'];
        $filename = $file['file_name'];
        $filesize =  round($file['file_size']*1024);
      }
    }

    $data = array(
      'action' => 'update_discountcoupon',
      'iddiscountcoupon' => $this->input->post('iddiscountcoupon', TRUE),
      'imageurl' =>  $imageurl,
      'idtenant' => $idtenant,
      'idcategory' => $idcategory,
      'title' => $this->input->post('title', TRUE),
      'caption' => $this->input->post('caption', TRUE),
      'fileurl' =>  $fileurl,
      'filename' => $filename,
      'filesize' => $filesize);

    $url = base_api().'Discountcoupon/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Update');
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
    }

    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }

  public function account()
  { 
    $url = base_api().'user/';
    $res = $this->exec_curl($url,null, "GET");
    $result = $res['result'];
    $data['data_con'] = array();
    if(isset($result)){
      $count = count($result);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idaccount" => $result[$i]['user_id'],
          "privilege" => $result[$i]['role_id'] == "1" ? "administrator" : "User",
          "email" => $result[$i]['email'],
          "createdate" => date("Y-m-d h:m:s A",strtotime($result[$i]['created_at']))));
      }
    }

    $data['title'] = "Account";
    $data['content'] = "account";
    $this->load->view('admin/main', $data);
  }

  
  public function accountdetail()
  {
    $idaccount = $this->input->get('id', TRUE);
    $url = base_api().'user/'.$idaccount;
    $res = $this->exec_curl($url,null, "GET");
    $result = $res['result'];
    $data['data_detail'] = $result;
    $data['data_con'] = array();
    if(isset($result)){
      $data['createdate'] = date("Y-m-d", strtotime($result['created_at']));      
    }
    $data['title'] = isset($result['username']) ? $result['username'] : "Edit";
    $data['content'] = "accountdetail";
    $this->load->view('admin/main', $data);
  }

  public function update_account(){
    if($this->input->post('privilege', TRUE)=='administrator'){
      $dateofbirth = '';
      $pscode='';
    }
    else if($this->input->post('privilege', TRUE)=='visitor'){
      $dateofbirth = '';
      $pscode='';
    }
    else if($this->input->post('privilege', TRUE)=='resident'){
      $dateofbirth = $this->input->post('dateofbirth', TRUE);
      $pscode= $this->input->post('pscode', TRUE);
    }

    if($this->input->post('empty_avatar', TRUE)==null) {
      $config['upload_path']          = 'assets/img/account/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = 'account-'.trim(str_replace(" ","",date('dmYHisu')));
      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('image');

      if (!$upload_img){
        $photo = $this->upload->data();

        $data = array(
          'action' => 'update_account',
          'idaccount' => $this->input->post('idaccount',TRUE),
          'gender' => $this->input->post('gender', TRUE),
          'phone' => $this->input->post('phone', TRUE),
          'dateofbirth' => $dateofbirth,
          'fullname' => $this->input->post('fullname', TRUE),
          'address' => $this->input->post('address', TRUE),
          'avatar' =>  $this->input->post('avatar', TRUE),
          'pscode' => $pscode,
          'email' => $this->input->post('email', TRUE),
          'privilege' => $this->input->post('privilege'));

      } else {
        if($this->input->post('avatar', TRUE)!=(base_img().'account/avatardefault.png')){
          //delete old image if have new image
          $avatar = $this->input->post('avatar', TRUE);
          $image =  str_replace('/','\\',$avatar);
          $ava =  str_replace(array('http:','https:'),'',$image);
          unlink($ava);
        }
        $photo = $this->upload->data();
        $data = array(
          'action' => 'update_account',
          'idaccount' => $this->input->post('idaccount',TRUE),
          'gender' => $this->input->post('gender', TRUE),
          'phone' => $this->input->post('phone', TRUE),
          'dateofbirth' => $dateofbirth,
          'fullname' => $this->input->post('fullname', TRUE),
          'address' => $this->input->post('address', TRUE),
          'avatar' =>  base_img().'account/'.$photo['file_name'],
          'pscode' => $pscode,
          'email' => $this->input->post('email', TRUE),
          'privilege' => $this->input->post('privilege'));
      }
    } else {
      if($this->input->post('avatar', TRUE)!=(base_img().'account/avatardefault.png')){
        //delete old image if have new image
        $avatar = $this->input->post('avatar', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
      }

      $data = array(
        'action' => 'update_account',
        'idaccount' => $this->input->post('idaccount',TRUE),
        'gender' => $this->input->post('gender', TRUE),
        'phone' => $this->input->post('phone', TRUE),
        'dateofbirth' => $dateofbirth,
        'fullname' => $this->input->post('fullname', TRUE),
        'address' => $this->input->post('address', TRUE),
        'avatar' =>  null,
        'pscode' => $pscode,
        'email' => $this->input->post('email', TRUE),
        'privilege' => $this->input->post('privilege', TRUE));
    }

    $url = base_api().'Account/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Updated.");
    }

    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }

  public function insert_account(){
    if($this->input->post('privilege', TRUE)=='administrator'){
      $dateofbirth = '';
      $pscode='';
    }
    else if($this->input->post('privilege', TRUE)=='visitor'){
      $dateofbirth = '';
      $pscode='';
    }
    else if($this->input->post('privilege', TRUE)=='resident'){
      $dateofbirth = $this->input->post('dateofbirth', TRUE);
      $pscode= $this->input->post('pscode', TRUE);
    }
    $data = array(
      'action' => 'register',
      'privilege' => $this->input->post('privilege', TRUE),
      'fullname' => $this->input->post('fullname', TRUE),
      'gender' => $this->input->post('gender', TRUE),
      'dateofbirth' => $dateofbirth,
      'phone' => $this->input->post('phone', TRUE),
      'password' => $this->input->post('password', TRUE),
      'email' => $this->input->post('email', TRUE),
      'pscode' => $pscode
    );
    $url = base_api().'Account/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == null) {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_account()
  {
    $data = array(
      'action' => 'delete_account',
      'idaccount' => $this->input->post('id', TRUE));

    $url = base_api().'Account/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted ');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  
  public function category()
  {$url = base_api().'category';
    $res = $this->exec_curl($url,null, "GET");
    $result = $res['result'];
    $data['data_con'] = array();
    if(isset($result)){
      $count = count($result);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "category_id" => $result[$i]['category_id'],
          "name" => $result[$i]['name']));
      }
    }

    $data['title'] = "Category";
    $data['content'] = "category";
    $this->load->view('admin/main', $data);
  }

  public function insert_category(){    
    $data = array(
      'name' => $this->input->post('name', TRUE)
    );
    $url = base_api().'category';
    $res = $this->exec_curl($url,$data, "POST");
    $result = $res['result'];
    if(isset($result)){
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      redirect(base_url('admin/category'));
    }else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      redirect(base_url('admin/category'));
    }
  }

  public function update_category(){    
    $data = array(
      'name' => $this->input->post('name', TRUE)
    );
    $url = base_api().'category';
    $res = $this->exec_curl($url,$data, "PUT");
    $result = $res['result'];
    if(isset($result)){
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      redirect(base_url('admin/category'));
    }else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      redirect(base_url('admin/category'));
    }
  }
  
  public function delete_category(){
    $data = array(
      'action' => 'delete_phonenumber',
      'idphonenumber' => $this->input->post('idphonenumber', TRUE));



    $url = base_api().'Phonenumber/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function gallery()
  {
    $url = base_api().'City/?action=listgallery&pagesize=1000&pagenumber=1&idcity=1';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_con'] = array();

    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idcitygallery" => $parser[$i]->idcitygallery,
          "idcity" => $parser[$i]->idcity,
          "title" => $parser[$i]->title,
          "avatar" => $parser[$i]->avatar));
      }
    }

    $url = base_api().'Gallery/?action=listhashtag&pagenumber=1&pagesize=100';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_hash'] = array();

    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_hash'], array(
          "idhashtag" => $parser[$i]->idhashtag,
          "tag" => $parser[$i]->tag,
          "description" => $parser[$i]->description));
      }
    }

    // var_dump($data['data_hash']);
    // die();

    $data['title'] = "Gallery";
    $data['content'] = "gallery";
    $this->load->view('admin/main', $data);
  }

  public function getproperty()
  {
    $idTCat = '39';
    $subcat = $this->input->get('subcat', TRUE)?$this->input->get('subcat', TRUE):$idTCat;
    $url = base_api().'Property/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=10000&status=%%';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['property'] = $parser;
    $data['data_con'] = array();
    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idproperty" => $parser[$i]->idproperty,
          "categoryname" => $parser[$i]->categoryname,
          "name" => $parser[$i]->name,
          "type" => $parser[$i]->type,
          "price" => $parser[$i]->price,
          "lblt" => $parser[$i]->lb.'/'.$parser[$i]->lt,
          "avatar" => $parser[$i]->avatar,
          "status" => $parser[$i]->status
        ));
      }
    }
    //---- get sub category ----
    $url              = base_api()."Category/?action=listallchild&idcategory=".$idTCat;
    $data['subcat']   = $this->my_lib->native_curl($url);

    // get agent
    $url              = base_api()."Agent/?action=listagent&pagenumber=1&pagesize=1000";
    $data['agent']   = $this->my_lib->native_curl($url);

    //----ADVERTISE-------
    $url = base_api().'Advertise/?action=listbycategory&idcategory='.$idTCat.'&pagenumber=1&pagesize=100000&category=property';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['adv'] = $parser;
    $data['data_advertise'] = array();
    $count = count($parser);

    if(isset($parser[0]->status)!=true) {
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_advertise'], array(
          "idadvertise" => $parser[$i]->idadvertise,
          "idproperty" => $parser[$i]->idproperty,
          "advertise" => $parser[$i]->advertise,
          "smalladvertise" => $parser[$i]->smalladvertise
        ));
      }
    }

    $data['tenantfull'] = array();
    $countf = count($data['property']);
    for($i=0; $i<=($countf-1); $i++) {
      array_push($data['tenantfull'], array(
        'idtenant' => $data['property'][$i]->idproperty,
        'tenantsname' => $data['property'][$i]->name,
        'idcategory' => $data['property'][$i]->idcategory
      ));
    }
    $data['tenantadv'] = array();
    $countf = count($data['adv']);
    for($i=0; $i<=($countf-1); $i++) {
      array_push($data['tenantadv'], array(
        'idtenant' => $data['adv'][$i]->idproperty
      ));
    }

    $data['i_tenant'] = array();

    for($i=0; $i<count($data['tenantfull']); $i++) {
      $found = false;
      for($j=0; $j<count($data['tenantadv']); $j++) {
        if ($data['tenantfull'][$i]['idtenant'] == $data['tenantadv'][$j]['idtenant']) {
          $found = true;
          break;
        }
      }
      if (!$found) {
        array_push($data['i_tenant'], array(
          "idtenant" => $data['tenantfull'][$i]['idtenant'],
          "tenantsname" => $data['tenantfull'][$i]['tenantsname'],
          'idcategory' => $data['property'][$i]->idcategory
        ));
      }
    }
    // var_dump($data['propertyadv']);

    $data['title'] = "Get Property";
    $data['content'] = "getproperty";
    $this->load->view('admin/main', $data);
  }

  public function insert_getproperty()
  {
    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
      $config['upload_path']          = 'assets/img/content/property';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'property-'.trim(str_replace(" ","",date('dmYHisu')));

      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('image');
      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        redirect(base_url('admin/getproperty'));
      }else{
        $photo = $this->upload->data();
        $data = array(
          'action' => 'insert_property',
          'avatar' =>  base_img().'content/property/'.$photo['file_name'],
          'lb' => $this->input->post('lb', TRUE),
          'lt' => $this->input->post('lt', TRUE),
          'idcity' => 1,
          'description' => $this->input->post('description', TRUE),
          'description_en' => $this->input->post('description_en', TRUE),
          'price' => $this->input->post('price',TRUE),
          'type' => $this->input->post('type', TRUE),
          'name' => $this->input->post('name', TRUE),
          'idcategory' => $this->input->post('idcategory', TRUE),
          'idagent' => $this->input->post('idagent', TRUE),
          'status' => $this->input->post('status', TRUE)
        );
      }
    }else{
      $data = array(
        'action' => 'insert_property',
        'avatar' =>  null,
        'lb' => $this->input->post('lb', TRUE),
        'lt' => $this->input->post('lt', TRUE),
        'idcity' => 1,
        'description' => $this->input->post('description', TRUE),
        'description_en' => $this->input->post('description_en', TRUE),
        'price' => $this->input->post('price',TRUE),
        'type' => $this->input->post('type', TRUE),
        'name' => $this->input->post('name', TRUE),
        'idcategory' => $this->input->post('idcategory', TRUE),
        'idagent' => $this->input->post('idagent', TRUE),
        'status' => $this->input->post('status', TRUE)
      );
    }

    $url = base_api().'Property/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function detail_getproperty(){
    $idtenant = $this->input->get('id', TRUE);
    $url = base_api()."Property/?action=retrieve_get&idproperty=".$idtenant."&lang=bilingual";
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    $data['idcategory'] = $data['data_detail']->detail[0]->idcategory;
    $data['idagent'] =  $data['data_detail']->detail[0]->idagent;
    //---- get sub category ----
    $url = base_api().'Category/?action=listallchild&idcategory=39';
    $data['subcat'] = $this->my_lib->native_curl($url);
    //---- get sub agent ----
    $url = base_api().'Agent/?action=listagent&pagenumber=1&pagesize=1000';
    $data['agent'] = $this->my_lib->native_curl($url);


    $data['title'] = $data['data_detail']->detail[0]->name!=null?$data['data_detail']->detail[0]->name:"Edit";
    $data['content'] = "getpropertydetail";
    $this->load->view('admin/main', $data);
  }

  public function update_getproperty(){
    if($this->input->post('empty_avatar', TRUE)==null) {
      $config['upload_path']          = 'assets/img/content/property';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'property-'.trim(str_replace(" ","",date('dmYHisu')));
      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('image');

      if (!$upload_img){
        $photo = $this->upload->data();

        $data = array(
          'action' => 'update_property',
          'avatar' =>  $this->input->post('avatar', TRUE),
          'lb' => $this->input->post('lb', TRUE),
          'description' => $this->input->post('description', TRUE),
          'description_en' => $this->input->post('description_en', TRUE),
          'price' => $this->input->post('price',TRUE),
          'type' => $this->input->post('type', TRUE),
          'name' => $this->input->post('name', TRUE),
          'idcategory' => $this->input->post('idcategory', TRUE),
          'lt' => $this->input->post('lt', TRUE),
          'idagent' => $this->input->post('idagent', TRUE),
          'idproperty' => $this->input->post('idproperty', TRUE),
          'status' => $this->input->post('status', TRUE)
        );
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('avatar', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $photo = $this->upload->data();
        $data = array(
          'action' => 'update_property',
          'avatar' =>  base_img().'content/property/'.$photo['file_name'],
          'lb' => $this->input->post('lb', TRUE),
          'description' => $this->input->post('description', TRUE),
          'description_en' => $this->input->post('description_en', TRUE),
          'price' => $this->input->post('price',TRUE),
          'type' => $this->input->post('type', TRUE),
          'name' => $this->input->post('name', TRUE),
          'idcategory' => $this->input->post('idcategory', TRUE),
          'lt' => $this->input->post('lt', TRUE),
          'idagent' => $this->input->post('idagent', TRUE),
          'idproperty' => $this->input->post('idproperty', TRUE),
          'status' => $this->input->post('status', TRUE)
        );
      }
    }else{
      //delete old image if have new image
      $avatar = $this->input->post('avatar', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
      $data = array(
        'action' => 'update_property',
        'avatar' =>  null,
        'lb' => $this->input->post('lb', TRUE),
        'description' => $this->input->post('description', TRUE),
        'description_en' => $this->input->post('description_en', TRUE),
        'price' => $this->input->post('price',TRUE),
        'type' => $this->input->post('type', TRUE),
        'name' => $this->input->post('name', TRUE),
        'idcategory' => $this->input->post('idcategory', TRUE),
        'lt' => $this->input->post('lt', TRUE),
        'idagent' => $this->input->post('idagent', TRUE),
        'idproperty' => $this->input->post('idproperty', TRUE),
        'status' => $this->input->post('status', TRUE)
      );
    }

    $url = base_api().'Property/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Updated.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_getproperty()
  {
    $data = array(
      'action' => 'delete_property',
      'idproperty' => $this->input->post('id', TRUE));

    $url = base_api().'Property/';
    $parser = $this->my_lib->native_curl($url,$data);

    $data['message'] = $parser[0]->message;

    $avatar = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$avatar);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_galleryproperty()
  {
    $idproperty = $this->input->post('idproperty', TRUE);
    $config['upload_path']          = 'assets/img/galleryproperty/'.$idproperty;
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = $idproperty.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');
    if (!$upload_img){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessage', $error['error']);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }else{
      $photo = $this->upload->data();
      $data = array(
        'action' => 'insert_propertygallery',
        'idproperty' => $this->input->post('idproperty', TRUE),
        'avatar' =>  base_img().'galleryproperty/'.$idproperty.'/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'Propertygallery/';
      $parser = $this->my_lib->native_curl($url,$data);

      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Inserted');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }

  public function update_galleryproperty(){
    $idproperty = $this->input->post('idproperty', TRUE);
    $config['upload_path']          = 'assets/img/galleryproperty/'.$idproperty;
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = $idproperty.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');

    if (!$upload_img){
      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_propertygallery',
        'idproperty' => $this->input->post('idproperty', TRUE),
        'avatar' =>  $this->input->post('photo1', TRUE),
        'title' => $this->input->post('title', TRUE),
        'idpropertygallery' => $this->input->post('idpropertygallery', TRUE)
      );

      $url = base_api().'Propertygallery/';
      $parser = $this->my_lib->native_curl($url,$data);

      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }else{
      //delete old image if have new image
      $avatar = $this->input->post('photo1', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      var_dump($ava);
      unlink($ava);

      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_propertygallery',
        'idproperty' => $this->input->post('idproperty', TRUE),
        'avatar' =>  base_img().'galleryproperty/'.$idproperty.'/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE),
        'idpropertygallery' => $this->input->post('idpropertygallery', TRUE));

      $url = base_api().'Propertygallery/';
      $parser = $this->my_lib->native_curl($url,$data);

      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }

  public function delete_galleryproperty()
  {
    $data = array(
      'action' => 'delete_propertygallery',
      'idpropertygallery' => $this->input->post('idpropertygallery', TRUE));

    $url = base_api().'Propertygallery/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('imageurl', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_room(){
    $data = array(
      'action' => 'insert_room',
      'idproperty' => $this->input->post('idproperty', TRUE),
      'name' => $this->input->post('name', TRUE),
      'jumlah' => $this->input->post('quantity', TRUE));
    $url = base_api().'Room/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function update_room(){
    $data = array(
      'action' => 'update_room',
      'idproperty' => $this->input->post('idproperty', TRUE),
      'idroom' => $this->input->post('idroom', TRUE),
      'name' => $this->input->post('name', TRUE),
      'jumlah' => $this->input->post('quantity', TRUE));

    $url = base_api().'Room/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_room(){
    $data = array(
      'action' => 'delete_room',
      'idroom' => $this->input->post('idroom', TRUE));

    $url = base_api().'Room/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function forum()
  {
    $url = base_api().'Forums/?action=listforums&pagesize=10000&pagenumber=1';
    $parser = $this->my_lib->native_curl($url); //call function
    // var_dump($parser);
    $data['data_con'] = array();
    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idforums" => $parser[$i]->idforums,
          "idaccount" => $parser[$i]->idaccount,
          "title" => $parser[$i]->title,
          "fullname" => $parser[$i]->fullname,
          "viewer" => $parser[$i]->viewer,
          "typeforum" => $parser[$i]->typeforum,
          "comment" => $parser[$i]->comment,
          "approvedby" => $parser[$i]->approvedby,
          "approveddate" => $parser[$i]->approveddate,
          "createdate" => date("Y-m-d G:i A", strtotime($parser[$i]->createdate))

        ));

        // var_dump($data['data_con']);
        // die();
      }
    }

    //---- get account ----
    $url              = base_api()."Account?action=listaccount";
    $data['account']   = $this->my_lib->native_curl($url);

    $data['title'] = "Forum";
    $data['content'] = "forum";
    $this->load->view('admin/main', $data);
  }

  public function foruminsert()
  {
    $config['upload_path']          = 'assets/img/forums';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 2000;
    $config['max_height']           = 2000;
    $config['min_width']            = 165;
    $config['min_height']           = 114;
    $config['file_name']            = 'forum-'.trim(str_replace(" ","",date('dmYHisu')));
    $this->load->library('upload', $config);
    $this->upload->do_upload("userfile");
    $photo = $this->upload->data();
    $name_array = base_img().'forums/'.$photo['file_name'];

    if(!is_dir($config['upload_path'])) {
      mkdir($config1['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config1['upload_path'], 0777);
    }
    $names= implode(',', $name_array);
    $data = array(
      'action' => 'insert_forums',
      'idaccount' => $this->input->post('idaccount'),
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description'),
      'viewer' => '0',
      'typeforum' => '1',
      'avatar' => $name_array
    );
    $url = base_api().'Forums/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  private function set_upload_options()
  {
    $config = array();
    $config['upload_path'] = 'assets/img/forums';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['overwrite'] = FALSE;
    return $config;
  }


  public function forumdetail()
  {
    $idaccount = $this->input->get('id', TRUE);
    $url = base_api()."Forums/?action=retrieve_get&idforums=".$idaccount;
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    $data['idaccount']=$data['data_detail']->detail[0]->idaccount;
    $data['date'] = date("Y-m-d", strtotime($data['data_detail']->detail[0]->createdate));
    $data['time'] = date("H:i", strtotime($data['data_detail']->detail[0]->createdate));
    $data['typeforum'] = $data['data_detail']->detail[0]->typeforum;
    // $data['idaccount'] = $data['data_detail'][0]->detail->idaccount;

    //---- get account ----
    $url              = base_api()."Account?action=listaccount";
    $data['account']   = $this->my_lib->native_curl($url);
    // var_dump($data['time']);
    // $data['typeforum']=$data['data_detail']->detail[0]->typeforum;
    $data['title'] = $data['data_detail']->detail[0]->title!=null?$data['data_detail']->detail[0]->title:"Edit";
    $data['content'] = "forumdetail";
    // var_dump($data['data_detail']);
    // die;

    $this->load->view('admin/main', $data);
  }

  public function delete_forum(){
    $data = array(
      'action' => 'delete_forums',
      'idforums' => $this->input->post('idforums', TRUE));

    $url = base_api().'Forums/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_forum(){
    $now = date('Y-m-d G:i:s');
    $data = array(
      'action' => 'update_forums',
      'idaccount' => $this->input->post('idaccount', TRUE),
      'title' => $this->input->post('title', TRUE),
      'description' => $this->input->post('description', TRUE),
      'viewer' => $this->input->post('viewer', TRUE),
      'typeforum' => $this->input->post('typeforum', TRUE),
      'approvedby' => $this->input->post('app_by', TRUE),
      'approveddate'=>$now,
      'idforums' => $this->input->post('idforums', TRUE)
    );

    // var_dump($data);
    // die();
    $url = base_api().'Forums/';
    $parser = $this->my_lib->native_curl($url,$data);
    // var_dump($data);
    // var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_comment(){
    $data = array(
      'action' => 'insert_comment',
      'idaccount' => $this->input->post('idaccount', TRUE),
      'idforums' => $this->input->post('idforums', TRUE),
      'comment' => $this->input->post('comment', TRUE));
    $url = base_api().'Comment/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted Comment');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert comment.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function update_comment(){
    $data = array(
      'action' => 'update_comment',
      'idcomment' => $this->input->post('idcomment', TRUE),
      'idforums' => $this->input->post('idforums', TRUE),
      'idaccount' => $this->input->post('idaccount', TRUE),
      'comment' => $this->input->post('comment', TRUE));

    $url = base_api().'Comment/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated Comment');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated comment.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_comment(){
    $data = array(
      'action' => 'delete_comment',
      'idcomment' => $this->input->post('idcomment', TRUE));

    $url = base_api().'Comment/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;
    var_dump($data);
    var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted Comment');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted comment.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function tindustry()
  {

    $data['linkcat'] = strtolower(str_replace(' ', '', $data['title']));
    $data['title'] = "Phone Number";
    $data['content'] = "tindustry";
    $this->load->view('admin/main', $data);
  }

  public function ctransportationcategory()
  {
    $data['title'] = "Transportation-Category";
    $data['content'] = "ctransportationcategory";
    $this->load->view('admin/main', $data);
  }
  public function ctransportationcategoryedit()
  {
    $data['title'] = "Transportation-Category";
    $data['content'] = "ctransportationcategoryedit";
    $this->load->view('admin/main', $data);
  }
  public function ctransportation()
  {
    $data['title'] = "Transportation";
    $data['content'] = "ctransportation";
    $this->load->view('admin/main', $data);
  }
  public function ctransportationedit()
  {
    $data['title'] = "Transportation";
    $data['content'] = "ctransportationedit";
    $this->load->view('admin/main', $data);
  }
  public function cpage()
  {
    $data['title'] = "Page";
    $data['content'] = "cpage";
    $this->load->view('admin/main', $data);
  }
  public function cpageedit()
  {
    $data['title'] = "Page";
    $data['content'] = "cpageedit";
    $this->load->view('admin/main', $data);
  }

  public function city()
  {
    $url = base_api().'City/?action=select_datacity&idcity=1';
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function

    $data['title'] = "City";
    $data['content'] = "city";
    $this->load->view('admin/main', $data);
  }

  public function callcenter()
  {
    $url = base_api().'Callcenter/?action=retrieve_get&idcallcenter=1&idcity=1';
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function

    $data['title'] = "Call Center";
    $data['content'] = "callcenter";
    $this->load->view('admin/main', $data);
  }

  public function callcenter_update()
  {
    $data = array(
      'action' => 'update_callcenter',
      'idcity' => $this->input->post('idcity', TRUE),
      'title' => $this->input->post('title', TRUE),
      'title_id' => $this->input->post('title_id', TRUE),
      'description' => $this->input->post('description', TRUE),
      'description_id' => $this->input->post('description_id', TRUE),
      'phone' => $this->input->post('phone', TRUE),
      'idcallcenter' => $this->input->post('idcallcenter', TRUE)
    );
    $url = base_api().'Callcenter/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function terms()
  {
    $url = base_api().'Terms/?action=list&idcity=1';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_con'] = array();
    if(isset($parser[0]->status)!=true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idterms" => $parser[$i]->idterms,
          "idcity" => $parser[$i]->idcity,
          "linkfile" => $parser[$i]->linkfile,
          "title" => $parser[$i]->title
        ));
      }
    }

    $data['title'] = "Terms";
    $data['content'] = "terms";
    $this->load->view('admin/main', $data);
  }

  public function insert_terms()
  {
    if($this->input->post('othername', TRUE)==null){
      $name = $this->input->post('title', TRUE);
    }else{
      //if textbox
      if($this->input->post('othertitle', TRUE)==null){
        $name = $this->input->post('title', TRUE);
      }else{
        $name = $this->input->post('othertitle', TRUE);
      }
    }
    $title = $name;
    $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($title)));
    $config['upload_path']          = 'assets/file/city/';
    $config['allowed_types']        = 'html';
    $config['max_size']             = 2000;
    $config['file_name']            = $title;
    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('file');

    if (!$upload_img){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessage', $error['error']);
      redirect(base_url('admin/terms'));
    }else if($upload_img){
      $photo = $this->upload->data();
      $data = array(
        'action' => 'insert',
        'idcity' => '1',
        'linkfile' =>  base_url().'assets/file/city/'.$photo['file_name'],
        'title' => $name
      );
    }
    $url = base_api().'Terms/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      redirect(base_url('admin/terms'));
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      redirect(base_url('admin/terms'));
    }
  }

  public function termsdetail(){
    $title = $this->input->get('title', TRUE);
    $filename = $this->input->get('linkfile', TRUE);
    $data['terms'] = read_file($filename);
    $data['title'] = $title;
    $data['filename']=$filename;
    $data['content'] = "termsdetail";
    $this->load->view('admin/main', $data);
  }

  public function termsdownload(){
    $this->load->helper('download');
    $title = $this->input->get('title', TRUE);
    $filename = $this->input->get('linkfile', TRUE);
    $file = read_file($filename);
    force_download($title.'.html', $file);
  }


  public function update_terms()
  {
    $title = $this->input->post('title', TRUE);
    $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($title)));
    $config['upload_path']          = 'assets/file/city/';
    $config['allowed_types']        = 'html';
    $config['max_size']             = 2000;
    $config['file_name']            = $title;
    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('file');

    if (!$upload_img) {
      $data = array(
        'action' => 'update',
        'idterms' => $this->input->post('idterms',TRUE),
        'idcity' => $this->input->post('idcity', TRUE),
        'title' =>  $this->input->post('title', TRUE),
        'linkfile' => $this->input->post('linkfile', TRUE));
    } else {
      //delete old image if have new image
      $avatar = $this->input->post('linkfile', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);

      $photo = $this->upload->data();

      $cek = $photo['upload_path'].$photo['file_name'];
      if(!(chmod($cek, 0777))) {
        chmod($cek, 0777);
      }

      $data = array(
        'action' => 'update',
        'idterms' => $this->input->post('idterms',TRUE),
        'idcity' => $this->input->post('idcity', TRUE),
        'title' =>  $this->input->post('title', TRUE),
        'linkfile' =>  base_url().'assets/file/city/'.$photo['file_name']);
    }

    $url = base_api().'Terms/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message== "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_terms()
  {
    $data = array(
      'action' => 'delete',
      'idterms' => $this->input->post('id', TRUE));

    $url = base_api().'Terms/';
    $parser = $this->my_lib->native_curl($url,$data);


    $data['message'] = $parser[0]->message;

    $avatar = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$avatar);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);
    // $this->load->helper("file");
    // $a = delete_files($ava, true);

    // var_dump($a);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
      var_dump($data['message']);
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
      var_dump($data['message']);
    }
  }

  public function talktous()
  {
    $url = base_api().'Talktous/?action=retrieve_get&idtalktous=1&idcity=1';
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function

    $data['title'] = "Talk To Us";
    $data['content'] = "talktous";
    $this->load->view('admin/main', $data);
  }

  public function talktous_update()
  {
    $data = array(
      'action' => 'update',
      'header' => $this->input->post('header', TRUE),
      'description' => $this->input->post('description', TRUE),
      'heading1' => $this->input->post('heading1', TRUE),
      'content1' => $this->input->post('content1', TRUE),
      'heading2' => $this->input->post('heading2', TRUE),
      'content2' => $this->input->post('content2', TRUE),
      'content3' => $this->input->post('content3', TRUE),
      'content4' => $this->input->post('content4', TRUE),
      'emergencycall' => $this->input->post('emergencycall', TRUE),
      'content5' => $this->input->post('content5', TRUE),
      'callcenter' => $this->input->post('callcenter', TRUE),
      'idcity' => $this->input->post('idcity', TRUE),
      'idtalktous' => $this->input->post('idtalktous', TRUE)
    );
    $url = base_api().'Talktous/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function cityupdate()
  {
    $data = array(
      'action' => 'update_datacity',
      'cityname' => $this->input->post('cityname', TRUE),
      'cityarea' => $this->input->post('cityarea', TRUE),
      'metroarea' => $this->input->post('metro', TRUE),
      'residentpopulation' => $this->input->post('resident', TRUE),
      'employmentpopulation' => $this->input->post('employment', TRUE),
      'jobspopulation' => $this->input->post('jobspopulation', TRUE),
      'jobsinformation' => $this->input->post('jobsinformation', TRUE),
      'treesinformation' => $this->input->post('trees', TRUE),
      'roadinformation' => $this->input->post('roads', TRUE),
      'houseinformation' => $this->input->post('house', TRUE),
      'shophouseinformation' => $this->input->post('shophouse', TRUE),
      'schoollinformation' => $this->input->post('school', TRUE),
      'internationalschoollinformation' => $this->input->post('schoolinternational', TRUE),
      'serviceapartmentinformation' => $this->input->post('serviceapartment', TRUE),
      'timezone' => $this->input->post('timezone', TRUE),
      'areacode' => $this->input->post('areacode', TRUE),
      'vehicleregistration' => $this->input->post('vehicle', TRUE),
      'website' => $this->input->post('website', TRUE),
      'idcity' => $this->input->post('idcity', TRUE)
    );
    $url = base_api().'City/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function news()
  {
    $url = base_api().'News/?action=listnews&pagenumber=1&pagesize=10000&lang=ina';
    $parser = $this->my_lib->native_curl($url); //call function

    $data['data_con'] = array();
    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idnews" => $parser[$i]->idnews,
          "avatar" => $parser[$i]->avatar,
          "createdate" => $parser[$i]->createdate,
          "title" => $parser[$i]->title
        ));
      }
    }

    //---- get news category ----
    $urlnewscat = base_api()."News/?action=listnewscategory";
    $data['subnewscat']   = $this->my_lib->native_curl($urlnewscat);

    $data['title'] = "News";
    $data['content'] = "news";
    $this->load->view('admin/main', $data);
  }

  public function insert_news()
  {
    $checkedavatar = $this->input->post('empty_avatar');
    $checkedvideo = $this->input->post('empty_video');
    if($checkedavatar!=null) {
      $avatar = null;
    }
    if($checkedvideo!=null) {
      $video = $this->input->post('url_video', TRUE);
      $type = "3";
    }
    if($checkedavatar==null && $checkedvideo ==null){
      //upload avatar
      $config['upload_path']          = 'assets/img/news/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'news-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('image');

      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        $photo = $this->upload->data();
        $avatar = base_img().'news/'.$photo['file_name'];
        $type = "1";
      }

      //upload video
      $configvideo['upload_path']          = 'assets/img/news/';
      $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
      $configvideo['max_size']             = 30000;
      $configvideo['file_name']            = 'news-video-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($configvideo['upload_path'])) {
        mkdir($configvideovideovideo['upload_path'], 0777, TRUE);
      }
      if(!(chmod($configvideovideo['upload_path'], 0777))) {
        chmod($configvideo['upload_path'], 0777);
      }
      $this->load->library('upload', $configvideo);
      $this->upload->initialize($configvideo);
      $upload_video = $this->upload->do_upload('video');

      if (!$upload_video){
        // $error = array('error' => $this->upload->display_errors());
        // $this->session->set_flashdata('breakmessage', $error['error']);
        // $this->load->library('user_agent');
        // $upvideo = $this->upload->data();
        $video = "NULL";
        // redirect($this->agent->referrer());
      }else{
        $upvideo = $this->upload->data();
        $video = base_img().'news/'.$upvideo['file_name'];
        $type = "2";
      }
    }


    if($checkedavatar==null && $checkedvideo !=null){
      var_dump("masuk 2");
      // die();
      //upload avatar
      $config['upload_path']          = 'assets/img/news/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'news-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('image');

      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        $photo = $this->upload->data();
        $avatar = base_img().'news/'.$photo['file_name'];
        $type = "1";
      }
      $video = $this->input->post('url_video', TRUE);
      $type = "3";

    }

    if($checkedavatar!=null && $checkedvideo ==null){
      var_dump("masuk 3");
      // die();
      $avatar=null;

      //upload video
      $configvideo['upload_path']          = 'assets/img/news/';
      $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
      $configvideo['max_size']             = 30000;
      $configvideo['file_name']            = 'news-video-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($configvideo['upload_path'])) {
        mkdir($configvideovideovideo['upload_path'], 0777, TRUE);
      }
      if(!(chmod($configvideovideo['upload_path'], 0777))) {
        chmod($configvideo['upload_path'], 0777);
      }
      $this->load->library('upload', $configvideo);
      $this->upload->initialize($configvideo);
      $upload_video = $this->upload->do_upload('video');

      if (!$upload_video){
        $video = null;
        // $error = array('error' => $this->upload->display_errors());
        // $this->session->set_flashdata('breakmessage', $error['error']);
        // $this->load->library('user_agent');
        // redirect($this->agent->referrer());
      }else{
        $upvideo = $this->upload->data();
        $video = base_img().'news/'.$upvideo['file_name'];
        $type = "2";
      }
    }
  
    $data = array(
      'action' => 'insert_news',
      'avatar' =>  $avatar,
      'video' => $video,
      'type' => $type,
      'title' => $this->input->post('title', TRUE),
      'description' => $this->input->post('description', TRUE),
      'title_en' => $this->input->post('title_en', TRUE),
      'description_en' => $this->input->post('description_en', TRUE),
      'idnewscategory' => $this->input->post('idnewscategory', TRUE),
      'tag' => $this->input->post('labeltags', TRUE)
    );
    
    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);
    
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_news()
  {
    $data = array(
      'action' => 'delete_news',
      'idnews' => $this->input->post('id', TRUE));

    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);


    $data['message'] = $parser[0]->message;

    $avatar = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$avatar);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    var_dump($data);
    var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
      var_dump($data['message']);
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
      var_dump($data['message']);
    }
  }

  public function update_news(){

    $checkedavatar = $this->input->post('empty_avatar');
    $checkedvideo = $this->input->post('empty_video');
    $typedetail = $this->input->post('type');
    $exist_video = $this->input->post('exist_video', TRUE);
    $exist_avatar = $this->input->post('exist_avatar', TRUE);

    if($checkedavatar == null && $checkedvideo ==null){
      if(empty($_FILES['image']['name'])){
        $avatar = $exist_avatar;
        $type = "1";
      }else{
        //upload avatar
        $config['upload_path']          = 'assets/img/news/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;
        $config['min_width']            = 165;
        $config['min_height']           = 114;
        $config['file_name']            = 'news-'.trim(str_replace(" ","",date('dmYHisu')));
        $this->load->library('upload', $config);
        $upload_img = $this->upload->do_upload('image');

        if (!$upload_img){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
        else{
          //delete old image if have new image
          if($typedetail=="1")
          {
            $avatar = $this->input->post('avatar', TRUE);
            $image =  str_replace('/','\\',$avatar);
            $ava =  str_replace(array('http:','https:'),'',$image);
            unlink($ava);
          }
          $photo = $this->upload->data();
          $avatar = base_img().'news/'.$photo['file_name'];
          $type = "1";
        }
      }

      if(empty($_FILES['video']['name'])){
        $video = $exist_video;
        $type = "2";
      }else{
        //upload video
        $configvideo['upload_path']          = 'assets/img/news/';
        $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
        $configvideo['max_size']             = 30000;
        $configvideo['file_name']            = 'news-video-'.trim(str_replace(" ","",date('dmYHisu')));
        if(!is_dir($configvideo['upload_path'])) {
          mkdir($configvideovideovideo['upload_path'], 0777, TRUE);
        }
        if(!(chmod($configvideovideo['upload_path'], 0777))) {
          chmod($configvideo['upload_path'], 0777);
        }
        $this->load->library('upload', $configvideo);
        $this->upload->initialize($configvideo);
        $upload_video = $this->upload->do_upload('video');

        if (!$upload_video){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }else{
          $upvideo = $this->upload->data();
          $video = base_img().'news/'.$upvideo['file_name'];
          $type="2";
        }
      }
    }elseif($checkedavatar == null && $checkedvideo !=null){
      if(empty($_FILES['image']['name'])){
        $avatar = $exist_avatar;
        $type = "1";
      }else{
        //upload avatar
        $config['upload_path']          = 'assets/img/news/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;
        $config['min_width']            = 165;
        $config['min_height']           = 114;
        $config['file_name']            = 'news-'.trim(str_replace(" ","",date('dmYHisu')));
        $this->load->library('upload', $config);
        $upload_img = $this->upload->do_upload('image');

        if (!$upload_img){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
        else{
          //delete old image if have new image
          if($typedetail=="1")
          {
            $avatar = $this->input->post('avatar', TRUE);
            $image =  str_replace('/','\\',$avatar);
            $ava =  str_replace(array('http:','https:'),'',$image);
            unlink($ava);
          }
          $photo = $this->upload->data();
          $avatar = base_img().'news/'.$photo['file_name'];
          $type = "1";
        }
      }
      $video = $this->input->post('url_video', TRUE);
      $type = "3";
    }elseif($checkedavatar != null && $checkedvideo ==null){
      $avatar = null;
      if(empty($_FILES['video']['name'])){
        $video = $exist_video;
        $type = "2";
      }else{
        //upload video
        $configvideo['upload_path']          = 'assets/img/news/';
        $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
        $configvideo['max_size']             = 30000;
        $configvideo['file_name']            = 'news-video-'.trim(str_replace(" ","",date('dmYHisu')));
        if(!is_dir($configvideo['upload_path'])) {
          mkdir($configvideovideovideo['upload_path'], 0777, TRUE);
        }
        if(!(chmod($configvideovideo['upload_path'], 0777))) {
          chmod($configvideo['upload_path'], 0777);
        }
        $this->load->library('upload', $configvideo);
        $this->upload->initialize($configvideo);
        $upload_video = $this->upload->do_upload('video');

        if (!$upload_video){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }else{
          $upvideo = $this->upload->data();
          $video = base_img().'news/'.$upvideo['file_name'];
          $type="2";
        }
      }
    }elseif($checkedavatar != null && $checkedvideo !=null){
      $avatar = null;
      $video = $this->input->post('url_video', TRUE);
      $type = "3";
    }

    $data = array(
      'action' => 'update_news',
      'avatar' =>  $avatar,
      'video' => $video,
      'title' =>  $this->input->post('title', TRUE),
      'description' => $this->input->post('description', TRUE),
      'title_en' =>  $this->input->post('title_en', TRUE),
      'description_en' => $this->input->post('description_en', TRUE),
      'idnews' => $this->input->post('idnews', TRUE),
      'type' => $type,
      'idnewscategory' => $this->input->post('idnewscategory', TRUE),
      'tag' => $this->input->post('labeltags', TRUE)
    );

    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);
    
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Updated.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_gallerynews()
  {
    $pilihan = $this->input->post('pilihan', TRUE);
    $idnews = $this->input->post('idnews', TRUE);
    $checkedvideo = $this->input->post('empty_video', TRUE);

    if($pilihan =="photo"){
      //upload image
      $config['upload_path']          = 'assets/img/content/news/'.$idnews;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $idnews.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('photo');
      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        $photo = $this->upload->data();
        $avatar = base_img().'content/news/'.$idnews.'/'.$photo['file_name'];
        $type = "1";
      }

      $vori = $avatar;
    }
    elseif($pilihan=="video"){
      if($checkedvideo!=null){
        $vori = $this->input->post('url_video', TRUE);
        $type="3";
      }else{
        //upload video
        $configvideo['upload_path']          = 'assets/img/content/news/'.$idnews;
        $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
        $configvideo['max_size']             = 30000;
        $configvideo['file_name']            = $idnews.'-video-'.trim(str_replace(" ","",date('dmYHisu')));
        if(!is_dir($configvideo['upload_path'])) {
          mkdir($configvideo['upload_path'], 0777, TRUE);
        }
        if(!(chmod($configvideo['upload_path'], 0777))) {
          chmod($configvideo['upload_path'], 0777);
        }
        $this->load->library('upload', $configvideo);
        $this->upload->initialize($configvideo);
        $upload_video = $this->upload->do_upload('video');
        if (!$upload_video){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }else{
          $upvideo = $this->upload->data();
          $video = base_img().'content/news/'.$idnews.'/'.$upvideo['file_name'];
          $type="2";
        }

        $vori = $video;
      }
    }

    $data = array(
      'action' => 'insert',
      'idnews' => $this->input->post('idnews', TRUE),
      'caption' => $this->input->post('caption', TRUE),
      'avatar' => $vori,
      'type' => $type
    );

    $url = base_api().'Newsgallery/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Insert success');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Insert fail');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_gallerynews(){
    $pilihan = $this->input->post('pilihan', TRUE);
    $idnews = $this->input->post('idnews', TRUE);
    if($pilihan =="photo" && !empty($_FILES['photo']['name'])){
      //upload image
      $config['upload_path']          = 'assets/img/content/news/'.$idnews;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $idnews.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('photo');
      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('photo1', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);

        $photo = $this->upload->data();
        $avatar = base_img().'content/news/'.$idnews.'/'.$photo['file_name'];
        $type="1";
      }

      $vori = $avatar;
    }
    elseif($pilihan=="video"){
      $checkedvideo = $this->input->post('empty_video');
      if($checkedvideo!=null) {
        $video = $this->input->post('url_video', TRUE);
        //$video = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$videomentah);
        $type="3";
      }else{
        //upload video
        $configvideo['upload_path']          = 'assets/img/content/news/'.$idnews;
        $configvideo['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
        $configvideo['max_size']             = 30000;
        $configvideo['file_name']            = $idnews.'-video-'.trim(str_replace(" ","",date('dmYHisu')));
        if(!is_dir($configvideo['upload_path'])) {
          mkdir($configvideo['upload_path'], 0777, TRUE);
        }
        if(!(chmod($configvideo['upload_path'], 0777))) {
          chmod($configvideo['upload_path'], 0777);
        }
        $this->load->library('upload', $configvideo);
        $this->upload->initialize($configvideo);
        $upload_video = $this->upload->do_upload('video');
        if (!$upload_video){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', $error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }else{
          //delete old image if have new image
          $avatar = $this->input->post('photo1', TRUE);
          $image =  str_replace('/','\\',$avatar);
          $ava =  str_replace(array('http:','https:'),'',$image);
          unlink($ava);

          $upvideo = $this->upload->data();
          $video = base_img().'content/news/'.$idnews.'/'.$upvideo['file_name'];
          $type="2";
        }

        $vori = $video;
      }
    }

    $data = array(
      'action' => 'update',
      'idnews' => $this->input->post('idnews', TRUE),
      'title' => $this->input->post('title', TRUE),
      'caption' => $this->input->post('caption', TRUE),
      'idnewsgallery' => $this->input->post('idnewsgallery', TRUE));
    if (!empty($vori)) {
        $data['type'] = $type;
        $data['avatar'] =  $vori;
    } else {
        $data['type'] = '1';
        $data['avatar'] = $this->input->post('photo1', TRUE);
    }
    $url = base_api().'Newsgallery/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Update');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_gallerynews()
  {
    $data = array(
      'action' => 'delete',
      'idnewsgallery' => $this->input->post('idnewsgallery', TRUE));

    $url = base_api().'Newsgallery/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('imageurl', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function newsdetail()
  {
    $idnews = $this->input->get('id', TRUE);
    $url = base_api()."News/?action=retrieve_get&idnews=".$idnews;
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    //---- get news category ----
    $urlnewscat = base_api()."News/?action=listnewscategory";
    $data['subnewscat']   = $this->my_lib->native_curl($urlnewscat);
    
    $data['title'] = $data['data_detail']->detail[0]->title!=null?$data['data_detail']->detail[0]->title:"Edit";
    $data['content'] = "newsedit";
    $this->load->view('admin/main', $data);
  }

  public function download()
  {
    $idTCat = '91';
    $subcat = $this->input->get('subcat', TRUE)?$this->input->get('subcat', TRUE):$idTCat;
    $url = base_api().'Download/?action=listdownload&pagesize=10000&pagenumber=1&idcategory='.$subcat;
    $parser = $this->my_lib->native_curl($url); //call function

    $data['data_con'] = array();
    if($parser[0]->status==true) {
      $count = count($parser);
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "iddownload" => $parser[$i]->iddownload,
          "idcategory" => $parser[$i]->idcategory,
          "categoryname" => $parser[$i]->categoryname,
          "title" => $parser[$i]->title,
          "avatar" => $parser[$i]->avatar,
          "linkfile" => $parser[$i]->linkfile,
          "filename" => $parser[$i]->filename,
          "filesize" => $parser[$i]->filesize
        ));
      }
    }

    //---- get sub category ----
    $url              = base_api()."Category/?action=listallchild&idcategory=".$idTCat;
    $data['subcat']   = $this->my_lib->native_curl($url);

    $data['title'] = "Download";
    $data['content'] = "download";
    $this->load->view('admin/main', $data);


  }

  public function insert_file()
  {
    $idcategory = $this->input->post('idcategory', TRUE);
    $idtenant = $this->input->post('idtenant', TRUE);

    if ($idtenant=="") {
      $idtenant = null;
    }

    $imageurl =  null;
    $fileurl =  null;
    $filename = null;
    $filesize =  null;

    if (($this->input->post('empty_avatar', TRUE)==null)){
      $config['upload_path']          = 'assets/file/download/'.$idcategory;
      $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = 'file-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('avatar');
      $photo = $this->upload->data();
      chmod($photo['full_path'], 0777);

      if($upload_img){
        $imageurl =  base_url().'assets/file/download/'.$idcategory.'/'.$photo['file_name'];
      }
    }

    if ($this->input->post('empty_file')==null){

      $config1['upload_path']          = 'assets/file/download/'.$idcategory;
      $config1['allowed_types']        = 'pdf';
      $config1['max_size']             = 5000;
      $config1['file_name']            = 'file-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($config1['upload_path'])) {
        mkdir($config1['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config1['upload_path'], 0777))) {
        chmod($config1['upload_path'], 0777);
      }

      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_file = $this->upload->do_upload('file');
      $file = $this->upload->data();
      chmod($file['full_path'], 0777);


      if ($upload_file) {
        $fileurl =  base_url().'assets/file/download/'.$idcategory.'/'.$file['file_name'];
        $filename = $file['file_name'];
        $filesize =  round($file['file_size']*1024);
      }
    }


    $data = array(
      'action' => 'insert_download',
      'idcategory' => $idcategory,
      'title' => $this->input->post('title', TRUE),
      'avatar' =>  $imageurl,
      'linkfile' => $fileurl,
      'filename' => $filename,
      'filesize' => $filesize
    );

    $url = base_api().'Download/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_file(){
    $title = $this->input->post('title', TRUE);
    $idcategory = $this->input->post('idcategory', TRUE);

    $avatar =  null;
    $linkfile =  null;
    $filename = null;
    $filesize =  null;

    if (($this->input->post('empty_avatar', TRUE)==null)){
      $catlink  = $this->my_lib->cleanlink($this->my_lib->linkspace(strtolower($title)));
      $config['upload_path']          = 'assets/file/download/'.$idcategory;
      $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = 'file-'.trim(str_replace(" ","",date('dmYHisu')));


      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('avatar');
      $photo = $this->upload->data();
      chmod($photo['full_path'], 0777);

      if(!$upload_img){
        $avatar =  $this->input->post('uavatar', TRUE);
      }else{
        if ($this->input->post('avatar', TRUE)!="") {
          $avatar1 = $this->input->post('avatar', TRUE);
          $image =  str_replace('/','\\',$avatar1);
          $ava =  str_replace(array('http:','https:'),'',$image);
          unlink($ava);
        }
        $avatar =  base_url().'assets/file/download/'.$idcategory.'/'.$photo['file_name'];
      }
    }

    if ($this->input->post('empty_file')==null){
      $config1['upload_path']          = 'assets/file/download/'.$idcategory;
      $config1['allowed_types']        = 'pdf';
      $config1['max_size']             = 5000;
      $config1['file_name']            = 'file-'.trim(str_replace(" ","",date('dmYHisu')));
      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_file = $this->upload->do_upload('linkfile');
      $file = $this->upload->data();
      chmod($file['full_path'], 0777);

      if (!$upload_file) {
        $linkfile = $this->input->post('ulinkfile', TRUE);
        $filename = $this->input->post('filename', TRUE);
        $filesize = $this->input->post('filesize', TRUE);
      }else{
        if ($this->input->post('ulinkfile', TRUE)!="") {
          $linkfile1 = $this->input->post('ulinkfile', TRUE);
          $linkfile2 =  str_replace('/','\\',$linkfile1);
          $linkfile3 =  str_replace(array('http:','https:'),'',$linkfile2);
          unlink($linkfile3);
        }
        $linkfile =  base_url().'assets/file/download/'.$idcategory.'/'.$file['file_name'];
        $filename = $file['file_name'];
        $filesize =  round($file['file_size']*1024);

      }
    }
    $data = array(
      'action' => 'update_download',
      'iddownload' => $this->input->post('iddownload', TRUE),
      'idcategory' => $idcategory,
      'title' => $this->input->post('title', TRUE),
      'avatar' =>  $avatar,
      'linkfile' => $linkfile,
      'filename' => $filename,
      'filesize' => $filesize
    );


    $url = base_api().'Download/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Updated.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_file()
  {
    $data = array(
      'action' => 'delete_download',
      'iddownload' => $this->input->post('iddownload', TRUE));

    $url = base_api().'Download/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($this->input->post('avatar', TRUE)!="") {
      $avatar = $this->input->post('avatar', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
    }
    $linkfile = $this->input->post('linkfile', TRUE);
    $linkfile2 =  str_replace('/','\\',$linkfile);
    $linkfile3 =  str_replace(array('http:','https:'),'',$linkfile2);
    unlink($linkfile3);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('message', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_history(){
    $data = array(
      'action' => 'delete_history',
      'idhistory' => $this->input->post('id', TRUE));

    $url = base_api().'History/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_bookmark(){
    $data = array(
      'action' => 'delete_bookmark',
      'idbookmark' => $this->input->post('id', TRUE));

    $url = base_api().'Bookmark/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted Bookmark');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted bookmark.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function currency()
  {
    $data['title'] = "Currency";
    $data['content'] = "currency";
    $this->load->view('admin/main', $data);
  }

  public function insert_gallerycity()
  {
    $config['upload_path']          = 'assets/img/citygallery/';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 5000;
    $config['max_width']            = 2000;
    $config['max_height']           = 2000;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['overwrite']            = TRUE;
    $config['file_name']            = 'gallerycity-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');
    if (!$upload_img){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessagegallery', $error['error']);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }else{
      $photo = $this->upload->data();
      $cek = $photo['upload_path'].$photo['file_name'];
      if(!(chmod($cek, 0777))) {
        chmod($cek, 0777);
      }
      $data = array(
        'action' => 'insert_gallery',
        'idcity' => '1',
        'avatar' =>  base_img().'citygallery/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'City/';
      $parser = $this->my_lib->native_curl($url,$data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Inserted');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }
  public function delete_gallerycity()
  {
    $data = array(
      'action' => 'delete_gallery',
      'idcitygallery' => $this->input->post('idgallery', TRUE));

    $url = base_api().'City/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('imageurl', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);
    // var_dump($photo);
    // var_dump($image);
    // var_dump($ava);
    // var_dump(unlink($ava));
    // unlink('innodev.vnetcloud.com\LiveInWeb\assets\img\citygallery\gallerycity-01082016103112000000.JPG');
    // var_dump(unlink('innodev.vnetcloud.com\LiveInWeb\assets\img\citygallery\gallerycity-01082016103112000000.JPG'));
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function update_gallerycity(){
    $config['upload_path']          = 'assets/img/citygallery/';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 5000;
    $config['max_width']            = 2000;
    $config['max_height']           = 2000;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = 'gallerycity-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');

    if (!$upload_img){
      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_gallery',
        'idcitygallery' => $this->input->post('idgallery', TRUE),
        'avatar' =>  $this->input->post('photo1', TRUE),
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'City/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }else{
      //delete old image if have new image
      $avatar = $this->input->post('photo1', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      var_dump($ava);
      unlink($ava);

      $photo = $this->upload->data();
      $data = array(
        'action' => 'update_gallery',
        'idcitygallery' => $this->input->post('idgallery', TRUE),
        'avatar' =>  base_img().'citygallery/'.$photo['file_name'],
        'title' => $this->input->post('title', TRUE));

      $url = base_api().'City/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Update');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }

  public function insert_hashtag()
  {
    $data = array(
      'action' => 'inserthashtag',
      'tag' => $this->input->post('tag', TRUE),
      'description' => $this->input->post('description', TRUE));

    $url = base_api().'Gallery/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_hashtag', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_hashtag()
  {
    $data = array(
      'action' => 'update_hashtag',
      'idhashtag' => $this->input->post('idhashtag', TRUE),
      'tag' =>  $this->input->post('tag', TRUE),
      'description' => $this->input->post('description', TRUE));


    $url = base_api().'Gallery/';
    $parser = $this->my_lib->native_curl($url,$data);
    var_dump($data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_hashtag', 'Sucessfully Update');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_hashtag()
  {
    $data = array(
      'action' => 'delete_hashtag',
      'idhashtag' => $this->input->post('idhashtag', TRUE));
    // var_dump($data);
    // die();

    $url = base_api().'Gallery/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message_hashtag', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function notification()
  {
    $url = base_api().'Notif/?action=listnotifbycity&pagenumber=1&pagesize=1000&idcity=1';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_notif'] = array();
    $count = count($parser);
    if(!isset($parser[0]->status)) {
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_notif'], array(
          "idnotif" => $parser[$i]->idnotif,
          "title" => $parser[$i]->title,
          "description" => $parser[$i]->description,
          "createdate" => $parser[$i]->createdate,
          "avatar" => $parser[$i]->image
        ));
      }
    }
    // list account
    $url = base_api().'Account/?action=listaccount';
    $data['account'] = $this->my_lib->native_curl($url);

    // list account resident
    $param = array(
      'action' => 'listaccount_byprivilege',
      'privilege' => 'resident');
    $url = base_api().'Account/';
    $data['account_resident'] = $this->my_lib->native_curl($url, $param);

    // list account visitor
    $param = array(
      'action' => 'listaccount_byprivilege',
      'privilege' => 'visitor');
    $url = base_api().'Account/';
    $data['account_visitor'] = $this->my_lib->native_curl($url, $param);

    $data['title'] = "Notification";
    $data['content'] = "notification";
    $this->load->view('admin/main', $data);
  }

  public function notificationdetail()
  {

    $idnotif = $this->input->get('id', TRUE);
    $url = base_api()."Notif/?action=retrieve_get&idnotif=".$idnotif;
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    $data['idtenant'] = $data['data_detail']->notif[0]->idtenant;
    $title = $data['data_detail']->notif[0]->title;

    $data['idaccount'] = $data['data_detail']->account;
    //list tenant

    $idcategory = $this->input->get('cat', TRUE);
    $url = base_api().'Tenant/?action=listbycategory&idcategory='.$idcategory.'&pagenumber=1&pagesize=10000';
    $data['tenant']   = $this->my_lib->native_curl($url);

    $data['account'] = array();
    //list acoount yo insert
    $url = base_api().'Account/?action=listaccount';
    $listaccount = $this->my_lib->native_curl($url);

    $listaccountnotif = $data['idaccount'];
    for($i=0; $i<count($listaccount); $i++) {
      $found = false;
      for($j=0; $j<count($data['idaccount']); $j++) {
        if ($listaccount[$i]->idaccount == $listaccountnotif[$j]->idaccount) {
          $found = true;
          break;
        }
      }
      if (!$found) {
        array_push($data['account'], array(
          "idaccount" => $listaccount[$i]->idaccount,
          "fullname" => $listaccount[$i]->fullname
        ));
      }
    }

    $data['title'] = $title;
    $data['category']=$this->input->get('name', TRUE);
    $data['content'] = "notificationdetail";
    $this->load->view('admin/main', $data);
  }

  public function insert_notif(){
    $imageurl =  null;
    $idtenant = $this->input->post('idtenant', TRUE);

    if ($idtenant!="") {
      $tenant = $idtenant;
    }else{
      $tenant = 'city';
      $idcity = '1';
    }

    if (!is_uploaded_file($_FILES['photo']['tmp_name'])){
      $imageurl =  null;
    } else {
      $config['upload_path']          = 'assets/img/notification';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $tenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('photo');
      $photo = $this->upload->data();
      chmod($photo['full_path'], 0777);

      if(!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        $imageurl = base_img().'notification/'.$photo['file_name'];
      }
    }

    if($this->input->post('account', TRUE) !== null)
      $accountall= implode(',', $this->input->post('account', TRUE));
    if($this->input->post('accountres', TRUE) !== null)
      $accountres= implode(',', $this->input->post('accountres', TRUE));
    if($this->input->post('accountvis', TRUE) !== null)
      $accountvis= implode(',', $this->input->post('accountvis', TRUE));

    if (!$accountall && !$accountres) {
      $account = $accountvis;
    } else if (!$accountres && !$accountvis) {
      $account = $accountall;
    } else {
      $account = $accountres;
    }

    $data = array(
      'action' => 'insert_notif',
      'title' => $this->input->post('title', TRUE),
      'description' => $this->input->post('description', TRUE),
      'title_en' => $this->input->post('title_en', TRUE),
      'description_en' => $this->input->post('description_en', TRUE),
      'idtenant' => $idtenant,
      'image' =>  $imageurl,
      'idaccount' => $account,
      'idcity' => $idcity
    );

    $url = base_api().'Notif/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Notif Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', $parser[0]->message);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }

  }

  public function update_notif(){
    $imageurl = null;
    $idtenant = $this->input->post('idtenant', TRUE);

    if ($idtenant!="") {
      $tenant = $idtenant;
    }else{
      $tenant = 'city';
      $idcity = '1';
    }

    if(is_uploaded_file($_FILES['photo']['tmp_name'])) {
      $config['upload_path']          = 'assets/img/notification';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 150;
      $config['min_height']           = 150;
      $config['file_name']            = $tenant.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('photo');
      $photo = $this->upload->data();
      chmod($photo['full_path'], 0777);

      if(!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', $error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else{
        $avatar = $this->input->post('photo1', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $imageurl =  base_img().'notification/'.$photo['file_name'];
      }
    } else if($this->input->post('empty_avatar', TRUE)!=null ){
      $avatar = $this->input->post('photo1', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
    } else {
      $imageurl = $this->input->post('photo1', TRUE);
    }

    $data = array(
      'action' => 'update_notif',
      'idnotif' => $this->input->post('idnotif', TRUE),
      'title' => $this->input->post('title', TRUE),
      'description' => $this->input->post('description', TRUE),
      'title_en' => $this->input->post('title_en', TRUE),
      'description_en' => $this->input->post('description_en', TRUE),
      'idtenant' => $idtenant,
      'createdate' => $this->input->post('createdate', TRUE),
      'image' => $imageurl,
      'idcity' => $idcity
    );

    $url = base_api().'Notif/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }

  }

  public function delete_notif(){
    $data = array(
      'action' => 'delete_notif',
      'idnotif' => $this->input->post('idnotif', TRUE));

    $url = base_api().'Notif/';
    $parser = $this->my_lib->native_curl($url,$data);
    $data['message'] = $parser[0]->message;

    $photo = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Notif Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Notif Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function agent()
  {
    $url = base_api().'Agent/?action=listagent&pagenumber=1&pagesize=1000';
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_con'] = array();
    $count = count($parser);
    if(!isset($parser[0]->status)) {
      for($i=0; $i<=($count-1); $i++) {
        array_push($data['data_con'], array(
          "idagent" => $parser[$i]->idagent,
          "name" => $parser[$i]->name,
          "avatar" => $parser[$i]->avatar,
          "email" => $parser[$i]->email,
          "phone" => $parser[$i]->phone
        ));
      }
    }

    $data['title'] = "Agent";
    $data['content'] = "agent";
    $this->load->view('admin/main', $data);
  }

  public function agentdetail()
  {
    $idagent = $this->input->get('id', TRUE);
    $url = base_api()."Agent/?action=retrieve_get&idagent=".$idagent;
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    $title = $data['data_detail'][0]->name;

    $url = base_api()."Property/?action=listbyagent&pagenumber=1&pagesize=100&idagent=".$idagent;
    $parser = $this->my_lib->native_curl($url); //call function
    $data['data_con'] = array();
    $count = count($parser);
    for($i=0; $i<=($count-1); $i++) {
      array_push($data['data_con'], array(
        "idproperty" => $parser[$i]->idproperty,
        "name" => $parser[$i]->name,
        "avatar" => $parser[$i]->avatar
      ));
    }
    $data['title'] = $title;
    $data['content'] = "agentdetail";
    $this->load->view('admin/main', $data);
  }

  public function insert_agent()
  {
    if($this->input->post('empty_avatar', TRUE)==null) {
      $config['upload_path']          = 'assets/img/agent';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'agent-'.trim(str_replace(" ","",date('dmYHisu')));

      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('image');
      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        //$this->load->view('admin/content/error', $error);
        $this->session->set_flashdata('breakmessage', $error['error']);
        redirect(base_url('admin/agent'));

      }else{
        $photo = $this->upload->data();
        $data = array(
          'action' => 'insert_agent',
          'avatar' =>  base_img().'agent/'.$photo['file_name'],
          'name' => $this->input->post('name', TRUE),
          'email' => $this->input->post('email', TRUE),
          'phone' => $this->input->post('phone', TRUE)
        );
      }
    }else{
      $data = array(
        'action' => 'insert_agent',
        'avatar' =>  null,
        'name' => $this->input->post('name', TRUE),
        'email' => $this->input->post('email', TRUE),
        'phone' => $this->input->post('phone', TRUE)
      );
    }

    $url = base_api().'Agent/';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_agent(){
    if($this->input->post('empty_avatar', TRUE)==null) {
      $config['upload_path']          = 'assets/img/agent';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 800;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'agent-'.trim(str_replace(" ","",date('dmYHisu')));
      $this->load->library('upload', $config);
      $upload_img = $this->upload->do_upload('image');

      if (!$upload_img){
        $photo = $this->upload->data();

        $data = array(
          'action' => 'update_agent',
          'avatar' =>  $this->input->post('avatar', TRUE),
          'name' => $this->input->post('name', TRUE),
          'email' => $this->input->post('email', TRUE),
          'phone' => $this->input->post('phone', TRUE),
          'idagent' => $this->input->post('idagent', TRUE)
        );
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('avatar', TRUE);
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $photo = $this->upload->data();
        $data = array(
          'action' => 'update_agent',
          'avatar' =>  base_img().'agent/'.$photo['file_name'],
          'name' => $this->input->post('name', TRUE),
          'email' => $this->input->post('email', TRUE),
          'phone' => $this->input->post('phone', TRUE),
          'idagent' => $this->input->post('idagent', TRUE)
        );
      }
    }else{
      //delete old image if have new image
      $avatar = $this->input->post('avatar', TRUE);
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
      $data = array(
        'action' => 'update_agent',
        'avatar' =>  null,
        'name' => $this->input->post('name', TRUE),
        'email' => $this->input->post('email', TRUE),
        'phone' => $this->input->post('phone', TRUE),
        'idagent' => $this->input->post('idagent', TRUE)
      );
    }

    $url = base_api().'Agent/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('messageu', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessageu', "Can't be Updated.");
      var_dump($data);
      var_dump($parser);
      // $this->load->library('user_agent');
      // redirect($this->agent->referrer());
    }
  }

  public function delete_agent()
  {
    $data = array(
      'action' => 'delete_agent',
      'idagent' => $this->input->post('idagent', TRUE));

    $url = base_api().'Agent/';
    $parser = $this->my_lib->native_curl($url,$data);

    $avatar = $this->input->post('avatar', TRUE);
    if($avatar!=null){
      $image =  str_replace('/','\\',$avatar);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
    }
    var_dump($data);
    var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted agent');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted agent.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_galleryforums(){
    $config['upload_path']          = 'assets/img/forums';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = 'forums-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');
    if (!$upload_img){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessage', $error['error']);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }else{
      $photo = $this->upload->data();
      $data = array(
        'action' => 'insert_galleryforums',
        'idforums' => $this->input->post('idforums', TRUE),
        'avatar' =>  base_img().'forums/'.$photo['file_name']
      );

      $url = base_api().'Galleryforums/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);var_dump($parser);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Inserted');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }
  public function update_galleryforums(){
    $config['upload_path']          = 'assets/img/forums';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 800;
    $config['min_width']            = 150;
    $config['min_height']           = 150;
    $config['file_name']            = 'forums-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $upload_img = $this->upload->do_upload('photo');

    if (!$upload_img){
      $avatar = $this->input->post('photo1', TRUE);
    }else{
      $photo = $this->upload->data();
      $avatar = base_img().'forums/'.$photo['file_name'];

      $photo = $this->input->post('photo1', TRUE);
      $image =  str_replace('/','\\',$photo);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
    }
    $data = array(
      'action' => 'update_galleryforums',
      'idgalleryforums' => $this->input->post('idgalleryforums', TRUE),
      'idforums' => $this->input->post('idforums', TRUE),
      'avatar' =>   $avatar
    );

    $url = base_api().'Galleryforums/';
    $parser = $this->my_lib->native_curl($url,$data);
    var_dump($data);var_dump($parser);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }

  }
  public function delete_galleryforums(){
    $data = array(
      'action' => 'delete_galleryforums',
      'idgalleryforums' => $this->input->post('idgalleryforums', TRUE));

    $url = base_api().'Galleryforums/';
    $parser = $this->my_lib->native_curl($url,$data);

    $photo = $this->input->post('avatar', TRUE);
    $image =  str_replace('/','\\',$photo);
    $ava =  str_replace(array('http:','https:'),'',$image);
    unlink($ava);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_isread(){
    $data = array(
      'action' => 'delete_isread',
      'idread' => $this->input->post('idread', TRUE));

    $url = base_api().'Notif/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_isread(){
    $account= implode(',', $this->input->post('account', TRUE));
    $data = array(
      'action' => 'insert_isread',
      'idaccount' => $account,
      'idnotif' => $this->input->post('idnotif', TRUE)
    );
    $url = base_api().'Notif/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function busschedule() {
    $url = base_api();
    $dt_route = $this->my_lib->native_curl($url . 'Transport/?action=listroute');
    $data['data_route'] = array();
    $item_sub = array();
    foreach($dt_route as $key => $value) {
      $idroute = $value->idroute;
      $routename = $value->routename;
      $idsub = $value->idsubroute;
      $subname = $value->subname;
      if(!in_array($routename, $item_sub)) {
        array_push($item_sub, $routename);
        $item = [
            "idroute" => $idroute,
            "routename" => $routename,
            "idsubroute" => $idsub,
            "subname" => $subname
        ];
        array_push($data['data_route'], $item);
      }
    }
    $dt_busschedule = $this->my_lib->native_curl($url . 'Transport/?action=listallbus&pagenumber=1&pagesize=1000');
    $data['data_con'] = $dt_busschedule;
    $data['title'] = "Bus Schedule";
    $data['content'] = "busschedule";
    $this->load->view('admin/main', $data);
  }

  public function insert_bus(){
    foreach ($this->input->post('starttime', TRUE) as $index => $starttime) {
      $starttime = date("H:i:s", strtotime($starttime));
      if(empty($this->input->post('endtime', TRUE)[$index])){
          $endtime = '00:00:00';
      } else {
          $endtime = date("H:i:s", strtotime($this->input->post('endtime', TRUE)[$index]));
      }
      $data = array(
          'action' => 'insert_bus',
          'iddayschedule' => $this->input->post('days', TRUE),
          'idroute' => $this->input->post('busroute', TRUE),
          'departure' => $starttime,
          'arrival' => $endtime,
      );
      if ($this->input->post('busroute') == '4') { //route internal
          $data['subroute'] = $this->input->post('subroute', TRUE);
      }
      $url = base_api().'Transport/';
      $parser = $this->my_lib->native_curl($url,$data);
    }

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Successfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_bus() {
      $data = array('iddayschedule' => $this->input->post('days', TRUE),
          'idroute' => $this->input->post('busroute', TRUE), 'action' => 'delete_bus');
      if (!empty($this->input->post('idsubroute'))) {
          $data['idsubroute'] = $this->input->post('idsubroute');
      }
      $url = base_api() . 'Transport/';
      $parser = $this->my_lib->native_curl($url, $data);
      $this->insert_bus();
  }

  public function delete_bus() {
      $data = array('iddayschedule' => $this->input->post('iddayschedule', TRUE),
                'idroute' => $this->input->post('idroute', TRUE), 'idsubroute' => $this->input->post('idsubroute', TRUE),
                'action' => 'delete_bus');
      $url = base_api() . 'Transport/';
      $parser = $this->my_lib->native_curl($url, $data);
      if ($parser[0]->message == "success") {
          $this->session->set_flashdata('message', 'Successfully Deleted');
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
      } else {
          $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
      }
  }

  public function publictransportation() {
    $url = base_api().'Publictransportation/?action=list&idcity=1&pagenumber=1&pagesize=1000';
    $parser = $this->my_lib->native_curl($url);
    $data['data_con'] = array();
    $count = count($parser);
    for($i=0; $i<=($count-1); $i++) {
      array_push($data['data_con'], array(
        "idpublictransportation" => $parser[$i]->idpublictransportation,
        "idcity" => $parser[$i]->idcity,
        "publictransportcode" => $parser[$i]->publictransportcode,
        "route" => $parser[$i]->route
      ));
    }

    $data['title'] = "Public Transportation";
    $data['content'] = "publictransportation";
    $this->load->view('admin/main', $data);
  }

  public function insert_publictransportation(){
    $data = array(
      'action' => 'insert_publictransportation',
      'idcity' => '1',
      'publictransportcode' => $this->input->post('publictransportcode', TRUE),
      'route' => $this->input->post('route', TRUE)
    );
    $url = base_api().'Publictransportation/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_publictransportation(){
    $data = array(
      'action' => 'update_publictransportation',
      'idcity' => '1',
      'publictransportcode' => $this->input->post('publictransportcode', TRUE),
      'route' => $this->input->post('route', TRUE),
      'idpublictransportation' => $this->input->post('idpublictransportation', TRUE)
    );
    $url = base_api().'Publictransportation/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function delete_publictransportation(){
    $data = array(
      'action' => 'delete_publictransportation',
      'idpublictransportation' => $this->input->post('idpublictransportation', TRUE));

    $url = base_api().'Publictransportation/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function insert_advertise(){
    $type = $this->input->post('type', TRUE);
    $idpropertya =  $this->input->post('idproperty', TRUE);
    $idtenanta = $this->input->post('tenantid', TRUE);
    if($type == "tenant"){
      $idfolder = $idtenanta;
      $idtenant = $idtenanta;
      $idproperty = null;
    }elseif($type == "property"){
      $idfolder = $idpropertya;
      $idtenant = null;
      $idproperty = $idpropertya;
    }

    //upload small advertise
    $config1['upload_path']          = 'assets/img/content/advertise/'.$idfolder;
    $config1['allowed_types']        = 'gif|jpg|png|jpeg';
    $config1['max_size']             = 2000;
    $config1['max_width']            = 750;
    $config1['max_height']           = 129;
    $config1['min_width']            = 100;
    $config1['min_height']           = 17;
    $config1['file_name']            = $idfolder.'-small-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config1['upload_path'])) {
      mkdir($config1['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config1['upload_path'], 0777))) {
      chmod($config1['upload_path'], 0777);
    }

    $this->load->library('upload', $config1);
    $this->upload->initialize($config1);
    $upload_imgsmall = $this->upload->do_upload('smallphoto');
    $photosmall = $this->upload->data();
    $smalladv = base_img().'content/advertise/'.$idfolder.'/'.$photosmall['file_name'];

    $config['upload_path']          = 'assets/img/content/advertise/'.$idfolder;
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 2000;
    $config['max_width']            = 800;
    $config['max_height']           = 1334;
    $config['min_width']            = 200;
    $config['min_height']           = 334;
    $config['rotation_angle']       = 'vrt';
    $config['file_name']            = $idfolder.'-'.trim(str_replace(" ","",date('dmYHisu')));

    if(!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    if(!(chmod($config['upload_path'], 0777))) {
      chmod($config['upload_path'], 0777);
    }

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    $upload_img = $this->upload->do_upload('photo');
    $photo = $this->upload->data();
    $fulladv = base_img().'content/advertise/'.$idfolder.'/'.$photo['file_name'];

    if (!$upload_img && !$upload_imgsmall ){
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('breakmessage', $error['error']);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }else{
      $data = array(
        'action' => 'insert_advertise',
        'idtenant' => $idtenant,
        'idproperty' => $idproperty,
        'advertise' =>  $fulladv,
        'smalladvertise' => $smalladv,
        'idcategory' => $this->input->post('idcategory', TRUE));

      $url = base_api().'Advertise/';
      $parser = $this->my_lib->native_curl($url,$data);
      var_dump($data);
      // var_dump($parser);
      if ($parser[0]->message == "success") {
        $this->session->set_flashdata('message', 'Sucessfully Inserted');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }
    }
  }
  public function delete_advertise()
  {
    $data = array(
      'action' => 'delete_advertise',
      'idadvertise' => $this->input->post('idadvertise', TRUE));

    $url = base_api().'Advertise/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $photo = $this->input->post('advertise', TRUE);
      $image =  str_replace('/','\\',$photo);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);
      $photo = $this->input->post('smalladvertise', TRUE);
      $image =  str_replace('/','\\',$photo);
      $smallava =  str_replace(array('http:','https:'),'',$image);
      unlink($smallava);
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }
  public function advertisedetail()
  {
    $type = $this->input->get('type', TRUE);
    $data['type'] = $type;

    $subcata = $this->input->get('subcat', TRUE);
    $idadvertise = $this->input->get('id', TRUE);
    $data['category'] = $this->input->get('name', TRUE);
    $url = base_api()."Advertise/?action=retrieve_get&idadvertise=".$idadvertise;
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function

    if($type =="tenant"){
      $subcat = $subcata;
      $url = base_api().'Tenant/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=10000';
      $parser = $this->my_lib->native_curl($url); //call function
      $data['tenant'] = $parser;
      $urllist = base_api().'Advertise/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=1000';
    }elseif($type =="property"){
      $subcat = '39';
      $idTCat = '39';
      $subcat = $this->input->get('subcat', TRUE)?$this->input->get('subcat', TRUE):$idTCat;
      $url = base_api().'Property/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=10000&status=%%';
      $parser = $this->my_lib->native_curl($url); //call function
      $data['property'] = $parser;
      $urllist = base_api().'Advertise/?action=listbycategory&idcategory='.$subcat.'&pagenumber=1&pagesize=1000&category=property';
    }

    $parser = $this->my_lib->native_curl($urllist); //call function
    $data['adv'] = $parser;

    if($type == "tenant"){
      $data['tenantfull'] = array();
      $countf = count($data['tenant']);
      for($i=0; $i<=($countf-1); $i++) {
        array_push($data['tenantfull'], array(
          'idtenant' => $data['tenant'][$i]->idtenant,
          'tenantsname' => $data['tenant'][$i]->tenantsname
        ));
      }
      $data['tenantadv'] = array();
      $countf = count($data['adv']);
      for($i=0; $i<=($countf-1); $i++) {
        array_push($data['tenantadv'], array(
          'idtenant' => $data['adv'][$i]->idtenant
        ));
      }

      $data['i_tenant'] = array();

      for($i=0; $i<count($data['tenantfull']); $i++) {
        $found = false;
        for($j=0; $j<count($data['tenantadv']); $j++) {
          if (($data['tenantfull'][$i]['idtenant'] == $data['tenantadv'][$j]['idtenant']) && ($data['data_detail'][0]->idtenant != $data['tenantadv'][$j]['idtenant'])) {
            $found = true;
            break;
          }
        }
        if (!$found) {
          array_push($data['i_tenant'], array(
            "idtenant" => $data['tenantfull'][$i]['idtenant'],
            "tenantsname" => $data['tenantfull'][$i]['tenantsname']
          ));
        }
      }
    }elseif($type == "property"){
      $data['tenantfull'] = array();
      $countf = count($data['property']);
      for($i=0; $i<=($countf-1); $i++) {
        array_push($data['tenantfull'], array(
          'idtenant' => $data['property'][$i]->idproperty,
          'tenantsname' => $data['property'][$i]->name
        ));
      }
      $data['tenantadv'] = array();
      $countf = count($data['adv']);
      for($i=0; $i<=($countf-1); $i++) {
        array_push($data['tenantadv'], array(
          'idtenant' => $data['adv'][$i]->idproperty
        ));
      }

      $data['i_tenant'] = array();

      for($i=0; $i<count($data['tenantfull']); $i++) {
        $found = false;
        for($j=0; $j<count($data['tenantadv']); $j++) {
          if (($data['tenantfull'][$i]['idtenant'] == $data['tenantadv'][$j]['idtenant']) && ($data['data_detail'][0]->idproperty != $data['tenantadv'][$j]['idtenant'])) {
            $found = true;
            break;
          }
        }
        if (!$found) {
          array_push($data['i_tenant'], array(
            "idtenant" => $data['tenantfull'][$i]['idtenant'],
            "tenantsname" => $data['tenantfull'][$i]['tenantsname']
          ));
        }
      }
      // var_dump($data['i_tenant']);
    }
    // $result = array_intersect($data['i_tenant'], $data['data_detail'][0]->idtenant);
    // var_dump($result);
    // var_dump($data['data_detail'][0]->idtenant);


    $data['title'] = $data['data_detail']->detail[0]->title!=null?$data['data_detail']->detail[0]->title:"Edit";
    $data['content'] = "advertise_detail";
    $this->load->view('admin/main', $data);
  }
  public function update_advertise(){
    $type = $this->input->post('type', TRUE);
    $idpropertya = $this->input->post('idproperty', TRUE);
    $idtenanta = $this->input->post('tenantid', TRUE);
    if($type == "tenant"){
      $idfolder = $idtenanta;
      $idtenant = $idtenanta;
      $idproperty = null;
    }elseif($type == "property"){
      $idfolder = $idpropertya;
      $idtenant = null;
      $idproperty = $idpropertya;
    }

    if ($_FILES['smallimage']['size']!=0) {
      $config1['upload_path']          = 'assets/img/content/advertise/'.$idfolder;
      $config1['allowed_types']        = 'gif|jpg|png|jpeg';
      $config1['max_size']             = 2000;
      $config1['max_width']            = 750;
      $config1['max_height']           = 129;
      $config1['min_width']            = 100;
      $config1['min_height']           = 17;
      $config1['file_name']            = $idfolder.'-small-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config1['upload_path'])) {
        mkdir($config1['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config1['upload_path'], 0777))) {
        chmod($config1['upload_path'], 0777);
      }

      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_imgsmall = $this->upload->do_upload('smallimage');
      if (!$upload_imgsmall){
        $smallstatus = false;
        $smallerrmess = $this->upload->display_errors();
        $smalladv = $this->input->post('old_smalladvertise', TRUE);
      }else{
        $smallstatus = true;
        //delete old image if have new image
        $avatar = $this->input->post('old_smalladvertise');
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $photo = $this->upload->data();
        $idtenant = $this->input->post('tenantid', TRUE);
        $smalladv =  base_img().'content/advertise/'.$idfolder.'/'.$photo['file_name'];
      }
    } else {
      $smallstatus = true;
      $smalladv = $this->input->post('old_smalladvertise', TRUE);
    }

    if ($_FILES['image']['size']!=0) {
      $config['upload_path']          = 'assets/img/content/advertise/'.$idfolder;
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      $config['max_width']            = 800;
      $config['max_height']           = 1334;
      $config['min_width']            = 200;
      $config['min_height']           = 334;
      $config['rotation_angle']       = 'vrt';
      $config['file_name']            = $idfolder.'-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('image');
      if (!$upload_img){
        $status = false;
        $errmess = $this->upload->display_errors();
        $newadvertise = $this->input->post('old_advertise', TRUE);
      }else{
        $status = true;
        //delete old image if have new image
        $avatar = $this->input->post('old_advertise');
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $photo = $this->upload->data();
        $idtenant = $this->input->post('tenantid', TRUE);
        $newadvertise =  base_img().'content/advertise/'.$idfolder.'/'.$photo['file_name'];
      }
    } else {
      $status = true;
      $newadvertise = $this->input->post('old_advertise', TRUE);
    }

    $data = array(
      'action' => 'update_advertise',
      'idtenant' => $idtenant,
      'idproperty' => $idproperty,
      'advertise' => $newadvertise,
      'smalladvertise' => $smalladv,
      'idadvertise' => $this->input->post('idadvertise', TRUE));

    $url = base_api().'Advertise/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      if($status == true && $smallstatus == false){
        $this->session->set_flashdata('breakmessage', $smallerrmess);
      }elseif($status == false && $smallstatus == true){
        $this->session->set_flashdata('breakmessage', $errmess);
      }else{
        $this->session->set_flashdata('message', 'Successfully updated');
      }
      $this->load->library('user_agent');
      redirect($this->agent->referrer());

    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Update.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }


  public function show_transaction(){
    if($this->input->post('btn_submit') == 'Submit') {
      $show = array(
        'startDate' => $this->input->post('startdate', TRUE),
        'endDate' => $this->input->post('enddate', TRUE),
        'PaymentTypeID' => $this->input->post('type', TRUE)
      );
      $url = base_api_payment().'gettransaction';
      $parser = $this->my_lib->native_curl($url,$show);
      $data['data_con'] = array();
      $merchant = array();
      $count = count($parser);

      try{
        if(is_array($parser)) {
          for($i=0; $i<=($count-1); $i++) {
            $merchantId =  $parser[$i]->MerchantTransactionID;
            $detail = $parser[$i]->DetailTransaction;
            foreach ($detail as $key => $value) {
              $isDuplicate;
              if(!in_array($merchantId, $merchant)) {
                $isDuplicate = 0;
                array_push($merchant, $merchantId);
              } else {
                $isDuplicate = 1;
              }
              array_push($data['data_con'], array(
                "CreatedOn" => date("d/m/y H:i",strtotime($parser[$i]->CreatedOn)),
                "Email" => $parser[$i]->Email,
                "MerchantTransactionID" => $parser[$i]->MerchantTransactionID,
                "Amount" => $parser[$i]->Amount,
                "PSCode" => $value->PSCode,
                "SiteID" => $value->SiteID,
                "BillingPaid" => $value->BillingPaid,
                "Status" => $value->Status,
                "IsDuplicate" => $isDuplicate,
                "OVOTransactionID" => $parser[$i]->OVOTransactionID,
                "OVOPhoneNumber" => $parser[$i]->OVOPhoneNumber,
                "OVOTransactionAmount" => $parser[$i]->OVOTransactionAmount
              ));
              // var_dump($data['data_con']);
              // die();
            }
          }
        }

      }catch(Exception $e){
        echo $e;
      }

      $data['title'] = "Transaction";
      $data['content'] = "transaction";
      $data['parameter'] = $show;
      $this->load->view('admin/main', $data);
    } else {
      $show = array(
        'startDate' => $this->input->post('startdate', TRUE),
        'endDate' => $this->input->post('enddate', TRUE),
        'PaymentTypeID' => $this->input->post('type', TRUE)
      );
      $url = base_api_payment().'gettransaction';
      $parser = $this->my_lib->native_curl($url,$show);
      $data['data_con'] = array();
      $merchant = array();
      $count = count($parser);

      try{
        if(is_array($parser)) {
          for($i=0; $i<=($count-1); $i++) {
            $merchantId =  $parser[$i]->MerchantTransactionID;
            $detail = $parser[$i]->DetailTransaction;
            foreach ($detail as $key => $value) {
              $isDuplicate;
              if(!in_array($merchantId, $merchant)) {
                $isDuplicate = 0;
                array_push($merchant, $merchantId);
              } else {
                $isDuplicate = 1;
              }
              array_push($data['data_con'], array(
                "CreatedOn" => date("d/m/y H:i",strtotime($parser[$i]->CreatedOn)),
                "Email" => $parser[$i]->Email,
                "MerchantTransactionID" => $parser[$i]->MerchantTransactionID,
                "Amount" => $parser[$i]->Amount,
                "PSCode" => $value->PSCode,
                "SiteID" => $value->SiteID,
                "BillingPaid" => $value->BillingPaid,
                "Status" => $value->Status,
                "IsDuplicate" => $isDuplicate,
                "OVOTransactionID" => $parser[$i]->OVOTransactionID,
                "OVOPhoneNumber" => $parser[$i]->OVOPhoneNumber,
                "OVOTransactionAmount" => $parser[$i]->OVOTransactionAmount
              ));
            }
          }
        }

      }catch(Exception $e){
        echo $e;
      }
      $data['parameter'] = $show;
      $this->load->view('admin/content/excel_transaction',$data);
    }

  }

  public function transaction() {
    $data['title'] = "Transaction";
    $data['content'] = "transaction";
    $this->load->view('admin/main', $data);
  }

  public function show_earnpoint(){
      $show = array(
        'startDate' => $this->input->post('startdate', TRUE),
        'endDate' => $this->input->post('enddate', TRUE),
      );
      $url = base_api().'Voucher/listearnpoint?startDate='.$show['startDate'].'&endDate='.$show['endDate'];
      $parser = $this->my_lib->native_curl($url);
      $data['data_con'] = array();
      $count = count($parser);

          for($i=0; $i<=($count-1); $i++) {
              array_push($data['data_con'], array(
                "transactionDateOld" => $parser[$i]->transactionDate,
                "transactionDate" => date("d M Y H:i",strtotime($parser[$i]->transactionDate)),
                "merchant_invoice" => $parser[$i]->merchant_invoice,
                "ovoid" => $parser[$i]->ovoid,
                "ovopoint" => $parser[$i]->ovopoint,
                "status" => $parser[$i]->status,
                "email" => $parser[$i]->email,
                "point" => $parser[$i]->point,
              ));
          }
      $data['startDate'] = $show['startDate'];
      $data['endDate'] = $show['endDate'];
      $data['title'] = "Earn Point";
      $data['content'] = "earnpoint";
      $data['parameter'] = $show;
      $this->load->view('admin/main', $data);
  }

  public function groupingDate(){

  }

  public function earnpoint() {
    $data['title'] = "Earn Point";
    $data['content'] = "earnpoint";
    $this->load->view('admin/main', $data);
  }


  public function chargepayment() {
    $url = base_api_payment().'paymenttype?action=get_payment_type';
    $parser = $this->my_lib->native_curl($url);
    $data['data_con'] = array();
    $count = count($parser);
    for($i=0; $i<=($count-1); $i++) {
      $format_charge = $parser[$i]->isPct ? $parser[$i]->charge."%" : "Rp ".$parser[$i]->charge;
      array_push($data['data_con'], array(
        "id" => $parser[$i]->id,
        "name" => $parser[$i]->name,
        "payment_type" => $parser[$i]->payment_type,
        "charge" => $parser[$i]->charge,
        "description" => $parser[$i]->description,
        "icon" => $parser[$i]->icon,
        "guide_file" => $parser[$i]->guide_file,
        "isPct" => $parser[$i]->isPct,
        "format_charge" => $format_charge
      ));
    }

    // var_dump($data['data_con']);die();

    $data['title'] = "Charge Payment";
    $data['content'] = "chargepayment";
    $this->load->view('admin/main', $data);
  }

  public function insert_chargepayment(){
    if($this->input->post('empty_icon')!=null){
      $icon = base_img().'default_billing.png';
    }else{
      $config1['upload_path']          = 'assets/img/chargepayment/icon';
      $config1['allowed_types']        = 'gif|jpg|png|jpeg';
      $config1['max_size']             = 2000;
      // $config1['max_width']            = 350;
      // $config1['max_height']           = 40;
      // $config1['min_width']            = 200;
      // $config1['min_height']           = 30;
      $config1['file_name']            = 'icon-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($config1['upload_path'])) {
        mkdir($config1['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config1['upload_path'], 0777))) {
        chmod($config1['upload_path'], 0777);
      }
      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_file = $this->upload->do_upload('icon');

      if (!$upload_file){
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('breakmessage', 'Attach Icon - '.$error['error']);
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
      }else if($upload_file){
          $upicon = $this->upload->data();
          $icon = base_img().'chargepayment/icon/'.$upicon['file_name'];
      }
    }

    if($this->input->post('empty_guide_file')!=null){
      $guidefile = null;
    }else{
      $config['upload_path']          = 'assets/img/chargepayment/guidefile';
      $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx';
      $config['max_size']             = 2000;
      $config['min_width']            = 165;
      $config['min_height']           = 114;
      $config['file_name']            = 'guide_file-'.trim(str_replace(" ","",date('dmYHisu')));
      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('guide_file');
      if (!$upload_img){
        $error = array('error' => $this->upload->display_errors());
        $this->session->set_flashdata('breakmessage', 'Attach Guide File - '.$error['error']);
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      }else if($upload_img){
        $photo = $this->upload->data();
        $guidefile = base_img().'chargepayment/guidefile/'.$photo['file_name'];

      }
    }

    if($this->input->post('isPct', TRUE)=="true" && $this->input->post('charge', TRUE) > 100){
      $this->session->set_flashdata('breakmessage', 'Percent max value should less than 100');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
    $isPct = $this->input->post('isPct', TRUE) == "true" ? true : false;
    $data = array(
      'action' => 'create_payment_type',
      'name' =>  $this->input->post('payment_type_name', TRUE),
      'payment_type' =>  $this->input->post('payment_type_code', TRUE),
      'charge' => $this->input->post('charge', TRUE),
      'description' => $this->input->post('description', TRUE),
      'icon' => $icon,
      'guide_file' => $guidefile,
      'isPct' => $isPct,
    );

    $url = base_api_payment().'paymenttype';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function update_chargepayment(){
    if($this->input->post('empty_icon')==null) {
      //upload icon
      $config['upload_path']          = 'assets/img/chargepayment/icon';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';
      $config['max_size']             = 2000;
      // $config['max_width']            = 800;
      // $config['max_height']           = 800;
      // $config['min_width']            = 165;
      // $config['min_height']           = 114;
      $config['file_name']            = 'icon-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config['upload_path'], 0777))) {
        chmod($config['upload_path'], 0777);
      }
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $upload_img = $this->upload->do_upload('icon');
      if (!$upload_img) {
        $icon = $this->input->post('icon_old', TRUE);
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('icon');
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);

        $photo = $this->upload->data();

        $cek = $photo['upload_path'].$photo['file_name'];
        if(!(chmod($cek, 0777))) {
          chmod($cek, 0777);
        }
        $icon = base_img().'chargepayment/icon/'.$photo['file_name'];
     }
    }else {
      if(!strpos($this->input->post('icon_old'), 'default_billing')){
        $icon = base_img().'default_billing.png';
      }else{
        //delete old image if have new image
        $icon = $this->input->post('icon_old');
        $image =  str_replace('/','\\',$icon);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $icon = base_img().'default_billing.png';
      }
    }

    if($this->input->post('empty_guide_file')==null) {
      //upload icon
      $config1['upload_path']          = 'assets/img/chargepayment/guidefile';
      $config1['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx';
      $config1['max_size']             = 2000;
      // $config['max_width']            = 800;
      // $config['max_height']           = 800;
      // $config['min_width']            = 165;
      // $config['min_height']           = 114;
      $config1['file_name']            = 'guidefile-'.trim(str_replace(" ","",date('dmYHisu')));

      if(!is_dir($config1['upload_path'])) {
        mkdir($config1['upload_path'], 0777, TRUE);
      }
      if(!(chmod($config1['upload_path'], 0777))) {
        chmod($config1['upload_path'], 0777);
      }
      $this->load->library('upload', $config1);
      $this->upload->initialize($config1);
      $upload_img = $this->upload->do_upload('guide_file');
      if (!$upload_img) {
        $guidefile = $this->input->post('guide_file_old', TRUE);
      }else{
        //delete old image if have new image
        $avatar = $this->input->post('guide_file_old');
        $image =  str_replace('/','\\',$avatar);
        $ava =  str_replace(array('http:','https:'),'',$image);
        unlink($ava);
        $photo = $this->upload->data();

        $cek = $photo['upload_path'].$photo['file_name'];
        if(!(chmod($cek, 0777))) {
          chmod($cek, 0777);
        }
        $guidefile = base_img().'chargepayment/guidefile/'.$photo['file_name'];
     }
    }else {
      //delete old image if have new image
      $guidefile = $this->input->post('guidefile');
      $image =  str_replace('/','\\',$guidefile);
      $ava =  str_replace(array('http:','https:'),'',$image);
      unlink($ava);

      $guidefile = null;
    }

    if($this->input->post('isPct', TRUE)=="true" && $this->input->post('charge', TRUE) > 100){
      $this->session->set_flashdata('breakmessage', 'Percent max value should less than 100');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }


    $isPct = $this->input->post('isPct', TRUE) == "true" ? true : false;
    $data = array(
      'action' => 'update_payment_type',
      'id' => $this->input->post('idchargepayment', TRUE),
      'name' =>  $this->input->post('payment_type_name', TRUE),
      'payment_type' =>  $this->input->post('payment_type_code', TRUE),
      'charge' => $this->input->post('charge', TRUE),
      'description' => $this->input->post('description', TRUE),
      'icon' => $icon,
      'guide_file' => $guidefile,
      'isPct' => $isPct,
    );
    $url = base_api_payment().'paymenttype';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Updated');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Updated.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_chargepayment(){
    $data = array(
      'action' => 'delete_payment_type',
      'id' => $this->input->post('idchargepayment', TRUE));

      $url = base_api_payment().'paymenttype';
    $parser = $this->my_lib->native_curl($url,$data);
    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function feedback()
  {
    if($this->input->post('btn_export') == 'Export to Excel') {
      $show = array(
        'startDate' => $this->input->post('startdate', TRUE),
        'endDate' => $this->input->post('enddate', TRUE),
        'rate' => $this->input->post('rateexport', TRUE)
      );
      $rate = $this->input->post('rateexport', TRUE);
      $startdate = NULL;
      $enddate = NULL;
      if($this->input->post('startdate') || $this->input->post('enddate') != NULL){
        $startdate = date('d/m/Y', strtotime($this->input->post('startdate')));
        $enddate = date('d/m/Y', strtotime($this->input->post('enddate')));
      }
      $url = base_api()."Rate/list?startDate=".$startdate."&endDate=".$enddate."&rate=".$rate."&keyword=null";
      $parser = $this->my_lib->native_curl($url); //call function    
      $data['data_con'] = array();      
      try{
        if(is_array($parser)) {
        $count = count($parser);
        for($i=0; $i<=($count-1); $i++) {
          array_push($data['data_con'], array(
            "id" => $parser[$i]->id,
            "rate" => $parser[$i]->rate,
            "createdOn" => $parser[$i]->createdon,
            "fullname" => $parser[$i]->fullname,
            "email" => $parser[$i]->email,
            "feedback" => $parser[$i]->feedback));
          }    
        }
      }catch(Exception $e){
        echo $e;
      }
      $data['parameter'] = $show;
      $this->load->view('admin/content/excel_feedback',$data);
    }
    else {
      $show = array(
        'startDate' => $this->input->post('startdate', TRUE),
        'endDate' => $this->input->post('enddate', TRUE),
        'rate' => $this->input->post('rate', TRUE)
      );
      $rate = $this->input->post('rate', TRUE);
      $startdate = NULL;
      $enddate = NULL;
      if($this->input->post('startdate') || $this->input->post('enddate') != NULL){
        $startdate = date('d/m/Y', strtotime($this->input->post('startdate')));
        $enddate = date('d/m/Y', strtotime($this->input->post('enddate')));
      }
      $url = base_api()."Rate/list?startDate=".$startdate."&endDate=".$enddate."&rate=".$rate."&keyword=null";
      $parser = $this->my_lib->native_curl($url); //call function    
      $data['data_con'] = array();      
      try{
        if(is_array($parser)) {
        $count = count($parser);
        for($i=0; $i<=($count-1); $i++) {
          array_push($data['data_con'], array(
            "id" => $parser[$i]->id,
            "rate" => $parser[$i]->rate,
            "createdOn" => $parser[$i]->createdon,
            "fullname" => $parser[$i]->fullname,
            "email" => $parser[$i]->email,
            "feedback" => $parser[$i]->feedback));
          }    
        }
      }catch(Exception $e){
        echo $e;
      }    
      $data['parameter'] = $show;
      $data['title'] = "User Feedback";
      $data['content'] = "feedback";
      $this->load->view('admin/main', $data);
    }
  }

  public function feedbackdetail()
  {
    $idrate = $this->input->get('id', TRUE);
    $url = base_api()."Rate/detail/".$idrate;    
    $list = base_api()."Rate/list?startDate=".$startdate."&endDate=".$enddate."&rate=".$rate."&keyword=null";
    $data['data_detail'] = $this->my_lib->native_curl($url); //call function
    $listrate = $this->my_lib->native_curl($list); //call function
    $array_list = array();

    $count = count($listrate);
    for($i=0; $i<=($count-1); $i++) {
      array_push($array_list, $listrate[$i]->id);      
    }              
    $array = array('87', '12');
    $index = array_search($idrate, $array_list);    
    
    if($index !== false && $index == ($count - 1)){                    
        $prev = $array_list[$index-1];
        $next = $array_list[0];      
    }else if($index !== false && $index == 0){              
        $next = $array_list[$index+1];
      $prev = $array_list[$count - 1];      
    }else{             
        $next = $array_list[$index+1];
      $prev = $array_list[$index-1];                     
    }
    $data['next'] = $next;
    $data['prev'] = $prev;
    $data['title'] = $data['data_detail']->id!=null?$data['data_detail']->id:"User Feedback Detail";
    $data['content'] = "feedbackdetail";
    $this->load->view('admin/main', $data);
  }

  public function news_category()
  {
    $url = base_api().'News/?action=listnewscategory';
    $parser = $this->my_lib->native_curl($url);
    $data['data_con'] = array();

    foreach($parser as $value){
      array_push($data['data_con'], array(
        "idnewscategory" => $value->idnewscategory,
        "newscategory" => $value->newscategory,
        "createdon" => $value->createdon,
        "modifiedon" => $value->modifiedon
      ));
    }

    $data['title'] = "News Category";
    $data['content'] = "news_category";
    $this->load->view('admin/main', $data);
  }

  public function insert_news_category(){
    
    $data = array(
      "action" => 'insert_newscategory',
      "newscategory" => $this->input->post('news_category', TRUE)
    );

    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function edit_news_category(){
    
    $data = array(
      "action" => 'update_newscategory',
      "idnewscategory" => $this->input->post('edit_idnewscategory', TRUE),
      "newscategory" => $this->input->post('edit_newscategory', TRUE)
    );

    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', "Can't be Insert.");
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

  public function delete_news_category()
  {
    $data = array(
      'action' => 'delete_newscategory',
      'idnewscategory' => $this->input->post('del_idnewscategory', TRUE)
    );

    $url = base_api().'News/';
    $parser = $this->my_lib->native_curl($url,$data);

    if ($parser[0]->message == "success") {
      $this->session->set_flashdata('message', 'Sucessfully Deleted'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    } else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be deleted.'.$succ);
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    }
  }

}