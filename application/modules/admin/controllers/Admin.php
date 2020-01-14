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
      
      if(($this->input->post('email', TRUE) == "admin" || $this->input->post('email', TRUE) == "admin@mail.com" ) && 
      ($this->input->post('password', TRUE) == "admin")){
        $role = 'administrator';
      }else{        
        $role = $result['role']['role_id'] =="1" ? 'User' : 'User';      
      }
      $user=array();
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

  public function insert()
  {
    $subcat = $this->input->get('id', TRUE);
    $data['title'] = $this->my_lib->linkspace($this->input->get('name', TRUE));
    $url              = base_api()."Category/?action=listallchild&idcategory=".$subcat;

    $data['subcat'] = $this->my_lib->native_curl($url);
    $data['content'] = "tenantinsert";
    $this->load->view('admin/main', $data);
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
          "name" => $result[$i]['name'],
          "image" => $result[$i]['image']));
      }
    }

    $data['title'] = "Category";
    $data['content'] = "category";
    $this->load->view('admin/main', $data);
  }

  public function insert_category(){    
    $data = array(
      'name' => $this->input->post('name', TRUE),
      'image' => $this->input->post('picture', TRUE)
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
      'name' => $this->input->post('name', TRUE),
      'category_id' => $this->input->post('category_id', TRUE),
      'image' => $this->input->post('picture', TRUE)
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
      'category_id' => $this->input->post('category_id', TRUE)
    );
    $url = base_api().'category';
    $res = $this->exec_curl($url,$data, "DELETE");
    $result = $res['result'];
    if($res){
      $this->session->set_flashdata('message', 'Sucessfully Deleted');
      redirect(base_url('admin/category'));
    }else {
      $this->session->set_flashdata('breakmessage', 'Sucessfully Deleted');
      redirect(base_url('admin/category'));
    }
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
    $image = "https://www.csircmc.res.in/sites/default/files/default_images/default_man_photo.jpg";
    $data = array(
      'username' => $this->input->post('username', TRUE),
      'email' => $this->input->post('email', TRUE),
      'phone_number' => $this->input->post('phone', TRUE),
      'password' => $this->input->post('password', TRUE),
      'gender' => $this->input->post('gender', TRUE),
      'address' => $this->input->post('address', TRUE),
      'role_id' => $this->input->post('privilege', TRUE),
      "image" => $this->input->post('gender', TRUE) == "F" ? "https://icon-library.net/images/no-profile-picture-icon-female/no-profile-picture-icon-female-3.jpg" : $image
    );    

    $url = base_api().'user';
    $res = $this->exec_curl($url,$data, "POST");
    $result = $res['result'];
    if(isset($result)){
      $this->session->set_flashdata('message', 'Sucessfully Inserted');
      redirect(base_url('admin/account'));
    }else {
      $this->session->set_flashdata('breakmessage', 'Can\'t be Insert.');
      redirect(base_url('admin/account'));
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
  
}