<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />

	<div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php if(!empty($dispName)){ echo ucfirst(strtolower($dispName)); }else{ echo ucfirst(strtolower($gameName)); }  ?></div>
      </div>
    </div>
    <div class="Agent_game_Left" style="width:350px;">
      <div class="Agent_game_tit_wrap" style="width:350px;">
        <div class="Agent_game_name">Hand ID</div>
        <div class="Agent_game_val2" style="width:220px;">: <?php echo $handId;?></div>
      </div>
    </div>
  </div>
  <div class="tableWrap">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Hand ID</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Start Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">End Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Stake</td>
            </tr>
          </table></td>
        
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
      </tr>
      <?PHP
	/* if($gameName=="mobspin2win_pro"){
		$query="select spin2win_pro_play.*,user.USERNAME from spin2win_pro_play, user where spin2win_pro_play.USER_ID = user.USER_ID AND GAME_ID='mobspin2win_pro' and INTERNAL_REFERENCE_NO='".$handId."'";
	}else{
		$query="select spin2win_pro_play.*,user.USERNAME from spin2win_pro_play, user where spin2win_pro_play.USER_ID = user.USER_ID AND GAME_ID='mobspin2win_protimer' and INTERNAL_REFERENCE_NO='".$handId."'";    
	}

	$results=mysql_query($query) or die("connection failed"); */

	$results = $this->game_model->getSpin2WinProPlayDetails($gameName,$handId); 
	
	if(isset($_REQUEST['page'])) {
		$i=$startpoint+1;
	} else {
		$i=1;
	}
	//while($row=mysql_fetch_array($results)){	
//		@extract($row);	
	foreach($results as $row) {	
		$tot=json_decode($row->PLAY_DATA, true);  
		$mWinAmount=$row->WIN;
		$jackWin=$row->JACKPOT_WIN;
		$totalWinAmount = $row->WIN+$row->JACKPOT_WIN
?>
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $row->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->INTERNAL_REFERENCE_NO; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->STARTED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->ENDED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->STAKE; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->WIN+$row->JACKPOT_WIN; ?></td>
            </tr>
          </table></td>          
      </tr>
      <?php 
	$i++;
	}
?>
    </table>
    <?php  
//	$tot=json_decode($PLAY_DATA, true); 
    $totalbets="";
	$single="";
	$ssingle="";
	$ddouble="";
	$ttriple="";
	$totalbets=$tot['singleWheelResult']['betNumbers'];
	$totalwin=$tot['singleWheelResult']['totalWinFactor'];
	$betnumber="";
	$wheel1id=$tot['singleWheelResult']['wheel']['wheel'][0]['id'];
	$wheel2id=$tot['singleWheelResult']['wheel']['wheel'][1]['id'];
	$wheel3id=$tot['singleWheelResult']['wheel']['wheel'][2]['id'];
	// print_r($totalbets);
  	foreach($totalbets as $key=>$value){
    	if(strlen($key)==1){
        	$single[$key]=$value;
          	$ssingle[]=$key;
      }elseif(strlen($key)==2){
          	$double[$key]=$value;
          	$ddouble[]=$key;
      }elseif(strlen($key)==3){
          	$triple[$key]=$value;
          	$ttriple[]=$key;
      }
	}
	$winpos="";
	$winmat="";
	$winbetpos="";   
  if($tot['singleWheelResult']['winPositions']){
      if(strstr($tot['singleWheelResult']['winPositions'],",")){
        $totwins=explode(",",$tot['singleWheelResult']['winPositions']);
        for($w=0;$w<count($totwins);$w++){
            $winbetpos=explode("-",$totwins[$w]);
            $arrcnt=count($winbetpos);
            $winpos[]="'".$winbetpos[0]."'";
            $akey=$arrcnt-1;
            $winmat[$winbetpos[0]]=$winbetpos[$akey];
        }    
      }else{
        $winbetpos=explode("-",$tot['singleWheelResult']['winPositions']);
        $arrcnt=count($winbetpos);
        $winpos[]="'".$winbetpos[0]."'";
        $akey=$arrcnt-1;
        $winmat[$winbetpos[0]]=$winbetpos[$akey];
      }
  }
	$win_amount= $tot['singleWheelResult']['wheel']['id'];
	$jackport = $tot['singleWheelResult']['jackpot'];
?>
<div class="SeachResultWrap">
    <div class="TCwrap">
    <div class="TC_infoWrap">
    <div class="TC_infoWinBet">
    <div class="BetColor"></div>
    <div class="infoTxt">User Bet</div>
</div>
<div class="TC_infoWinBet">
<div class="WinColor"></div>
<div class="infoTxt">Win Ticket</div>
</div>
<?php if($totalwin){
 ?>    
<div class="TC_infoWinBet">
    <div class="infoTxt">Win:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php echo $mWinAmount;?></div>
</div>
<div class="TC_infoWinBet">
    <div class="infoTxt">Jackport Win:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php echo $jackWin;?></div>
</div>
<div class="TC_infoWinBet">
    <div class="infoTxt">Total Win:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php echo $totalWinAmount;?></div>
</div>

<div class="TC_infoWinBet">
    <div class="infoTxt">Win Number:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php echo $win_amount;?></div>
</div>    
<?php }else{ ?>

<div class="TC_infoWinBet">
    <div class="infoTxt">Win Number:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php echo $win_amount;?></div>
</div>    
<?php } ?>    
</div>
<div class="TC_Left_Wrap">
<?php if($ssingle){
        sort($ssingle);
?>    
<div class="TC_doubleHdr">Play Positions</div>
<div class="TC_DoublesWrap">
<?php for($s=0;$s<count($ssingle);$s++){
    $singelbet=explode("-",$single[$s]);
    $sbetval="'".$ssingle[$s]."'";
    $sbetamt=$single[$ssingle[$s]];
    ?>    
<div class="<?php if(in_array($sbetval,$winpos,true)){ echo "TC_Win_NumberWrap"; }else{ echo "TC_NumberWrap";}?>">
<div class="TC_Number"><?php echo str_replace("'","",$sbetval);?></div>
<div class="TC_BetAmount"><?php echo $sbetamt;?></div>
</div>
<?php } ?>
</div>
<?php }
 ?>
</div>
<div class="TC_MidWrap">
<div class="TC_Flash_Display">
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="502" height="400"  id="externalInterface">
            <param name="allowScriptAccess" value="always"/>
            <param name="movie" value="single_wheel.swf"/>
            <param name="flashvars" value="wheel1id=<?php echo $win_amount;?>" />
            <param name="quality" value="high" />
            <embed height="400" width="502" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" flashvars="wheel1id=<?php echo $win_amount;?>" src="<?php echo base_url(); ?>static/images/single_wheel.swf"/> 	
    </object>   
<div>
	<?php
	if(!empty($tot["singleWheelResult"]["jackpot"])) {
		if($tot["singleWheelResult"]["jackpot"]==4) {
			echo '<img src="images/minigame/spin2win_pro_games/X_0003.png" width="100" height="100">';
		}
		if($tot["singleWheelResult"]["jackpot"]==3) {
			echo '<img src="images/minigame/spin2win_pro_games/X_0002.png" width="100" height="100">';
		}
		if($tot["singleWheelResult"]["jackpot"]==2) {
			echo '<img src="images/minigame/spin2win_pro_games/X_0001.png" width="100" height="100">';
		}									
	} 
	?>
</div>
</div></div>
</div>
</div>
  </div>
 