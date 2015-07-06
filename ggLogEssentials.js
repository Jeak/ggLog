function IsMobileBrowser()
{
  var check=false;
  (function(a,b){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check=true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}
function SetDateDropdown(idname, prefix, showlabel, year, month, date)
{
  if(typeof prefix === "undefined")
  {
    prefix = "";
  }
  if(typeof showlabel === "undefined")
  {
    showlabel = true;
  }
  var today = new Date();
  var todayyear = today.getUTCFullYear();
  if(typeof date === "undefined")
  {
    year = todayyear;
    date = today.getDate();
    month = today.getMonth();
  }
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  var contents ="";
  if(showlabel == true)
  {
    contents += "Date: ";
  }
  contents +="<select name=\"" + prefix + "month\" style=\"width:70px;padding-left:3px;padding-right:3px;\" class=\"mblil form-control\"> ";
  for(var i=0;i<12;++i)
  {
  var j = i+1; // javascript dates are 0-11, while php dates are 1-12
    if(i == month)
    {
      contents += "<option value=\"" + j + "\" selected>" + months[i] + "</option>";
    }
    else
    {
      contents += "<option value=\"" + j + "\">" + months[i] + "</option>";
    }
  }

//  var contents ="Date: <select name=\"month\" style=\"width:70px;\">  <option value=\"1\">Jan</option>  <option value=\"2\">Feb</option>  <option value=\"3\">Mar</option>  <option value=\"4\">Apr</option>  <option value=\"5\">May</option>  <option value=\"6\">Jun</option>  <option value=\"7\">Jul</option>  <option value=\"8\">Aug</option>  <option value=\"9\">Sep</option>  <option value=\"10\">Oct</option>  <option value=\"11\">Nov</option>  <option value=\"12\">Dec</option></select> ";
  contents += "</select>"
  contents += "<select name=\"" + prefix + "day\" style=\"width:60px;padding-left:3px;padding-right:3px;\" class=\"mblil form-control\">";
  for(var i=1;i<32;i++)
  {
    if(i == date)
    {
      contents += "<option value=\"" + i + "\" selected>" + i + "</option>";
    }
    else
    {
      contents += "<option value=\"" + i + "\">" + i + "</option>";
    }
  }
  contents += "</select> ";
  contents += "<select name=\"" + prefix + "year\" style=\"width:70px;padding-left:3px;padding-right:3px;\" class=\"mblil form-control\">";
  var diff = Math.abs(todayyear - year) +1;
  if(diff < 7)
  {
    diff = 7;
  }
  diff*= -1;
  for(var i=0;i>diff;i--)
  {
    if(year == (todayyear+i))
    {
      contents += "<option value=\"" + (todayyear+i) + "\" selected>" + (todayyear+i) + "</option>";
    }
    else
    {
      contents += "<option value=\"" + (todayyear+i) + "\">" + (todayyear+i) + "</option>";
    }
  }
  contents += "</select>";

  document.getElementById(idname).innerHTML = contents;
}


function decodeseasondates(str, type)
{
  var parts = str.split(' to ');
  for(var i=0;i<parts.length;++i)
  {
    parts[i] = parts[i].split(" ");
    var datevar = new Date(parts[i][0] + " 13 2013");
    parts[i][0] = datevar.getMonth();
    parts[i][1] = parseInt(parts[i][1]);
    parts[i][2] = parseInt(parts[i][2]);
  }
  switch (type)
  {
    case 1: return parts[0][0]; break;
    case 2: return parts[0][1]; break;
    case 3: return parts[0][2]; break;
    case 4: return parts[1][0]; break;
    case 5: return parts[1][1]; break;
    case 6: return parts[1][2]; break;
  }
  return parts[0][0];
}

function decodetime(str, type)
           //    '1:24:41', 'h' would return 1; (--, 'm') would return 24;
{
  var parts = str.split(':');
  if(type == 'h' || type == 0)
  {
    return parseInt(parts[0]);
  }
  if(type == 'm' || type == 1)
  {
    return parseInt(parts[1]);
  }
  if(type == 's' || type == 2)
  {
    return parseInt(parts[2]);
  }
  return -1;
}

// note: these functions are taken from 'weeks.php' They follow the PHP method
// of representing months: using 1 as Jan, instead of 0 as javascript does.

function intrp(p1, p2)
{
  if(typeof(p1) == "string")
  {
    var type = p1;
    var dayNum = p2;
    if(type == 'L')
      return intrp_L(dayNum);
    if(type == 'Y')
      return intrp_Y(dayNum);
    if(type == 'w')
      return intrp_w(dayNum);
    if(type == 'z')
      return intrp_z(dayNum);
    if(type == 'm')
      return intrp_m(dayNum);
    if(type == 'j')
      return intrp_j(dayNum);
    if(type == 'M')
      return intrp_capM(dayNum);
    if(type == 'D')
      return intrp_D(dayNum);
  }
  else // array of types
  {
    var output = "";
    for(var i=0;i<p2.length;++i)
    {
      output += intrp(p2[i], p1) + " ";
    }
    return output;
  }
}
function intrp_w(dayNum)
{
  return (dayNum+4)%7;
}
// 1 is Sunday.
function intrp_D(dayNum)
{
  var dnar = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  return dnar[intrp_w(dayNum)];
}
function intrp_L(dayNum)
{
  if(intrp_Y(dayNum)%4 == 0)
    return true;
  return false;
}
function intrp_Y(dayNum)
{
  return Math.floor((dayNum-Math.floor((dayNum+365)/1461))/365)+1970;
}
function intrp_z(dayNum)
{
  var val = (dayNum+365)%1461;
  //echo "intrp_z $dayNum $val " . gettype($val) . "  ";
  if(val == 1460)
    return 365;
  return val%365;
}
// See above at intrp(): this uses PHP dates (1 as Jan, not 0)
function intrp_m(dayNum)
{
  var doy = intrp_z(dayNum);
  var offset = 0;
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
// Warning: see above at intrp(): this uses PHP dates, with 1 as Jan (not 0)
function intrp_capM(dayNum, thisIsMonth)
{
  if(typeof thisIsMonth == 'undefined')
    thisIsMonth = false;
  var marr = [, "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  if(thisIsMonth == true && dayNum >= 1 && dayNum <= 12)
  {
    return marr[dayNum];
  }
  return marr[intrp_m(dayNum)];
}
function intrp_j(dayNum)
{
  var doy = intrp_z(dayNum);
  var offset = 0;
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
// This uses PHP dates, not javascript: 1 is Jan, instead of 0.
function monthOffset(month)
{
  // for a non-leap year
  if(month > 12 || month < 1)
    return false;
  var arr = [null, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
  return arr[month];
}
// Using 1 as Jan
function ggcreatedate(year, month, date)
{
  // For leapyears, note that Jan 1 still occurs on the expected date
  //  value because the extra day does not occur until Feb.
  var output = (year-1970)*365;
  output += floor((year-1969)/4); // add one for every previous leapyear.

  output += monthOffset(month);
  if(year%4 == 0 && month > 2) // add 1 if is > Feb of leapyear
    ++output;

  output += date -1;
  return output;
}

function ggcreateSQLdate(dayNum)
{
  var month = intrp_m(dayNum);
  var date = intrp_j(dayNum);
  var output = intrp_Y(dayNum) + "-";
  if(month < 10)
    output += "0";
  output += month + "-";
  if(date < 10)
    output += "0";
  output += date;
  return output;
}

function ggreadSQLdate(input)
{
  var parts = input.split("-");
  if(parts.length != 3)
    return false;
  var year =parseInt(parts[0]);
  var month =parseInt(parts[1]);
  var day =parseInt(parts[2]);

  // For leapyears, note that Jan 1 still occurs on the expected date
  //  value because the extra day does not occur until Feb.
  var output = (year-1970)*365;
  output += Math.floor((year-1969)/4); // add one for every previous leapyear.

  output += monthOffset(month);
  if(year%4 == 0 && month > 2) // add 1 if is > Feb of leapyear
    ++output;

  output += day -1;
  return output;
}
