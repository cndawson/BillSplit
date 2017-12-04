<!DOCTYPE html>
<!-- 
Author: Caylie Dawson & Christian Mancha
-->
<html>
<head>
	<title>Main Page</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<?php
		session_start ();
	?>
</head>
<body onload="getData()">

<!-- If group is set then show the payments else as them to register -->

<div id="mainContainer">
	<div id="header">
		<img id="logo" src="images/blacklogo.png"/>
		<form id="logout" action="controller.php" method="POST">
			<button id="logoutButton" type="submit" name="logout">Logout</button>
		</form>
	</div>
	<br>
	<br>
	<div id="left">
		<!-- Profile section -->
		<img class="profilePicture" src="images/profilepicture.jpg"/>
		<br>
		<h1 id="welcomeMessage">Hello Christian!</h1> 
		<hr>
		<div id="personalInfo">
			<span class="font">Personal information</span>
		</div>
		
	</div>
	<div id="right">
		<?php
		if (isset ( $_SESSION ['group'] )) {
			echo "<div id=\"payments\">
					Loading...
				  </div>
				  <br>
				  <div id=\"bottom\">
					  <div id=\"people\">
						<span class=\"font\">People in the same group as the user</span>
					  </div>
					  <div id=\"addPayment\">
						<span class=\"font\">Add payment form</span>
					  </div>
				  </div>";
		} else {
			echo "<div class=\"register\">Register for a group here! <br>
				<form action=\"controller.php\" method=\"POST\">
				<input class=\"fields\" type=\"text\" placeholder=\"Name Your Group\" name=\"groupRegister\" required>
				<button type=\"submit\" name=\"registerGroup\">Register</button>";
			
			if(isset($_SESSION['groupRegisterError']))
				echo "<br>" . $_SESSION['groupRegisterError'];
			
			echo "</form> <br>
				Already have a group?<br>
				<form action=\"controller.php\" method=\"POST\">
				<input class=\"fields\" type=\"text\" placeholder=\"Group Name\" name=\"groupJoin\" required>
				<button type=\"submit\" name=\"joinGroup\">Join</button>";
			
			if(isset($_SESSION['groupJoinError']))
				echo "<br>" . $_SESSION['groupJoinError'];
			
			echo "</form></div>";
		}
		?>
	</div>
</div>
<script>
var $array = [];
function getData() {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?getPayments=yes", true); // Arguments Method, url, async
	ajax.send();
   ajax.onreadystatechange = function () {
   if (ajax.readyState == 4 && ajax.status == 200) {
      $array = JSON.parse(ajax.responseText);
      str = "<table>";
      str += "<th>Who paid for this?</th>"
      str += "<th style='width:250px;'"+">Description</th>"
      str += "<th>Amount</th>" 
      str += "<th>Date</th>"

      for (var i = 0; i < $array.length; i++) {
         str += "<tr>";
         str += "<td style='text-align:center;'>" + $array[i]['username'] + "</td>";
         str += "<td>" + $array[i]['description'] + "</td>";
         str += "<td>$" + $array[i]['amount'] + "</td>";
         str += "<td>$" + $array[i]['date'] + "</td>";
         str += "</tr>";
      }
      str += "</table>";
      var toChange = document.getElementById("payments");
      
      toChange.innerHTML = str;
    }
  };
}
</script>
</body>
</html>