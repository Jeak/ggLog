<?php
//This PHP file is for accepting ajax requests of all types.  Will be expanded later and more will use this.
require_once('workouts.php'); // adding/editing/deleting workouts
require_once('seasons.php');

    // each html form has a <input type="hidden" name="submitting" value="__" />
    // which specifies what is happening

    if($_POST['submitting'] == "newworkout") // for editing or creating a workout
    {
      $day= floatval(sqlite_escape_string($_POST['day']));
      $month= floatval(sqlite_escape_string($_POST['month']));
      $year= floatval(sqlite_escape_string($_POST['year']));
      $title= sqlite_escape_string($_POST['title']);
      $distance= floatval(sqlite_escape_string($_POST['distance']));
      $h= intval(sqlite_escape_string($_POST['hours']));
      $m= intval(sqlite_escape_string($_POST['minutes']));
      $s= intval(sqlite_escape_string($_POST['seconds']));
      $notes= sqlite_escape_string($_POST['notes']);
      //if we are editing a workout, it must pass a PID to specify which workout.
      //  If no PID is specified, a new one is created.
      if($_POST['PID'] != "") // editing
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
      $beginday = intval(sqlite_escape_string($_POST['begin-day']));
      $beginmonth = intval(sqlite_escape_string($_POST['begin-month']));
      $beginyear = intval(sqlite_escape_string($_POST['begin-year']));
      $endday = intval(sqlite_escape_string($_POST['end-day']));
      $endmonth = intval(sqlite_escape_string($_POST['end-month']));
      $endyear = intval(sqlite_escape_string($_POST['end-year']));
      $name = sqlite_escape_string($_POST['seasonname']);
      if($_POST['id'] != "") // editing
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

?>
