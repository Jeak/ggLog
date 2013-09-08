function newworkout()
{
  if(IsMobileBrowser() == true)
  {
    document.getElementById("addworkoutmobile").className = "ggLog-newworkoutmobile";
    SetDateDropdown("AddWorkoutMobileDate");
  }
  else
  {
    if(document.getElementById("addworkoutdesktop").className == "ggLog-newworkout")
    {
      closenewworkout();
    }
    else
    {
      document.getElementById("addworkoutdesktop").className = "ggLog-newworkout";
      var inputs = document.getElementById("addworkoutdesktop").getElementsByTagName("input");
      for(var i=0;i<inputs.length;i++)
      {
        if(inputs[i].name == 'title')
        {
          inputs[i].focus();
          break;
        }
      }
    }
  }
  document.getElementById("ggLogwn").value = "";
}
function closenewworkout()
{
  document.getElementById("addworkoutdesktop").className = "ggLog-hide";
//  document.getElementById("addworkoutmobile").className = "ggLog-hide";
}
function changewn()
{
  if(document.getElementById("ggLogwn").value == "")
    document.getElementById("workoutname").innerHTML = "Untitled Workout";
  else
    document.getElementById("workoutname").innerHTML =  document.getElementById("ggLogwn").value;
}
function coverscreen(id)
{
//  document.getElementById('coverForNotices').className="ggLog-cover";
  document.getElementById('coverForNotices').className="ggLog-cover";
}
function uncoverscreen()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}
function deleteworkout(id)
{
  var message = "Are you sure you want to delete this workout?";
  
  var content = "";
  content += "<div class=\"colorcover\" onclick=\"canceldeleteworkout(); return false;\"></div>";
  content += "  <div class=\"ggLog-centerquestion\">";
  content += "    <p class=\"text-center\"><b>";
    content += message;
    content += "</b></p>";
  content += "    <div style=\"position:absolute;left:80px;width:150px;\">";
  content += "      <form class=\"form-inline\" action=\"demo.php\" method=\"post\">";
  content += "        <input type=\"hidden\" value=\"deleteworkout\" name=\"submitting\" />";
  content += "        <input type=\"hidden\" value=\"";
    content += id;
    content += "\" name=\"PID\" />";
  content += "        <button onClick=\"return true;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\" style=\"width:70px;\">Yes</button>";
  content += "      <button onClick=\"canceldeleteworkout(); return false;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\" style=\"width:70px;\">No</button>";
  content += "    </form>";
  content += "  </div>";
  content += "</div>";

  document.getElementById('coverForNotices').innerHTML=content;
  document.getElementById('coverForNotices').className="ggLog-cover";

  document.getElementById('coverForNotices').getElementsByTagName('button')[1].focus();
}
function canceldeleteworkout()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}
function dwswitchbutton(evt) // this function allows for switching between the yes and no buttons
{
  if(evt.keyCode == 37 || evt.keyCode == 39)
  {
    if(document.activeElement.innerHTML != document.getElementById('coverForNotices').getElementsByTagName('button')[1].innerHTML)
    {
      document.getElementById('coverForNotices').getElementsByTagName('button')[1].focus();
    }
    else
    {
      document.getElementById('coverForNotices').getElementsByTagName('button')[0].focus(); 
    }
  }
}
function demoload()
{
  SetDateDropdown('datesdrop');
  SetDateDropdown('PID--1drop');
}
function editworkout(id)
{
  //parse the current one
  var idval = "PID-" + id;
  var staticHTML = document.getElementById(idval).innerHTML; // so you don't have to rewrite the code when you cancel
  var date = document.getElementById(idval + "date").value;
  var title = document.getElementById(idval + "title").value;
  var notes = removebr(document.getElementById(idval + "notes").innerHTML);
  var distance = document.getElementById(idval + "distance").innerHTML;
  var time = document.getElementById(idval + "time").innerHTML;
  var hours = decodetime(time, 'h');
  var minutes = decodetime(time, 'm');
  var seconds = decodetime(time, 's');
  
  var content = "";
  content += "  <input type=\"hidden\" id=\"" + idval + "orig\" value=\"" + escape(staticHTML) + "\" />";

  content += "  <form class=\"form-inline\" action=\"demo.php\" method=\"post\">";
  content += "    <input type=\"hidden\" name=\"submitting\" value=\"newworkout\" />";
  content += "    <input type=\"hidden\" name=\"PID\" value=\"" + id + "\" />";
  content += "    <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#000;font-size:1em;\">";
  content += "      <div style = \"position:absolute;top:0;left:40px;\" id=\"" + idval + "drop\"></div>";
  content += "      <div style=\"position:absolute;top:0;left:350px;\">";
  content += "        <label>Title: </label>";
  content += "        <input type=\"text\" value=\"" + title + "\" class=\"form-control\" style=\"width:200px\" name=\"title\" />";
  content += "      </div>";
  content += "    </div>";
  content += "    <div style=\"position:relative;top:0;left:0;width:100%;\">";
  content += "      <div style=\"float:left;width:500px;margin-bottom:25px;\">";
  content += "        <textarea class=\"form-control\" style=\"margin-top:20px;width:480px;height:120px;\" name=\"notes\">";
  content +=            notes;
  content +=         "</textarea>";
  content += "      </div>";
  content += "      <div style=\"float:left;width:120px;margin-bottom:25px;margin-left:10px\">";
  content += "        <div class=\"runspecs\">";
  content += "          <input type=\"text\" class=\"form-control\" style=\"margin-top:5px;padding-left:3px;padding-right:3px;width:40px;\" name=\"distance\" value=\"";
    content += distance;
    content += "\"> miles";
  content += "        </div>";
  content += "      </div>";
  content += "      <div style=\"float:left;width:120px;\">";
  content += "        <div class=\"runspecs\">";
  content += "          <input type=\"text\" name=\"hours\" value=\"" + hours + "\" style=\"width:20px;padding-left:3px;padding-right:3px;\" class=\"form-control\" placeholder=\"h\"/> :";
  content += "          <input type=\"text\" name=\"minutes\" value=\"" + twodigits(minutes) + "\" style=\"width:25px;padding-left:3px;padding-right:3px;\" class=\"form-control\" placeholder=\"m\" /> :";
  content += "          <input type=\"text\" name=\"seconds\" value=\"" + twodigits(seconds) + "\" style=\"width:25px;padding-left:3px;padding-right:3px;\" class=\"form-control\" placeholder=\"s\"/>";
  content += "        </div>";
  content += "      </div>";
  content += "      <div style=\"float:left;width:230px;padding-left:10px;\">";
  content += "        <button class=\"form-control\" style=\"width:55px;\">save</button>";
  content += "        <button class=\"form-control\" style=\"width:55px;\" onclick=\"canceleditworkout('" + id + "'); return false;\">cancel</button>";
  content += "        <button class=\"form-control\" style=\"width:55px;\" onclick=\"deleteworkout('" + id + "');return false;\">delete</button>";
  content += "      </div>";
  content += "    </div>";
  content += "  </form>";
  
  document.getElementById(idval).innerHTML = content;
  SetDateDropdown(idval + "drop");
  
}

