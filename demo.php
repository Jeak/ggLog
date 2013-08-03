<!doctype html>
<html style="width:100%">
  <head>
    <title>Running Logs</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      function newworkout()
      {
        document.getElementById("addworkout").className = "ggLog-newworkout";
      }
      function closenewworkout()
      {
        document.getElementById("addworkout").className = "ggLog-hide";
      }
      function changewn()
      {
        document.getElementById("workoutname").innerHTML =  document.getElementById("ggLogwn").value;
      }
    </script>
    <style>
      div.ggLog-hide
      {
        display:none;
      }
      div.ggLog-newworkout
      {
        position:relative;
        top:10px;
        left:50px;
        width:600px;
        background-color:#EEEEEE
      }
    </style>
  </head>
  <body style="width:100%">
    <?php require_once("navbar.php"); navbar("demo.php"); ?>
    <div style="position:relative;top:0;width:100%;height:50px;">
      <div class="btn-group" style="position:absolute;top:0;left:100px">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          Action <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li>
            <!--a href="#" onclick="newworkout()">New Workout</a-->
            <a href="javascript:newworkout();">New Workout</a>
          </li>
          <li>
            <a href="#">Second Link</a>
          </li>
          <li>
            <a href="#">Third Link</a>
          </li>
        </ul>
      </div> 
      <!--button onclick="newworkout()" style="position:absolute;top:0;right:100px;">New Workout</button-->
    </div>
    <div class="ggLog-hide" id="addworkout">
      <form action="demo.php" method="post">
        <p class="text-center"><b><span style="color:red">New</span> <span id="workoutname">Untitled Workout</span></b></p>
        <div style="position:relative;height:35px;width:100%;">
          <div style="position:absolute;top:0;left:0;">Title: <input type="text" name="title" id="ggLogwn" value="abcd" oninput="changewn()" /></div>
          <div style="position:absolute;top:0;right:0;">
            Date:
            <select name="month" style="width:70px;">
              <option value="1">Jan</option>
              <option value="2">Feb</option>
              <option value="3">Mar</option>
              <option value="4">Apr</option>
              <option value="5">May</option>
              <option value="6">Jun</option>
              <option value="7">Jul</option>
              <option value="8">Aug</option>
              <option value="9">Sep</option>
              <option value="10">Oct</option>
              <option value="11">Nov</option>
              <option value="12">Dec</option>
            </select>
            <select name="day" style="width:60px;">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <select name="year" style="width:70px">
              <option value="2012">2012</option>
              <option value="2013" selected>2013</option>
              <option value="2014">2014</option>
            </select>
          </div>
        </div>
        <div style="position:relative;width:100%;height:170px;top:0">
          <div style="position:absolute;top:0;left:0;width:420px;">
            <p class="text-center">Workout notes:</p>
            <textarea style="width:400px;height:120px;" name=notes> </textarea>
          </div>
          <div style="position:absolute;top:0;right:0;width:160px;height:170px">
            <div style="position:relative;top:35px;right:0;width:160px;height:35px;">
              Distance: <input type="text" name="distance" style="width:60px"/>
            </div>
            <div style="position:relative;top:35px;right:0;width:160px;height:35px;">
              Time:
              <input type="text" name="distance" style="width:10px"/>h
              <input type="text" name="distance" style="width:10px"/>m
              <input type="text" name="distance" style="width:10px"/>s
            </div>
          </div>
        </div>
        <div style="position:relative;width:100%;height:35px;top:0">
          <div style="display:block;margin-left:auto;margin-right:auto;width:200px" >
            <input type="submit" value="save" />
            <button onClick="closenewworkout()" >cancel</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
