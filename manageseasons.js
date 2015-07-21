function mouseoverseason(id)
{
  //shows the pencil icon when mousing over a season
  var idval = id + "-edit";
  document.getElementById(idval).className = "glyphicon glyphicon-resize-full";
}
function mouseoffseason(id)
{
  var idval = id + "-edit";
  document.getElementById(idval).className = "ggLog-hide";
}
function expandseason(type, id)
{
  
  //when you click on a season: it shows or hides Display Workouts, Analysis, and Edit for that season.
  if($("li.active.list-group-item").length == 0)
  {
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\" onclick=\"analyze()\">Display Workouts</li>");
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\">Analysis</li>");
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\" onclick=\"editseason('edit', '" + id + "')\">Edit</li>");
  }
  else
  {
    clearseason();
  }

}
function analyze()
{
  alert('whoa');
}
function clearseason()
{
  //Hides the Display Workouts, Analysis, and Edit dropdown thing
  $("li.active.list-group-item").remove();
}
function editseason(type, id)
{
  // Edits a season with ajax, a form; Also responsible for new seasons
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
  content += "    <form action=\"#\" method=\"post\" id=\"editseason\" class=\"form-inline\">";
  content += "      <input type=\"hidden\" name=\"submitting\" value=\"season\" />";
  if(type == 'edit')
  {
    content += "      <input type=\"hidden\" name=\"id\" value=\"" + id + "\" />";
  }
  content += "      <label>Season Name:</label> <input type=\"text\" name=\"seasonname\" value=\"" + sn + "\" style=\"width:300px;\" class=\"form-control\" /><br />";
  content += "      <label>Begins:</label> <span id=\"" + NewSeasonBeginId + "\"></span><br />";
  content += "      <label>Ends:</label> <span id=\"" + NewSeasonEndId + "\"></span><br />";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:60px;margin-top:10px;\" onclick=\"submitSeason(); return false;\">Save</button> ";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:10px;margin-top:10px;\" onclick=\"canceleditseason(); return false;\">Cancel</button>";
  content += "      <button class=\"btn btn-default\" style=\"float:left;margin-left:10px;margin-top:10px;\" onclick=\"deleteseason('" + id + "'); return false;\">Delete</button>";
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

function deleteseason(id) {
  // AJAX for deleting a season
  var dataString = "submitting=deleteseason&id=" + id;
  $.ajax({
  type: "POST",
  url: "accept.php",
  data: dataString
  })
    .done(function() {
    canceleditseason();
    clearseason();
    listseasons();
  });
}

function canceleditseason()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}

function listseasons()
{
  //update seasons from the SQL database.
  //remember, before calling this from a previous ajax event, have it occur in the
  // .done() area, to prevent it loading before the new info is put
  // into the SQL database.
  $("#seasonlist").html("");
  $.ajax({
  type: "POST",
  url: "accept.php",
  data: "submitting=seasonlist" })
    .done (function ( data ) {
    $("#seasonlist").html(data);
  });
}

function submitSeason() {
  var dataString = $("#editseason").serialize();
  $.ajax({
  type: "POST",
  url: "accept.php",
  data: dataString
  })
    .done(function(data) {
    canceleditseason();
    clearseason();
    listseasons();
  });
}


function DoAnalyze()
{
  var datapoints = [ ["Mon", 34], ["Tues", 37], ["Wed", 25], ["Thu", 38], ["Fri", 31], ["Sat", 41], ["Sun", 23] ];
  var data = {
    color: "#1A1",
    bars: {fillColor: {colors: [ {opacity: 0.8}, {opacity: 0.5} ] } },
    hoverable: true,
    data: datapoints
  };

  $.plot("#chartloc", [ data ], {
    series: {
      bars: {
        show: true,
        barWidth: 0.6,
        align: "center"
      }
    },
  xaxis: {
    mode: "categories",
    tickLength: 0
    }
  });

  // Add the Flot version string to the footer

  $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
}

function Hovering()
{

}

$(function() {DoAnalyze();});
