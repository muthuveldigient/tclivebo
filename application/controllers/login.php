<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Login extends CI_Controller{
        
	function __construct(){
		session_start();
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->library('session');
	}
    
	public function index($err = NULL){
		$this->load->helper("form");
        $this->load->library("form_validation"); 
		$data['err'] = $err;
		$sessionPartnerID = $this->session->userdata('adminuserid');
		$sessionPartnerName = $this->session->userdata('adminusername');
		
        if(empty($sessionPartnerName)){
        	$this->load->view('common/login',$data);
        }else{
			$adminUserId =array(68,69);
			if( $sessionPartnerID==18){
				redirect('admin/draw/drawresult?rid=75');
			}elseif( in_array( $sessionPartnerID,$adminUserId) ){
				redirect('reports/agent_turnover/report?rid=62');
			}else{
				redirect('reports/agent_turnover/report?rid=62'); 
			}
        }
	}
        
	public function loginprocess() {
	    $this->load->helper('url');
        $this->load->model("common/login_model");
        $captchaValue =$this->input->post('captcha');
        $captchaStatus=false;       
        if(isset($captchaValue) && $captchaValue!="" && $_SESSION["code"]==$captchaValue) {
            $captchaStatus=true;
        }
        if($captchaStatus==false) {
            $err='Invalid Login.Please try again.';
            $this->index($err); die;    
        }
       
        $result=$this->login_model->validate_login();
        if(!$result){
            $this->session->sess_destroy();
        	$err='Invalid Login.Please try again.';
            $this->index($err);
        }else{
			//$roleAccess["FK_ADMIN_USER_ID"] = $this->session->userdata('adminuserid');
			//$roleAccess["FK_ROLE_ID"]       = 1;
			/* $dashboardAccess                = "";
			$chkRoles["dashboard"] = $this->login_model->chkDashboardAccess($roleAccess);
			if(!empty($chkRoles["dashboard"]))
			$dashboardAccess = 1;
				
			$this->session->set_userdata('dashboardAccess',$dashboardAccess); */
			$adminUserId =array(68,69);
			$sessionPartnerID = $this->session->userdata('adminuserid');
			
			if( $sessionPartnerID ==18){
				redirect('admin/draw/drawresult');
			}elseif( in_array( $sessionPartnerID,$adminUserId) ){
				redirect('reports/agent_turnover/report?rid=62');
			}else{
				redirect('reports/agent_turnover/report?rid=62');  
			}
        }
    }
        
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */