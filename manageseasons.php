<!DOCTYPE html>
<html>
  <head>
    <title>Seasons</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="ggLogEssentials.js"></script>
    <script type="text/javascript" src="manageseasons.js"></script>
    <script type="text/javascript" src="flot/jquery.flot.min.js"></script>
    <script type="text/javascript" src="flot/jquery.flot.categories.min.js"></script>
    <link rel="stylesheet" href="demo.css" />
  </head>
  
  <body>
    <?php require_once("navbar.php"); navbar("demo.php"); ?>
    <h1 class="text-center">Seasons</h1>
    <ul class="list-group" style="max-width:800px;display:block;margin-left:auto;margin-right:auto;">
      <?php
      require_once("seasons.php");
      
      echo listseasons(false);
      ?>   

      <li class="list-group-item" style="background-color:#EEFFEE"><a href="#">Add a season</a></li>
    </ul>
    <h2 class = "text-center">Analysis test</h2>
    <h4 class = "text-center">Day-of-the-week analysis</h4>
    <div id="chartloc" style="display:block;margin-left:auto;margin-right:auto;width:750px;background-color:#eef;height:200px;"></div>
    
  </body>
</html>
