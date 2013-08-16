<?php

function adduser($username)
{
  //check to see if exists
  // and to make sure it's only #s and letters
  //if not, return false
  //otherwise...
  mkdir("./data/" . $username);
  $dbhandle = sqlite_open("data/" . $username . "/" . $username . "_test.db", 0666, $error);
  if (!$dbhandle) die ($error);
  
  $stms = array();
  $stms[] = "CREATE TABLE workouts(".
  "PID INT AUTO_INCREMENT,".
  "rundate DATE NOT NULL,".
  "title TINYTEXT,".
  "distance DOUBLE,".
  "runtime TIME,".
  "notes TEXT,".
  "PRIMARY KEY (PID)".
  ")";
  sqlite_exec($dbhandle, $stms[0], $error);

  sqlite_close($dbhandle);

  return true;
}



?>
