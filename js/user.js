
function coverscreen(id)
{
//  document.getElementById('coverForNotices').className="ggLog-cover";
  document.getElementById('coverForNotices').className="ggLog-cover";
}
function uncoverscreen()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
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
  setNavbar(false);
  if(IsMobileBrowser())
  {
    //SetDateDropdown('datesdrop-mobile');
    document.getElementById('buttonholder').className = "ggLog-buttonholdermobile btn-group";
    document.getElementById('recentworkouts-desktop').className = "ggLog-hide";
    document.getElementById('recentworkouts-mobile').className = "ggLog-containrecentworkouts";
    var anymore = loadmore(10);
    if(anymore == true)
    {
      loadmore(10);
    }
    document.getElementById("mchart").className = "ggLog-hide";
  }
  else{
    //SetDateDropdown('datesdrop');
    document.getElementById('recentworkouts-mobile').className = "ggLog-hide";
    //document.getElementById('recentworkouts-desktop').className = "ggLog-containrecentworkouts";
    document.getElementById('recentworkouts-desktop').className = "ggLog-containrecentworkouts";
    loadmore();
    mileageGraphDesktop("mchart");
  }
  //$('#useralerts').popover();
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

function loadmore(howmany)
{
  if(typeof howmany == 'undefined') {
    howmany = 20;
  }
  var anymore = true;
  var beginningl = $("#numberloaded").val();
  var imb = IsMobileBrowser();
  var cuser = document.getElementById("ggcurrentusername").value;
  var request = $.post(
    "accept.php",
    {"begin": beginningl, "number": howmany, "submitting": "jsonwktsother", "username": cuser} ,
    function( data ) {
      var jsonData = JSON.parse(data);
      if(!imb) {
        for(var i=0;i<jsonData['count'];++i)
          $("#loadmorebutton").before(createJSONworkoutDesktop(jsonData[i]));
      }
      else {
        //alert(createJSONworkoutMobile(jsonData[0]));
        for(var i=0;i<jsonData['count'];++i)
          $("#loadmoremobilebutton").before(createJSONworkoutMobile(jsonData[i]));
      }
      $("#numberloaded").val(parseInt(beginningl)+parseInt(howmany));
      $("#loadmorebutton").before("<span>" + jsonData['timing'] + " for " + jsonData['count'] + "</span>");
      anymore = jsonData['more'];
      if(jsonData['more'] == false)
      {
/*        if(imb)
          $("#loadmoremobilebutton").remove();
        else
          $("#loadmorebutton").remove(); */
      }
    }
  );
  return anymore;
}

function loadspec(begin, end)
{
  howmany = 20;
  var anymore = true;
  var imb = IsMobileBrowser();
  var cuser = document.getElementById("ggcurrentusername").value;
  var request = $.post(
    "accept.php",
    {"begin": begin, "end": end, "submitting": "jsonwktsspecother", "username": cuser} ,
    function( data ) {
      var jsonData = JSON.parse(data);
      if(!imb) {
        for(var i=0;i<jsonData['count'];++i)
	{
          $("#loadmorebutton").before(createJSONworkoutDesktop(jsonData[i]));
	}
      }
      else {
        //alert(createJSONworkoutMobile(jsonData[0]));
        for(var i=0;i<jsonData['count'];++i)
          $("#loadmoremobilebutton").before(createJSONworkoutMobile(jsonData[i]));
      }
      $("#numberloaded").val(jsonData['count']);
     /*   if(imb)
          $("#loadmoremobilebutton").remove();
        else
          $("#loadmorebutton").remove();*/
    }
  );
  return anymore;
}

