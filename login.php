<!DOCTYPE html>
<html>
  <head>
    <title>Login Page | ggLog.xyz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="ggLogEssentials.css">
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
      <form action="login.php" action="post">
        <div style="float:left;">Username: </div>
        <div style="float:left;width:50%;"><input type="text" name="username" class="form-control" /></div><br style="clear:both;" /><br />
        <div style="float:left;">Password: </div>
        <div style="float:left;width:50%;"><input type="password" name="username" class="form-control" /></div>
        <br style="clear:both;" /><br />
        <div class="ggLog-submit-cont" id="submitbutton">
          <input type="submit" value="Login" class="form-control" />
        </div>
      </form>
    </div>
  </body>
</html>
