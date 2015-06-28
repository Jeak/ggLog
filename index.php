<!DOCTYPE html>
<html>
  <head>
    <title>ggLog</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="ggLogEssentials.js"></script>
    <script type="text/javascript">
      function bload()
      {
        if(IsMobileBrowser())
        {
          document.getElementById("bugnote").className = "bugnoteMobile";
          document.getElementById("donbosco").className = "donBoscoMobile";
        }
      }
    </script>
  </head>
  
  <body onLoad="bload()">
    <?php require_once("navbar.php"); navbar("index.php"); ?>
    <h1 class="text-center">ggLog</h1>
    <p class="text-center"><b>A running log for the rest of us.</b></p>
	<a class="text-center"; href="http://pastehtml.com/view/dg0vqgaa5.html"><strong>IMPORTANT ANNOUNCEMENT</strong></a>
    <p class="text-center">ggLog is an online running log for those of us who simply:<br></p>
    <p></p>
    <ul>
      <li class="text-left">Don't like writing things down</li>
      <li class="text-left">Don't want to hassle with papers and remembering to write down things everyday</li>
      <li class="text-left">Spend a lot of time on our devices</li>
      <li class="text-left">Run a lot</li>
    </ul>
    <p class="text-center">If this sounds like you, then feel free to jump in. Click the <a href="demo.php"><b>Logs</b></a>&nbsp;tab to get started.</p><br><br>
    <div class="bugnoteDesktop" id="bugnote"><b><p class="text-center" style="font-size:1.5em">If you find a bug (problem) or have a suggestion, visit our logs page and post a new workout with your bug report or suggestion</p></b></div>
    <a class="btn btn-link" href="https://github.com/Jeak/ggLog">our Github :D</a>
    <p>Powered by <a href="http://twitter.github.io/bootstrap/">#Bootstrap</a></p>
    <div style="width:100%;"><a href="http://imgur.com/AYamMmn"><img class="donBoscoDesktop" src="http://i.imgur.com/AYamMmn.png" title="Hosted by imgur.com" id="donbosco" /></a></div>
  </body>
</html>
