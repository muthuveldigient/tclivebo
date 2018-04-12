<?php
//error_reporting(E_ALL);
class Draw_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	
	public function minigamesList($uGames='') {

/*	   print_r($uGames);
	   if($uGames != '')
		$uGames = explode(',',$uGames);
       else
	    $uGames = '';*/

		$this->load->database();
		$this->db2->select('MINIGAMES_NAME,DESCRIPTION,MINIGAMES_ID')->from('minigames');
		$this->db2->where('STATUS',1);
		//$this->db2->where_not_in('MINIGAMES_ID', 62); 
		if($uGames!='' && !empty($uGames))
			$this->db2->where_in('MINIGAMES_NAME', $uGames);

		$browseSQL = $this->db2->get();
		//echo $this->db2->last_query(); die;
		return $browseSQL->result();
	}
	
	public function getDrawInfo($config,$searchArray) {
		$limit  = $config["per_page"];
		$offset = $config["cur_page"];
		
		$this->db2->select("*")->from("lotto_draw");
		if(!empty($searchArray["DRAW_NAME"])){
			$this->db2->like("DRAW_DESCRIPTION",$searchArray["DRAW_NAME"]);
		}
		
		if(!empty($searchArray["DRAW_NUMBER"])){
			$this->db2->like("DRAW_NUMBER",$searchArray["DRAW_NUMBER"]);
		}
		if(isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"]!=''){
			$this->db2->where("IS_ACTIVE",$searchArray["DRAW_STATUS"]);
		}
		
		if(!empty($searchArray['START_DATE_TIME']) && !empty( $searchArray['END_DATE_TIME'] )){
			$start_date	=	$searchArray['START_DATE_TIME'];
			$end_date	=	$searchArray['END_DATE_TIME'];
			$this->db2->where('DRAW_STARTTIME BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
		}
		$this->db2->order_by('draw_id', 'desc'); 
		$this->db2->limit($limit,$offset);	
		$resultInfo = $this->db2->get();
		//echo $this->db2->last_query();exit;
		return $resultInfo->result();
	}
	
	public function getDrawcount($searchArray) {
		$this->db2->select("count(*) as cnt")->from("lotto_draw");
		if(!empty($searchArray["DRAW_NAME"])){
			$this->db2->like("DRAW_DESCRIPTION",$searchArray["DRAW_NAME"]);
		}
		
		if(!empty($searchArray["DRAW_NUMBER"])){
			$this->db2->like("DRAW_NUMBER",$searchArray["DRAW_NUMBER"]);
		}
		if(isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"]!=''){
			$this->db2->where("IS_ACTIVE",$searchArray["DRAW_STATUS"]);
		}
		
		
		if(!empty($searchArray['START_DATE_TIME']) && !empty( $searchArray['END_DATE_TIME'] )){
			$start_date	=	$searchArray['START_DATE_TIME'];
			$end_date	=	$searchArray['END_DATE_TIME'];
			$this->db2->where('DRAW_STARTTIME BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
		}
		$this->db2->order_by('draw_id', 'desc'); 
		$resultInfo = $this->db2->get();
		
		return $resultInfo->row_object();
	}
	
	function updateDrawStatus($drawDetails, $drawId) {
		
		$this->db2->where("DRAW_ID",$drawId);
		$rsResult = $this->db2->update('lotto_draw',$drawDetails);
	
		return $rsResult;
	}
	
	
	public function getCategoryManagementInfo() {
		$this->db2->select("c.CATEGORY_ID,c.MINIGAME_ID,cc.CATEGORY_NAME,m.DESCRIPTION")
					->from("categories_management as c");
		$this->db2->join("categories as cc","cc.CATEGORY_ID=c.CATEGORY_ID","left");
		$this->db2->join("minigames as m","m.MINIGAMES_ID=c.MINIGAME_ID","left");
		$this->db2->where("CATEGORY_STATUS",1);
		//echo $this->db2->last_query();exit;
		$resultInfo = $this->db2->get();
		return $resultInfo->result();
	}
	
	public function getCategory() {
		$this->db2->select("*")->from("categories");
		$this->db2->where("CATEGORY_STATUS",1);
		$this->db2->order_by('CATEGORY_NAME', 'ASC'); 
		$resultInfo = $this->db2->get();
		//echo $this->db2->last_query();exit;
		return $resultInfo->result();
	}
	
	public function getCategoryGames($catID){
		$select = $this->db2->query("SELECT MINIGAMES_ID,DESCRIPTION FROM minigames WHERE STATUS=1 AND MINIGAMES_ID IN(SELECT MINIGAME_ID FROM categories_management WHERE CATEGORY_ID=".$catID.")");
		return $select->result();
	}
	
	public function getCategoryUnknownGames($catID){
		$select = $this->db2->query("SELECT MINIGAMES_ID,DESCRIPTION FROM minigames WHERE STATUS=1 AND MINIGAMES_ID NOT IN(SELECT MINIGAME_ID FROM categories_management WHERE CATEGORY_ID=".$catID.")");
		return $select->result();
	}
	
	public function deleteCategory($catID){
		$this->db2->delete('categories_management', array('CATEGORY_ID' => $catID)); 
	}
	public function InsertCategory($data){
		$this->db2->insert('categories_management', $data); 
		return $this->db2->insert_id();
	}
	public function getWinBigBossGameDetails(){
		$this->load->database();
		$this->db2->select("*");
		$this->db2->where("STATUS",1);
		$browseSQL = $this->db2->get("lucky7_games");
		$gameInfo  =  $browseSQL->result();
		return $gameInfo;	
	} 
	
	public function insertLuckyGames($data){
		if(empty($data)){
			return 0;
		}
		$res = $this->db2->update_batch('lucky7_games', $data, 'GAMES_ID'); 
		return $res;
		
	}
}
?>
