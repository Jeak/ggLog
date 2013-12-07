<?php

require_once('datetime.php');

/*/////////////////////
     ADDING WORKOUTS
*//////////////////////

function workoutsAsArray()
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
  $dbhandle = sqlite_open("data/user_test.db", 0666, $error);
  if (!$dbhandle) die ($error);

  $result = sqlite_query($dbhandle, "SELECT rundate, title, distance, runtime, notes, PID FROM workouts");
  $data = array();
  while ($row = sqlite_fetch_array($result, SQLITE_NUM))
  {
    $data[] = $row;
  }
  sqlite_close($dbhandle);
  return $data;
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

function displayworkouts($echoResults = true, $wheretobegin = -1, $numbertodisplay = 30, &$finished=false)
{
  $output = "";
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
  sqlite_close($dbhandle);
  sortbydate($data); // function above

  $output .= displayOnlyWorkouts($data, $wheretobegin, $numbertodisplay, $finished); // function below

  if($echoResults == true)
  {
    echo $output;
  }

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
    $PID = $data[$i][5];
  //          echo $PID;
    $output .= "$preface<div class=\"ggLog-center-90\" id=\"PID-" . $PID . "\">\n";
    
  //          store hard-to-access data in hidden inputs
    $output .= "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "date\" value=\"" . $data[$i][0] . "\" />\n";
    $output .= "$preface  <input type=\"hidden\" id=\"PID-" . $PID . "title\" value=\"" . $data[$i][1] . "\" />\n";
  
    $output .= "$preface  <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;\">\n";
  //<a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-trash"> </span></a>
    $output .= "$preface  <a href=\"javascript:editworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>\n";
    $output .= "$preface  <a href=\"javascript:deleteworkout('$PID');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
    $output .= "<span class=\"workoutdate\">";
    $output .= date("D M j Y", strtotime($data[$i][0])); // date
    $output .= "</span><span class=\"workouttitle\">";
    $output .= stripslashes($data[$i][1]); // title
    $output .= "</span></div>\n";
  
    $output .= "$preface  <div style=\"position:relative;top:0;left:0;width:100%;\">\n";
    
    $output .= "$preface    <div style=\"float:left;width:500px;margin-bottom:25px;\" id=\"PID-" . $PID . "notes\">";
    $output .= htmlnewline(stripslashes($data[$i][4])); // notes?
    $output .= "</div>\n";
    $output .= "$preface  </div>\n";
  
    $output .= "$preface  <div style=\"float:left;width:120px;border:1px;margin-bottom:25px;margin-left:10px\">\n";
    $output .= "$preface    )div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "distance\">";
    $output .= $data[$i][2]; // distance
    $output .= "</span> miles</div>\n";
    $output .= "$preface    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\">";
    $output .= speed($data[$i][3], $data[$i][2]);
    $output .= "</span> min/mi</div>\n";
    $output .= "$preface  </div>\n";
            
    $output .= "$preface  <div style=\"float:left;width:120px;\">";
    $output .= "<div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" . $PID . "time\">";
    $output .= $data[$i][3];  // time
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

//                       bool     date   date
function convertToText($alltime, $begin, $end) // inclusive
{
  $when;
  if($alltime == true)
    $when = "All Time";
  else
  {
    $begins = date("D M j Y", $begin);
    $ends = date("D M j Y", $end);
    $when = $begins . " to " . $ends;
  }

  $title = "First Last's Running Logs From " . $when;
  
  $output;
  for($i=0;$i<8;++$i) $output .= " ";
  $output .= $title . "\n";
  for($i=0;$i<8;++$i) $output .= " ";
  for($i=0;$i<strlen($title);++$i) $output .= "=";
  $output .= "\n\n";

  $allworkouts = workoutsAsArray();
  for($i = 0;$i<count($allworkouts);++$i)
  {
    for($j=0;$j<20;++$j) $output .= "~";
    $output .= "\n";
    $output .= Date("D M j Y", strtotime($allworkouts[$i][0]));
    $output .= "  \"" . $allworkouts[$i][1] . "\"\n";
    $distance = $allworkouts[$i][2] . " mi";
    $spaces = 10;
    $diff = $spaces - strlen($distance);
    $output .= $distance;
    for($j=0;$j<$diff;++$j) $output .= " ";
    $output .= $allworkouts[$i][3] . "\n";
    for($j=0;$j<$spaces;++$j) $output .= " ";
    $output .= speed($allworkouts[$i][3],$allworkouts[$i][2]) . "\n\n";
    $output .= $allworkouts[$i][4] . "\n\n";
  }

  $output .= "\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
  $output .= "\nExported from ggLog (currently at http://ko.kooia.info/ggLog/) on " . date("D M j Y", time());
  $output .= "\n\n";

  return $output;
}

?>
