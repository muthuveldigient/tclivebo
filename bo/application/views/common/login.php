<?php $this->load->view("common/header"); ?>
<style>
body {
    height: auto !important;
    background-color:#fff3c5;
	background-image: url(<?php echo base_url();?>/static/images/bg_v2.jpg);
    background-size: cover;
}
.ContentHdr{
  background-color: #F8F8F8 !important;
}
.ErrorMsg{
  text-align: center;
}
.btn, button, input[type="submit"], input[type="reset"], input[type="button"]{
	background: #6107a8 !important;
    border: none !important;
    color: #fff;

}
.logo {
    position: static !important;
    float: none !important;
    width: 100% !important;
    text-align: center;
	height: initial;
}
.logo img {
    float: none !important;
    margin: 0 !important;
}
.header {
    padding-top: 5%;
}
</style>
<form action='<?php echo base_url();?>login/loginprocess' method='post' name='process'>
<div class="LoginWrap">

<div class="LoginInWrap">
	<?php if(isset($err) && $err!=""){ ?>
	<div class="UpdateMsgWrap">
	  <table width="100%" class="ErrorMsg">
		<tr>
		  <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
		  <td width="95%"><?php echo $err;?></td>
		  </tr>
	  </table>
	</div>
	<?php }elseif(isset($_GET['fm'])){ ?>
	<div class="UpdateMsgWrap">
	  <table width="100%" class="ErrorMsg">
		<tr>
		  <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
		  <td width="95%"><?php echo base64_decode($_GET['fm']);?></td>
		  </tr>
	  </table>
	</div>
	<?php } ?>

      <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="LoginTableWrap">
        <tr>
          <td>
          <table width="100%" class="ContentHdr">
      <tr>
        <td><span style="color:#428bca;font-size: 15px;line-height: 15px;">Please login to your account.</span></td>
        </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
      <tr>
        <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
          <label>
          <input name="username" type="text" required class="TextField100" onkeydown="txtBlur('user');" id="username" size="60"  />
          </label>
            <span id="user" class="errormsg"><? if(isset($_GET['errmsg'])==2){ echo "Enter Username"; }?></span>
        </td>
        </tr>

      <tr>
        <td width="40%"><span class="TextFieldHdr">Password:</span><br />
          <label>
          <input name="password" type="password" required class="TextField100" id="password" size="60"  />
          </label></td>
        </tr>


      <tr>
        <td width="40%"><span class="TextFieldHdr">Captcha:</span><br />
          <label>
          <input name="captcha" type="captcha"  required class="TextField100" style="width:78%;margin-top:1px;" autocomplete="off" id="password" maxlength="4" />&nbsp;
      <?php if($_SERVER['SERVER_NAME']=="manage.shanplay.com") {?>
      <img src="<?php echo base_url();?>captcha.php" style="position: absolute; width: 47px; height: 27px;" /><br />
      <?php } else { ?>
      <img src="<?php echo base_url();?>captcha_shan18.php" style="position: absolute; width: 47px; height: 27px;" /><br />
      <?php  } ?>
          </label></td>
        </tr>
      <tr>
          <td width="40%">
              <input name="submit" type="submit" id="submit" value="LOGIN"/>&nbsp;</td>
        </tr>
    </table>

      </tr>
    </table>

      </div>
</div>
</form>
<!--<div style="width:67%;text-align:right;padding-right:30px;" class="UDeditR"><a href="<?php echo base_url()?>" >Agent Login</a></div>-->
<?php $this->load->view("common/footer"); ?>
