<?php

require_once( __DIR__.'/../config.php');
require_once('datetime.php');
require_once("weeks.php");

function addseason($PID = -1, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday)
 // note that addseason can also edit seasons
 // If $PID == -1, then it will add a season
 // If a valid $PID is given, then it will edit the season with the corresponding $PID.
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $sname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_other";

    $begindate = ggcreatedate($beginyear, $beginmonth, $beginday);
    $enddate = ggcreatedate($endyear, $endmonth, $endday);

    if($begindate != false && $enddate != false)
    {
      $command = "";
      if($PID == -1)
      {
        $command = "INSERT INTO " . $sname . "(name, begindate, enddate) ".
          "VALUES(?, ?, ?)";
        $stmt = $pdo->prepare($command);
        $stmt->execute(array($name, $begindate, $enddate));
      }
      else if($PID != -1)
      {
        $command = "UPDATE " . $sname . " ".
          "SET name=?, begindate=?, enddate=? WHERE PID=?";
        $stmt = $pdo->prepare($command);
        $stmt->execute(array($name, $begindate, $enddate, $PID));
      }
    }
    else
      echo "Incorrect dates $beginyear, $beginmonth, $beginday; $endyear, $endmonth, $endday";
    $pdo = null;
  }
}

function deleteseason($PID)
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $sname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_other";

    $pdo->exec("DELETE FROM " . $sname . " WHERE PID=$PID");

    $pdo = null;
  }
}

function decodeseasonid($enc)
{
  //season IDs are differentiated from workout IDs with the prefix, "seas".
  // if $enc="seas32", it returns int(32)

  //Used because a javascript id will have "seas32" for example, while a PHP/SQL id will have only int(32)
  $asstring = substr($enc, 4);
  return intval($asstring);
}

function encodeseasonid($id)
{
  //season IDs are differentiated from workout IDs with the prefix, "seas".
  //See decodeseasonid($enc)
  return "seas" . $id;
}

function seasondistances($workouts, $seasons)
{
  $beginloc = "begindate";
  $endloc = "enddate";

  $dateloc = "rundate";
  $distloc = "distance";

  $seasondists = array();
  foreach($seasons as $season)
  {
    $begin = intval($season[$beginloc]);
    $end = intval($season[$endloc]);
    $thisSeasonDist = 0;
    foreach($workouts as $workout)
    {
      $day = intval($workout[$dateloc]);
      if(inrange($day, $begin, $end))
        $thisSeasonDist += $workout[$distloc];
    }
    $seasondists[] = $thisSeasonDist;
  }

  return $seasondists;
}

// These are dates as defined in 'weeks.php'.
function inrange($day, $begin, $end) {
  if($day < $end && $day > $begin)
    return true;
  //if(date('z Y', $day) == date('z Y', $begin))
  if($day == $begin)
    return true;
  //if(date('z Y', $day) == date('z Y', $end))
  if($day == $end)
    return true;
  return false;
}

function listseasons($echoResults = false) // if true, will also echo seasons
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $fulllist = "";
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_workouts";
    $sname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_other";

    $PIDloc = 'PID';
    $nameloc = 'name';
    $beginloc = 'begindate';
    $endloc = 'enddate';

    $allworkouts;
    $results = $pdo->query("SELECT rundate, distance, runtime, PID FROM " . $tname);
    while($row = $results->fetch(PDO::FETCH_ASSOC))
    {
      $allworkouts[] = $row;
    }

    $allseasons = array();
    $results = $pdo->query("SELECT PID, name, begindate, enddate FROM " . $sname);

    while($row = $results->fetch(PDO::FETCH_ASSOC))
      $allseasons[] = $row;

    $distances = seasondistances($allworkouts, $allseasons);

    for($i=0;$i<count($allseasons);++$i)
    {
      $pid = $allseasons[$i][$PIDloc];
      $idval = "seas" . $pid;
      $out = "";
      $out .= "<a href=\"javascript:expandseason('edit','$idval')\" class=\"none\">";

      $out .= "  <li class=\"list-group-item\" id=\"" . $idval .  "\" onmouseover=\"mouseoverseason('" . $idval . "');\"";
        $out .= " onmouseout=\"mouseoffseason('" . $idval . "');\">";
      $out .= "<span style=\"color:#00F;\">" . $distances[$i] . "mi</span> ";
      $out .= stripslashes($allseasons[$i][$nameloc]) . " ";

      $out .= "<span class=\"badge\">";
      //$out .= date('M j Y', strtotime($allseasons[$i][2]));
      $out .=  intrp(intval($allseasons[$i][$beginloc]), array('M','j','Y'));
      $out .= " to ";
      //$out .= date('M j Y', strtotime($allseasons[$i][3]));
      $out .= intrp(intval($allseasons[$i][$endloc]), array('M', 'j', 'Y'));
      $out .= "</span>";

      $out .= "<span class=\"ggLog-hide\" id=\"$idval-edit\"></span>";

      $out .= "  </li>";
      $out .= "</a>";

      $fulllist .= $out;
    }
    $pdo = null;

    if($echoResults == true)
      echo $fulllist;

    return $fulllist;
  }
}
function displayWeeklyDistances($echoResults = true)
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $output = "";
    $pdo = gg_get_pdo();
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_workouts";

    $result = $pdo->query("SELECT rundate, title, distance, runtime, notes, PID FROM " . $tname);
    $data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      $data[] = $row;
    }

    $pdo = null;

    require_once('weeks.php');
    $wm = new weekManage();
    foreach($data as $workout)
    {
      //$day = strtotime($workout["rundate"]);
      $day = intval($workout["rundate"]);
      $time = timetoseconds($workout["runtime"]);
      $distance = $workout["distance"];
      $wm->addtime($day, $time);
      $wm->addmiles($day, $distance);
    }
    //        $thisweek = $wm->get(time());
    $orderedweeks = $wm->weekArray();
    /* foreach($wm->weeks as $week)
    {
      //$orderedweeks[] = array($week->beginday, $week->endday, $week->distance, $week->time);
    } */
    sortbydate($orderedweeks, 0);
    $output .= "<div style=\"width:700px;display:block;margin-left:auto;margin-right:auto;\">\n";
    if(true)
    {
      $tdist = $wm->totaldistance;
      $ttime = $wm->totaltime;
      $output .= "<span style=\"color:#7A7;font-size:1.5em;\"> All Time: " . $tdist .  " miles in ";
      $output .= secondstotime($ttime) . " (" . speed($ttime, $tdist) .  " pace)</span><br /><br />";
    }
    foreach($orderedweeks as $thisweek)
    {
      $output .= "<span style=\"color:#999;font-size:1.5em;\">";
      //$output .= date('M j Y', $thisweek[0]) . " to ";
      $output .= intrp(intval($thisweek[0]), array('M', 'j', 'Y')) . " to ";
      //$output .= date('M j Y', $thisweek[1]);
      $output .= intrp(intval($thisweek[1]), array('M', 'j', 'Y'));
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
  return false;
}

?>
