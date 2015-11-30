function alerthi()
{
  alert("hi");
}
function switchuser()
{
  var users = new Array();
  users.push(new Array("David B.", "0", "You currently have no notifications."));
  users.push(new Array("Jack G.", "69,420", "Coach says: Work on your form!  You look like a marathon runner.  Your classmates say: You know you're not going to get anywhere with computer science.  You're doing calf raisers wrong.  Why do you only do crunchy frogs?  You know you're not funny, right?  That's not how you do obliques!  Your arms flail around when you're running.  *knee-grab*.  Why do you make that noise when we grab your knees?  It doesn't even hurt you when we grab your knees.  You're doing life wrong.  Why do y... [view profile for all notifications]"));
  users.push(new Array("John N.", "1", "Coach says: Get your eyes up! Stop looking at the ground."));

  var currentnumber = parseInt(document.getElementById("usernumber").value);
  var cnm = currentnumber%users.length;
  var current = users[cnm];
  document.getElementById("usernumber").value = currentnumber+1;

  var notices = current[2];
  var numberOfNotices = current[1];
  var name = current[0];

  var contents = "";
  contents += "<span class=\"badge\" style=\"font-weight:900;background-color:#a00;\" id=\"useralerts\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" title=\"Warnings\" data-content=\"" + notices + "\">" + numberOfNotices + "</span>";
  contents += "<span id=\"userinfo\"> Logged on as <a style=\"position:relative;\" href=\"javascript:switchuser()\">" + name + "</a> | <a href=\"javascript:switchuser();\">Switch user</a></span>";

  document.getElementById("userstuff").innerHTML = contents;
  $('#useralerts').popover();
}
