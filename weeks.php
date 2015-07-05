<?php
  // An attempt at making things faster: date() is slow
  // Pass things around as an integer: # days since 1 Jan 1970.
  // 1 Jan 1970 = 0; 2 Jan 1970 = 1; etc.

  // Every day is core day!
  function is_core_day()
  {
    return true;
  }
  function today_exercises()
  {
    return "It's core day!";
  }
  //function intrp(type, dayNum)
  // or function intrp(dayNum, array of types)
  function intrp($p1, $p2)
  {
    if(gettype($p1) == "string")
    {
      $type = $p1;
      $dayNum = $p2;
      if($type == 'L')
        return intrp_L($dayNum);
      if($type == 'Y')
        return intrp_Y($dayNum);
      if($type == 'w')
        return intrp_w($dayNum);
      if($type == 'z')
        return intrp_z($dayNum);
      if($type == 'm')
        return intrp_m($dayNum);
      if($type == 'j')
        return intrp_j($dayNum);
      if($type == 'M')
        return intrp_capM($dayNum);
    }
    else // array of types
    {
      $output = "";
      foreach($p2 as $type)
      {
        $output .= intrp($type, $p1) . " ";
      }
      return $output;
    }
  }
  function intrp_w($dayNum)
  {
    return ($dayNum+4)%7;
  }
  function intrp_L($dayNum)
  {
    if(intrp_Y($dayNum)%4 == 0)
      return true;
    return false;
  }
  function intrp_Y($dayNum)
  {
    return intval(($dayNum-intval(($dayNum+365)/1461))/365)+1970;
  }
  function intrp_z($dayNum)
  {
    $val = ($dayNum+365)%1461;
    //echo "intrp_z $dayNum $val " . gettype($val) . "  ";
    if($val == 1460)
      return 365;
    return $val%365;
  }
  function intrp_m(&$dayNum)
  {
    $doy = intrp_z($dayNum);
    $offset = 0;
    if(intrp_L($dayNum))
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
  function intrp_capM($dayNum, $thisIsMonth = false)
  {
    $marr = array(0, "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    if($thisIsMonth == true && $dayNum >= 1 && $dayNum <= 12)
    {
      return $marr[$dayNum];
    }
    return $marr[intrp_m($dayNum)];
  }
  function intrp_j($dayNum)
  {
    $doy = intrp_z($dayNum);
    $offset = 0;
    if(intrp_L($dayNum))
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
  function monthOffset($month)
  {
    // for a non-leap year
    if($month > 12 || $month < 1)
      return false;
    $arr = array(null, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    return $arr[$month];
  }
  function ggcreateSQLdate($dayNum)
  {
    $month = intrp_m($dayNum);
    $date = intrp_j($dayNum);
    $output = intrp_Y($dayNum) . "-";
    if($month < 10)
      $output .= "0";
    $output .= $month;
    if($date < 10)
      $output .= "0";
    $output .= $date;
    return $output;
  }
  function ggreadSQLdate($input)
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

    $output += monthOffset($month);
    if($year%4 == 0 && $month > 2) // add 1 if is > Feb of leapyear
      ++$output;

    $output += $day -1;
    return $output;
  }
  // date() time method
  function fromDate($timestamp)
  {
    return readSQLdate(date("Y-m-j", $timestamp));
  }
  function toDate($dayNum)
  {
    return strtotime(createSQLdate);
  }
  // Perhaps create non-static functions.

class weekManage
{
  //Weeks will be stored as the index of arrays; it will be the first
  // day of that week.  Ex: Jul 6 2015 is a Monday.  If you enter
  // Jul 8 2015, that week will be denoted as the number for Jul 6, '15.
  // Will be different if weekbegin is not a monday. (Sunday = 0)
  public $weekbeginning = 1; // on a Monday
  public $totaldistance = 0;
  public $totaltime = 0;
  public $timeArray = array();
  public $milesArray = array();

  public function __construct()
  {
    $this->weekbeginning = 1;
    $this->totaldistance = 0;
    $this->totaltime = 0;
    $this->timeArray = array();
    $this->milesArray = array();
  }

// Finds the date relating to the beginning of the week of a certain date.
  public function toBegin($dayNum)
  {
    $dow = intrp_w($dayNum);
    $out = $dayNum - $dow + $this->weekbeginning; // $dayNum-($dow-$weekbeginning);
    if($dow < $this->weekbeginning)
      $out -= 7;
    return $out;
  }

  public function addtime($dayNum, $time)
  {
    $begin = $this->toBegin($dayNum);
    if(isset($this->timeArray[$begin]))
    {
      $this->timeArray[$begin] += $time;
    }
    else
    {
      $this->timeArray[$begin] = $time;
      $this->milesArray[$begin] = 0;
    }
    $this->totaltime += $time;
  }
  public function addmiles($dayNum, $miles)
  {
    $begin = $this->toBegin($dayNum);
    if(isset($this->milesArray[$begin]))
    {
      $this->milesArray[$begin] += $miles;
    }
    else
    {
      $this->timeArray[$begin] = 0;
      $this->milesArray[$begin] = $miles;
    }
    $this->totaldistance += $miles;
  }
  public function addboth($dayNum, $time, $miles)
  {
    $begin = $this->toBegin($dayNum);
    if(isset($this->milesArray[$begin]))
    {
      $this->milesArray[$begin] += $miles;
      $this->timeArray[$begin] += $time;
    }
    else
    {
      $this->timeArray[$begin] = $time;
      $this->milesArray[$begin] = $miles;
    }
    $this->totaldistance += $distance;
    $this->totaltime += $time;
  }
  public function weekArray()
  {
    $outarray = array(); // array of arrays
    // each array is in the form
    // array(beginday, endday, distance, time);

    $orderarray = array();
    foreach($this->timeArray as $key => $val)
    {
      $orderarray[] = $key;
    }
    sort($orderarray);
    foreach($orderarray as $weekbase)
    {
      $outarray[] = array($weekbase, $weekbase+6,
        $this->milesArray[$weekbase], $this->timeArray[$weekbase]);
    }
    return $outarray;
  }
}
/*$wm = new weekManage();
$wm->addmiles(time(), 5);
$wm->addtime(time(), 555);
$wm->addmiles(time(), 13);
$wm->addmiles(time(), 13);

echo $wm->get(time())->strout();*/


?>
