<?php

require_once('sqldatetime.php');

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

?>
