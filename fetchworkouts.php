<?php
require_once("src/workouts.php");
require_once("config.php");
session_start();
if(isset($_SESSION[GG_PREFIX . 'username']))
{
  $beginloc;
  $numberofworkouts;
  if(isset($_POST['begin']))
    $beginloc = intval($_POST['begin']);
  if(isset($_POST['number']))
    $numberofworkouts = intval($_POST['number']);

  if(!isset($_POST['type']) || $_POST['type'] == "")
  {
    $dwork = displayworkouts(false, $beginloc, $numberofworkouts, $finished);

    // passes info on whether all workouts have been accessed yet by the location of the '|'
    if($finished == true)
      echo "t";

    echo "|";
    echo $dwork;
  }
  if(isset($_POST['type']))
  {
    if($_POST['type'] == 'json') {
      $dwork = getWorkoutJSON($beginloc, $numberofworkouts, false);
      echo $dwork;
    }
    if($_POST['type'] == 'jsonnn')
    {
      $dwork = getWithoutNotesJSON();
      echo $dwork;
    }
    if($_POST['type'] == 'mgraph')
    {
      $daysToReturn = intval($_POST['len']);
      if($daysToReturn == 0)
        $daysToReturn = 100000;
      $edate = ggreadSQLdate(date('Y-m-j'));
      if(isset($_POST['end']))
        $edate = intval($_POST['begin']);
      $dwork = getWeeklyJSON($edate-$daysToReturn, $edate, 10000, false);
      echo $dwork;
    }
  }
}
?>
