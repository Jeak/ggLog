<?php
require_once("config.php");

// return "true": still good. return "false": bad, already present.
function checkEmailDatabase($givenemail)
{
  $output = true;
  $pdo = gg_get_pdo();
  $stm = "SELECT email FROM " . GG_PREFIX . "users";
  $results = $pdo->query($stm);
  $allrows = $results->fetchAll(PDO::FETCH_ASSOC);
  $match = false;
  foreach($allrows as $emailToCheck) {
    if($emailToCheck['email'] == strtolower($givenemail))
    {
      return false;
    }
  }
  return true;
}

function checkUserDatabase($givenuser)
{
  $pdo = gg_get_pdo();
  $stm = "SELECT username FROM " . GG_PREFIX . "users";
  $results = $pdo->query($stm);
  $allrows = $results->fetchAll(PDO::FETCH_ASSOC);
  $match = false;
  foreach($allrows as $usernameToCheck) {
    if($usernameToCheck['username'] == strtolower($givenuser))
    {
      return false;
    }
  }
  return true;
}

function checkEmail($givenemail)
{
  if(!checkEmailDatabase($givenemail))
    return false;
  if(strpos($givenemail, "@") == false)
    return false;
  return true;
}

function checkUser($givenuser)
{
  $givenuser = strtolower($givenuser);
  if(!checkUserDatabase($givenuser))
    return false;
  for($i=0;$i< strlen($givenuser);++$i)
  {
    $tn = ord($givenuser[$i]);
    if(!(($tn >=97 && $tn <= 122) || ($tn >= 48 && $tn <= 57)))
      return false;
  }
  if($givenuser == 'user' || $givenuser == 'users' || $givenuser == 'other' || $givenuser == 'admin' || $givenuser == 'others')
    return false;
  return true;
}

function checkPassword($givenpassword)
{
  if(strlen($givenpassword) < 5)
    return false;
  return true;
}


// Also check for too short, specific things we don't want like too short, "user", etc.
if(isset($_POST['type']))
{
  if($_POST['type'] == 'email' && isset($_POST['email']))
  {
    if(checkEmailDatabase($_POST['email']))
      echo "good";
    else
      echo "bad";
  }
  else if($_POST['type'] == 'username' && isset($_POST['username']))
  {
    if(checkUserDatabase($_POST['username']))
      echo "good";
    else
      echo "bad";
  }
}
?>
