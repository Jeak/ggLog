<?php

$iploc = "../58/";

#require_once($iploc . "IPmanage.php");

class navitem
{
  public $pageurl;
  public $pagename;
  
  function __construct($pageurl, $pagename)
  {
    $this->pageurl=$pageurl;
    $this->pagename=$pagename;
  }
}

function navbar($activepage)
{
#  IPadd();
  $navpages = array(new navitem("index.php", "Home")); //adding the pages
  $navpages[] = new navitem("demo.php","Logs");
//  $navpages[] = new navitem("people.php","People");
  $navpages[] = new navitem("about.php","About");

  echo "<div style=\"position:relative;width:90%;margin-left:5%;\" >";
  echo "<div class=\"navbar\" style=\"margin-top:0;\"></div>";
  echo "<ul class=\"nav nav-tabs\">";
  for($i=0;$i<count($navpages);++$i)
  {
    if($activepage == $navpages[$i]->pageurl)
      echo "<li class=\"active\">";
    else
      echo "<li>";
    echo "<a href=\"" . $navpages[$i]->pageurl . "\">" . $navpages[$i]->pagename . "</a>";
    echo "</li>";
  }
  echo "</ul>";
  echo "</div>\n";
}
/*  
   <div class="container">
    <div class="navbar"></div>
      <ul class="nav nav-tabs">
        <li>
          <a href="index.php">Home</a>
        </li>
        <li class="active">
          <a href="demo.php">Logs</a>
        </li>
      </ul>
    </div>
  */
?>
