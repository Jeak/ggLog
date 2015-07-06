<?php
require_once("workouts.php");
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
if(isset($_POST['type']) && $_POST['type'] == 'json') {
  $dwork = getWorkoutJSON($beginloc, $numberofworkouts);
  echo $dwork;
}

?>
