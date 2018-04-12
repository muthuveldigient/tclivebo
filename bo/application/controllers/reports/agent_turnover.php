<?php
/*
  Class Name	: Agent_turnover
  Package Name  : Report
  Purpose       : Controller all the Turnover releated details
  Auther 	    : Sivakumar
  Date of create: July 08 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_turnover extends CI_Controller{
    
        function __construct(){
            parent::__construct();
			$CI = &get_instance();
			
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
            $this->load->helper(array('url','form'));	
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');

			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			if($USR_ID == ''){
				redirect('login');
			}
			$this->load->model('common/common_model');
			$this->load->model('reports/agentreport_model');
			$partner_id = $this->session->userdata['partnerid'];
			$this->load->view("common/header");

        }
	
	
	public function report() {
	 	
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid']  = $this->input->get_post('rid',TRUE);

		if( $this->input->post('keyword',TRUE) == "Search" ) {
			$post = $this->input->post();
			
			$data['START_DATE_TIME'] = !empty( $post['START_DATE_TIME'] ) ? $post['START_DATE_TIME'] : date('Y-m-d 00:00:00');
            $data['END_DATE_TIME'] 	 = !empty( $post['END_DATE_TIME'] ) ? $post['END_DATE_TIME'] : date('Y-m-d 23:59:59');
		}

		$data["results"] = $this->agentreport_model->getTurnoverReport($data);

 		$this->load->view('reports/agent_turnover', $data);
	}
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */