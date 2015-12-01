<?php
require_once("config.php");
session_start();
require_once("src/loginbackend.php");
$validUser = false;
if(isset($_GET['u']))
  $validUser = user_exists($_GET['u']);
if($validUser && isset($_SESSION[GG_PREFIX . 'username']) && $_SESSION[GG_PREFIX . 'username'] == $_GET['u'])
  header("Location: demo.php");
/*
if(!isset($_SESSION[GG_PREFIX . 'username']))
{
  header("Location: index.php");
} */
?>
<!doctype html>
<html style="width:100%;height:100%">
  <head>
    <title>gglog.xyz: Running Logs</title>
    <meta name="viewport" content="width=device-width" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <link rel="stylesheet" href="css/workouts.css" />
    <link rel="stylesheet" href="css/ggLogEssentials.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/ggLogEssentials.js"></script>
    <script type="text/javascript" src="js/user.js"></script>
    <!--script type="text/javascript" src="loginstuff.js"></script-->
  </head>
  <body style="width:100%;height:100%;" onLoad="demoload();">
    <!--div style="display:block;top:0;right:0;text-align:right;padding-bottom:0;z-index:1;padding-right:10px;" id="userstuff">
      <span class="badge" style="font-weight:900;background-color:#a00;" id="useralerts" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Warnings" data-content="Get more sleep.">1</span>
      <span id="userinfo"> Logged on as <a style="position:relative;" href="javascript:switchuser();">David B.</a> | <a href="javascript:switchuser();">Switch user</a></span>
    </div-->
    <input type="hidden" id="usernumber" value="0" />
    <?php require_once("navbar.php"); navbar("demo.php"); ?>
    <div class="ggLog-hide" id="coverForNotices"></div>
    
    <?php
    if($validUser)
    {
    ?>
    <input type="hidden" value="<?php echo $_GET['u']; ?>" id="ggcurrentusername" />
    <h1 class="text-center"><?php echo $_GET['u']; ?>'s Workouts</h1>
    <!--iframe src="test1.php" height="200" style="display:block;margin: 0 auto;width:820px;"></iframe-->
    <svg id="mchart"></svg>
  
    <div class="ggLog-containrecentworkouts" id="recentworkouts-desktop">
      <hr class="ggLog-partial" style="clear:both;"/>
        <hr class="ggLog-partial" style="clear:both;" />
        <?php /*
        require_once("src/workouts.php");
        require_once("src/seasons.php");
        $start = microtime(true);
        displayWeeklyDistances(true);
        echo (microtime(true) - $start) . " (Please do not mind these load times; they are temporary, for beta testing.)";
        $start = microtime(true);
        echo "<h3 class=\"text-center\">Recent Workouts</h3>";
        displayworkouts(true, 0, 20);
        echo microtime(true) - $start; */
        ?>
        <button class="btn btn-default" style="display:block;margin-left:auto;margin-right:auto;margin-bottom:15px;" onclick="loadmore();" id="loadmorebutton">Load More</button>
        <input type="hidden" id="numberloaded" value="0" autocomplete="off" />
    </div>
    <hr class="ggLog-partial" style="clear:both;" />
    <div class="ggLog-hide" id="recentworkouts-mobile">
      <h3 class="text-center">Recent Workouts</h3>
      <hr class="ggLog-partial" style="clear:both;" />
      <button class="btn btn-default" style="display:block;margin-left:auto;margin-right:auto;margin-bottom:15px;" onclick="loadmore();" id="loadmoremobilebutton">Load More</button>
      <!-- numberloaded will just use the one provided in the desktop section -->
    </div>
    <?php
    }
    else {
    ?>
    Otherwise..
    <?php
    }
    ?>
    <br /><br />
  </body>
</html>
