<?php error_reporting(0); ?>
<script src="<?php echo base_url(); ?>static/js/lightbox-form.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>static/css/lightbox-form.css">
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            // Slide
            $('#menu1 > li > a.expanded + ul').slideToggle('');
            $('#menu1 > li > a').click(function () {
                $(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('');
                var excclass = $(this).attr("class");
                var exclass = $(this).attr("class");
                var posid = $(this).attr("id");

                if (posid == 1) {
                    var collap = '<?php echo base_url() . '/static/images/user-home.png'; ?>';
                    var expan  = '<?php echo base_url() . '/static/images/user-home.png'; ?>';
                } else {
                    var collap = '<?php echo base_url() . '/static/images/collapse.gif'; ?>';
                    var expan  = '<?php echo base_url() . '/static/images/expand.gif'; ?>';
                }
                if (exclass == 'menuitem submenuheader expanded') {
                    $("#imgpos" + posid).html('<img src="' + expan + '" width="11" height="11" align="left" style="padding:2px 5px 0 0" >');
                } else {
                    $("#imgpos" + posid).html('<img src="' + collap + '" width="11" height="11" align="left" style="padding:2px 5px 0 0" >');
                }
            });
        }, 250);
    });
</script>
<style>
    .example_menu1 ul {	display: none;  }
    #menu1 {	margin: 0;    }
    #menu1 li,
    .example_menu li {	background-image: none;	margin: 0;	padding: 0;  }
    .example_menu ul ul {	display: block;  }
    .style5{  h1 {text-decoration:underline; }  color: #0066CC;  font: bold;  text-decoration:none;  }
</style>
<script type="text/javascript">
    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if (e.style.display == 'block') {
            e.style.display = 'none';
            document.getElementById('changeToggleIcon').innerHTML = "<img src='<?php echo base_url(); ?>static/images/expand.gif' style='padding:2px 5px 0 0' />";
        } else {
            e.style.display = 'block';
            document.getElementById('changeToggleIcon').innerHTML = "<img src='<?php echo base_url(); ?>static/images/collapse.gif' style='padding:2px 5px 0 0' />";
        }
    }
</script>

<div class="LeftMenuWrap">
    <div class="MainMenuHdr">Main Menu</div>

    <div class="glossymenu">
        <ul id="menu1" class="example_menu1">

            <li>
                <a class="menuitem submenuheader collapsed" href=" <?php echo base_url(); ?>" id="1" title="Home ">
                    <div id="imgpos1">
                        <img src="<?php echo base_url(); ?>static/images/user-home.png" width="11" height="11" align="left" style="padding:2px 5px 0 0">
                    </div>
                    Home        
                </a>
            </li></ul>
    </div>


    <?php
    $adminUserId = array(3, 4);
    $sessionPartnerID = $this->session->userdata('adminuserid');

    if ($sessionPartnerID == 2) {//result_admin
        ?>
        <div class="glossymenu">
            <ul id="menu1" class="example_menu1">

                <li>
                    <a class="menuitem submenuheader expanded" href=" #" id="5" title="Ticket System ">
                        <div id="imgpos5"><img src="<?php echo base_url(); ?>static/images/collapse.gif" width="11" height="11" align="left" style="padding:2px 5px 0 0"></div>
                    Ticket System</a>
                    <ul id="-1" style="display: block;">

                    </ul>
                    <ul id="1" style="display: block;">

                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>admin/draw/drawresult">Result </a></li></div>      
                    </ul>

                </li></ul>
        </div>
    <?php } elseif (in_array($sessionPartnerID, $adminUserId)) { //report_admin1,report_admin2
        ?>
        <div class="glossymenu">
            <ul id="menu1" class="example_menu1">

                <li>
                    <a class="menuitem submenuheader collapsed" href=" #" id="4" title="Reports ">
                        <div id="imgpos4">
                            <img src="<?php echo base_url(); ?>static/images/expand.gif" width="11" height="11" align="left" style="padding:2px 5px 0 0">
                        </div>
                    Reports</a>
                    <ul id="-1" style="display: block;">

                    </ul>
                    <ul id="0" style="display: block;">

                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>reports/agent_turnover/report?rid=62">Turn Over </a></li></div>      
                    </ul>

                </li></ul>
        </div>
<?php } else { //admin 

    $segment   = $this->uri->segment(1);
    $segment_2 = $this->uri->segment(2);

    if($segment == 'reports') {
        $reports_icon     = 'collapsed';
        $reports_img      = 'collapse';
        $reports_sub_menu = 'style="display:block"';

        $draw_icon     = 'expanded';
        $draw_img      = 'expand';
        $draw_sub_menu = 'style="display:none"';
    } else if($segment_2 == 'draw') {
        $draw_icon     = 'collapsed';
        $draw_img      = 'collapse';
        $draw_sub_menu = 'style="display:block"';

        $reports_icon     = 'expanded';
        $reports_img      = 'expand';
        $reports_sub_menu = 'style="display:none"';
    } 
?>
        <div class="glossymenu">
            <ul id="menu1" class="example_menu1">
                <li>
                    <a class="menuitem submenuheader <?php echo $reports_icon; ?>" href=" #" id="4" title="Reports ">
                        <div id="imgpos4">
                            <img src="<?php echo base_url(); ?>static/images/<?php echo $reports_img; ?>.gif" width="11" height="11" align="left" style="padding:2px 5px 0 0">
                        </div>
                    Reports</a>
                    <ul id="-1" <?php echo $reports_sub_menu; ?>>

                    </ul>
                    <ul id="0" <?php echo $reports_sub_menu; ?>>

                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>reports/agent_turnover/report?rid=62">Turn Over </a></li></div>      
                    </ul>

                </li>
            </ul>
        </div>

        <div class="glossymenu">
            <ul id="menu1" class="example_menu1">

                <li>
                    <a class="menuitem submenuheader <?php echo $draw_icon; ?>" href=" #" id="5" title="Ticket System ">
                        <div id="imgpos5"><img src="<?php echo base_url(); ?>static/images/<?php echo $draw_img; ?>.gif" width="11" height="11" align="left" style="padding:2px 5px 0 0"></div>
                    Ticket System</a>

                    <ul id="-1" <?php echo $draw_sub_menu; ?>>

                    </ul>
                    <ul id="0" <?php echo $draw_sub_menu; ?>>
                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>admin/draw/creation">Create Draw</a></li></div>      
                    </ul>
                    <ul id="1" <?php echo $draw_sub_menu; ?>>
                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>admin/draw/drawresult">Result</a></li></div>      
                    </ul>
                    <ul id="1" <?php echo $draw_sub_menu; ?>>
                        <div class="SubMenuCnt"><li><a href="<?php echo base_url(); ?>admin/draw/streaming_settings">Settings</a></li></div>      
                    </ul>

                </li>
            </ul>
        </div>
    <?php }
    ?>





</div>
