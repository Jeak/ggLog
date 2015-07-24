function newworkout()
{

  if(IsMobileBrowser() == true)
  {
    if(document.getElementById("addworkoutmobile").className == "ggLog-newworkoutmobile")
      closenewworkout();
    else
      document.getElementById("addworkoutmobile").className = "ggLog-newworkoutmobile";
    SetDateDropdown("AddWorkoutMobileDate");
  }
  else
  {
    document.getElementById("editseasons").className = "ggLog-hide";
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
  document.getElementById("addworkoutmobile").className = "ggLog-hide";
}
function submitnewworkout()
{
  // return true; should submit the form.
  var formID = "newworkoutform";
  if(document.getElementById("newH").value == ""
  && document.getElementById("newM").value == ""
  && document.getElementById("newS").value == "")
  {
    document.getElementById("newH").setCustomValidity("Must enter a time (can be 0)");
  }
  else
  {
    document.getElementById("newH").setCustomValidity("");
  }
  return true;
}
function changewn()
{
  if(document.getElementById("ggLogwn").value == "")
    document.getElementById("workoutname").innerHTML = "Untitled Workout";
  else
    document.getElementById("workoutname").innerHTML =  document.getElementById("ggLogwn").value;
}
function changewnMobile()
{
  if(document.getElementById("ggLogwn-mobile").value == "")
    document.getElementById("workoutname-mobile").innerHTML = "Untitled Workout";
  else
    document.getElementById("workoutname-mobile").innerHTML =  document.getElementById("ggLogwn-mobile").value;
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
  content += "        <div style=\"float:left;width:70px;margin-right:5px;\"><button onClick=\"return true;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\">Yes</button></div>";
  content += "        <div style=\"float:left;width:70px;\"><button onClick=\"canceldeleteworkout(); return false;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\">No</button></div>";
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
  $("#numberloaded").val("0");
  setNavbar();
  if(IsMobileBrowser())
  {
    SetDateDropdown('datesdrop-mobile');
    document.getElementById('buttonholder').className = "ggLog-buttonholdermobile btn-group";
    document.getElementById('recentworkouts-desktop').className = "ggLog-hide";
    document.getElementById('recentworkouts-mobile').className = "ggLog-containrecentworkouts";
    var anymore = loadmore(10);
    if(anymore == true)
    {
      loadmore(10);
    }
  }
  else{
    SetDateDropdown('datesdrop');
    document.getElementById('recentworkouts-mobile').className = "ggLog-hide";
    //document.getElementById('recentworkouts-desktop').className = "ggLog-containrecentworkouts";
    document.getElementById('recentworkouts-desktop').className = "ggLog-containrecentworkouts";
    loadmore();
  }
  //$('#useralerts').popover();
}

function editworkout(id)
{
  if(IsMobileBrowser()) {
    return editworkoutMobile(id);
  }

  //parse the current one
  var idval = "PID-" + id;
  var staticHTML = document.getElementById(idval).innerHTML; // so you don't have to rewrite the code when you cancel
  var datest = document.getElementById(idval + "date").value;
  var date = new Date(datest);
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

  var day = date.getUTCDate();
  var month = date.getUTCMonth();
  var year = date.getUTCFullYear();
  // SetDateDropdown from ggLogEssentials.js
  SetDateDropdown(idval + "drop", "", true, year, month, day);

}

function canceleditworkout(id)
{
  var idval = "PID-" + id;
  var val = document.getElementById(idval + "orig").value;
  document.getElementById(idval).innerHTML = unescape(val);
}

function editworkoutMobile(id)
{
  var idval = "PID-" + id;
  var staticHTML = document.getElementById(idval).innerHTML; // so you don't have to rewrite the code when you cancel
  var datest = document.getElementById(idval + "date").value;
  var date = new Date(datest);
  var title = document.getElementById(idval + "title").value;
  var notes = removebr(document.getElementById(idval + "notes").innerHTML);
  var distance = document.getElementById(idval + "distance").innerHTML;
  var time = document.getElementById(idval + "time").innerHTML;
  var hours = decodetime(time, 'h');
  var minutes = decodetime(time, 'm');
  var seconds = decodetime(time, 's');

  var content = "";
  content += "<form action=\"demo.php\" method=\"post\" class=\"form-inline\">";
  content += "  <input type=\"hidden\" id=\"" + idval + "orig\" value=\"" + escape(staticHTML) + "\" />";
  content += "  <input type=\"hidden\" name=\"submitting\" value=\"newworkout\" />";
  content += "  <input type=\"hidden\" name=\"PID\" value=\"" + id + "\" />";
  content += "  <div style=\"width:100%;top:0;display:block;text-align:center;font-weight:900;color:green;\">Editing Workout</div>";
  content += "  <div class=\"ggLog-leftinputmobile\">";
  content += "    <label>Title/Loc:</label> <input type=\"text\" class=\"form-control mblil\" style=\"width:70%;\" name=\"title\" id=\"ggLogwn-mobile\" value=\""+ title + "\" />";
  content += "  </div>";
  content += "  <div class=\"ggLog-leftinputmobile\">";
  content += "    <label>Distance:</label> <input type=\"text\" class=\"form-control mblil\" style=\"width:50%\" name=\"distance\" value=\""+ distance + "\" />";
  content += "  </div>";
  content += "  <div class=\"ggLog-leftinputmobile\" id=\""+ idval + "dropmob\"></div>";
  content += "  <div class=\"ggLog-leftinputmobile\">";
  content += "    <div class=\"ggLog-lefttimewords\">";
  content += "      <label>Time:</label>";
  content += "    </div>";
  content += "    <div class=\"ggLog-inputhour\">";
  content += "      <input type=\"text\" name=\"hours\" class=\"ggLog-inputpad form-control\" value=\"" + hours + "\" />";
  content += "    </div>";
  content += "    <div class=\"ggLog-lefttimewords\"> : </div>";
  content += "    <div class=\"ggLog-inputms\">";
  content += "      <input type=\"text\" name=\"minutes\" class=\"ggLog-inputpad form-control\" value=\"" + minutes + "\" />";
  content += "    </div>";
  content += "    <div class=\"ggLog-lefttimewords\"> : </div>";
  content += "    <div class=\"ggLog-inputms\">";
  content += "      <input type=\"text\" name=\"seconds\" class=\"ggLog-inputpad form-control\" value=\"" + seconds + "\" />";
  content += "    </div>";
  content += "  </div>";
  content += "   <br style=\"clear:both;\" />";
  content += "  <div class=\"ggLog-leftinputmobile\" style=\"font-weight:900;\">Notes:</div>";
  content += "  <textarea style=\"width:90%;height:200px;display:block;margin-left:auto;margin-right:auto;\" class=\"form-control\" name=\"notes\">"+ notes + "</textarea>";
  content += "  <br />";
  content += "  <div class=\"ggLog-leftinputmobile\">";
  content += "    <div style=\"float:left;width:25%;margin-right:1%;\"><input type=\"submit\" class=\"mblil form-control\" value=\"save\" /></div>";
  content += "    <div style=\"float:left;width:30%;margin-right:1%;\"><button onClick=\"canceleditworkout('" + id + "'); return false;\" class=\"mblil form-control\">cancel</button></div>";
  content += "    <div style=\"float:left;width:30%;margin-bottom:5px;\"><button onClick=\"deleteworkout('" + id + "'); return false;\" class=\"mblil form-control\">delete</button></div>";
  content += "  </div>";
  content += "</form>";

  document.getElementById(idval).innerHTML = content;

  var day = date.getUTCDate();
  var month = date.getUTCMonth();
  var year = date.getUTCFullYear();
  // SetDateDropdown from ggLogEssentials.js
  SetDateDropdown(idval + "dropmob", "", true, year, month, day);

  return id;
}

function viewseasons()
{
//  alert("bc");
  closenewworkout();
  var current = document.getElementById("editseasons").className;

  if(current == "ggLog-hide") // now change it to viewable
    document.getElementById("editseasons").className = "ggLog-newworkout";
  else
    document.getElementById("editseasons").className = "ggLog-hide";

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
    var startloc = sn.indexOf("</span>")+7;
    var endloc = sn.indexOf("<span",5);
    sn = sn.substr(startloc, (endloc-startloc));
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

    var allspans = document.getElementById(id).getElementsByTagName('span');
    var dateinfo;
    for(var i=0;i<allspans.length;++i)
    {
      if(allspans[i].className == "badge")
      {
        dateinfo = allspans[i];
        break;
      }
    }

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

function loadmore(howmany)
{
  if(typeof howmany == 'undefined') {
    howmany = 20;
  }
  var anymore = true;
  var beginningl = $("#numberloaded").val();
  var imb = IsMobileBrowser();
  var request = $.post(
    "fetchworkouts.php",
    {"begin": beginningl, "number": howmany, "type": "json"} ,
    function( data ) {
      var jsonData = JSON.parse(data);
      if(!imb) {
        for(var i=0;i<jsonData['count'];++i)
          $("#loadmorebutton").before(createJSONworkoutDesktop(jsonData[i]));
      }
      else {
        alert(createJSONworkoutMobile(jsonData[0]));
        for(var i=0;i<jsonData['count'];++i)
          $("#loadmoremobilebutton").before(createJSONworkoutMobile(jsonData[i]));
      }
      $("#numberloaded").val(parseInt(beginningl)+parseInt(howmany));
      $("#loadmorebutton").before("<span>" + jsonData['timing'] + " for " + jsonData['count'] + "</span>");
      anymore = jsonData['more'];
      if(jsonData['more'] == false)
      {
        if(imb)
          $("#loadmoremobilebutton").remove();
        else
          $("#loadmorebutton").remove();
      }
    }
  );
  return anymore;
}

function createJSONworkoutDesktop(jsonInput)
{
  // jsonInput is of this format:
  // {"PID":(int), "rundate":(int),
  //  "title":(string), "runtime":(string),
  //  "notes":(string), "distance":(double),
  //  "speed":(string)}
  // In PHP, make sure to change newlines into <br /> with htmlnewline.
  var output = "";
    output += "<div class=\"ggLog-center-90\" id=\"PID-" + jsonInput['PID'] + "\">\n";

  //          store hard-to-access data in hidden inputs
    output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "date\" value=\"" + ggcreateSQLdate(jsonInput["rundate"]) + "\" />\n";
    output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "title\" value=\"" + jsonInput["title"] + "\" />\n";

    output += "  <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;\">\n";
  //<a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-trash"> </span></a>
    output += "  <a href=\"javascript:editworkout('"+ jsonInput['PID']+ "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>\n";
    output += "  <a href=\"javascript:deleteworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
    output += "<span class=\"workoutdate\">";
    //output += date("D M j Y", strtotime($data[$i]["rundate"])); // date
    output += intrp(jsonInput["rundate"], new Array('D', 'M', 'j', 'Y')); // date
    output += "</span><span class=\"workouttitle\">";
    output += jsonInput["title"]; // title
    output += "</span></div>\n";

    output += "  <div style=\"position:relative;top:0;left:0;width:100%;\">\n";

    output += "    <div style=\"float:left;width:500px;margin-bottom:25px;\" id=\"PID-" + jsonInput['PID'] + "notes\">";
    output += addbr(jsonInput["notes"]); // notes?
    output += "</div>\n";
    output += "  </div>\n";

    output += "  <div style=\"float:left;width:120px;border:1px;margin-bottom:25px;margin-left:10px\">\n";
    output += "    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" + jsonInput['PID'] + "distance\">";
    output += jsonInput["distance"]; // distance
    output += "</span> miles</div>\n";
    output += "    <div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\">";
    output += jsonInput["speed"];
    output += "</span> min/mi</div>\n";
    output += "  </div>\n";

    output += "  <div style=\"float:left;width:120px;\">";
    output += "<div class=\"runspecs\"><span style=\"font-size:1.3em;color:#888\" id=\"PID-" + jsonInput['PID'] + "time\">";
    output += jsonInput["runtime"];  // time
    output += "</span></div>";
    output += "  </div>\n";

    output += "</div>\n";
    output += "<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";
    return output;
}

function createJSONworkoutMobile(jsonInput)
{
  // see above for json object format.
  var output = "";
  output += "<span id=\"PID-"+ jsonInput['PID'] +"\">";
  output += "<div class=\"ggLog-centerinputmobile\">";

  output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "date\" value=\"" + ggcreateSQLdate(jsonInput["rundate"]) + "\" />\n";
  output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "title\" value=\"" + jsonInput["title"] + "\" />\n";

  output += "  <span style=\"color:#AAAAAA;font-size:1.3em;margin-right:15px;\">" + intrp(jsonInput['rundate'], new Array('D', 'M', 'j', 'Y')) + "</span>";
  output += "  <a href=\"javascript:editworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>";
  output += "  <a href=\"javascript:deleteworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
  output += "</div>";
  output += "<div class=\"ggLog-leftinputmobile\">";
  output += "  <span style=\"color:#558855;font-size:1.3em;\" id=\"\">" + jsonInput['title'] + "</span>";
  output += "</div>";
  output += "<div class=\"ggLog-leftinputmobile\">";
  output += "  <span class=\"ggLog-biggraytext\" id=\"PID-" + jsonInput['PID'] + "distance\">"+ jsonInput['distance'] +"</span> miles &nbsp; &nbsp; &nbsp";
  output += "  <span class=\"ggLog-biggraytext\" id=\"PID-" + jsonInput['PID'] + "time\">" + jsonInput['runtime'] + "</span>";
  output += "</div>";
  output += "<div class=\"ggLog-leftinputmobile\">";
  output += "  <span class=\"ggLog-biggraytext\">"+ jsonInput['speed'] + "</span> min/mi";
  output += "</div>";
  output += "<div class=\"ggLog-leftinputmobile\" id=\"PID-" + jsonInput['PID'] + "notes\">";
  output += addbr(jsonInput['notes']);
  output += "</div>";
  output += "</span>\n";
  output += "<hr class=\"ggLog-partial\" style=\"clear:both;\" />\n";

  return output;
}

function removebr(inhtml)
{
  inhtml = inhtml.replace(new RegExp('\n', 'g'), '');
  inhtml = inhtml.replace(new RegExp('<br />', 'g'), '\n');
  inhtml = inhtml.replace(new RegExp('<br/>', 'g'), '\n');
  inhtml = inhtml.replace(new RegExp('<br>', 'g'), '\n');
  return inhtml;
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
