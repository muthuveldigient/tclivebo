<?php
//error_reporting(E_ALL);
/*
  Class Name	: Agentreport_model
  Package Name  : Report
  Purpose       : Handle all the database services related to Turnover report
  Author 	    : Sivakumar
  Date of create: July 08 2014
*/
class agentreport_Model extends CI_Model
{

	public function getTurnoverReport( $data ) {

		$this->db->select('MAIN_AGEN_ID, MAIN_AGEN_NAME, SUM(PLAY_POINTS) AS TOT_BET, SUM(WIN_POINTS) AS TOT_WIN, SUM(MARGIN) AS MARGIN, SUM(NET) AS NET');

		if( !empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$start = date("Y-m-d 00:00:00", strtotime($data["START_DATE_TIME"]));
			$end   = date("Y-m-d 23:59:59", strtotime($data["END_DATE_TIME"]));
			$where = "DATE_FORMAT(START_TIME,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db->where($where);
		} else {
			$start = date("Y-m-d 00:00:00");
			$end   = date("Y-m-d 23:59:59");
			$where = "DATE_FORMAT(START_TIME,'%Y-%m-%d %h:%m:%s') BETWEEN '".$start."' AND '".$end."'";
			$this->db->where($where);
		}

		$this->db->group_by("MAIN_AGEN_ID");
		return $this->db->get('ymainagent_game_turn_over_history')->result();
	}

}

?>
