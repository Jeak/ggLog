function mouseoverseason(id)
{
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
  if($("li.active.list-group-item").length == 0)
  {
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\" onclick=\"analyze()\">Display Workouts</li>");
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\">Analysis</li>");
    $("#" + id).parent().after("<li class=\"list-group-item active\" style=\"margin-left:30px;border-color:white;\">Edit</li>");
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
  $("li.active.list-group-item").remove();
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
