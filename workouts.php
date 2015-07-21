<?php
// Assumes that sesssion_start() has already been called.
require_once('datetime.php');
require_once('config.php');
require_once('weeks.php');

/*/////////////////////
     ADDING WORKOUTS
*//////////////////////

function workoutsAsArray($startsession = true)
{
  /* $data[workout #][_attribute__]
  *        Attributes:
  * 0. date
  * 1. title
  * 2. distance
  * 3. time
  * 4, notes
  * 5. PID
  */
  if($startsession == true)
    session_start();
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();

    $result = $pdo->query("SELECT rundate, title, distance, runtime, notes, PID FROM " . GG_PREFIX . $_SESSION[GG_PREFIX . "username"] . "_workouts");
    $data = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      $data[] = $row;
    }
    // Close connection
    $pdo = null;
    return $data;
  }
  return false;
}

// Actually EDITS a workout but creates one if not found
function addworkout($PID = -1, $year, $month, $day, $title, $distance, $h, $m, $s, $notes)
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();

    $works = true;

    //$rundate = createsqldate($year, $month, $day);
    $rundate = ggcreatedate($year, $month, $day);

    if($rundate == false)
      $works = false;

    $runtime = createsqltime($h, $m, $s);
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . "username"] . "_workouts";
    if($works == true)
    {
      if($PID < 0)
      {
        $stm = "INSERT INTO " . $tname . "(rundate, title, distance, runtime, notes, PID) ".
        "VALUES(?,?,?,?,?, NULL)"; // pass NULL to PID to make it auto increment
        $stmt = $pdo->prepare($stm);
        $stmt->execute(array($rundate, $title, $distance, $runtime, $notes));
        //sqlite_exec($dbhandle, $stm, $error);
      }
      else
      {
        $stm = "UPDATE " . $tname . " ".
        "SET rundate=?, title=?, distance=?, runtime=?, notes=? WHERE PID=?";
        $stmt = $pdo->prepare($stm);
        $stmt->execute(array($rundate, $title, $distance, $runtime, $notes, $PID));
      }
    }
    $pdo = null;
  }
  else {
    return false;
  }
}

function deleteworkout($PID) // $PID as a string
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_workouts";

    $results = $pdo->query("SELECT PID FROM " . $tname);
    $found = false;
    while ($row = $results->fetch(PDO::FETCH_ASSOC))
    {
      if(intval($PID == intval($row['PID'])))
      {
        $found = true;
        break;
      }
    }

    $stm = "DELETE FROM " . $tname . " WHERE PID=" . $PID;
    if($found == true)
    {
      $pdo->exec($stm);
    }
    //[RELEASE] for the release, replace with @sqlite_exec() to surpress errors

    $pdo = null;
  }
  else {
    return false;
  }
}

/*//////////////////////////////////////////
        DISPLAYING WORKOUTS
/*//////////////////////////////////////////
require_once("datetime.php");

