<!doctype html>
<html>
<head>
  <title>ggLog Installation</title>
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <style>
  body, html
  {
    width:100%;
  }
  div.cent
  {
    max-width:600px;
    display:block;
    margin-left:auto;
    margin-right:auto;
    margin-top:40px;
  }
  </style>
</head>
<body>
  <div class="cent">
  <img src="logo.png" style="height:39px;display:block;margin-left:auto;margin-right:auto;" />
  <?php
    function clearboth()
    {
      echo "<br style=\"clear:both\" />";
    }

    if(isset($_GET['part']))
    {
      if($_GET['part'] == "1")
      {
        $errors = false;
        
      //return new PDO("mysql:host=" . GG_HOST . ";dbname=" . GG_DATABASE, GG_USERNAME, GG_PASSWORD );
        $pdo = null;
        try { // Check if the 
          $pdo = new PDO("mysql:host=" . $_POST['dbhost'] . ";dbname=" . $_POST['dbname'], $_POST['dbuser'], $_POST['dbpass']);
        }
        catch (PDOException $e)
        {
          echo "<b>Connection error: " . $e->getMessage();
          echo "\n<br /><a href=\"index.php\">Go back</a><br /></b>";
          $errors=true;
        }
        require_once("../config.php");
        if($errors==false)
        {
          $t = $pdo->query('SHOW TABLES');
          $tbls = array();
          while($row = $t->fetch(PDO::FETCH_NUM))
            $tbls[] = $row;
          $prfx = $_POST['dbprfx'];
          foreach($tbls as $tblname)
          {
            if(strlen($tblname[0]) >= strlen($prfx) && $prfx == substr($tblname[0], 0, strlen($prfx)))
            {
              echo "<b>Prefix $prfx is already used.  <br /><a href=\"index.php\">Go back</a><br /></b>";
              $errors=true;
              break;
            }
          }
        }
        if($errors==false)
        {
          $prfx = $_POST['dbprfx'];
          $stm = "CREATE TABLE $prfx" . "users(" .
          "PID INTEGER AUTO_INCREMENT PRIMARY KEY, " . 
          "username TINYTEXT, " . 
          "password TINYTEXT" . 
          ")";
          echo $stm;
          $pdo->exec($stm);
        }
      }
    }
    else
    { // First run.
      echo "<h2>Welcome to the famous 5-hour ggLog Installation!</h2>";
      echo "<p>We will only need to set up database info.</p>";

      echo "<form action=\"index.php?part=1\" method=\"post\">\n";
      echo "<div style=\"float:left;\">Database name: </div>";
      echo  "<div style=\"float;width:300px;\"><input type=\"text\" name=\"dbname\" value=\"ggLog\" class=\"form-control\" /></div>";
      clearboth();
      echo "<div style=\"float:left;\">Database hostname: </div>";
      echo "<div style=\"float;width:300px;\"><input type=\"text\" name=\"dbhost\" value=\"localhost\" class=\"form-control\" /></div>";
      clearboth();
      echo "<div style=\"float:left;\">Database user: </div>";
      echo "<div style=\"float;width:300px;\"><input type=\"text\" name=\"dbuser\" class=\"form-control\" /></div>";
      clearboth();
      echo "<div style=\"float:left;\">Database password: </div>";
      echo "<div style=\"float;width:300px;\"><input type=\"text\" name=\"dbpass\" class=\"form-control\" /></div>";
      clearboth();
      echo "<div style=\"float:left;\">Table prefix for this installation: </div>";
      echo "<div style=\"float;width:300px;\"><input type=\"text\" name=\"dbprfx\" value=\"gg_\" class=\"form-control\" /></div>";
      clearboth();
      echo "<div style=\"width:150px;display:block;margin-left:auto;margin-right:auto;\"><input type=\"submit\" class=\"form-control\" value=\"Continue\" /></div>";
      clearboth();
      
      echo "</form>"; 
    }
  ?>
  </div>
</body>
</html>
