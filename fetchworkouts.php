<?php
require_once("workouts.php");
require_once("config.php");
session_start();
if(isset($_SESSION[GG_PREFIX . 'username']))
{
  $beginloc = intval($_POST['begin']);
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
    if($_POST['type'] == 'jsonnn'))
    {
      $dwork = getWithoutNotesJSON();
      echo $dwork;
    }
  }
}
?>
