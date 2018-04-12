<?php
//error_reporting(E_ALL);

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Draw extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
        $CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->authendication();
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','session','pagination','encrypt'));
		$partnerTypeId=$this->session->userdata['partnertypeid'];
		
		if($partnerTypeId != 0){
			redirect('login');
		}
				
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
	
		$searchdata['rdoSearch']='';
		$this->load->model('common/common_model');
		$this->load->model('admin/draw_model');
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);
		$this->load->view("common/header",$amount);
    }
	
	function authendication() {
		$adminusername = $this->session->userdata('adminusername');
		if($this->uri->uri_string() !== 'login' && !$adminusername) {
			$this->session->set_flashdata('message', 'Please login to access the page.');
        	redirect('login');
    	}
	}
    
    public function index()	{
		
		$data["page_title"]    = "Draw List";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('drawSearchData');
		}

		if($this->input->get('start') == 1){
			$this->session->unset_userdata('drawSearchData');
		}

		if($this->input->post('keyword',TRUE)=="Search") {
			$data["DRAW_NAME"]  			= $this->input->post('draw_name');
			$data["DRAW_STATUS"]      		= $this->input->post('draw_status');
			$data["START_DATE_TIME"]          	= $this->input->post('START_DATE_TIME');
			$data["END_DATE_TIME"] 	= $this->input->post('END_DATE_TIME');
			$data["SEARCH_LIMIT"] 			= $this->input->post('SEARCH_LIMIT');
			
			$this->session->set_userdata(array('drawSearchData'=>$data));
			$noOfRecords  = $this->draw_model->getDrawcount($data);	
		} else if($this->session->userdata('drawSearchData')) {
			$noOfRecords  = $this->draw_model->getDrawcount($this->session->userdata('drawSearchData'));	
		} else {
			$data["START_DATE_TIME"]= date('Y-m-d').' 00:00:00';
			$data["END_DATE_TIME"]	= date('Y-m-d').' 23:59:59';
			$this->session->set_userdata(array('drawSearchData'=>$data));
			$noOfRecords  = $this->draw_model->getDrawcount($data);	
		}
		
		/* Set the config parameters */
		$config['base_url']   = base_url()."admin/draw/index";
		$config['total_rows'] = (!empty($noOfRecords->cnt)?$noOfRecords->cnt:'');
		$config['per_page']   = $this->config->item('limit');
		$config['cur_page']   = $this->uri->segment(4);
		$config['suffix']     = '?rid=51';
		$config['order_by']	  = "DRAW_ID";
		$config['sort_order'] = "asc";

		if($this->input->post('keyword',TRUE)=="Search") {
			$data["results"] = $this->draw_model->getDrawInfo($config,$data);
		} else if($this->session->userdata('drawSearchData')) {
			$data["results"] = $this->draw_model->getDrawInfo($config,$this->session->userdata('drawSearchData'));
		} else {
			$data["result"] = $this->draw_model->getDrawInfo($config,$data);
		}
