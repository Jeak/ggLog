<?php

$iploc = "../58/";

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

  $navpages = array(new navitem("index.php", "Home")); //adding the pages
  $navpages[] = new navitem("demo.php","Logs");
//  $navpages[] = new navitem("people.php","People");
  $navpages[] = new navitem("about.php","About");

  echo "<div style=\"position:fixed;z-index:10;background-image:url('fade.png');top:0;width:100%;padding-left:5%;padding-top:10px;border-bottom-style:solid;border-width:3px;border-color:#557c48;height:60px;\" ><img style=\"float:left;height:39px;margin-right:15px;\" src=\"logo.png\">";
  echo "<div class=\"navbar\" style=\"margin-top:0;float:left;\">";
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
  echo "</div></div><div style=\"clear:both;position:block;height:70px;width:100%;\" /></div>\n";
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
