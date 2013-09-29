function alerthi()
{
  alert("hi");
}
function switchuser()
{
  var users = new Array();
  users.push(new Array("David B.", "1", "Quick Strides Quick Strides.."));
  users.push(new Array("Jack G.", "1", "Work on your form"));
  users.push(new Array("John N.", "1", "Get your eyes up! Stop looking at the ground."));

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
