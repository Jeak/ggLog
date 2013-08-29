function newworkout()
{
  if(IsMobileBrowser() == true)
  {
    document.getElementById("addworkoutmobile").className = "ggLog-newworkoutmobile";
    SetDateDropdown("AddWorkoutMobileDate");
  }
  else
  {
    document.getElementById("addworkoutdesktop").className = "ggLog-newworkout";
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
//  if(document.getElementById("ggLogwn").value == "")
//    document.getElementById("workoutname").innerHTML = "Untitled Workout";
//  else
//    document.getElementById("workoutname").innerHTML =  document.getElementById("ggLogwn").value;
}
function coverscreen(id)
{
//  document.getElementById('coverForNotices').className="cover";
  document.getElementById('coverForNotices').className="cover";
  document.getElementById('')
}
function uncoverscreen()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}
function deleteworkout(id)
{
/*
      <div class="colorcover"></div>
      <div class="ggLog-centerquestion">
        <p class="text-center"><b>Are you sure you want to delete this workout?</b></p>
        <div style="position:absolute;left:100px;width:150px;">
          <form class="form-inline">
            <input type="hidden" value="deleteworkout" name="submitting" />
            <input type="hidden" value="###" name="PID" />
            <input type="submit" class="form-control" style="width:50px;" value="Yes" />
            <button onClick="canceldeleteworkout(); return false;" class="form-control" style="width:50px;">No</button>
          </form>
        </div>
      </div>
*/
  var message = "Are you sure you want to delete this workout?";
  
  var content = "";
  content += "<div class=\"colorcover\"></div>";
  content += "  <div class=\"ggLog-centerquestion\">";
  content += "    <p class=\"text-center\"><b>";
    content += message;
    content += "</b></p>";
  content += "    <div style=\"position:absolute;left:100px;width:150px;\">";
  content += "      <form class=\"form-inline\" action=\"demo.php\" method=\"post\">";
  content += "        <input type=\"hidden\" value=\"deleteworkout\" name=\"submitting\" />";
  content += "        <input type=\"hidden\" value=\"";
    content += id;
    content += "\" name=\"PID\" />";
  content += "        <button onClick=\"return true;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\" style=\"width:50px;\">Yes</button>";
  content += "      <button onClick=\"canceldeleteworkout(); return false;\" onkeypress=\"dwswitchbutton(event)\" class=\"form-control\" style=\"width:50px;\">No</button>";
  content += "    </form>";
  content += "  </div>";
  content += "</div>";

  document.getElementById('coverForNotices').innerHTML=content;
  document.getElementById('coverForNotices').className="cover";

  document.getElementById('coverForNotices').getElementsByTagName('button')[1].focus();
}
function canceldeleteworkout()
{
  document.getElementById('coverForNotices').className="ggLog-hide";
}
function dwswitchbutton(evt)
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
