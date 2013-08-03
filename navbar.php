<?php
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

  echo "<div class=\"container\">\n";
  echo "  <div class=\"navbar\"></div>\n";
  echo "  <ul class=\"nav nav-tabs\">\n";
  for($i=0;$i<count($navpages);++$i)
  {
    if($activepage == $navpages[$i]->pageurl)
      echo "    <li class=\"active\">\n";
    else
      echo "    <li>\n";
    echo "      <a href=\"" . $navpages[$i]->pageurl . "\">" . $navpages[$i]->pagename . "</a>\n";
    echo "    </li>\n";
  }
  echo "  </ul>\n";
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
