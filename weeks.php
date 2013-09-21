<?php

class singleWeek
{
  public $beginday;
  public $endday;
  public $distance;
  public $time;
  public $numberofruns;

  function __construct($newday, $beginning = 1)
  {
    $this->distance = 0;
    $this->time = 0;
    $this->numberofruns = 0;
    $this->set($newday, $beginning);
  }

  function set($newday, $beginning = 1)
  {
    $this->beginday = singleWeek::weekBeginning($newday, $beginning);
    $this->endday = $this->beginday + 6*60*60*24;
  }
  
  function isPartOfWeek($newday)
  {
    $dow = intval(date('w', $newday));
    $begindow = intval(date('w', $this->beginday));
    $diff = $dow - $begindow; // days from beginning of the week
    if($diff < 0) // if negative, change to positive, see function set()
      $diff += 7;
    $tocheckday = $this->beginday + $diff*(60*60*24);

    if ( intval(date('o', $tocheckday)) == intval(date('o', $newday))
      && intval(date('z', $tocheckday)) == intval(date('z', $newday)))
    {
      return true;
    }
    return false;
  }

  function addmiles($dist)
  {
    $this->distance += $dist;
    $this->numberofruns += 1;
  }

  function addtime($time)
  {
    $this->time += $time;
    $this->numberofruns += 1;
  }

  static function weekbeginning($newday, $beginning)
  {
    $dow = intval(date('w', $newday)); // day of week
    $diff = $dow - $beginning; // $dow = Tuesday [2]; $beginning = Monday [1];  $diff = 1
    if($dow < $beginning) // $dow = 0; $beginning = 1; will change $dow to be +1 day, 
    {                     //   but that's the next week, so -1 week;
      $diff +=7;
    }
    return ($newday - $diff * (60 * 60 *24));
  }

  function strout()
  {
    $end = $this->beginday + 6 * (60*24*24);
    $out = date('Y-m-d', $this->beginday);
    $out .=" to ";
    $out .=date('Y-m-d', $end);
    $out .=" with ";
    $out .=$this->distance;
    $out .=" miles and ";
    $out .=$this->time;
    $out .=" seconds.";
    return $out;
  }
  
}

class weekManage
{
  public $weeks;
  public $weekbegin; // week begin date (Sun, Mon, etc);
  public $constrained;
  public $constraints;

  function __construct($weekbegin = 1, $constrained = false, $earliest = 0, $latest = 0)
  {
    $this->weekbegin = $weekbegin;
    $this->constrained = $constrained;
    if($constrained == true)
    {
      $this->constrain($earliest, $latest);
    }
  }

  function constrain($earliest, $latest)
  {
    $this->constrained = true;
    if($latest < $earliest) // make sure that $earliest is before $latest
    {
      $ne = $latest;
      $latest = $earliest;
      $earliest = $ne;
    }
    
    $counter = $earliest;
    while(true)
    {
      $newweek = new singleWeek($counter, $this->weekbegin);
      $this->constraints[] = $newweek;
      if($newweek->isPartOfWeek($latest))
        break;
      $counter += (60*60*24*7);
    }
  }
 
  function isPartOf($newdate)
  {
    if($this->constrained == false)
      return true;
    foreach($this->constraints as $legalweek)
    {
      if($legalweek->isPartOfWeek($newdate))
        return true;
    }
    return false;
  }

  function createweek($newdate)
  {
    for($i=0;$i<count($this->weeks);++$i)
    {
      if($this->weeks[$i]->isPartOfWeek($newdate))
        return $i;
    }
    $loc = count($this->weeks);
    $this->weeks[] = new singleWeek($newdate, $this->weekbegin);
    return $loc;
  }

  function addmiles($newdate, $dist)
  {
    if($this->isPartOf($newdate))
    {
      $loc = $this->createweek($newdate);
      $this->weeks[$loc]->addmiles($dist);
    }
  }

  function addtime($newdate, $time)
  {
    if($this->isPartOf($newdate))
    {
    $loc = $this->createweek($newdate);
    $this->weeks[$loc]->addtime($time);
    }
  }

  function adddate($newdate)
  {
    if($this->isPartOf($newdate))
    {
    $loc = $this->createweek($newdate);
    }
  }

  function get($date)
  {
    foreach($this->weeks as $week)
    {
      if($week->isPartOfWeek($date))
        return $week;
    }
  }

  function totaldistance()
  {
    $tdist = 0;
    for($i=0;$i<count($this->weeks);++$i)
    {
      $tdist += $this->weeks[$i]->distance;
    }
    return $tdist;
  }

}

/*$wm = new weekManage();
$wm->addmiles(time(), 5);
$wm->addtime(time(), 555);
$wm->addmiles(time(), 13);
$wm->addmiles(time(), 13);

echo $wm->get(time())->strout();*/


?>
