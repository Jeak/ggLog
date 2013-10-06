<?php
require_once("workouts.php");
$beginloc = intval($_POST['begin']);
$numberofworkouts = intval($_POST['number']);

$dwork = displayworkouts(false, $beginloc, $numberofworkouts, $finished);

// passes info on whether all workouts have been accessed yet by the location of the '|'
if($finished == true)
  echo "t";

echo "|";
echo $dwork;

?>
