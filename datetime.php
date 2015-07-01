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

function timetoseconds($time)
{
  $pieces = explode(":", $time);
  $timeint  = intval($pieces[0])*60*60;
  $timeint += intval($pieces[1])*60;
  $timeint += intval($pieces[2]);
  return $timeint;
}

function secondstotime($secs, $depth=3)
{
  if($depth == 2)
  {
    $minutes = intval($secs/60);
    $seconds = intval($secs-$minutes*60);
    $out = "$minutes:";
    if($seconds < 10)
      $out.="0";
    $out.="$seconds";
    return $out;
  }
  else if($depth == 3)
  {
    $hours = intval($secs/3600);
    $minutes = intval(($secs-$hours*3600)/60);
    $seconds = intval($secs-$minutes*60-$hours*3600);
    $out = "$hours:";
    if($minutes < 10)
      $out.="0";
    $out .= "$minutes:";
    if($seconds < 10)
      $out.="0";
    $out.="$seconds";
    return $out;
  }
  return "";
}

      //  'HH:MM:SS', double
      //or        S , double
function speed($time, $distance)
{
  if($distance != 0)
  {
    $timeint = $time; // for $time as seconds
    if(gettype($time) == 'string')
      $timeint = timetoseconds($time);
    $secpermile= intval($timeint/$distance);
    $out = secondstotime($secpermile, 2);
    return $out;
  }
  else return "0:00";
}

function htmlnewline($in)
{
  return str_replace("\n", "<br />\n", $in);
}

function sanitize($in)
{
  $in = str_replace("<", "&lt;", $in);
  $in = str_replace(">", "&gt;", $in);
  $in = str_replace("\"", "&quot;", $in);
  $in = str_replace("'", "&x27;", $in);
  $in = str_replace("/", "&#x2F;", $in);
  $in = str_replace("&", "&amp;", $in);
  return $in;
}


function sortbydate(&$workouts, $location="rundate")
{
  // Earliest workout goes first; latest workout goes last.
  $dates = array();
  $found = array();
  $incr = 0;
  foreach( $workouts as $row )
  {
    $value;
    $exists = array_search($row[$location], $found);
    if($exists === false)
    {
      $value = $row[$location];
      $found[] = $row[$location];
    }
    else // if there's multiple entries with the same date, change it so you don't end up overriding anything
    {
      $value = $row[$location] . '-' . $incr;
    }
    $dates[] = $value; // ex: $dates[0] = '2013-06-24'
    ++$incr;
  }
  $dates = array_flip($dates); // ex: $dates['2013-06-24'] = 0;
  ksort($dates); // sort by the key (the date)
  $newworkouts = array();
  // makes array with only the date and the key of the original array.
  // sorts by date
  // changes the date to the key and the key of the original array to the value
  // reorders the workouts
  // example: $workouts = array(0 => array(... '2013-06-24' ...),  1 => array(... '2013-08-16 ... ));
  //          $dates = array(0 => '2013-06-24', 1=> '2013-08-16')
  //          $dates = array('2013-08-16' => 1, '2013-06-24' => 0) // which is eq. to $dates array(0=>1, 1=>0)
  //          $workouts[0] = $workouts[1]; $workouts[1] = $workouts[0]
  foreach( $dates as $loc )
  {
    $newworkouts[] = $workouts[$loc];
  }
  $workouts = $newworkouts;
}
 
 
 
?>