function canceleditworkout(id)
{
  var idval = "PID-" + id;
  var val = document.getElementById(idval + "orig").value;
  document.getElementById(idval).innerHTML = unescape(val);
}

function mouseoverseason(id)
{
  var idval = id + "-edit";
  document.getElementById(idval).className = "glyphicon glyphicon-pencil";

}
function mouseoffseason(id)
{
  var idval = id + "-edit";
  document.getElementById(idval).className = "ggLog-hide";
}

function editseason(type, id)
{
  var NewSeasonBeginId = "newseason-bd";
  var NewSeasonEndId = "newseason-ed";
  var sn = "";
  var title = "New Season";

  if(type == 'edit')
  {
    sn = document.getElementById(id).innerHTML;
    var loc = sn.indexOf("<span");
    sn = sn.substr(0, loc);
    sn = sn.trim();
    title="Edit '" + sn + "'";
  }

  var content = "";
  content += "<div class=\"colorcover\" onclick=\"canceleditseason(); return false;\"></div>";
  content += "  <div class=\"ggLog-centernewseason\">";
  content += "    <p class=\"text-center\"><b>" + title + "</b></p>";
  content += "    <form action=\"demo.php\" method=\"post\" class=\"form-inline\">";
  content += "      <input type=\"hidden\" name=\"submitting\" value=\"season\" />";
  if(type == 'edit')
  {
    content += "      <input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
  }
  content += "      <label>Season Name:</label> <input type=\"text\" name=\"seasonname\" value=\"" + sn + "\" style=\"width:300px;\" class=\"form-control\" /><br />";
  content += "      <label>Begins:</label> <span id=\"" + NewSeasonBeginId + "\"></span><br />";
  content += "      <label>Ends:</label> <span id=\"" + NewSeasonEndId + "\"></span><br />";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:60px;margin-top:10px;\" onclick=\"return true;\">Save</button> ";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:10px;margin-top:10px;\" onclick=\"canceleditseason(); return false;\">Cancel</button>";
  content += "    </form>";
  content += "    <form action=\"demo.php\" method=\"post\" class=\"form-inline\">";
  content += "      <input type=\"hidden\" name=\"submitting\" value=\"deleteseason\" />";
  content += "      <input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:10px;margin-top:10px;\" onclick=\"return true;\">Delete</button>";
  content += "    </form>";
  content += "  </div>";
  content += "</div>";

  document.getElementById('coverForNotices').innerHTML=content;
  document.getElementById('coverForNotices').className="ggLog-cover";

  if(type == 'new')
  {
    SetDateDropdown(NewSeasonBeginId, "begin-", false);
    SetDateDropdown(NewSeasonEndId, "end-", false);
  }
  else if(type == 'edit')
  {
    var dateinfo = document.getElementById(id).getElementsByTagName('span')[0];
    var info = dateinfo.innerHTML;
    var beginmonth = decodeseasondates(info, 1);
    var beginday = decodeseasondates(info, 2);
    var beginyear = decodeseasondates(info, 3);
    var endmonth = decodeseasondates(info, 4);
    var endday = decodeseasondates(info, 5);
    var endyear = decodeseasondates(info, 6);
    SetDateDropdown(NewSeasonBeginId, "begin-", false, beginyear, beginmonth, beginday);
    SetDateDropdown(NewSeasonEndId, "end-", false, endyear, endmonth, endday);
  }
  
}

function canceleditseason()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}

function addbr(inhtml)
{
inhtml = inhtml.replace(new RegExp('\n', 'g'), '<br />\n');
return inhtml;
}

function removebr(inhtml)
{
  inhtml = inhtml.replace(new RegExp('\n', 'g'), '');
  inhtml = inhtml.replace(new RegExp('<br />', 'g'), '\n');
  inhtml = inhtml.replace(new RegExp('<br/>', 'g'), '\n');
  inhtml = inhtml.replace(new RegExp('<br>', 'g'), '\n');
  return inhtml;
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

function encodetime(h, m, s)
{
  var out = h + ":";
  out+=twodigits(m) + ":";
  out+=twodigits(s);
  return out;
}

function twodigits(x) // integer x
{
var y = "";
if(x < 10)
  y = "0";
y += x;
return y;
}
