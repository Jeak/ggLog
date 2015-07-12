<?php
session_start();
//$sessionstarted = false;
//session_start();
//if(isset($_SESSION[GG_PREFIX . 'username']))
//{
//  header("Location: _my_workouts_page.php");
//}
if(isset($_POST['username']))
{
  require_once("config.php");
  require_once("loginbackend.php");
  require_once("registercheck.php");

  $givenusername = $_POST['username'];
  $givenpassword = $_POST['password'];
  $givenemail = $_POST['email'];

  if(checkEmail($givenemail) && checkUser($givenusername) && checkPassword($givenpassword))
  {
    $newsalt = hash("sha1", microtime());
    $storepassword = ggLog_encrypt( $givenpassword, $newsalt );
    $screenname = $givenusername;
    $userarray = array( "username" => $givenusername, "saltedpassword" => $storepassword, "salt" => $newsalt,
                        "screenname" => $screenname, "email" => $givenemail);
    ggLog_create_new_user($userarray);
    header("Location: login.php");
  }
}
$error = false;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Make an account | ggLog.xyz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="ggLogEssentials.css">
    <!--link rel="icon" href="something" sizes="" /-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="ggLogEssentials.js"></script>
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
    .ggLog-eu-notes
    {
      clear:both;
      width:100%;
      color:#661111;
    }
    </style>
    <script>
    function setSubmitButton() {
      if(($("#emailnotes").html() == "" && $("#passnotes").html() == "" && $("#usernotes").html() == "") && ($("email").val() != "" && $("#password").val() != "" && $("#username").val() != ""))
      {
        $("#submb").prop('disabled', false);
      }
      else {
        $("#submb").prop('disabled', true);
      }
    }

    function bload()
    {
      document.getElementById("email").value = "";
      document.getElementById("username").value = "";
      $("#submb").prop('disabled', true);
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
    var ebusy = false;
    var ubusy = false;

    $(document).ready(function(){
      $("#email").on("input", function(){
        var currentval = $("#email").val();
        currentval = currentval.toLowerCase();
        if(ebusy == false && currentval != "") {
          ebusy = true;
          if(currentval.indexOf("@") == -1)
          {
            document.getElementById("emailnotes").className="ggLog-eu-notes";
            document.getElementById("emailnotes").innerHTML="Invalid email address.";
            ebusy = false;
          }
          else {
            var request = $.post(
              "registercheck.php",
              {"type": "email", "email": currentval} ,
              function( data ) {
                if(data == 'bad')
                {
                  document.getElementById("emailnotes").className="ggLog-eu-notes";
                  document.getElementById("emailnotes").innerHTML="This email is already taken or is invalid";
                }
                else {
                  document.getElementById("emailnotes").className="ggLog-hide";
                  document.getElementById("emailnotes").innerHTML="";
                }
                ebusy = false;
            });
          }
        }
        setSubmitButton();
      });
      $("#username").on("input", function(){
        var currentval = $("#username").val();
        currentval = currentval.toLowerCase();
        if(ubusy == false && currentval != "") {
          ubusy = true;
          var allow = true;
          for(var i=0;i<currentval.length; ++i)
          {
            var thisnum = currentval.charCodeAt(i);
            if(!((thisnum >= 97 && thisnum <=122) || (thisnum >= 48 && thisnum <= 57)))
            {
              allow = false;
              break;
            }
          }
          if(currentval.length > 20 || currentval.length < 2)
            allow = false;
          if(currentval == "users" || currentval == "user" || currentval == "other" || currentval == "others" || currentval == "admin")
            allow = false;
          if(allow == false)
          {
            document.getElementById("usernotes").className="ggLog-eu-notes";
            document.getElementById("usernotes").innerHTML="This email is too short or contains bad characters.";
            ubusy = false;
          }
          if(allow == true)
          {
            var request = $.post(
              "registercheck.php",
              {"type": "username", "username": currentval} ,
              function( data ) {
                if(data == "bad")
                {
                  document.getElementById("usernotes").className="ggLog-eu-notes";
                  document.getElementById("usernotes").innerHTML = "This email has already been taken.";
                }
                else {
                  document.getElementById("usernotes").className="ggLog-hide";
                  document.getElementById("usernotes").innerHTML="";
                }
                ubusy = false;
            });
          }
        }
        setSubmitButton();
      });
      $("#password").on("input", function(){
        if($("#password").val().length < 5) {
          document.getElementById("passnotes").className="ggLog-eu-notes";
          document.getElementById("passnotes").innerHTML = "Not long enough.";
        }
        else {
          document.getElementById("passnotes").className="ggLog-hide";
          document.getElementById("passnotes").innerHTML = "";
        }
        setSubmitButton();
      });
    });
    </script>
  </head>

  <body onLoad="bload()">
    <?php require_once("navbar.php"); navbar("register.php"); ?>
    <h1 class="text-center">Make an account</h1>
    <br />
    <div id="formContainer" class="ggLog-hide">
      <form action="register.php" method="post">
        <?php
        if($error != false)
        { ?>
          <div style="width:90%;background-color:#FFAA99;margin: 0 auto;display:block;border:2px solid #661111;">
            <b>Error: </b> <?php echo $error; ?>
          </div>
          <?php } ?>
        <div style="float:left;">Email: </div>
        <div style="float:left;width:50%;"><input type="text" name="email" id ="email" class="form-control" /></div><div class="ggLog-hide" id="emailnotes"></div><br style="clear:both;" /><br />
        <div style="float:left;">Username: </div>
        <div style="float:left;width:50%;"><input type="text" name="username" id="username" class="form-control" /></div><div class="ggLog-hide" id="usernotes"></div><br style="clear:both;" /><br />
        <div style="float:left;">Password: </div>
        <div style="float:left;width:50%;"><input type="password" name="password" id="password" class="form-control" /></div><div class="ggLog-hide" id="passnotes"></div><br style="clear:both;" /><br />
        <br style="clear:both;" /><br />
        <div class="ggLog-submit-cont" id="submitbutton">
          <input type="submit" id="submb" value="Register" class="form-control" />
        </div>
      </form>
      <span style="color:#776600;">Already have an account?  Login <a href="login.php">here</a></span>
    </div>
  </body>
</html>
