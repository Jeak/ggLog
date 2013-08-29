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
