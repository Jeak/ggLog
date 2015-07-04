<?php

class ggDay
{
  // An attempt at making things faster: date() is slow
  // Pass things around as an integer: # days since 1 Jan 1970.
  // 1 Jan 1970 = 0; 2 Jan 1970 = 1; etc.
  public $dayInt; // days since 1 Jan 1970.
  public static function intrp($type, $dayNum)
  {
    if($type == 'w')
      return intrp_w($dayNum);
    if($type == 'Y')
      return intrp_Y($dayNum);
  }
  public static function intrp_w($dayNum)
  {
    return ($dayNum+4)%7;
  }
  public static function intrp_L($dayNum)
  {
    if(ggDay::intrp_Y($dayNum)%4 == 0)
      return true;
    return false;
  }
  public static function intrp_Y($dayNum)
  {
    return intval(($dayNum-intval(($dayNum+365)/1461))/365)+1970;
  }
  public static function intrp_z($dayNum)
  {
    $val = ($dayNum+365)%1461;
    //echo "intrp_z $dayNum $val " . gettype($val) . "  ";
    if($val == 1460)
      return 365;
    return $val%365;
  }
  public static function intrp_m(&$dayNum)
  {
    $doy = ggDay::intrp_z($dayNum);
    $offset = 0;
    if(ggDay::intrp_L($dayNum))
      ++$offset;

    if($doy >= 334+$offset)
      return 12;
    if($doy >= 304+$offset)
      return 11;
    if($doy >= 273+$offset)
      return 10;
    if($doy >= 243+$offset)
      return 9;
    if($doy >= 212+$offset)
      return 8;
    if($doy >= 181+$offset)
      return 7;
    if($doy >= 151+$offset)
      return 6;
    if($doy >= 120+$offset)
      return 5;
    if($doy >= 90+$offset)
      return 4;
    if($doy >= 59+$offset)
      return 3;
    if($doy >= 31)
      return 2;
    return 1;
  }
  public static function intrp_j($dayNum)
  {
    $doy = ggDay::intrp_z($dayNum);
    $offset = 0;
    if(ggDay::intrp_L($dayNum))
      ++$offset;
    if($doy >= 334+$offset)
      return (1+$doy-334-$offset);
    if($doy >= 304+$offset)
      return (1+$doy-304-$offset);
    if($doy >= 273+$offset)
      return (1+$doy-273-$offset);
    if($doy >= 243+$offset)
      return (1+$doy-243-$offset);
    if($doy >= 212+$offset)
      return (1+$doy-212-$offset);
    if($doy >= 181+$offset)
      return (1+$doy-181-$offset);
    if($doy >= 151+$offset)
      return (1+$doy-151-$offset);
    if($doy >= 120+$offset)
      return (1+$doy-120-$offset);
    if($doy >= 90+$offset)
      return (1+$doy-90-$offset);
    if($doy >= 59+$offset)
      return (1+$doy-59-$offset);
    if($doy >= 31)
      return (1+$doy-31);
    return (1+$doy);
  }
  public static function monthOffset($month)
  {
    // for a non-leap year
    if($month > 12 || $month < 1)
      return false;
    $arr = array(null, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    return $arr[$month];
  }
  public static function readSQLdate($input)
  {
    $parts = explode("-", $input);
    if(count($parts) != 3)
      return false;
    $year =intval($parts[0]);
    $month =intval($parts[1]);
    $day =intval($parts[2]);

    // For leapyears, note that Jan 1 still occurs on the expected date
    //  value because the extra day does not occur until Feb.
    $output = ($year-1970)*365;
    $output += floor(($year-1969)/4); // add one for every previous leapyear.

    $output += ggDay::monthOffset($month);
    if($year%4 == 0 && $month > 2) // add 1 if is > Feb of leapyear
      ++$output;

    $output += $day -1;
    return $output;
  }
  // Perhaps create non-static functions.
}

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
  public $constrained; // boolean: is it limited to certain timespan?
  public $constraints;  // array of singleWeek

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
  /*
    for($i=0;$i<count($this->weeks);++$i)
    {
      if($this->weeks[$i]->isPartOfWeek($newdate))
        return $i;
    } */
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
  function totaltime()
  {
    $ttime = 0;
    for($i=0;$i<count($this->weeks);++$i)
    {
      $ttime += $this->weeks[$i]->time;
    }
    return $ttime;
  }

}
/*$wm = new weekManage();
$wm->addmiles(time(), 5);
$wm->addtime(time(), 555);
$wm->addmiles(time(), 13);
$wm->addmiles(time(), 13);

echo $wm->get(time())->strout();*/


?>
