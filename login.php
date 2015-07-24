<?php
session_start();
// REMEMBER TO TAKE INTO ACCOUNT LOWERCASE!
require_once("config.php");
require_once("src/loginbackend.php");
//$sessionstarted = false;
//session_start();
//if(isset($_SESSION[GG_PREFIX . 'username']))
//{
//  header("Location: _my_workouts_page.php");
//}
$tried_before = false;
$error = false;
$successfullogin = false;
if(isset($_POST['username']) && isset($_POST['password']))
{
  $pdo = gg_get_pdo();
  $tried_before = true;
  // Figure out if this username actually exists
  $stm = "SELECT salt, password FROM " . GG_PREFIX . "users WHERE username=?";
  echo $stm;
  $sth = $pdo->prepare($stm);
  $sth->execute(array($_POST['username']));
  $salt = "";
  $givenpasswordhash = ""; // one from database
  if(empty($sth)) // If the username doesn't exist..
    $error = "Username not found.";
  else {
    // In this case, the username DOES exist.
    $userinfo = $sth->fetchAll(PDO::FETCH_ASSOC);
    $userinfo = $userinfo[0];
    $givenpasswordhash = $userinfo['password'];
    $salt = $userinfo['salt'];
    // Figured out the password hash now
    $passwordhash = ggLog_encrypt($_POST['password'], $salt);
    if($passwordhash === $givenpasswordhash)
    {
      $successfullogin = true;
      session_start();
      $_SESSION[GG_PREFIX . 'username'] = $_POST['username'];
      header("Location: index.php"); //LATER, GO SOMEWHERE WE ACTUALLY WANT TO GO.
    }
    else
      $error = "Username and/or password were incorrect.  Try again.";
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login Page | ggLog.xyz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="css/ggLogEssentials.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="js/ggLogEssentials.js"></script>
    <style>
    .ggLog-submit-cont
    {
      display:block;
      width:200px;
      margin:0 auto;
    }
    .ggLog-submit-contm
    {
      display:block;
      width:50%;
      margin:0 auto;
    }
    .ggLog-form-cont
    {
      display:block;
      margin: 0 auto;
      max-width:600px;
    }
    .ggLog-form-contm
    {
      display:block;
      width:90%;
      margin-left:5%;
    }
    </style>
    <script>
    function bload()
    {
      if(IsMobileBrowser())
      {
        document.getElementById("submitbutton").className="ggLog-submit-contm";
        document.getElementById("formContainer").className="ggLog-form-contm";
      }
      else
      {
        document.getElementById("submitbutton").className="ggLog-submit-cont";
        document.getElementById("formContainer").className="ggLog-form-cont";
      }
    }
    </script>
  </head>

  <body onLoad="bload()">
    <?php require_once("navbar.php"); navbar("login.php"); ?>
    <h1 class="text-center">Login</h1>
    <br />
    <div id="formContainer" class="ggLog-hide">
      <form action="login.php" method="post">
        <?php
        if($error != false)
        { ?>
          <div style="width:90%;background-color:#FFAA99;margin: 0 auto;display:block;border:2px solid #661111;margin-bottom:15px;padding:5px;">
            <b>Error: </b> <?php echo $error; ?>
          </div>
          <?php } ?>
        <div style="float:left;">Username: </div>
        <div style="float:left;width:50%;"><input type="text" name="username" class="form-control" /></div><br style="clear:both;" /><br />
        <div style="float:left;">Password: </div>
        <div style="float:left;width:50%;"><input type="password" name="password" class="form-control" /></div>
        <br style="clear:both;" /><br />
        <div class="ggLog-submit-cont" id="submitbutton">
          <input type="submit" value="Login" class="form-control" />
        </div>
      </form>
      <span style="color:#776600;">Don't have an account yet?  Register <a href="register.php">here</a></span>
    </div>
  </body>
</html>
