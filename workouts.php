<?php

require_once('datetime.php');

/*/////////////////////
     ADDING WORKOUTS
*//////////////////////

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

function deleteworkout($PID) // $PID as a string
{
  $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
  if (!$dbhandle) die ($error);
  
  $results = sqlite_query($dbhandle, "SELECT PID FROM workouts");
  $found = false;
  while ($row = sqlite_fetch_array($results, SQLITE_NUM)) // keep this?  it probably uses time & resources
  {
    if(intval($PID == intval($row[0])))
    {
      $found = true;
      break;
    }
  }

  $stm = "DELETE FROM workouts WHERE PID=" . $PID;
  if($found == true)
  {
    sqlite_exec($dbhandle, $stm, $error);
  }
  //[RELEASE] for the release, replace with @sqlite_exec() to surpress errors
  
  sqlite_close($dbhandle);
}

/*//////////////////////////////////////////
        DISPLAYING WORKOUTS
/*//////////////////////////////////////////
require_once("datetime.php");

function displayworkouts()
{
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
}

?>
