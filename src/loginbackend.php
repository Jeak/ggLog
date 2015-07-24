<?php
require_once("../config.php");

function ggLog_encrypt($toEncrypt, $salt = null)
{
  $hash_number = 10;
  $result = hash("tiger192,4", $toEncrypt . $salt);
  for($i=0;$i<$hash_number;++$i)
    $result = hash("tiger192,4", $result . $salt);
  return $result;
}

function ggLog_create_new_user($infoarray)
{
  // $infoarray has:
  // "email", "username", {("password") OR "saltedpassword", "salt"}, "screenname"

  $pdo = gg_get_pdo();
  // Add an entry to the users table
  $userarray;
  $userarray[':email'] = $infoarray['email'];
  $userarray[':username'] = $infoarray['username'];
  $userarray[':screenname'] = $infoarray['screenname'];
  if(isset($infoarray['saltedpassword']))
  {
    $userarray[':passwordhash'] = $infoarray['saltedpassword'];
    $userarray[':salt'] = $infoarray['salt'];
  }
  else
  {
    $salt = hash('sha1', microtime());
    $userarray[':passwordhash'] = ggLog_encrypt($infoarray['password'], $salt);
    $userarray[':salt'] = $salt;
  }
  $stm = "INSERT INTO " . GG_PREFIX . "users(PID, username, salt, password, screenname, email)".
         " VALUES (NULL, :username, :salt, :passwordhash, :screenname, :email)";
  $stmt = $pdo->prepare($stm);
  $stmt->execute($userarray);

  // Create the [prfx]_[user]_workouts table
  $stm = "CREATE TABLE " . GG_PREFIX . $infoarray['username'] . "_workouts (".
         "PID INTEGER AUTO_INCREMENT PRIMARY KEY, " .
         "rundate INTEGER NOT NULL, ".
         "title TINYTEXT, ".
         "distance DOUBLE, ".
         "runtime TIME, ".
         "notes TEXT".
         ")";
  $pdo->exec($stm);

  // Create the [prfx]_[user]_other table
  $stm = "CREATE TABLE " . GG_PREFIX . $infoarray['username'] . "_other (".
         "PID INTEGER AUTO_INCREMENT PRIMARY KEY, " .
         "type TINYTEXT, ".
         "name TINYTEXT, ".
         "begindate INTEGER, ".
         "enddate INTEGER".
         ")";
  $pdo->exec($stm);

}

function ggLog_logout()
{
  session_start();
  unset($_SESSION[GG_PREFIX . 'username']);
  session_destroy();
}

if(isset($_POST['type']) && $_POST['type'] == 'logout')
{
  ggLog_logout();
}

?>
