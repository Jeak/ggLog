<!doctype html>
<html style="width:100%;height:100%">
  <head>
    <title>Running Logs</title>
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="demo.css" />
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="ggLogEssentials.js"></script>
    <script type="text/javascript" src="demo.js"></script>
    <script type="text/javascript" src="loginstuff.js"></script>
  </head>
  <body style="width:100%;height:100%;" onLoad="demoload();">
    <div style="display:block;top:0;right:0;text-align:right;padding-bottom:0;z-index:1;padding-right:10px;" id="userstuff">
      <span class="badge" style="font-weight:900;background-color:#a00;" id="useralerts" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Warnings" data-content="Get more sleep.">1</span>
      <span id="userinfo"> Logged on as <a style="position:relative;" href="javascript:switchuser();">David B.</a> | <a href="javascript:switchuser();">Switch user</a></span>
    </div> 
    <input type="hidden" id="usernumber" value="0" />
    <?php require_once("navbar.php"); navbar("demo.php"); ?>
    <div class="ggLog-hide" id="coverForNotices"></div>
    <?php // deal with $_POST requests
    require_once('workouts.php'); // adding/editing/deleting workouts
    require_once('seasons.php');
    require_once('datetime.php');

    // each html form has a <input type="hidden" name="submitting" value="__" />
    // which specifies what is happening
  if(isset($_POST['submitting']))
  {
    if($_POST['submitting'] == "newworkout") // for editing or creating a workout
    {
      $day= floatval($_POST['day']);
      $month= floatval($_POST['month']);
      $year= floatval($_POST['year']);
      $title= sanitize($_POST['title']);
      $distance= floatval($_POST['distance']);
      $h= intval($_POST['hours']);
      $m= intval($_POST['minutes']);
      $s= intval($_POST['seconds']);
      $notes= sanitize($_POST['notes']);
      //if we are editing a workout, it must pass a PID to specify which workout.
      //  If no PID is specified, a new one is created.

      if(isset($_POST['PID']) && $_POST['PID'] != "") // editing
        addworkout(intval($_POST['PID']), $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
      else // adding new workout
        addworkout(-1, $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
    }
    else if($_POST['submitting'] == "deleteworkout")
    {
      deleteworkout($_POST['PID']); // from workouts.php
    }
    else if($_POST['submitting'] == "season")
    {
      $beginday = intval($_POST['begin-day']);
      $beginmonth = intval($_POST['begin-month']);
      $beginyear = intval($_POST['begin-year']);
      $endday = intval($_POST['end-day']);
      $endmonth = intval($_POST['end-month']);
      $endyear = intval($_POST['end-year']);
      $name = sanitize($_POST['seasonname']);
      if(isset($POST_['id']) && $_POST['id'] != "") // editing
      {
        $PID = decodeseasonid($_POST['id']);
        addseason($PID, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
      }
      else //new
        addseason(-1, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
    }
    else if($_POST['submitting'] == "deleteseason")
    {
      // $_POST['id'] is in the format "seas12", so $PID = int(12)
      // done to differentiate from workout IDs
      $PID = decodeseasonid($_POST['id']); // seasons.php
      deleteseason($PID);
    }
  }
    ?>
    <div style="positition:relative;margin-top:15px;width:100%;height:50px;">
      <div class="btn-group" style="display:block;width:400px;margin-left:auto;margin-right:auto;">
        <button type="button" class="btn btn-default" style="" onclick="javascript:newworkout();">New Workout</button>
        <button type="button" class="btn btn-default" onclick="viewseasons();">Seasons</button>
      </div>
    </div>
    <div class="ggLog-hide" id="editseasons">
      <div class="ggLog-centerseasons">
        <a href="manageseasons.php" style="margin-left:30px;">Manage seasons</a>
        <ul class="list-group" style="margin-top:15px;width:519px;max-height:350px;overflow:auto;">
          <a href="javascript:editseason('edit', 'pid')" class="none"><li class="list-group-item" id="pid" onmouseover="mouseoverseason('pid');" onmouseout="mouseoffseason('pid');"><span style="color:#00F">450mi</span> Summer Training (nonfunctional Example) <span class="badge">Jun 23 2013 to Sep 17 2013</span><span class="ggLog-hide" id="pid-edit"></span></li></a>
          <?php // listing seasons
          require_once("seasons.php");
          
          echo listseasons(false);
          ?>
        </ul>
      </div>
    </div>
    <div class="ggLog-hide" id="addworkoutdesktop">
      <div class="ggLog-center">
        <form action="demo.php" method="post" class="form-inline">
          <input type="hidden" name="submitting" value="newworkout" />
          <p class="text-center"><b><span style="color:red">New</span> <span id="workoutname">Untitled Workout</span></b></p>
          <div style="position:relative;height:35px;width:100%;">
            <div style="position:absolute;top:0;left:0;"><label>Title:</label> 
			<input type="text" style="width:250px;" class="form-control" name="title" maxlength="39" id="ggLogwn" onkeyup="changewn();"  value="" /></div>
            <div style="position:absolute;top:0;right:0;" id="datesdrop">
            </div>
          </div>
          <div style="position:relative;width:100%;height:170px;top:0">
            <div style="position:absolute;top:0;left:0;width:420px;">
              <p class="text-center"><b>Workout notes:</b></p>
              <textarea style="width:400px;height:120px;" class="form-control" name="notes" maxlength="250" ></textarea>
            </div>
            <div style="position:absolute;top:0;right:0;width:160px;height:170px">
              <div style="position:relative;top:35px;right:0;width:160px;height:35px;">
                <label> Distance:</label>
                <input type="text" class="form-control" name="distance" maxlength = "3" style="width:90px" placeholder="Distance" />
              </div>
              <div style="position:relative;top:50px;right:0;width:160px;height:35px;">
                <label>Time:</label>
                <input type="text" name="hours" maxlength = "2" style="width:20px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="h"/> :
                <input type="text" name="minutes" maxlength = "2" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="m" /> :
                <input type="text" name="seconds" maxlength = "2" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="s"/>
              </div>
            </div>
          </div>
          <div style="position:relative;width:100%;height:35px;top:0">
            <div style="display:block;margin-left:auto;margin-right:auto;width:200px" >
              <input type="submit" class="form-control" value="save" style="width:60px;" />
              <button onClick="closenewworkout(); return false;" class="form-control" style="width:60px;" >cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="ggLog-hide" id="addworkoutmobile">
      Mobile version under construction...</span>
      <!-- Probably would be better if the mobile site was at a different url -->
    </div>
    <div style="position:relative;height:20px;top:0;width:100%;">
      <h1 class="text-center">Recent Workouts</h1>
      <hr class="ggLog-partial" style="clear:both;"/>
      <div class="ggLog-center-90">
        <div style="position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;"> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="javascript:deleteworkout(-1)" class="editworkoutlink"><span class="glyphicon glyphicon-trash"></span></a><span style="padding-left:25px;">Jun 24 2013</span><span style="padding-left:35px;">Feel free to post a workout!</span></div>
        <div style="position:relative;top:0;left:0;width:100%;">
          <div style="float:left;width:500px;margin-bottom:25px;">Help us find bugs (problems with this website) by testing out the site!  If you find a problem or have a suggestion to make this project better, either report it at <a href="https://github.com/Jeak/ggLog/issues?state=open">our github page</a> (account needed), or post a workout here describing the problem/suggestion. </div>
          <div style="float:left;width:120px;margin-bottom:25px;margin-left:10px">
            <div class="runspecs">
              <span id="idnumber-distance" style="font-size:1.3em;color:#888">5</span> miles
            </div>
            <div class="runspecs">
              <span id="idnumber-distance" style="font-size:1.3em;color:#888">7:40</span> min/mi
            </div>
          </div>
          <div style="float:left;width:120px;">
            <div class="runspecs"><span id="idnumber-time" style="font-size:1.3em;color:#888">1:04:24</span></div>
          </div>
        </div>
      </div>
      <hr class="ggLog-partial" style="clear:both;" />
        <a href="astext.txt" style="text-align:center;display:block;width:100%;" download>Download my workouts as a text file.</a>
        <hr class="ggLog-partial" style="clear:both;" />
        <?php
        require_once("workouts.php");
        require_once("seasons.php");
        displayWeeklyDistances(true);
        displayworkouts(true, 0, 20);
        ?>
        <button class="btn btn-default" style="display:block;margin-left:auto;margin-right:auto;margin-bottom:15px;" onclick="loadmore();" id="loadmorebutton">Load More</button>
        <input type="hidden" id="numberloaded" value="20" />
    </div>
  </body>
</html>
