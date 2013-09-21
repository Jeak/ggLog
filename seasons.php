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
{  // if id=32, encoded id = 'seas32'
  $asstring = substr($enc, 4);
  return intval($asstring);
}

function encodeseasonid($id)
{
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

?>
