
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
  </head>
  <body style="width:100%;height:100%;" onLoad="demoload();">
    <?php require_once("navbar.php"); navbar("demo.php"); ?>
    <div class="ggLog-hide" id="coverForNotices"></div>
    <?php
/*    $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
    if (!$dbhandle) die ($error);
    sqlite_exec($dbhandle, "DELETE FROM workouts", $error);
    sqlite_close($dbhandle);*/

    function createsqldate($year, $month, $day)
    {
      $rundate="$year-";
      if($month < 10)
        $rundate.="0";
      $rundate.="$month-";
      if($day < 10)
        $rundate.="0";
      $rundate.="$day";
      if(!checkdate($month, $day, $year))
        return false;
      return $rundate;
    }

    function createsqltime($hours, $minutes, $seconds)
    {
      $runtime="$hours:";
      if($minutes < 10)
        $runtime.="0";
      $runtime.="$minutes:";
      if($seconds < 10)
        $runtime.="0";
      $runtime.="$seconds";
      return $runtime;
    }

    function decodeseasonid($enc)
    {  // if id=32, encoded id = 'seas32'
      $asstring = substr($enc, 4);
      return intval($asstring);
    }

    function encodeseasonid($id)
    {
      return "seas" . $id;
    }

    function addseason($PID = -1, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday)
    {
      $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
      if (!$dbhandle) die ($error);
      
      $begindate = createsqldate($beginyear, $beginmonth, $beginday);
      $enddate = createsqldate($endyear, $endmonth, $endday);
      
      if($begindate != false && $enddate != false)
      {
        $command = "";
        if($PID == -1)
        {
          $command = "INSERT INTO seasons(name, begindate, enddate) ".
            "VALUES('$name', '$begindate', '$enddate');";
        }
        else if($PID != -1)
        {
          $command = "UPDATE seasons ".
            "SET name='$name', begindate='$begindate', enddate='$enddate' WHERE PID=$PID";
        }
        sqlite_exec($dbhandle, $command, $error);
      }
      else
        echo "Incorrect dates $beginyear, $beginmonth, $beginday; $endyear, $endmonth, $endday";
      sqlite_close($dbhandle);
    }
    
    function addworkout($PID = -1, $year, $month, $day, $title, $distance, $h, $m, $s, $notes)
    {
      $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
      if (!$dbhandle) die ($error);
      
      $works = true;
      
      $rundate = createsqldate($year, $month, $day);
      if($rundate == false)
        $works = false;
      
      $runtime = createsqltime($h, $m, $s);

      if($works == true)
      {
        if($PID < 0)
        {
          $stm = "INSERT INTO workouts(rundate, title, distance, runtime, notes, PID) ". // pass NULL to PID to make it auto increment
          "VALUES('$rundate', '$title', $distance, '$runtime', '$notes', NULL)";
          sqlite_exec($dbhandle, $stm, $error);
        }
        else
        {
          $stm = "UPDATE workouts ".
          "SET rundate='$rundate', title='$title', distance=$distance, runtime='$runtime', notes='$notes' ".
          "WHERE PID=$PID";
          sqlite_exec($dbhandle, $stm, $error);
        }
      }
      sqlite_close($dbhandle);
    }

    if($_POST['submitting'] == "editworkout")
    {
      $day= floatval(sqlite_escape_string($_POST['day']));
      $month= floatval(sqlite_escape_string($_POST['month']));
      $year= floatval(sqlite_escape_string($_POST['year']));
      $title= sqlite_escape_string($_POST['title']);
      $distance= floatval(sqlite_escape_string($_POST['distance']));
      $h= intval(sqlite_escape_string($_POST['hours']));
      $m= intval(sqlite_escape_string($_POST['minutes']));
      $s= intval(sqlite_escape_string($_POST['seconds']));
      $notes= sqlite_escape_string($_POST['notes']);
      addworkout(intval($_POST['PID']), $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
    }
    else if($_POST['submitting'] == "deleteworkout")
    {
      $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
      if (!$dbhandle) die ($error);
      
      $results = sqlite_query($dbhandle, "SELECT PID FROM workouts");
      $found = false;
      while ($row = sqlite_fetch_array($results, SQLITE_NUM)) // keep this?  it probably uses time & resources
      {
        if(intval($_POST['PID']) == intval($row[0]))
        {
          $found = true;
          break;
        }
      }

      $stm = "DELETE FROM workouts WHERE PID=" . $_POST['PID'];
      if($found == true)
      {
        sqlite_exec($dbhandle, $stm, $error);
      }
      //[RELEASE] for the release, replace with @sqlite_exec() to surpress errors
      
      sqlite_close($dbhandle);
    }
    else if($_POST['submitting'] == "newworkout")
    {
      $day= floatval(sqlite_escape_string($_POST['day']));
      $month= floatval(sqlite_escape_string($_POST['month']));
      $year= floatval(sqlite_escape_string($_POST['year']));
      $title= sqlite_escape_string($_POST['title']);
      $distance= floatval(sqlite_escape_string($_POST['distance']));
      $h= intval(sqlite_escape_string($_POST['hours']));
      $m= intval(sqlite_escape_string($_POST['minutes']));
      $s= intval(sqlite_escape_string($_POST['seconds']));
      $notes= sqlite_escape_string($_POST['notes']);
      addworkout(-1, $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
    }
    else if($_POST['submitting'] == "season")
    {
      $beginday = intval(sqlite_escape_string($_POST['begin-day']));
      $beginmonth = intval(sqlite_escape_string($_POST['begin-month']));
      $beginyear = intval(sqlite_escape_string($_POST['begin-year']));
      $endday = intval(sqlite_escape_string($_POST['end-day']));
      $endmonth = intval(sqlite_escape_string($_POST['end-month']));
      $endyear = intval(sqlite_escape_string($_POST['end-year']));
      $name = sqlite_escape_string($_POST['seasonname']);
      if($_POST['id'] != "")
      {
        $PID = decodeseasonid($_POST['id']);
        addseason($PID, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
      }
      else
      {
        addseason(-1, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
      }
    }
    ?>
    <div style="positition:relative;margin-top:15px;width:100%;height:50px;">
      <div class="btn-group" style="display:block;width:400px;margin-left:auto;margin-right:auto;">
        <button type="button" class="btn btn-default" style="" onclick="javascript:newworkout();">New Workout</button>
        <button type="button" class="btn btn-default" onclick="">Seasons</button>
      </div>
    </div>
    <div class="ggLog-newworkout" id="editseasons">
      <div class="ggLog-center" style="background-color:#FFF;">
        <a href="javascript:editseason('new');" style="margin-left:30px;">New season</a>
        <ul class="list-group" style="margin-top:15px;width:475px;max-height:350px;overflow:auto;">
          <a href="javascript:editseason('edit', 'pid')" class="none"><li class="list-group-item" id="pid" onmouseover="mouseoverseason('pid');" onmouseout="mouseoffseason('pid');">Summer Training (Example) <span class="badge">Jun 23 2013 to Sep 17 2013</span><span class="ggLog-hide" id="pid-edit"></span></li></a>
          <?php
          $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
          if (!$dbhandle) die ($error);

//          sqlite_exec($dbhandle, "UPDATE seasons SET begindate = '2013-05-17', enddate='2013-08-18' WHERE name='Summer Training 2013'");
          
          $results = sqlite_query($dbhandle, "SELECT PID, name, begindate, enddate FROM seasons");
          while($row = sqlite_fetch_array($results, SQLITE_NUM))
          {
            $pid = $row[0];
            $idval = "seas" . $pid;
            $out = "";
            $out .= "<a href=\"javascript:editseason('edit','$idval')\" class=\"none\">";
  
            $out .= "  <li class=\"list-group-item\" id=\"" . $idval .  "\" onmouseover=\"mouseoverseason('" . $idval . "');\""; 
              $out .= " onmouseout=\"mouseoffseason('" . $idval . "');\">";
            $out .= stripslashes($row[1]) . " ";
            
            $out .= "<span class=\"badge\">";
            $out .= date('M j Y', strtotime($row[2]));
            $out .= " to ";
            $out .= date('M j Y', strtotime($row[3]));
            $out .= "</span>";
  
            $out .= "<span class=\"ggLog-hide\" id=\"$idval-edit\"></span>";
            
            $out .= "  </li>";
            $out .= "</a>";
            
            echo $out;
          }
          
          sqlite_close($dbhandle);
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
            <div style="position:absolute;top:0;left:0;"><label>Title:</label> <input type="text" style="width:250px;" class="form-control" name="title" id="ggLogwn" onkeyup="changewn();"  value="" /></div>
            <div style="position:absolute;top:0;right:0;" id="datesdrop">
            </div>
          </div>
          <div style="position:relative;width:100%;height:170px;top:0">
            <div style="position:absolute;top:0;left:0;width:420px;">
              <p class="text-center"><b>Workout notes:</b></p>
              <textarea style="width:400px;height:120px;" class="form-control" name="notes"></textarea>
            </div>
            <div style="position:absolute;top:0;right:0;width:160px;height:170px">
              <div style="position:relative;top:35px;right:0;width:160px;height:35px;">
                <label> Distance:</label>
                <input type="text" class="form-control" name="distance" style="width:90px" placeholder="Distance" />
              </div>
              <div style="position:relative;top:50px;right:0;width:160px;height:35px;">
                <label>Time:</label>
                <input type="text" name="hours" style="width:20px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="h"/> :
                <input type="text" name="minutes" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="m" /> :
                <input type="text" name="seconds" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="s"/>
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
      Mobile version under construction...
      <!-- Probably would be better if the mobile site was at a different url -->
    </div>
    <div style="position:relative;height:20px;top:0;width:100%;">
      <h1 class="text-center">Recent Workouts</h1>
      <hr class="ggLog-partial" style="clear:both;"/>
      <div class="ggLog-center-90">
        <div style="position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;"> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="javascript:deleteworkout(-1)" class="editworkoutlink"><span class="glyphicon glyphicon-trash"></span></a> &nbsp; &nbsp; Jun 24 2013 &nbsp; &nbsp; &nbsp; &nbsp; Feel free to post a workout!</div>
        <div style="position:relative;top:0;left:0;width:100%;">
          <div style="float:left;width:500px;margin-bottom:25px;">Help us find bugs (problems with this website) by testing out the site!  If you find a problem or have a suggestion to make this project better, either report it at <a href="https://github.com/Jeak/ggLog/issues?state=open">our github page</a> (account needed), or post a workout here describing the problem/suggestion.</div>
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
      <div class="ggLog-center-90"><form class="form-inline">
        <div style="position:relative;top:0;left:-40px;width:100%;height:30px;color:#000;font-size:1em;"> <div style = "position:absolute;top:0;left:40px;" id="PID--1drop">-----</div> <div style="position:absolute;top:0;left:350px;"><label>Title: </label><input type="text" value="Feel free to post a workout!" class="form-control" style="width:200px" name="title" /></div></div>
        <div style="position:relative;top:0;left:0;width:100%;">
          <div style="float:left;width:500px;margin-bottom:25px;"><textarea class="form-control" style="margin-top:20px;width:480px;height:120px;">Help us find bugs (problems with this website) by testing out the site!  If you find a problem or have a suggestion to make this project better, either report it at <a href="https://github.com/Jeak/ggLog/issues?state=open">our github page</a> (account needed), or post a workout here describing the problem/suggestion.</textarea></div>
          <div style="float:left;width:120px;margin-bottom:25px;margin-left:10px">
            <div class="runspecs">
              <input type="text" class="form-control" style="margin-top:5px;padding-left:3px;padding-right:3px;width:40px;" name="distance" value="5"> miles
            </div>
          </div>
          <div style="float:left;width:120px;">
            <div class="runspecs">
                <input type="text" name="hours" value="1" style="width:20px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="h"/> :
                <input type="text" name="minutes" value="04" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="m" /> :
                <input type="text" name="seconds" value="24" style="width:25px;padding-left:3px;padding-right:3px;" class="form-control" placeholder="s"/>
            </div>
          </div>
            <div style="float:left;width:230px;padding-left:10px;">
              <button class="form-control" style="width:55px;">save</button>
              <button class="form-control" style="width:55px;">cancel</button>
              <button class="form-control" style="width:55px;">delete</button>
            </div>
        </div></form>
      </div>
        <hr class="ggLog-partial" style="clear:both;" />
        <?php
        
        function timetoseconds($time)
        {
          $pieces = explode(":", $time);
          $timeint  = intval($pieces[0])*60*60;
          $timeint += intval($pieces[1])*60;
          $timeint += intval($pieces[2]);
          return $timeint;
        }
        function secondstotime($secs, $depth=3)
        {
          if($depth == 2)
          {
            $minutes = intval($secs/60);
            $seconds = intval($secs-$minutes*60);
            $out = "$minutes:";
            if($seconds < 10)
              $out.="0";
            $out.="$seconds";
            return $out;
          }
          else if($depth == 3)
          {
            $hours = intval($secs/3600);
            $minutes = intval(($secs-$hours*3600)/60);
            $seconds = intval($secs-$minutes*60-$hours*3600);
            $out = "$hours:";
            if($minutes < 10)
              $out.="0";
            $out .= "$minutes:";
            if($seconds < 10)
              $out.="0";
            $out.="$seconds";
            return $out;
          }
          return "";
        }
              //  'HH:MM:SS', double
              //or        S , double
        function speed($time, $distance)
        {
          if($distance != 0)
          {
            $timeint = $time; // for $time as seconds
            if(gettype($time) == 'string')
              $timeint = timetoseconds($time);
            $secpermile= intval($timeint/$distance);
            $out = secondstotime($secpermile, 2);
            return $out;
          }
          else return "0:00";
        }
        
        function htmlnewline($in)
        {
          return str_replace("\n", "<br />\n", $in);
        }

        function sortbydate(&$workouts, $location=0)
        {
          $dates = array();
          $found = array();
          $incr = 0;
          foreach( $workouts as $row )
          {
            $value;
            $exists = array_search($row[$location], $found);
            if($exists === false)
            {
              $value = $row[$location];
              $found[] = $row[$location];
            }
            else // if there's multiple entries with the same date, change it so you don't end up overriding anything
            {
              $value = $row[$location] . '-' . $incr;
            }
            $dates[] = $value; // ex: $dates[0] = '2013-06-24'
            ++$incr;
          }
          $dates = array_flip($dates); // ex: $dates['2013-06-24'] = 0;
          ksort($dates); // sort by the key (the date)
          $newworkouts = array();
          // makes array with only the date and the key of the original array.
          // sorts by date
          // changes the date to the key and the key of the original array to the value
          // reorders the workouts
          // example: $workouts = array(0 => array(... '2013-06-24' ...),  1 => array(... '2013-08-16 ... ));
          //          $dates = array(0 => '2013-06-24', 1=> '2013-08-16')
          //          $dates = array('2013-08-16' => 1, '2013-06-24' => 0) // which is eq. to $dates array(0=>1, 1=>0)
          //          $workouts[0] = $workouts[1]; $workouts[1] = $workouts[0]
          foreach( $dates as $loc )
          {
            $newworkouts[] = $workouts[$loc];
          }
          $workouts = $newworkouts;
        }
        
        $preface="      ";
        $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
        if (!$dbhandle) die ($error);

        /*            //  UNCOMMENT THIS TO DISPLAY ALL VALUES IN A TABLE
                      // -------------------------------------------------
        $result = sqlite_query($dbhandle, "SELECT * FROM workouts");
        echo "<table style=\"border:2px solid black;\">";
        while( $row = sqlite_fetch_array($result, SQLITE_NUM))
        {
          echo "<tr style=\"border:2px solid black;\">";
          foreach($row as $col)
          {
            echo "<td style=\"border:2px solid black;width:120px;\">" . $col . "</td>";
          }
          echo "</tr>";
        }
        echo "</table><br /><br /><br />";
        */
        
        $result = sqlite_query($dbhandle, "SELECT rundate, title, distance, runtime, notes, PID FROM workouts");
        $data = array();
        while ($row = sqlite_fetch_array($result, SQLITE_NUM))
        {
          $data[] = $row;
        }
        sortbydate($data);
        
        require_once('weeks.php');
        $wm = new weekManage();
        foreach($data as $workout)
        {
          $day = strtotime($workout[0]);
          $time = timetoseconds($workout[3]);
          $distance = $workout[2];
          $wm->addtime($day, $time);
          $wm->addmiles($day, $distance);
        }
//        $thisweek = $wm->get(time());
        $orderedweeks;
        foreach($wm->weeks as $week)
        {
          $orderedweeks[] = array($week->beginday, $week->endday, $week->distance, $week->time);
        }
        sortbydate($orderedweeks);
        echo "<div style=\"width:700px;display:block;margin-left:auto;margin-right:auto;\">\n";
        foreach($orderedweeks as $thisweek)
        {
          echo "<span style=\"color:#999;font-size:1.5em;\">";
          echo date('M j Y', $thisweek[0]) . " to ";
          echo date('M j Y', $thisweek[1]);
          echo " with " . $thisweek[2];
          echo " miles in " . secondstotime($thisweek[3]);
          echo " (avg " . speed($thisweek[3], $thisweek[2]) . ")";
          echo "</span><br />\n";
        }
        echo "</div>\n";
        echo "<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";
        
        for($i=count($data)-1;$i>=0;--$i)
        {
          $PID = $data[$i][5];
//          echo $PID;
          echo "$preface<div class=\"ggLog-center-90\" id=\"PID-" . $PID . "\">\n";
          
//          store hard-to-access data in hidden inputs
          echo "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "date\" value=\"" . $data[$i][0] . "\" />\n";
          echo "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "title\" value=\"" . $data[$i][1] . "\" />\n";

          echo "$preface  <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;\">\n";
//<a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-trash"> </span></a>
          echo "$preface  <a href=\"javascript:editworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>\n";
          echo "$preface  <a href=\"javascript:deleteworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
          echo " &nbsp; &nbsp; ";
          echo date("D M j Y", strtotime($data[$i][0])); // date
          echo "&nbsp; &nbsp; &nbsp; &nbsp; ";
          echo stripslashes($data[$i][1]); // title
          echo "</div>\n";

          echo "$preface  <div style=\"position:relative;top:0;left:0;width:100%;\">\n";
          
          echo "$preface    <div style=\"float:left;width:500px;margin-bottom:25px;\" id=\"PID-" . $PID . "notes\">";
          echo htmlnewline(stripslashes($data[$i][4])); // notes?
          echo "</div>\n";
          echo "$preface  </div>\n";

          echo "$preface  <div style=\"float:left;width:120px;border:1px;margin-bottom:25px;margin-left:10px\">\n";
          echo "$preface    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "distance\">";
          echo $data[$i][2]; // distance
          echo "</span> miles</div>\n";
          echo "$preface    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\">";
          echo speed($data[$i][3], $data[$i][2]);
          echo "</span> min/mi</div>\n";
          echo "$preface  </div>\n";
          
          echo "$preface  <div style=\"float:left;width:120px;\">";
          echo "<div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "time\">";
          echo $data[$i][3];  // time
          echo "</span></div>";
          echo "$preface  </div>\n";

          echo "$preface</div>\n";
          echo "$preface<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";
        }
  
        sqlite_close($dbhandle);
        ?>
    </div>
  </body>
</html>
