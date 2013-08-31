<!DOCTYPE html>
<html>
  <head>
    <title>New Page</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <style type="text/css">
      h1, h2, h3, h4, h5, h6
      {
      text-align:center; font-weight:900;
      }
    </style>
  </head>
  
  <body>
    <?php require_once("navbar.php"); navbar("index.php"); ?>
    <h1 class="text-center">ggLog</h1>
    <p class="text-center"><b>A running log for the rest of us.</b></p>
    <p class="text-center">ggLog is an online running log for those of us who simply:<br></p>
    <p></p>
    <ul>
      <li class="text-left">Don't like writing things down</li>
      <li class="text-left">Don't want to hassle with papers and remembering to write down things everyday</li>
      <li class="text-left">Spend a lot of time on our devices</li>
      <li class="text-left">Run a lot</li>
    </ul>
    <p class="text-center">If this sounds like you, then feel free to jump in. Click the <a href="demo.php"><b>Logs</b></a>&nbsp;tab to get started.</p><br><br>
    <div style="display:block;margin-left:auto;margin-right:auto;width:900px;"><b><p class="text-center" style="font-size:1.5em">If you find a bug (problem) or have a suggestion, visit our logs page and post a new workout with your bug report or suggestion</p></b></div>
    <a class="btn btn-link" href="https://github.com/Jeak/ggLog">our Github :D</a>
    <p>Powered by <a href="http://twitter.github.io/bootstrap/">#Bootstrap</a></p>
    <div style="width:100%;"><a href="http://imgur.com/AYamMmn"><img style="display:block;margin-left:auto;margin-right:auto;" src="http://i.imgur.com/AYamMmn.png" title="Hosted by imgur.com" /></a></div>
  </body>
</html>
