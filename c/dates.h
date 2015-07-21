#ifndef GGLOG_C_DATE_STUFF
#define GGLOG_C_DATE_STUFF

// An attempt at making things faster: date() is slow
// Pass things around as an integer: # days since 1 Jan 1970.
// 1 Jan 1970 = 0; 2 Jan 1970 = 1; etc.

char checkdate(int year, int month, int date);

// Every day is core day!
char is_core_day();
char * today_exercises();
//function intrp(type, dayNum)
// or function intrp(dayNum, array of types)

int intrp_w(int dayNum);
char* intrp_D(int dayNum);
char intrp_L(int dayNum);
int intrp_Y(int dayNum);
int intrp_z(int dayNum);
int intrp_m(int dayNum);

char intrp_capM(int dayNum);
char intrp_capM(int dayNum, char thisIsMonth);
int intrp_j(int dayNum);
int monthOffset(int month);
function ggcreatedate($year, $month, $date)
{
  if(!checkdate($month, $date, $year))
    return false;
  // For leapyears, note that Jan 1 still occurs on the expected date
  //  value because the extra day does not occur until Feb.
  $output = ($year-1970)*365;
  $output += floor(($year-1969)/4); // add one for every previous leapyear.

  $output += monthOffset($month);
  if($year%4 == 0 && $month > 2) // add 1 if is > Feb of leapyear
    ++$output;

  $output += $date -1;
  return $output;
}
function ggcreateSQLdate($dayNum)
{
  $month = intrp_m($dayNum);
  $date = intrp_j($dayNum);
  $output = intrp_Y($dayNum) . "-";
  if($month < 10)
    $output .= "0";
  $output .= $month . "-";
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



#endif
