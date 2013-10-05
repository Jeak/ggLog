<!DOCTYPE html>
<html>
  <head>
    <title>ggLog</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="ggLogEssentials.js"></script>
    <script type="text/javascript" src="manageseasons.js"></script>
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
    </ul>
  </body>
</html>
