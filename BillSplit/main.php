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
<?php
echo "<div id=\"mainContainer\">
		<div id=\"header\">
			<img id=\"logo\" src=\"images/blacklogo.png\"/>
			<form id=\"logout\" action=\"controller.php\" method=\"POST\">
				<button id=\"logoutButton\" type=\"submit\" name=\"logout\">Logout</button>
			</form>
		</div>
	";

if (isset ( $_SESSION ['group'] )) {
	echo "<div id=\"toChange\">
			This user is member of a group, we need to display the payments/dashboard of the user
		  <div>";
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
	
	echo "</form></div></div>";
}
?>
<script>
var $array = [];
function getData() {
	console.log("Hola");
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?getPayments=yes", true); // Arguments Method, url, async
	ajax.send();
   ajax.onreadystatechange = function () {
   if (ajax.readyState == 4 && ajax.status == 200) {
      $array = JSON.parse(ajax.responseText);
      str = "<table>";
      str += "<th>Username</th>"
      str += "<th>Description</th>"
      str += "<th>Amount</th>" 

      for (var i = 0; i < $array.length; i++) {
         str += "<tr>";
         str += "<td>" + $array[i]['username'] + "</td>";
         str += "<td>" + $array[i]['description'] + "</td>";
         str += "<td>$" + $array[i]['amount'] + "</td>";
         str += "</tr>";
      }
      str += "</table>";
      var toChange = document.getElementById("toChange");
      console.log(str);
      toChange.innerHTML = str;
    }
  };
}
</script>
</body>
</html>