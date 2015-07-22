#include "dates.h"

// An attempt at making things faster: date() is slow
// Pass things around as an integer: # days since 1 Jan 1970.
// 1 Jan 1970 = 0; 2 Jan 1970 = 1; etc.

char checkdate(int year, int month, int day)
{
  int monthlengths[13] = {0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 };

  if(year%4 == 0) // Leapyears
    monthlengths[2] = 29;

  if(month < 1 || month > 12)
    return 0;
  if(day < 1 || day > monthlengths[month])
    return 0;
  // If it hasn't been deemed invalid, it's valid.
  return 1;
}

// Every day is core day!
char is_core_day()
{
  return 1;
}
char * today_exercises()
{
  char out[] = "It's core day!";
  return out;
}
//function intrp(type, dayNum)
// or function intrp(dayNum, array of types)

int intrp_w(int dayNum)
{
  return (dayNum+4)%7;
}
char* intrp_D(int dayNum)
{
  char dnar[7][4] = {"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"};
  return dnar[intrp_w(dayNum)];
}
char intrp_L(int dayNum)
{
  if(intrp_Y(dayNum)%4 == 0)
    return true;
  return false;
}
int intrp_Y(int dayNum)
{
  return ((int) ((dayNum-((int) ((dayNum+365)/1461)))/365))+1970;
}
int intrp_z(int dayNum)
{
  int val = (dayNum+365)%1461;
  //echo "intrp_z $dayNum $val " . gettype($val) . "  ";
  if(val == 1460)
    return 365;
  return val%365;
}
int intrp_m(int dayNum)
{
  int doy = intrp_z(dayNum);
  int offset = 0;
  if(intrp_L(dayNum))
    ++offset;

  if(doy >= 334+offset)
    return 12;
  if(doy >= 304+offset)
    return 11;
  if(doy >= 273+offset)
    return 10;
  if(doy >= 243+offset)
    return 9;
  if(doy >= 212+offset)
    return 8;
  if(doy >= 181+offset)
    return 7;
  if(doy >= 151+offset)
    return 6;
  if(doy >= 120+offset)
    return 5;
  if(doy >= 90+offset)
    return 4;
  if(doy >= 59+offset)
    return 3;
  if(doy >= 31)
    return 2;
  return 1;
}
char * intrp_capM(int dayNum, char thisIsMonth)
{
  char marr[13][4] = {"abc", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"};
  if(thisIsMonth == 1 && dayNum >= 1 && dayNum <= 12)
  {
    return marr[dayNum];
  }
  return marr[intrp_m(dayNum)];
}
char * intrp_capM(int dayNum)
{
  return intrp_capM(dayNum, 0);
}
int intrp_j(int dayNum)
{
  int doy = intrp_z(dayNum);
  int offset = 0;
  if(intrp_L(dayNum))
    ++offset;
  if(doy >= 334+offset)
    return (1+doy-334-offset);
  if(doy >= 304+offset)
    return (1+doy-304-offset);
  if(doy >= 273+offset)
    return (1+doy-273-offset);
  if(doy >= 243+offset)
    return (1+doy-243-offset);
  if(doy >= 212+offset)
    return (1+doy-212-offset);
  if(doy >= 181+offset)
    return (1+doy-181-offset);
  if(doy >= 151+offset)
    return (1+doy-151-offset);
  if(doy >= 120+offset)
    return (1+doy-120-offset);
  if(doy >= 90+offset)
    return (1+doy-90-offset);
  if(doy >= 59+offset)
    return (1+doy-59-offset);
  if(doy >= 31)
    return (1+doy-31);
  return (1+doy);
}
int monthOffset(int month)
{
  // for a non-leap year
  if(month > 12 || month < 1)
    return -1;
  int arr[13] = {null, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334};
  return arr[month];
}
int ggcreatedate(int year, int month, int date)
{
  if(!checkdate(month, date, year))
    return -1;
  // For leapyears, note that Jan 1 still occurs on the expected date
  //  value because the extra day does not occur until Feb.
  int output = (year-1970)*365;
  output += ((int) ((year-1969)/4)); // add one for every previous leapyear.

  output += monthOffset(month);
  if(year%4 == 0 && month > 2) // add 1 if is > Feb of leapyear
    ++output;

  output += date -1;
  return output;
}
char * ggcreateSQLdate(int dayNum)
{
  int year = intrp_Y(dayNum);
  int month = intrp_m(dayNum);
  int date = intrp_j(dayNum);
  char output[11];
  output[0] = ((int) (year/1000))+48;
  output[1] = ((int) (year/100))%10+48;
  output[2] = ((int) (year/10))%100+48;
  output[3] = year%1000+48;
  output[4] = '-';
  output[5] = ((int) (month/10))+48;
  output[6] = month%10+48;
  output[7] = '-';
  output[8] = ((int) (date/10))+48;
  output[9] = date%10+48;
  output[10] = '\0';
  return output;
}
int ggreadSQLdate(char *input)
{
  int year, month, day, dateint[3], i, j, counta, countb;
  year=month=day=counta=countb=0;
  char datestr[3][5];
  for(i=0;i<strlen(input) && input[i] != '\0'l++i)
  {
    if(input[i] == '-')
    {
      datestr[counta][countb] = '\0';
      countb = 0;
      ++counta;
    }
    else
    {
      datestr[counta][countb] = input[i];
      ++countb;
    }
  }
  for(i=0;i<3;++i)
  {
    dateint[i] = 0;
    for(j=0;j<strlen(datestr[i]);++j)
    {
      dateint[i] *= 10;
      dateint[i] += datestr[i]-48;
    }
  }
  year = dateint[0];
  month = dateint[1];
  day = dateint[2];

  // For leapyears, note that Jan 1 still occurs on the expected date
  //  value because the extra day does not occur until Feb.
  int output = (year-1970)*365;
  output += ((int) ((year-1969)/4));

  output += monthOffset(month);
  if(year%4 == 0 && month > 2)
    ++output;
  output += day - 1;
  return output;
}
