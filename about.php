<!DOCTYPE html>
<html>
  <head>
    <title>About</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/ggLogEssentials.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="js/ggLogEssentials.js"></script>

    <style type="text/css">
      h1, h2, h3, h4, h5, h6
      { text-align:center; font-weight:900; }

    </style>
  </head>

  <body>
    <?php require_once("navbar.php"); navbar("about.php"); ?>
    <div style="display:block;width:160px;margin-left:auto;margin-right:auto;">
    </div>
    <h4> Loaded from <a href="https://github.com/Jeak/ggLog">our github</a> <br /> in Markdown </h4>
    <div style="max-width:900px;margin-left: auto;margin-right: auto;margin-top:40px;margin-bottom:30px;border: 1px solid #555;padding:10px;border-radius:10px;background-color:#DDC">
    <?php
      $stuff = file_get_contents('https://raw.github.com/Jeak/ggLog/master/README.md');
      file_put_contents("README.md", $stuff);
      exec("perl Markdown.pl README.md > about.inf");
      echo file_get_contents('about.inf');
    ?>
    </div>
  </body>
</html>
