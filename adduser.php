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
  "PID INTEGER AUTO_INCREMENT,".
  "rundate INTEGER NOT NULL,".
  "title TINYTEXT,".
  "distance DOUBLE,".
  "runtime TIME,".
  "notes TEXT,".
  "PRIMARY KEY (PID)".
  ")";
  sqlite_exec($dbhandle, $stms[0], $error);


  $command = <<<_SQL_
  CREATE TABLE seasons
  (
  PID INTEGER AUTO_INCREMENT,
  name TINYTEXT,
  begindate DATE NOT NULL,
  enddate DATE NOT NULL,
  PRIMARY_KEY(PID)
  );

  sqlite_close($dbhandle);

  return true;
}



?>
