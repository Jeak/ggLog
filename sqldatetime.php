<?php

function createsqldate($year, $month, $day)
{
  $rundate="$year-";
  if($month < 10)
    $rundate.="0";
  $rundate.="$month-";
  if($day < 10)
    $rundate.="0";
  $rundate.="$day";
  if(!checkdate($month, $day, $year))
    return false;
  return $rundate;
}

function createsqltime($hours, $minutes, $seconds)
{
  $runtime="$hours:";
  if($minutes < 10)
    $runtime.="0";
  $runtime.="$minutes:";
  if($seconds < 10)
    $runtime.="0";
  $runtime.="$seconds";
  return $runtime;
}


?>
