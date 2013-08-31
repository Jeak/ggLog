
<!DOCTYPE html>
<html>
  <head>
    <title>New Page</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/3.0.0/css/bootstrap-combined.min.css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    <style type="text/css">
      h1, h2, h3, h4, h5, h6
      { text-align:center; font-weight:900; }
      
    </style>
  </head>
  
  <body>
    <?php require_once("navbar.php"); navbar("about.php"); ?>
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
