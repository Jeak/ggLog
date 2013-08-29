<?php
function dbfilename()
{
  return dirname(__FILE__) . "/ipm.db";
}

function allowed($name)
{
  $dev = array();
  $dev[] = 'JG';
  $dev[] = 'Jack Gallegos';
  $dev[] = 'David Berard';
  $dev[] = 'John Nover';

  foreach ( $dev as $i )
  {
    if($name == $i )
      return true;
  }
  return false;
}

function IPadd()
{
  $dbhandle = sqlite_open(dbfilename(), 0666, $error);
  if (!$dbhandle) die ($error);
  
  $myip = sqlite_escape_string($_SERVER["REMOTE_ADDR"]);
  $ipexists = false;
  $visits = 0;

  $query = "SELECT address, visits FROM ip";
  $result = sqlite_query($dbhandle, $query);
  if (!$result) die("Cannot execute query.");

  while ($row = sqlite_fetch_array($result, SQLITE_NUM))
  {
    if($row[0] == $myip)
    {
      $ipexists = true;
      $visits = $row[1];
      break;
    }
  }
  ++$visits;

  if($ipexists)
  {
    $stm = "UPDATE ip SET visits=$visits WHERE address='$myip'";
    $ok = sqlite_exec($dbhandle, $stm, $error);
    if (!$ok) die("Cannot execute query. $error"); 
  }
  else
  {
    $stm = "INSERT INTO ip VALUES('$myip', '', 1)";
    $ok = sqlite_exec($dbhandle, $stm, $error);
    if (!$ok) die("Cannot execute query. $error"); 
  }
  sqlite_close($dbhandle);

  IPview();
}

function IPreplace($ipin)
{
  $dbhandle = sqlite_open(dbfilename(), 0666, $error);
  if (!$dbhandle) die ($error);

  $query = "SELECT name FROM ip WHERE address='$ipin'";
  $result = sqlite_query($dbhandle, $query);
  if (!$result) die("Cannot execute query.");

  $out = "";
  $row = sqlite_fetch_array($result, SQLITE_NUM);
  if($row == false)
    $out = $ipin;
  else
    $out = $row[0];
  
  sqlite_close($dbhandle);
  return $out;
}

function IPsetup()
{
  $dbhandle = sqlite_open(dbfilename(), 0666, $error);
  if (!$dbhandle) die ($error);
  
  $stm = "CREATE TABLE ip(address text UNIQUE NOT NULL, name text, visits int)";
  $ok = sqlite_exec($dbhandle, $stm, $error);
  if (!$ok) die("Cannot execute query. $error"); 

  sqlite_close($dbhandle);
}

function IPview()
{
  $dbhandle = sqlite_open(dbfilename(), 0666, $error);
  if (!$dbhandle) die ($error);

  $query = "SELECT address, name, visits FROM ip";
  $result = sqlite_query($dbhandle, $query);
  if (!$result) die("Cannot execute query.");

  $out = "";

  $out .= "<table width=\"500\" border=\"1\"><tr style=\"background-color:#000000;color:#FFFFFF\"><td width=\"150\">IP</td><td width=\"200\">Name</td><td width=\"100\">Visits</td><td width=\"50\">Edit</td></tr>";
  while ($row = sqlite_fetch_array($result, SQLITE_NUM))
  {
    $out .= "<tr>";
    $out .= "<form action=\"IPmanage.php\" method=\"post\"><input type=\"hidden\" value=\"" . $row[0] . "\" name=\"ip\"/>";

    $out .= "<td>";
    $out .= $row[0];
    $out .= "</td>\n";

      $out .= "<td>";
    if($row[1] != "")
      $out .= $row[1];
    else
      $out .= "<input type=\"text\" name=\"name\" value=\"\"/>";
    $out .= "</td>\n";

    $out .= "<td>";
    $out .= $row[2] . " visits";
    $out .= "</td>\n";

    $out .= "<td><input type=\"submit\" value=\"save\"/></td>\n";
 
    $out .= "</form></tr>";
  }
  $out .= "</table>";
  
  sqlite_close($dbhandle);
  return $out;
}

function IPupdate($ip, $name)
{
  $dbhandle = sqlite_open(dbfilename(), 0666, $error);
  if (!$dbhandle) die ($error);
  
  $name = sqlite_escape_string($name);
  $ip = sqlite_escape_string($ip);
  $stm = "UPDATE ip SET name = '$name' WHERE address = '$ip'";
  $ok = sqlite_exec($dbhandle, $stm, $error);

  sqlite_close($dbhandle);
}

if( $_POST['name'] != "" && $_POST['name'] != NULL)
{
  if(allowed(IPreplace($_SERVER["REMOTE_ADDR"])) == true)
    IPupdate($_POST['ip'], $_POST['name']);
}

?>
