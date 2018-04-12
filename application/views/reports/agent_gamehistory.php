<script language="javascript">
function showdaterange(vid)
{
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="1"){
              sdate='<?php echo date("d-m-Y 00:00:00");?>';
              edate='<?php echo date("d-m-Y 23:59:59");?>';
          }
          if(vid=="2"){
              <?php
              $yesterday=date('d-m-Y',strtotime("-1 days"));?>
              sdate='<?php echo $yesterday;?>'+' 00:00:00';
              edate='<?php echo $yesterday;?>'+' 23:59:59';
          }
          if(vid=="3"){
              
            
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>'+' 00:00:00';
              edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
          }
          if(vid=="4"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?>'+' 00:00:00';
              edate='<?php echo $slastweekeday;?>'+' 23:59:59';
          }
          if(vid=="5"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate="01-".$tmonth."-".$tyear." 00:00:00";
              $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear." 23:59:59";
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          if(vid=="6"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate=date("01-m-Y", strtotime("-1 month"))." 00:00:00";
              $lday=date("t-m-Y", strtotime("-1 month"))." 23:59:59";
              
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          document.getElementById("START_DATE_TIME").value=sdate;
          document.getElementById("END_DATE_TIME").value=edate;
      }
      
        
}
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); 
?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     
   <form action="<?php echo base_url()?>reports/agent_game_history/gamehistory?rid=<?php echo $rid?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Game History</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Player ID:</span><br />
            <label>
         <input type="text" name="playerID" id="playerID" class="TextField" value="<?PHP if(isset($_REQUEST['playerID'])) echo $_REQUEST['playerID']; ?>" tabindex="4" >
            </label>
          </td>
          <td width="30%">
          <span class="TextFieldHdr">Internal Reference No:</span><br />
            <label>
            <input type="text" name="intRefNo" id="intRefNo" class="TextField" value="<?PHP if(isset($_REQUEST['intRefNo'])) echo $_REQUEST['intRefNo']; ?>" tabindex="1" >
            </label>          
          </td>
          <td width="40%">
          <span class="TextFieldHdr">Game Name:</span><br />
            <!--<label>
            <input type="text" name="gameID" id="gameID" class="TextField" value="<?PHP //if(isset($_REQUEST['gameID'])) echo $_REQUEST['gameID']; ?>" tabindex="2" >
            </label>-->
            	<label>
            		<select name="gameID" id="gameID" class="ListMenu">
                		<option value="select">Select</option>
                    	<?php foreach($activeGames as $gameNames){ ?>
                    	<option  value="<?php echo $gameNames->MINIGAMES_NAME; ?>" <?php if(isset($_REQUEST['gameID']) && $_REQUEST['gameID']== "$gameNames->MINIGAMES_NAME"){ echo "selected";}?>><?php echo ucfirst(strtolower($gameNames->DESCRIPTION)); ?></option>
                    	<?php } ?>
                  	</select>
                </label>  
          </td>

        </tr>
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST['START_DATE_TIME'])
						$START_DATE_TIME = $_REQUEST['START_DATE_TIME'];
					else
						$START_DATE_TIME = date("d-m-Y 00:00:00");
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; } ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                   <?php
					if($_REQUEST['END_DATE_TIME'])
						$END_DATE_TIME = $_REQUEST['END_DATE_TIME'];
					else
						$END_DATE_TIME = date("d-m-Y 23:59:59");
				  ?> 
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>
                <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td width="33%"><table>
            <tr>
              <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
  </form>
  </td>
  <td><form action="<?php echo base_url();?>reports/agent_game_history/gamehistory?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
      <input name="reset" type="submit"  id="reset" value="Clear"  />
    </form></td>
  <td>&nbsp;</td>
  </tr>
  </table>
  </td>
  <td width="33%">&nbsp;</td>
  <td width="33%">&nbsp;</td>
  </tr>
  </table>
  </table>
  </form>
<?php	
if(isset($page)){
	$j=$page;
}else{
	$j=0;
}   
									
$resvalues = array();
//echo "<pre>"; print_r($results)."</pre>";
if($results[0]->USERNAME!=""){
	if(isset($results)){ 
		if(count($results)>0 && is_array($results)){
			for($i=0;$i<count($results);$i++){
				$userName 		= $results[$i]->USERNAME;		
				$tot_Bets 		= $results[$i]->TOT_BETS;
				$tot_Wins 		= $results[$i]->TOT_WINS;
				$tot_Refunds 	= $results[$i]->TOT_REFUNDS;
				$end_Points		= $tot_Bets-$tot_Wins-$tot_Refunds;
				if($userName)
					$resvalue['USERNAME']	= '<a href="'.base_url().'reports/agent_game_history/usergame_history/?rid='.$rid.'&keyword=Search&playerID='.$userName.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'">'.$userName.'</a>';
				else
					$resvalue['USERNAME']	= '-';
				if($tot_Bets)
					$resvalue['TOT_BETS']	= $tot_Bets;
				else
					$resvalue['TOT_BETS']	= '-';
				if($tot_Wins)
					$resvalue['TOT_WINS']	= $tot_Wins;
				else
					$resvalue['TOT_WINS']	= '-';	
				if($tot_Refunds)
					$resvalue['TOT_REFUNDS']	= $tot_Refunds;
				else
					$resvalue['TOT_REFUNDS']	= '-';		
				if($end_Points)
					$resvalue['TOT_END_POINTS']	= $end_Points;
				else
					$resvalue['TOT_END_POINTS']	= '-';
				
				if($resvalue){
					$arrs[] = $resvalue;
				}$j++;
			}
		}else{
			$arrs = "";
		}
	}
}		

if(isset($arrs) && $arrs !=''){  
	if($totalrecords){ ?>
     <style>
	.searchWrap1 {
    background-color: #F8F8F8;
    border: 1px solid #EEEEEE;
    border-radius: 5px;
    float: left;
    width: 100%;
	margin-top:10px;
	font-size:13px;
}
	</style>
    <p class="searchWrap1" style="height:30px;">
    <span style="position:relative;top:8px;left:10px">
    <!--<b> Total Win: <font color="green">(<?php //if($total_win) echo number_format($total_win,2,".",""); ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Revenue: <font color="#FF3300">(<?php //if($total_revenue) echo number_format($total_revenue,2,".","");?>)</font></b>
    <b> Total Pot Amount: <font color="#FF3300">(<?php //if($total_potamount) echo number_format($total_potamount,2,".","");?>)</font></b>-->
    </span>
     </p>
    <?php } ?>
    <div class="tableListWrap">
      <div class="data-list">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
        <table id="list4" class="data">
          <tr>
            <td></td>
          </tr>
        </table>
        <div id="pager3"></div>
        <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['User Name','Total Bets','Total Wins','Total Refunds','Total End Points'],
                    colModel:[
						{name:'USERNAME',index:'USERNAME', align:"center", width:60},
						{name:'TOT_BETS',index:'TOT_BETS', align:"right", width:60,sorttype:"float"},
						{name:'TOT_WINS',index:'TOT_WINS', align:"right", width:50,sorttype:"float"},
						{name:'TOT_REFUNDS',index:'TOT_REFUNDS', align:"right", width:60,sorttype:"float"},
						{name:'TOT_END_POINTS',index:'TOT_END_POINTS', align:"right", width:60},
					],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
        <div class="page-wrap">
          <div class="pagination">
            <?php	echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
<?php }else{ 
		if(empty($_POST) || $_POST['reset'] == 'Clear'){
			$message  = "Please select the search criteria"; 
		}else{
			$message  = "There are currently no games found in this search criteria.";
		} ?> 
<div class="tableListWrap">
	<div class="data-list">
       	<table id="list4" class="data">
       		<tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
            </tr>
        </table>
		</div>
</div>		
<?php	}?> 
</div>
 </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>