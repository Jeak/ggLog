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
  //Desktop version
  echo "<div class=\"navbar ggLog-navbar-desktop\" id=\"ggNavbarDesktop\">";
  echo "<ul class=\"nav nav-tabs\">";
  for($i=0;$i<count($navpages);++$i)
  {
    if($activepage == $navpages[$i]->pageurl)
      echo "<li class=\"active\">";
    else
      echo "<li>";
    echo "<a href=\"" . $navpages[$i]->pageurl . "\" >" . $navpages[$i]->pagename . "</a>";
    echo "</li>";
  }
  echo "</ul>";
  echo "</div>";

  // Mobile version
  echo "<div class=\"ggLog-navbar-mobile\" id=\"ggNavbarMobile\">";
  echo "  <div class=\"dropdown\">";
  echo "    <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">";
  echo "      <span class=\"glyphicon glyphicon-menu-hamburger\"></span>";
  echo "    </button>";
  echo "    <ul class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"dropdownMenu1\">";
  for($i=0;$i<count($navpages);++$i)
  {
    if($activepage != $navpages[$i]->pageurl)
      echo "<li><a href=\"" . $navpages[$i]->pageurl . "\">" . $navpages[$i]->pagename . "</a></li>";
    else
      echo "<li><a href=\"" . $navpages[$i]->pageurl . "\">" . $navpages[$i]->pagename . "</a></li>";
  }
  echo "    </ul>";
  echo "  </div>";
  echo "</div>";
  // Endng (all)
  echo "</div>";
  echo "<div style=\"clear:both;position:block;height:70px;width:100%;\" /></div><script type=\"text/javascript\">setNavbar();</script>\n";
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
