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

	public function exportToExcel() {
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		ini_set('memory_limit', '-1');
		// ini_set('memory_limit', '3500M');

		// echo __LINE__; exit;
        //load our new PHPExcel library
        $this->load->library('phpexcel/PHPExcel');

        //activate worksheet number 1
        $this->phpexcel->setActiveSheetIndex(0);

        //name the worksheet
        $this->phpexcel->getActiveSheet()->setTitle('Cards list');
 
        $result = $this->agentreport_model->andarbahar_random_cards_export();
		// echo '<pre>'; print_r($result); exit;
        $resExport = array( '0' => array(
			'GAME_ID'			=> '',
            'PLAY_GROUP_ID' 	=> 'PLAY_GROUP_ID',
            'ANDARBAHAR_DATA' 	=> 'ANDARBAHAR_DATA',
            'STARTED' 			=> 'STARTED',
		));

		// if( !empty( $result ) ) {

		// 	foreach( $result as $index => $list ) {
		// 		$indexes = $index + 1; 		
		// 		$resExport[$indexes]['GAME_ID'] 	    = $list->GAME_ID;
		// 		$resExport[$indexes]['PLAY_GROUP_ID'] 	= $list->PLAY_GROUP_ID;
		// 		$resExport[$indexes]['ANDARBAHAR_DATA'] = $list->SLOT_NUMBER_DATA;
		// 		$resExport[$indexes]['STARTED'] 		= $list->STARTED;
		// 	}
		// }
 
        // read data to active sheet
        // $this->phpexcel->getActiveSheet()->fromArray($resExport);
        $this->phpexcel->getActiveSheet()->fromArray($result);
 
        $filename = 'excel_list_'.date('Y-m-d H:i:s').'.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' ( and adjust the filename extension, also the header mime type )
        //if you want to save it as.XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5'); 
 		ob_end_clean();

        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        exit;
	}
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */