<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />

<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function confirmDelete(){
var agree=confirm("Are you sure you want to delete this file?");
if(agree)
    return true;
else
     return false;
}

function activateUser(status,userid,positionid){
   xmlHttp3=GetXmlHttpObject()
   
   if(status == 1){
     var urlstatus = 'deactive';
   }else{
     var urlstatus = 'active';
   }
   var url='<?php echo base_url()."user/ajax/"?>'+urlstatus+'/'+userid;    
 
   //url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showsubagent(userid,status,positionid)
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}

</script>
<style>
.PageHdr{
  width: 94.9%;
}
</style>
<script>
function showdaterange(vid){
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

<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
         
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Turn Over Report</strong></td>
          </tr>
        </table>
        
        <form action="<?php echo base_url(); ?>reports/agent_turnover/report?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
            <?php
                $START_DATE_TIME = !empty( $START_DATE_TIME ) ? date("d-m-Y 00:00:00", strtotime($START_DATE_TIME)) : date('d-m-Y 00:00:00');
                $END_DATE_TIME = !empty( $END_DATE_TIME ) ? date("d-m-Y 00:00:00", strtotime($END_DATE_TIME)) : date('d-m-Y 23:59:59');
            ?>
              <tr>
                <td width="30%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?php echo $START_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="30%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?php echo $END_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
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
                <td width="33%">
                  <table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" /></td>
                    <td><form action="<?php echo base_url();?>reports/agent_turnover/report?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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

            $resValue = array();
            if ( !empty( $results ) ) {
                foreach ($results as $key => $value) {
                    // $resValue[$key]['MAIN_AGEN_ID']   = $value->MAIN_AGEN_ID;     
                    $resValue[$key]['Partner_Namer'] = $value->MAIN_AGEN_NAME;
                    $resValue[$key]['Play_Point']    = $value->TOT_BET;
                    $resValue[$key]['Win_Point']     = $value->TOT_WIN;
                    $resValue[$key]['Agent']         = !empty($value->MARGIN) ? $value->MARGIN : 0;
                    $resValue[$key]['Company']       = !empty($value->NET) ? $value->NET : 0;
                }
            }
        ?>

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
      
        <div class="tableListWrap">
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
              <table id="listsg11"></table>
              <div id="pager3"></div>
              <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
              <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
              <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <?php if( !empty( $results ) ) { ?>
              <table id="list2">
              </table>
              <div id="pager2"></div>
              <script type="text/javascript">

                  jQuery("#list2").jqGrid({
                      datatype: "local",
                      colNames:['Partner Namer', 'Play Point', 'Win Point', 'Agent', 'Company'],
                      colModel:[
                        {name:'Partner_Namer',index:'Partner_Namer',align:"left", width:140,sortable:true},
                        {name:'Play_Point',index:'Play_Point',align:"left", width:90,sortable:true},
                        {name:'Win_Point',index:'Win_Point',align:"left", width:90,sortable:true},
                        {name:'Agent',index:'Agent',align:"left", width:90,sortable:true},
                        {name:'Company',index:'Company',align:"left", width:90,sortable:true}
                      ],
                      rowNum:500,
                      width: 999, height: "100%"
                  });
                  var mydata = <?php echo json_encode($resValue); ?>;
                  for( var i = 0; i <= mydata.length; i++ )
                      jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);

              </script>
              <div class="page-wrap">
                <div class="pagination">
                  <?php echo $pagination; ?>
                </div>
              </div>

            <?php }

            if( empty($results) ) {
                $message = "There is no record to display. Please select the search criteria";
            }

            if( !empty($message) ) { ?>
              <table id="list4" class="data">
                <tr>
                  <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span> </td>
                </tr>
              </table>
            <?php } ?>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>