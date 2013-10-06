<?php

require_once('datetime.php');
require_once("weeks.php");

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

function deleteseason($PID)
{
  $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
  if (!$dbhandle) die ($error);
  
  sqlite_exec($dbhandle, "DELETE FROM seasons WHERE PID=$PID");
  
  sqlite_close($dbhandle);
}
    
function decodeseasonid($enc)
{ 
  //season IDs are differentiated from workout IDs with the prefix, "seas".
  // if $enc="seas32", it returns int(32)
  $asstring = substr($enc, 4);
  return intval($asstring);
}

function encodeseasonid($id)
{
  //season IDs are differentiated from workout IDs with the prefix, "seas".
  return "seas" . $id;
}

function seasondistances($workouts, $seasons)
{
  $beginloc = 2;
  $endloc = 3;

  $dateloc = 0;
  $distloc = 1;

  $seasonweeks = array();
  foreach($seasons as $season) // create new (weekManage)s which are constrained to the dates within the corresponding season
  {
    $begin = strtotime($season[$beginloc]);
    $end = strtotime($season[$endloc]);
    $seasonmanage = new weekManage();
    $seasonmanage->constrain($begin, $end);
    $seasonweeks[] = $seasonmanage;
  }

  $seasondists = array();
  foreach($seasonweeks as $seasonweek)
  {
    foreach($workouts as $workout) // input every single workout into every single seasonweeks (weekManage)
    {                              //   and it will automatically have to check to see whether it's within range
      $day = strtotime($workout[$dateloc]);
      $seasonweek->addmiles($day, $workout[$distloc]);
    }
    $seasondists[] = $seasonweek->totaldistance();
  }
  return $seasondists;
}

function listseasons($echoResults = false) // if true, will also echo seasons
{
  $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
  if (!$dbhandle) die ($error);
  $fulllist = "";

  $allworkouts;
  $results = sqlite_query($dbhandle, "SELECT rundate, distance, runtime, PID FROM workouts");
  while($row = sqlite_fetch_array($results, SQLITE_NUM))
  {
    $allworkouts[] = $row;
  }
  
  $allseasons;
  $results = sqlite_query($dbhandle, "SELECT PID, name, begindate, enddate FROM seasons");
  while($row = sqlite_fetch_array($results, SQLITE_NUM))
    $allseasons[] = $row;

  $distances = seasondistances($allworkouts, $allseasons);
  
  for($i=0;$i<count($allseasons);++$i)
  {
    $pid = $allseasons[$i][0];
    $idval = "seas" . $pid;
    $out = "";
    $out .= "<a href=\"javascript:editseason('edit','$idval')\" class=\"none\">";

    $out .= "  <li class=\"list-group-item\" id=\"" . $idval .  "\" onmouseover=\"mouseoverseason('" . $idval . "');\""; 
      $out .= " onmouseout=\"mouseoffseason('" . $idval . "');\">";
    $out .= "<span style=\"color:#00F;\">" . $distances[$i] . "mi</span> ";
    $out .= stripslashes($allseasons[$i][1]) . " ";
    
    $out .= "<span class=\"badge\">";
    $out .= date('M j Y', strtotime($allseasons[$i][2]));
    $out .= " to ";
    $out .= date('M j Y', strtotime($allseasons[$i][3]));
    $out .= "</span>";

    $out .= "<span class=\"ggLog-hide\" id=\"$idval-edit\"></span>";
    
    $out .= "  </li>";
    $out .= "</a>";
    
    $fulllist .= $out;
  }
  sqlite_close($dbhandle);
  
  if($echoResults == true)
    echo $fulllist;
  
  return $fulllist;
}
function displayWeeklyDistances($echoResults = true)
{
  $output;
  $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
  if (!$dbhandle) die ($error);

  $result = sqlite_query($dbhandle, "SELECT rundate, title, distance, runtime, notes, PID FROM workouts");
  $data = array();
  while ($row = sqlite_fetch_array($result, SQLITE_NUM))
  {
    $data[] = $row;
  }

  sqlite_close($dbhandle);
  
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
  $output .= "<div style=\"width:700px;display:block;margin-left:auto;margin-right:auto;\">\n";
  if(true)
  {
    $tdist = $wm->totaldistance();
    $ttime = $wm->totaltime();
    $output .= "<span style=\"color:#7A7;font-size:1.5em;\"> All Time: " . $tdist .  " miles in ";
    $output .= secondstotime($ttime) . " (" . speed($ttime, $tdist) .  " pace)</span><br /><br />";
  }
  foreach($orderedweeks as $thisweek)
  {
    $output .= "<span style=\"color:#999;font-size:1.5em;\">";
    $output .= date('M j Y', $thisweek[0]) . " to ";
    $output .= date('M j Y', $thisweek[1]);
    $output .= " with " . $thisweek[2];
    $output .= " miles in " . secondstotime($thisweek[3]);
    $output .= " (avg " . speed($thisweek[3], $thisweek[2]) . ")";
    $output .= "</span><br />\n";
  }
  $output .= "</div>\n";
  $output .= "<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";

  if($echoResults == true)
  {
    echo $output;
  }
  
  return $output;
}

?>