function removeAllWorkouts(classname)
{
  var additional = false
  if(typeof classname != "string") {
    classname = "workoutcont";
    additional = true;
  }
  var allWorkoutElements = document.getElementsByClassName(classname);
  for(var i=allWorkoutElements.length-1;i>=0;--i)
  {
    allWorkoutElements[i].parentElement.removeChild(allWorkoutElements[i]);
  }
  $("#numberloaded").val(0);
  if(additional)
  {
    removeAllWorkouts("blankwohr");
  }
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
    output += "<div class=\"ggLog-center-90 workoutcont\" id=\"PID-" + jsonInput['PID'] + "\">\n";

  //          store hard-to-access data in hidden inputs
    output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "date\" value=\"" + ggcreateSQLdate(jsonInput["rundate"]) + "\" />\n";
    output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "title\" value=\"" + jsonInput["title"] + "\" />\n";

    output += "  <div style=\"position:relative;top:0;left:-40px;width:100%;height:30px;color:#AAAAAA;font-size:1.3em;\">\n";
  //<a href="" class="editworkoutlink"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" class="editworkoutlink"><span class="glyphicon glyphicon-trash"> </span></a>
    //output += "  <a href=\"javascript:editworkout('"+ jsonInput['PID']+ "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>\n";
    //output += "  <a href=\"javascript:deleteworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
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
    output += "<hr class=\"ggLog-partial blankwohr\" style=\"clear:both;\" />\n";
    return output;
}

