<?php
// Will be rewritten by nginx to appear as png, jpg, gif
require_once(__DIR__."/../config.php");


//if(isset($_GET['u']) && isset($_GET['t']))
//{
//  $pdo = gg_get_pdo();
  /*
  $stmt = $pdo->prepare("SELECT PID FROM " . GG_PREFIX . "_users WHERE username=?");
  $stmt
  check if user exists.
  */
//  if(true) // if has permissions to view file...
//  {
//    $file = "./avatars/" . $_GET['u'] . "." $_GET['t'];
//    header('Expires: 0');
//    header('Content-Length: ' . filesize($file));
//    if($_GET['type'] == 'png')
//      header("Content-type: image/png");
//    if($_GET['type'] == 'gif')
//      header("Content-type: image/gif");
//    if($_GET['type'] == 'jpg')
//      header("Content-type: image/jpeg");
//    readfile("$file");
//    exit;
//  }
//}
//else{
  header("Content-type: image/png");
  $file = "./avatars/_default_.png";
  readfile($file);
  exit;
//}
//


//header('Content-type: text/plain');
//echo $_GET['u'] . " " . $_GET['t'];
?>
