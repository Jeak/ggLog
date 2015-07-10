<?php
// Also check for too short, specific things we don't want like too short, "user", etc.
require_once("config.php");
if(isset($_POST['type']))
{
  if($_POST['type'] == 'email' && isset($_POST['email']))
  {
    $pdo = gg_get_pdo();
    $stm = "SELECT email FROM " . GG_PREFIX . "users";
    $results = $pdo->query($stm);
    $allrows = $results->fetchAll(PDO::FETCH_ASSOC);
    $match = false;
    foreach($allrows as $emailToCheck) {
      if($emailToCheck['email'] == strtolower($_POST['email']))
      {
        echo "bad";
        $match = true;
        break;
      }
    }
    if($match == false)
    {
      echo "good";
    }
  }
  else if($POST['type'] == 'username' && isset($_POST['username']))
  {
    $pdo = gg_get_pdo();
    $stm = "SELECT username FROM " . GG_PREFIX . "users";
    $results = $pdo->query($stm);
    $allrows = $results->fetchAll(PDO::FETCH_ASSOC);
    $match = false;
    foreach($allrows as $usernameToCheck) {
      if($usernameToCheck == strtolower($_POST['username']))
      {
        echo "bad";
        $match = true;
        break;
      }
    }
    if($match == false)
    {
      echo "good";
    }
  }
}
?>
