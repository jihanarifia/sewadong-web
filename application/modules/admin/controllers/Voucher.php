<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends MX_Controller{
    public function __construct()
    {
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
        $idaccount = $this->session->userdata('sc_sess')[0]["idaccount"];
        $url = base_api()."Voucher/listall?idaccount=".$idaccount;
        $parser = (array)$this->my_lib->native_curl($url);

        $data["vouchers"] = array();
        if($parser["status"] == true){
            $data["vouchers"] = $parser["data"];
        }

        $data['title'] = "Master Voucher";
        $data['content'] = "voucher";
        $this->load->view('admin/main', $data);
    }

    public function delete(){
        $data = array(
            "idaccount" => $this->session->userdata('sc_sess')[0]["idaccount"],
            "idvoucher" => $this->input->post("id",true)
        );

        $url = base_api().'Voucher/delete';
        $parser = $this->my_lib->native_curl($url,$data);

        if($parser->status == true){
            $this->session->set_flashdata('message', $parser->message);
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }else{
            $this->session->set_flashdata('breakmessage', $parser->message);
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
    }

    public function create(){
        $data['prev'] = "Master Voucher";
        $data['link'] = "voucher";
        $data['title_page'] = "Create Voucher";
        $data['title'] = "Create Voucher";
        $data['content'] = "voucher_insert";

        $url = base_api().'Voucher/type';
        $objType = $this->my_lib->native_curl($url);
        $data['objType'] = $objType;
        
        $this->load->view('admin/main', $data);
    }

    public function fn_create(){
        $dataavatar = array();
        $dataImg = array();
        $files = $_FILES;
        $cpt = count($_FILES['image']['name']);
        $config['upload_path']          = 'assets/img/voucher/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;
        $config['file_name']            = 'voucher-'.trim(str_replace(" ","",date('dmYHisu')));

        if(!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        if(!(chmod($config['upload_path'], 0777))) {
            chmod($config['upload_path'], 0777);
        }
        
        $this->load->library('upload', $config);
        for($i=0; $i<$cpt; $i++) {       
            $_FILES['image']['name']= $files['image']['name'][$i];
            $_FILES['image']['type']= $files['image']['type'][$i];
            $_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
            $_FILES['image']['error']= $files['image']['error'][$i];
            $_FILES['image']['size']= $files['image']['size'][$i];    

            $this->upload->initialize($config);
            $upload_img = $this->upload->do_upload("image");

            if (!$upload_img){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('breakmessage', $error['error']);
                $this->load->library('user_agent');
                redirect($this->agent->referrer());
            } else {
                $dataImg[] = $this->upload->data();
                $avatar = base_img().'voucher/'.$dataImg[$i]['file_name'];
                array_push($dataavatar, $avatar);
            }
        }

        $expireddate = $this->input->post('expireddate', TRUE);
        $expiredtime = date("H:i:s",strtotime($this->input->post('expiredtime', TRUE)));
        $joinexpired = $expireddate ." ".$expiredtime;

        $data = array(
            "action" => "insert_voucher",
            "idtenant"=> $this->input->post('idtenant', TRUE),
            "title" => $this->input->post('title', TRUE),
            "title_id" => $this->input->post('title_id', TRUE),
            "description" => $this->input->post('description', TRUE),
            "description_id" => $this->input->post('description_id', TRUE),
            "point" => $this->input->post('point', TRUE),
            "stock" => $this->input->post('stock', TRUE),
            "useof" => $this->input->post('useof', TRUE),
            "useof_id" => $this->input->post('useof_id', TRUE),
            "terms" => $this->input->post('terms', TRUE),
            "terms_id" => $this->input->post('terms_id', TRUE),
            "expired" => $joinexpired,
            "image" => join(",",$dataavatar),
            "type" => $this->input->post('type', TRUE),
            "ovopoint" => $this->input->post('ovopoint', TRUE)
        );

        $url = base_api().'Voucher';
        $parser = $this->my_lib->native_curl($url,$data);

        if ($parser[0]->message  == "success") {
          $this->session->set_flashdata('message', 'Voucher sucessfully created');
          $this->session->set_flashdata('activationcode', 'Activation Code : '.$parser[0]->activationcode);
          redirect(base_url().'admin/voucher/edit?id='.$parser[0]->id.'&ref=1');
        } else {
          $this->session->set_flashdata('breakmessage', 'Can\'t create voucher. Please check your data input');
          redirect(base_url('admin/voucher'));
        }
    }

    public function edit(){
        $idaccount = $this->session->userdata('sc_sess')[0]['idaccount'];
        $id = $this->input->get('id', TRUE);
        $ref = $this->input->get('ref', TRUE);
        $url = base_api().'Voucher/detailweb?idaccount='.$idaccount.'&idvoucher='.$id;
        $parser = $this->my_lib->native_curl($url); //call function
        
        if($parser->expired_date != NULL){
            $expired_date = explode(" ",$parser->expired_date);
            $expireddate = date("Y-m-d",strtotime($expired_date[0]));
            $expiredtime = date("H:i",strtotime($expired_date[1]));
        }

        if($parser->created_date != NULL){
            $created_date = explode(" ",$parser->created_date);
            $createddate = date("Y-m-d",strtotime($created_date[0]));
            $createdtime = date("H:i",strtotime($created_date[1]));
        }
        
        $url = base_api().'Voucher/type';
        $objType = $this->my_lib->native_curl($url);
        $data['objType'] = $objType;

        $data['id'] = $parser->id;
        $data['title'] = $parser->title;
        $data['title_id'] = $parser->title_id;
        $data['description'] = $parser->description;
        $data['description_id'] = $parser->description_id;
        $data['idtenant'] = $parser->tenant->id;
        $data['tenantsname'] = $parser->tenant->name;
        $data['point'] = $parser->point;
        $data['available'] = $parser->available;
        $data['reedem_voucher'] = $parser->reedem_voucher;
        $data['howtouse'] = $parser->howtouse;
        $data['howtouse_id'] = $parser->howtouse_id;
        $data['terms'] = $parser->terms;
        $data['terms_id'] = $parser->terms_id;
        $data['expireddate'] = $expireddate;
        $data['expiredtime'] = $expiredtime;
        $data['createddate'] = $createddate;
        $data['createdtime'] = $createdtime;
        $data['worth'] = $parser->worth;
        $data['activation_code'] = $parser->activationcode;
        $data['image'] = $parser->image;
        $data['ref'] = $ref;
        $data['type'] = $parser->type;
        $data['type_id'] = $parser->type_id;
        $data['ovopoint'] = $parser->ovopoint;

        $data['prev'] = "Master Voucher";
        $data['link'] = "voucher";
        $data['title_page'] = "Edit Voucher";
        $data['content'] = "voucher_update";
        
        $this->load->view('admin/main', $data);
    }

    public function fn_edit(){
        $dataavatar = array();
        $dataImg = array();
        $files = $_FILES;
        $cpt = count($_FILES['image']['name']);
        $config['upload_path']          = 'assets/img/voucher/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2000;
        $config['max_width']            = 800;
        $config['max_height']           = 800;
        $config['file_name']            = 'voucher-'.trim(str_replace(" ","",date('dmYHisu')));

        if(!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        if(!(chmod($config['upload_path'], 0777))) {
            chmod($config['upload_path'], 0777);
        }

        $tempimage = $this->input->post('tempimage', TRUE);

        $this->load->library('upload', $config);
        for($i=0; $i<$cpt; $i++) {  
            $_FILES['image']['name'] = $files['image']['name'][$i];
            $_FILES['image']['type'] = $files['image']['type'][$i];
            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];
            $_FILES['image']['error'] = $files['image']['error'][$i];
            $_FILES['image']['size'] = $files['image']['size'][$i];    
            
            $this->upload->initialize($config);
            $upload_img = $this->upload->do_upload("image");

            if (!$upload_img){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('breakmessage', $error['error']);
                $this->load->library('user_agent');
                redirect($this->agent->referrer());
                $result = $tempimage;
            }else{
                $dataImg[] = $this->upload->data();
                $avatar = base_img().'voucher/'.$dataImg[$i]['file_name'];
                array_push($dataavatar, $avatar);
            }
        }

        if(count($dataavatar) > 0){
            $result = join(",",$dataavatar);
        }

        $expireddate = $this->input->post('expireddate', TRUE);
        $expiredtime = date("H:i:s",strtotime($this->input->post('expiredtime', TRUE)));
        $joinexpired = $expireddate ." ".$expiredtime;
        
        $data = array(
            "action" => "update_voucher",
            "idvoucher"=> $this->input->post('id', TRUE),
            "idtenant"=> $this->input->post('idtenant', TRUE),
            "title" => $this->input->post('title', TRUE),
            "title_id" => $this->input->post('title_id', TRUE),
            "description" => $this->input->post('description', TRUE),
            "description_id" => $this->input->post('description_id', TRUE),
            "point" => $this->input->post('point', TRUE),
            "stock" => $this->input->post('stock', TRUE),
            "useof" => $this->input->post('useof', TRUE),
            "useof_id" => $this->input->post('useof_id', TRUE),
            "terms" => $this->input->post('terms', TRUE),
            "terms_id" => $this->input->post('terms_id', TRUE),
            "expired" => $joinexpired,
            "image" => $result,
            "type" => $this->input->post('type', TRUE),
            "ovopoint" => $this->input->post('ovopoint', TRUE)
        );
        
        $url = base_api().'Voucher';
        $parser = $this->my_lib->native_curl($url,$data);
        
        if ($parser[0]->message  == "success") {
          $this->session->set_flashdata('message', 'Sucessfully Updated');
        } else {
          $this->session->set_flashdata('breakmessage', 'Can\'t be Update.');
        }
        redirect(base_url('admin/voucher'));
    }
}