function displayworkouts($echoResults = true, $wheretobegin = -1, $numbertodisplay = 30, &$finished=false)
{
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $output = "";
    $preface="      ";
    $pdo = gg_get_pdo();
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_workouts";

    /*            //  UNCOMMENT THIS TO DISPLAY ALL VALUES IN A TABLE
                  // -------------------------------------------------
    $result = sqlite_query($dbhandle, "SELECT * FROM " . GG TABLE);
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

    $result = $pdo->query("SELECT rundate, title, distance, runtime, notes, PID FROM " . $tname);
    $data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      $data[] = $row;
    }
    $pdo = null;

    sortbydate($data); // function above

    $output .= displayOnlyWorkouts($data, $wheretobegin, $numbertodisplay, $finished); // function below

    if($echoResults == true)
    {
      echo $output;
    }

    return $output;
  }
  return false;
}

function filterWorkoutsByDate($beginloc, $endloc, $data = null, $sorted = false)
{
  if($data == null)
    $data = workoutsAsArray();
  $output;
  foreach($data as $entry)
  {
    if($entry['rundate'] >= $beginloc && $entry['rundate'] <= $endloc)
      $output[] = $entry;
  }
  if(!$sorted)
    $output = sortbydate($output);
  return $output;
}

function displayOnlyWorkouts($data, $beginloc, $numberToDisplay, &$isFinished = false) // why is $isFinished in variables?
{
  $preface = "";
  $output = "";
  $numberofworkouts = 0;
  if($beginloc < 0)
  {
    $beginloc = 0;
    $numberToDisplay = count($data) +1;
  }
  for($i=count($data)-1-$beginloc;$i>=0 && $i>=(count($data)-$beginloc-$numberToDisplay);--$i, ++$numberofworkouts)
  {
    //echo ":::" . gettype($data[$i]['rundate']) . $data[$i]['rundate'];
    $PID = $data[$i]["PID"];
  //          echo $PID;
    $output .= "$preface<div class=\"ggLog-center-90\" id=\"PID-" . $PID . "\">\n";

  //          store hard-to-access data in hidden inputs
    $output .= "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "date\" value=\"" . ggcreateSQLdate(intval($data[$i]["rundate"])) . "\" />\n";
    $output .= "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "title\" value=\"" . $data[$i]["title"] . "\" />\n";

    $output .= "$preface  <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;\">\n";
  //<a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-trash"> </span></a>
    $output .= "$preface  <a href=\"javascript:editworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>\n";
    $output .= "$preface  <a href=\"javascript:deleteworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
    $output .= "<span class=\"workoutdate\">";
    //$output .= date("D M j Y", strtotime($data[$i]["rundate"])); // date
    $output .= intrp(intval($data[$i]["rundate"]), array('D', 'M', 'j', 'Y')); // date
    $output .= "</span><span class=\"workouttitle\">";
    $output .= stripslashes($data[$i]["title"]); // title
    $output .= "</span></div>\n";

    $output .= "$preface  <div style=\"position:relative;top:0;left:0;width:100%;\">\n";

    $output .= "$preface    <div style=\"float:left;width:500px;margin-bottom:25px;\" id=\"PID-" . $PID . "notes\">";
    $output .= htmlnewline(stripslashes($data[$i]["notes"])); // notes?
    $output .= "</div>\n";
    $output .= "$preface  </div>\n";

    $output .= "$preface  <div style=\"float:left;width:120px;border:1px;margin-bottom:25px;margin-left:10px\">\n";
    $output .= "$preface    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "distance\">";
    $output .= $data[$i]["distance"]; // distance
    $output .= "</span> miles</div>\n";
    $output .= "$preface    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\">";
    $output .= speed($data[$i]["runtime"], $data[$i]["distance"]);
    $output .= "</span> min/mi</div>\n";
    $output .= "$preface  </div>\n";

    $output .= "$preface  <div style=\"float:left;width:120px;\">";
    $output .= "<div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "time\">";
    $output .= $data[$i]["runtime"];  // time
    $output .= "</span></div>";
    $output .= "$preface  </div>\n";

    $output .= "$preface</div>\n";
    $output .= "$preface<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";
  }
  if($numberofworkouts == $numberToDisplay)
    $isFinished = false;
  else
    $isFinished = true;

return $output;
}

function makeWorkoutJSON($data, $beginloc, $numberToDisplay)
{
  // for pre-sorted data, earliest activities first.
  $starter = microtime(true);
  $templateOutput = array();
  $ic = 0;
  for($i = count($data)-1-$beginloc; $i>= count($data)-$beginloc-$numberToDisplay && $i >= 0;--$i)
  {
    $ic = $i;
    $single = $data[$ic];
    $single['PID'] = intval($single['PID']);
    $single['rundate'] = intval($single['rundate']);
    $single['distance'] = floatval($single['distance']);
    $single['speed'] = speed($single["runtime"], $single["distance"]);
    $templateOutput[] = $single;
  }
  $templateOutput['more'] = true;
  if(count($data)-$beginloc-$numberToDisplay <= 0)
    $templateOutput['more'] = false;
  $templateOutput['count'] = (count($data)-$beginloc)-$ic;
  $templateOutput['timing'] = (microtime(true) - $starter);
  return json_encode($templateOutput);
}

function getWorkoutJSON($beginloc, $numberToDisplay, $startsession = true)
{
  if($startsession == true)
    session_start();
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $tname = GG_PREFIX . $_SESSION[GG_PREFIX . 'username'] . "_workouts ";
    $result = $pdo->query("SELECT rundate, title, distance, runtime, notes, PID FROM " . $tname);
    $data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      $data[] = $row;
    }
    $pdo = null;

    sortbydate($data); // function above
    return makeWorkoutJSON($data, $beginloc, $numberToDisplay);
  }
  return false;
}

function getWeeklyJSON($beginloc, $endloc, $numberToDisplay = 10000, $startsession = true)
{
  // Since this is coming from JS, this should sanitize
  $beginloc = intval($beginloc);
  $endloc = intval($endloc);
  $numberToDisplay = intval($numberToDisplay);
  if($startsession == true)
    session_start();
  if(isset($_SESSION[GG_PREFIX . 'username']))
  {
    $pdo = gg_get_pdo();
    $stm = "SELECT rundate, distance, runtime FROM " . GG_PREFIX . $_SESSION[GG_PREFIX . "username"] . "_workouts "; //.
        //"WHERE rundate <= $endloc AND rundate >= $beginloc";
    $results = $pdo->query($stm);
    $data = $results->fetchAll(PDO::FETCH_ASSOC);

    $wm = new weekManage();
    foreach($data as $entry)
    {
      $day = intval($entry["rundate"]);
      $time = timetoseconds($entry["runtime"]);
      $distance = $entry["distance"];
      $wm->addtime($day, $time);
      $wm->addmiles($day, $distance);
    }
    $orderedweeks = $wm->weekArray();
    sortbydate($orderedweeks, 0);

    return $orderedweeks;
  }
  return false;
}

//                       bool     date   date
function convertToText($alltime, $begin, $end) // inclusive
{
  $when;
  if($alltime == true)
    $when = "All Time";
  else
  {
    $begins = intrp($begin, array('D', 'M', 'j', 'Y'));
    $ends = intrp($end, array('D', 'M', 'j', 'Y'));
    $when = $begins . " to " . $ends;
  }

  $title = "First Last's Running Logs From " . $when;

  $output = "";
  for($i=0;$i<8;++$i) $output .= " ";
  $output .= $title . "\n";
  for($i=0;$i<8;++$i) $output .= " ";
  for($i=0;$i<strlen($title);++$i) $output .= "=";
  $output .= "\n\n";

  $allworkouts = workoutsAsArray();
  sortbydate($allworkouts);
  for($i = 0;$i<count($allworkouts);++$i)
  {
    for($j=0;$j<20;++$j) $output .= "~";
    $output .= "\n";
    //$output .= date("D M j Y", strtotime($allworkouts[$i]["rundate"]));
    $output .= intrp(intval($allworkouts[$i]["rundate"]), array('D', 'M', 'j', 'Y'));

    $output .= "  \"" . $allworkouts[$i]["title"] . "\"\n";
    $distance = $allworkouts[$i]["distance"] . " mi";
    $spaces = 10;
    $diff = $spaces - strlen($distance);
    $output .= $distance;
    for($j=0;$j<$diff;++$j) $output .= " ";
    $output .= $allworkouts[$i]["runtime"] . "\n";
    for($j=0;$j<$spaces;++$j) $output .= " ";
    $output .= speed($allworkouts[$i]["runtime"],$allworkouts[$i]["distance"]) . "\n\n";
    $output .= $allworkouts[$i]["notes"] . "\n\n";
  }

  $output .= "\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
  $output .= "\nExported from ggLog (currently at http://www.gglog.xyz/ggLog/) on " . date("D M j Y", time());
  $output .= "\n\n";

  return $output;
}

?>
