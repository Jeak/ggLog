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
function editseason(type, id)
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
