<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo base_url(); ?>static/images/favicon.png?v=2" title="Triple Chance Live" type="image/png">
<title>Backoffice Manager</title>
<link href="<?php echo base_url(); ?>static/css/style_shan18.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>static/css/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    var global_baseurl = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>static/js/adminvalidate.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/jconfirmaction.jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>static/css/lightbox-form.css">
<script src="<?php echo base_url(); ?>static/js/lightbox-form.js" type="text/javascript"></script>
<script type="text/javascript">
	var SITEURL = '<?php echo base_url(); ?>';
	/*$(document).ready(function() {
		$('.ask').jConfirmAction();
	});*/
</script>
<script src = "<?php echo base_url(); ?>static/js/ajaxCall.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/ddaccordion.js"></script>
<!--<script type="text/javascript" src="<?php //echo base_url(); ?>static/js/stickytooltip.js"></script>-->
<style>
.style1 {
	color: #a2daff;
	font-weight: bold;
}

.style2 {
	color: #57bcff;
	font-weight: bold;
}
</style>
</head>
<body>
<?php
$this->load->model('common/common_model');
$dbTime = $this->common_model->getServerTime();
?>
<script type="text/javascript">
var xmlHttp
//Ads Start
function GetXmlHttpObject()
{

var objXMLHttp=null
if (window.XMLHttpRequest)
{
objXMLHttp=new XMLHttpRequest()
}
else if (window.ActiveXObject)
{
objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
}
return objXMLHttp
}

function Showusers()
{
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
            var result=xmlHttp.responseText;
            var trecords=result.split("##");
            document.getElementById("onlineusers").innerHTML='Online User:&nbsp;<span class="errormsg" style="color:#FF3300"><a style="cursor:pointer;"  onclick="javascript:document.getElementById(\'shogameusers\').style.display=\'\';document.getElementById(\'showonlineusers\').style.display=\'none\'">'+trecords[0]+'</a></span>';
            document.getElementById("gameusers").innerHTML='Game User:&nbsp;<span class="errormsg" style="color:#FF3300"><a style="cursor:pointer;"  onclick="javascript:document.getElementById(\'showonlineusers\').style.display=\'\';document.getElementById(\'shogameusers\').style.display=\'none\'">'+trecords[1]+'</a></span>';
            document.getElementById("showonlineusers").innerHTML=trecords[3];
            document.getElementById("shogameusers").innerHTML=trecords[2];

    }
}
function showgameuserlist(vid){
    if(vid){
        document.getElementById(vid).style.display='';
    }
}


var currenttime = '<? print date("F d, Y H:i:s", strtotime($dbTime))?>'
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1)
//var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
document.getElementById("servertime").innerHTML=timestring;
}

window.onload=function(){
setInterval("displaytime()", 1000)
}
</script>
<body>
  <?php
  if($this->session->userdata('partnerusername') != ''){
   ?>
<style>
.header { float: left; width: 100%; height: 80px; background:#c8181e;}
</style>
<?php }else { ?>

<?php }?>

<div id="container">
  <div class="header">

          <div class="logo" style="position:relative; top:-25px; left:5px;"><!-- BACKOFFICE MANAGER<br/> -->
            <?php
            if($this->session->userdata('partnerusername') != ''){
             ?>
		  <img src="<?php echo base_url(); ?>static/images/logo.png" align="Logo" style="margin: 15px 0px 0px -3px;float: left;height: 83px;" />
<?php }else { ?>
  <img src="<?php echo base_url(); ?>static/images/logo.png" align="Logo" style="margin: 15px 0px 0px -3px;float: left;" />

<?php } ?>
          <!-- <h1>Agent</h1> -->
      <!--<span class="logocaption">for amusement only</span>--></div>

    <?php
    if($this->session->userdata('partnerusername') != ''){
	?>
	<div style="width: 28%;float: left;margin-top: 20px;color: #fff;">
		<p><span class="partner-name" style="width:140px;float: left;">Partner Username</span>:&nbsp;<?PHP echo ucfirst($this->session->userdata('partnerusername')); ?></p>
		<!--<p style="margin-bottom: 3%;"><span class="partner-name" style="width: 140px;float: left;">Partner Name</span>:&nbsp;<?PHP echo ucfirst($this->session->userdata('partnername')); ?></p>-->
	</div>
    <?php /* if(isset($amt)>0)
    {?>
    <div class="HeaderDisplay">Balance: <strong><?PHP if(isset($amt)){ echo $amt;} ?></strong></div>
    <?php } */ ?>
    <div class="HeaderDisplay">Date: <strong><?PHP echo date("d-m-Y"); ?></strong></div>
    <div class="HeaderDisplay style2" id="servertime"></div>
    <!--<div class="HeaderDisplay">Online Users: <strong>2000</strong></div>
    <div class="HeaderDisplay">Game Users: <strong>154</strong></div>-->
    <div class="logout">
      <form action="<?php echo base_url(); ?>logout">
       <input name="submit" type="submit" value="Logout">
      </form>
    </div>
   <?php }

   ?>
</div>