//echo '<pre>';print_r($data);exit;

		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();
		$data['rid'] =51;
		//if needed
		//$draw = $this->draw_model->getDrawInfo();
		//echo '<pre>';print_r($draw);exit;
		$this->load->view("admin/draw_list",$data);
	}
	
	public function creation()	{
		$miniGameList =  $this->draw_model->minigamesList();
		$gameList = array();
		if(!empty($miniGameList)){
			$gameList['']='Select';
			foreach($miniGameList as $list){
				$gameList[$list->MINIGAMES_ID] = $list->DESCRIPTION;
			}
			$data['miniGameList']=	$gameList;
		}
		$this->load->view("admin/drawcreation",$data);
	}
	
	public function createdraw(){
		
		if(!empty($_POST["DRAW_GAME_ID"])&& isset($_POST["frmSubmit"])){
			$arrDraw["DRAW_GAME_ID"]    = $_POST["DRAW_GAME_ID"];
			$arrDraw["DRAW_DESCRIPTION"]= $_POST["DRAW_NAME"];
			$arrDraw["DRAW_PRICE"]      = $_POST["DRAW_PRICE"];	
			$arrDraw["DRAW_COUNTDOWN_TIME"] = 60; //60seconds
			$arrDraw["DRAW_START_DATE"] = $_POST["START_DATE_TIME"];
			$arrDraw["DRAW_END_DATE"]   = $_POST["END_DATE_TIME"];
			$arrDraw["DRAW_INTERVAL"]   = $_POST["DRAW_INTERVAL"];
			$arrDraw["DRAW_STATUS"]     = $_POST["DRAW_STATUS"];
			//$arrDraw["DRAW_TOTNUM"]     = $_POST["TOTAL_NUMBER_OF_DRAWS"];	
			
			if(!empty($arrDraw)) {
				if(!empty($arrDraw["DRAW_START_DATE"])) {
					$drawSDate   = strtotime($arrDraw["DRAW_START_DATE"]);
					$cTime       = date('d-m-Y H:i:s',strtotime('+1 minutes',strtotime(date('d-m-Y H:i:s'))));
					$currentTime = strtotime($cTime);
					
					if($drawSDate < $currentTime) {
						redirect("admin/draw/creation?err=2&chk=1");die;					
					}
				}
				if(!empty($arrDraw["DRAW_END_DATE"])) {
					$drawEDate   = strtotime($arrDraw["DRAW_END_DATE"]);
					$cTime       = date('d-m-Y H:i:s',strtotime('+1 minutes',strtotime(date('d-m-Y H:i:s'))));
					$currentTime = strtotime($cTime);
					if($drawEDate < $currentTime) {
						redirect("admin/draw/creation?err=3&chk=1");die;
					}
				}					
				if($arrDraw["DRAW_GAME_ID"]==115){ 
					/* lucky7 game type lists*/
					$arrDraw["GAME_TYPE_ID"] ='1,2,3,4,5,6,7,8,9,10';
					$arrDraw["GAME_TYPE_DRAW_PRICE"] =0;
				}				
		/*		if(empty($arrDraw["DRAW_TOTNUM"])) {
					header("Location: admin-home.php?p=cdraw&err=5&chk=1"); die; //invalid input is given - the total number of draws is in-correct
				}*/
				//DRAW EXISTENSE VALIDATION NEED TO CHECK
				 $spData = "CALL sp_lotto_draw_recurrence('".$arrDraw["DRAW_GAME_ID"]."','".$arrDraw["DRAW_DESCRIPTION"]."','".$arrDraw["DRAW_PRICE"]."','".$arrDraw["DRAW_COUNTDOWN_TIME"]."','".date('Y-m-d H:i:s',strtotime($arrDraw["DRAW_START_DATE"]))."','".date('Y-m-d H:i:s',strtotime($arrDraw["DRAW_END_DATE"]))."',".$arrDraw["DRAW_INTERVAL"].",".$arrDraw["DRAW_STATUS"].",'".$arrDraw["GAME_TYPE_ID"]."','".$arrDraw["GAME_TYPE_DRAW_PRICE"]."',@V_OUT1)";
				//$result = mysqli_query($connection, $spData);
				$this->db2->query($spData);
				$select = $this->db2->query('SELECT @V_OUT1');
				$result = $select->row_array();
				$resOut = $result['@V_OUT1'];

				//$result=$conn1->exec($spData);		
				if($resOut==1) {
					redirect("admin/draw/creation?err=1&chk=1");die;//success
				} else if($resOut==2){
					redirect("admin/draw/creation?err=6&chk=1");die;//duplicate record exists
				} else {
					redirect("admin/draw/creation?err=4&chk=1");die;//failed
				}
			}
		}else{
			redirect("admin/draw/creation?err=4&chk=1");die;//failed
		}
	}
	
	
	public function drawstatus(){
		
		if($_REQUEST["drawID"] || $_REQUEST["drawStatus"]) {
			$newDrawStatus="";
			if($_REQUEST["drawStatus"]==1)
				$newDrawStatus=0;
			else
				$newDrawStatus=1;
					
			$drawStatus["DRAW_ID"]     = $_REQUEST["drawID"];
			$drawStatus1["IS_ACTIVE"]   = $newDrawStatus;		
			$updateDrawStatus = $this->draw_model->updateDrawStatus($drawStatus1, $_REQUEST["drawID"]);
			if($drawStatus1["IS_ACTIVE"]==1)
				$statusString = "<a href='javascript:updateDrawStatus(".$drawStatus["DRAW_ID"].",".$drawStatus1["IS_ACTIVE"].")' title='Deactive' class='viewuserActive'>Active</a>";
			else
				$statusString = "<a href='javascript:updateDrawStatus(".$drawStatus["DRAW_ID"].",".$drawStatus1["IS_ACTIVE"].");' title='Active' class='viewuserDeactive'>Deactive</a>";			
						
			echo $statusString;die;
		}
	}
	
	public function categorymanagement(){
		
		if(isset($_POST['Submit'])) {
			if(!empty($_POST["category"])) {
				$delExistingCatGames=$this->draw_model->deleteCategory($_POST["category"]);
				if(!empty($_POST["center_ids"])) {
					$gameIDs=explode(",",$_POST["center_ids"]);
					foreach($gameIDs as $gIndex=>$gameID) {	
						$data['CATEGORY_ID']=$_POST["category"];
						$data['MINIGAME_ID']=$gameID;
						$data['CREATED_DATE']=date('Y-m-d H:i:s');
						$assignGame=$this->draw_model->InsertCategory($data);
						if(!empty($assignGame)){
							$err=1;
						}else{
							$err=2;
						}
					}
				}
			}
			$err =1;
		}

		$data['category'] =  $this->draw_model->getCategory();
		$data['getCategoryGames'] =  $this->draw_model->getCategoryManagementInfo();
		$data['err']=$err;
		$this->load->view("admin/category",$data);
	}
	
	public function categorygames(){
		
		$catID=$_REQUEST["catid"];
		$selectbox1=""; $selectbox2="";
		if(isset($catID)) {
			$getCAssignedGames=$this->draw_model->getCategoryGames($catID);
			if(!empty($getCAssignedGames)) {
				$existingGames="";
				foreach($getCAssignedGames as $rsCAssignedGames) {
					$selectbox2.='<option value="'.$rsCAssignedGames->MINIGAMES_ID.'">'.$rsCAssignedGames->DESCRIPTION.'</option>';
					if(!empty($existingGames))
						$existingGames=$existingGames.",".$rsCAssignedGames->MINIGAMES_ID;
					else
						$existingGames=$rsCAssignedGames->MINIGAMES_ID;
				}		
			}

			$getCUAssignedGames=$this->draw_model->getCategoryUnknownGames($catID);
			if(!empty($getCUAssignedGames)) {
				foreach( $getCUAssignedGames as $rsCUAssignedGames ) {
					$selectbox1.='<option value="'.$rsCUAssignedGames->MINIGAMES_ID.'">'.$rsCUAssignedGames->DESCRIPTION.'</option>';
				}		
			}
		}
		echo $selectbox1."###".$selectbox2."###".$existingGames;die;
	}
        
	public function gamelist(){
		 if( isset( $_POST['submit'] ) ){
				extract($_POST);	
				
			$game1=addslashes($game1);				
			$game2=addslashes($game2);
			$game3=addslashes($game3);				
			$game4=addslashes($game4);
			$game5=addslashes($game5);				
			$game6=addslashes($game6);
			$game7=addslashes($game7);
			$game8=addslashes($game8);				
			$game9=addslashes($game9);
			$game10=addslashes($game10);

			$description1=addslashes($description1);				
			$description2=addslashes($description2);
			$description3=addslashes($description3);				
			$description4=addslashes($description4);
			$description5=addslashes($description5);				
			$description6=addslashes($description6);
			$description7=addslashes($description7);
			$description8=addslashes($description8);				
			$description9=addslashes($description9);
			$description10=addslashes($description10);	
			
			$data = array(
							array(
								  'GAMES_ID' => 1 ,
								  'GAMES_NAME' => $game1 ,
								  'DESCRIPTION' => $description1
							),
							array(
								  'GAMES_ID' => 2 ,
								  'GAMES_NAME' => $game2 ,
								  'DESCRIPTION' => $description2
							),
							array(
								  'GAMES_ID' => 3 ,
								  'GAMES_NAME' => $game3 ,
								  'DESCRIPTION' => $description3
							),
							array(
								  'GAMES_ID' => 4 ,
								  'GAMES_NAME' => $game4 ,
								  'DESCRIPTION' => $description4
							),
							array(
								  'GAMES_ID' => 5 ,
								  'GAMES_NAME' => $game5 ,
								  'DESCRIPTION' => $description5
							),
							array(
								  'GAMES_ID' => 6 ,
								  'GAMES_NAME' => $game6 ,
								  'DESCRIPTION' => $description6
							),
							array(
								  'GAMES_ID' => 7 ,
								  'GAMES_NAME' => $game7 ,
								  'DESCRIPTION' => $description7
							),
							array(
								  'GAMES_ID' => 8 ,
								  'GAMES_NAME' => $game8 ,
								  'DESCRIPTION' => $description8
							),
							array(
								  'GAMES_ID' => 9 ,
								  'GAMES_NAME' => $game9 ,
								  'DESCRIPTION' => $description9
							),
							array(
								  'GAMES_ID' => 10 ,
								  'GAMES_NAME' => $game10 ,
								  'DESCRIPTION' => $description10
							)
				);
			
			$result=$this->draw_model->insertLuckyGames($data);
			
			/* $query = "INSERT INTO lucky7_games (GAMES_ID,GAMES_NAME, DESCRIPTION) VALUES (1,'$game1','$description1'),(2,'$game2','$description2'),(3,'$game3','$description3'),(4,'$game4','$description4'),(5,'$game5','$description5'),(6,'$game6','$description6'),(7,'$game7','$description7'),(8,'$game8','$description8'),(9,'$game9','$description9'),(10,'$game10','$description10')
			ON DUPLICATE KEY UPDATE GAMES_NAME=VALUES(GAMES_NAME),DESCRIPTION=VALUES(DESCRIPTION)"; 
			$result = mysql_query($query) or die (mysql_error());	*/					   		
			$data['msg'] =2;
			if(!empty($result))	{
				$data['msg'] =1;
			}		 
		}
		$result=$this->draw_model->getWinBigBossGameDetails();
		foreach($result as $row){	
			$data['gameList'][$row->GAMES_ID]['GAMES_NAME'] = $row->GAMES_NAME;
			$data['gameList'][$row->GAMES_ID]['DESCRIPTION'] = $row->DESCRIPTION;
		}
		//echo '<prE>';print_r($data);exit;
		$this->load->view("admin/updategame",$data);
	}
        
        
        
        
        
        
}?>
    