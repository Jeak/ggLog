<?php
//This PHP file is for accepting ajax requests of all types.  Will be expanded later and more will use this.
require_once('src/workouts.php'); // adding/editing/deleting workouts
require_once('src/seasons.php');
require_once('src/datetime.php');

    // each html form has a <input type="hidden" name="submitting" value="__" />
    // which specifies what is happening
  session_start();
  if(isset($_POST['submitting']))
  {
    if(isset($_SESSION[GG_PREFIX . 'username']))
    {
      if($_POST['submitting'] == "newworkout") // for editing or creating a workout
      {
        $day= floatval($_POST['day']);
        $month= floatval($_POST['month']);
        $year= floatval($_POST['year']);
        $title= $_POST['title'];
        $distance= floatval($_POST['distance']);
        $h= intval($_POST['hours']);
        $m= intval($_POST['minutes']);
        $s= intval($_POST['seconds']);
        $notes= $_POST['notes'];
        //if we are editing a workout, it must pass a PID to specify which workout.
        //  If no PID is specified, a new one is created.
        if(isset($_POST['PID']) && $_POST['PID'] != "") // editing
          addworkout(intval($_POST['PID']), $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
        else // adding new workout
          addworkout(-1, $year, $month, $day, $title, $distance, $h, $m, $s, $notes);
      }
      else if($_POST['submitting'] == "deleteworkout")
      {
        deleteworkout($_POST['PID']); // from workouts.php
      }
      else if($_POST['submitting'] == "season")
      {
        $beginday = intval($_POST['begin-day']);
        $beginmonth = intval($_POST['begin-month']);
        $beginyear = intval($_POST['begin-year']);
        $endday = intval($_POST['end-day']);

        $endmonth = intval($_POST['end-month']);
        $endyear = intval($_POST['end-year']);
        $name = sanitize($_POST['seasonname']);
        if(isset($_POST['id']) && $_POST['id'] != "") // editing
        {
          $PID = decodeseasonid($_POST['id']);
          addseason($PID, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
        }
        else //new
          addseason(-1, $name, $beginyear, $beginmonth, $beginday, $endyear, $endmonth, $endday);
      }
      else if($_POST['submitting'] == "deleteseason")
      {
        // $_POST['id'] is in the format "seas12", so $PID = int(12)
        // done to differentiate from workout IDs
        $PID = decodeseasonid($_POST['id']); // seasons.php
        deleteseason($PID);
      }
      else if($_POST['submitting'] == "seasonlist")
      {
        //for updating lists of seasons in manageseasons.php and stuff
        // usually an AJAX request
        echo listseasons(false);
      }
      else if($_POST['submitting'] == 'jsonwkts')
      {
        $beginloc = intval($_POST['begin']);
        $numberofworkouts = intval($_POST['number']);
        $dwork = getWorkoutJSON($beginloc, $numberofworkouts, false);
        echo $dwork;
      }
      else if($_POST['submitting'] == 'jsonwktsnn')
      {
        $dwork = getWithoutNotesJSON();
        echo $dwork;
      }
      else if($_POST['submitting'] == 'mgraph')
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
      else if($_POST['submitting'] == 'flotrackrimport')
      {
        $csv = $_FILES['csvfile'];
        $rand = "./csv/" . substr(md5(microtime()),0,10) . ".csv";
        move_uploaded_file($csv["tmp_name"], $rand);
        $content = file_get_contents($rand);
        //echo $content;
        importFromFlotrackr($content);
        unlink($rand);
      }
    }
	else
	{
    if($_POST['submitting'] == 'jsonwktsother')
    {
      $username = $_POST['username'];
      $beginloc = intval($_POST['begin']);
      $numberofworkouts = intval($_POST['number']);
      $dwork = getWorkoutJSONOther($username, $beginloc, $numberofworkouts, false);
      echo $dwork;
    }
    if($_POST['submitting'] == 'jsonwktsspecother')
    {
      $username = $_POST['username'];
      $begindate = intval($_POST['begin']);
      $enddate = intval($_POST['end']);
      $dwork = getWorkoutJSONSpecOther($username, $begindate, $enddate, false);
      echo $dwork;
    }
    else if($_POST['submitting'] == 'mgraphother')
    {
      $username = $_POST['username'];
      $daysToReturn = intval($_POST['len']);
      if($daysToReturn == 0)
        $daysToReturn = 100000;
      $edate = ggreadSQLdate(date('Y-m-j'));
      if(isset($_POST['end']))
        $edate = intval($_POST['begin']);
      $dwork = getWeeklyJSONOther($username, $edate-$daysToReturn, $edate, 10000, false);
      echo $dwork;
    }
	}
  }

?>