function createJSONworkoutMobile(jsonInput)
{
  // see above for json object format.
  var output = "";
  output += "<span id=\"PID-"+ jsonInput['PID'] +"\">";
  output += "<div class=\"ggLog-centerinputmobile workoutcont\">";

  output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "date\" value=\"" + ggcreateSQLdate(jsonInput["rundate"]) + "\" />\n";
  output += "  <input type=\"hidden\" id=\"PID-" + jsonInput['PID'] + "title\" value=\"" + jsonInput["title"] + "\" />\n";

  output += "  <span style=\"color:#AAAAAA;font-size:1.3em;margin-right:15px;\">" + intrp(jsonInput['rundate'], new Array('D', 'M', 'j', 'Y')) + "</span>";
  //output += "  <a href=\"javascript:editworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-pencil\"></span></a>";
  //output += "  <a href=\"javascript:deleteworkout('" + jsonInput['PID'] + "');\" class=\"editworkoutlink\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
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
  output += "<hr class=\"ggLog-partial blankwohr\" style=\"clear:both;\" />\n";

  return output;
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

function startUploadFlotrackr()
{
	var contain = document.getElementById("uflotrackr");
	contain.innerHTML = "";
	var form = document.createElement("form");
	form.setAttribute("onsubmit", "submitUploadFlotrackr(); return false;");
	form.setAttribute("style", "display:inline");
	form.setAttribute("id", "uftrfrm");
	
	var uploadselect = document.createElement("input");
	uploadselect.setAttribute("type", "file");
	uploadselect.setAttribute("name", "csvfile");
	uploadselect.setAttribute("id", "csvfile");
	uploadselect.setAttribute("style", "display:inline");
	var submitbutton = document.createElement("input");
	submitbutton.setAttribute("type", "submit");
	submitbutton.setAttribute("style", "display:inline");
	
	var cancelbutton = document.createElement("button");
	cancelbutton.setAttribute("onclick", "cancelUploadFlotrackr()");
	cancelbutton.innerHTML = "Cancel";
	cancelbutton.setAttribute("style", "display:inline");
	
	form.appendChild(uploadselect);
	form.innerHTML += " &nbsp; &nbsp; ";
	form.appendChild(submitbutton);
	
	contain.appendChild(form);
	contain.innerHTMl += " &nbsp; &nbsp; ";
	contain.appendChild(cancelbutton);
}

function submitUploadFlotrackr()
{
	
	var contain = document.getElementById("uflotrackr");
	
	var formData = new FormData();
	var file = document.getElementById("csvfile").files[0];//, formdata = false;
	if(file.type != "text/csv" && file.type != "text/plain")
	{
		contain.innerHTML = "failure.";
	}
	else
	{
		formData.append("csvfile", file, file.name);
		formData.append("submitting", "flotrackrimport");
		//Finish formData
	}
	
	contain.innerHTML = "Loading...";
	
	
	cancelUploadFlotrackr();
}

function cancelUploadFlotrackr()
{
	var contain = document.getElementById("uflotrackr");
	contain.innerHTML = "";
	var ulink = document.createElement("a");
	ulink.innerHTML = "Upload Flotrack Logs";
	ulink.setAttribute("href", "javascript:startUploadFlotrackr();");
	contain.appendChild(ulink);
}

function mileageGraphDesktop(id, data)
{
  var dateloc = 0;
  var milesloc = 2;
  // If provided, data is already JSON.parse-ed.

  var cuser = document.getElementById("ggcurrentusername").value;

  //Fetch data
  if(typeof data == "undefined")
  {
    var request = $.post(
      "accept.php",
      {"submitting": "mgraphother", "len": 0, "username": cuser} ,
      function( data ) {
        data =JSON.parse(data);
        mileageGraphDesktop(id, data);
      }
    );
  }

  else
  {
    var dmax = 0;
    for(var i=0;i<data.length;++i)
    {
      if(dmax < data[i][milesloc])
        dmax = data[i][milesloc];
    }
    var rnd = Math.ceil(dmax/15)*5;

    dmax = Math.ceil(dmax/rnd)*rnd;

    var tch = d3.select("#" + id);
    tch.classed("ggmcd", true);

    var maxheight = 100;

    var diff = maxheight/dmax;

    var maxtotalwidth = 750;
    var maxwidth = 50;
    var minwidth = 20;
    var startfrom = 0;

    var bwidth = parseInt(maxtotalwidth/data.length);
    if(bwidth > 50)
      bwidth = maxwidth;
    if(bwidth < 20)
    {
      bwidth = minwidth;
      startfrom = data.length-parseInt(maxtotalwidth/minwidth);
    }

    tch.html("");

    tch.style("height", (dmax*diff+35)+"px")
      .style("width", (maxtotalwidth+30)+"px");
       //.style("width", (data.length*bwidth+30)+"px");

    for(var i=0;i<=dmax/rnd;++i)
    {
      tch.append("line")
        .attr("x1", 0)
        .attr("y1", i*diff*rnd+20)
        //.attr("x2", data.length*bwidth+17)
        .attr("x2", maxtotalwidth+17)
        .attr("y2", i*diff*rnd+20)
        .attr("style", "stroke:#aaaaaa;width:0.5px;");
      tch.append("g")
        .attr("transform", "translate("+ (maxtotalwidth+30) +","+ (i*diff*rnd+20) +")")
      .append("text")
        .attr("style", "fill:#bbbbbb")
        .text(dmax-i*rnd);
    }

    for(var i=startfrom;i<data.length;++i)
    {
      var bar = tch.append("g")
        .attr("transform", "translate(" + (bwidth*(i-startfrom)) + ", " + (dmax*diff+20-diff*data[i][milesloc]) + ")");
      bar.append("rect")
        .on('mouseover', function(){mgdOver(this)})
        .on('click', function(){mgdClick(this)})
        .on("mouseout", function(){mgdOff();})
        .attr("weekstart", data[i][dateloc])
        .attr("width", bwidth-1)
        .attr("height", diff*data[i][milesloc]);
      bar.append("text")
        .attr("x", bwidth/2+1)
        .attr("y", (-5)+"px")
        .on('click', function(){cchanger(this)})
        .text(data[i][milesloc]);
      if(intrp_j(data[i][dateloc]) < 8 && intrp_j(data[i][dateloc]) > 0)
      {
        bar.append("text")
          .attr("x", (bwidth/2+1) + "px")
          .attr("y", (diff*data[i][milesloc]+12) + "px")
          .text(intrp_capM(data[i][dateloc]))
      }
    }
  }
}

function mgdOver(tinput){
  d3.select(tinput).classed("special", true);
}
function mgdOff(){
  var cparts = d3.select("#mchart").select(".special").classed("special", false);
}
function mgdClick(tinput) {
  var cparts = d3.select("#mchart").select(".clicked").classed("clicked", false);
  d3.select(tinput).classed("clicked", true);
  var dayone = parseInt(d3.select(tinput).attr("weekstart"));
  var endweek = dayone +6;
  removeAllWorkouts();
  loadspec(dayone, endweek);
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
