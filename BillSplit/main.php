<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
<title>Main Page</title>
<style>
div {
	border: 1px solid black;
	border-radius: 10px;
	padding: 5px;
	margin: 10px;
	float: left;
}
</style>
</head>
<body>
<?php
session_start ();
?>
<!-- If group is set then show the payments else as them to register -->
<?php
echo "<form action=\"controller.php\" method=\"POST\">
		<button type=\"submit\" name=\"logout\">Logout</button>
	</form>";
if (isset ( $_SESSION ['group'] )) {
	echo "<form action=\"controller.php\" method=\"POST\">
		<button type=\"submit\" name=\"unflag\">Unflag All</button>
		<button type=\"submit\" name=\"logout\">Logout</button>
	</form>";
}
else {
	echo "<div>Register for a group here! <br>
		<form action=\"controller.php\" method=\"POST\">
		<input class=\"fields\" type=\"text\" placeholder=\"Name Your Group\" name=\"groupRegister\">
		<button type=\"submit\" name=\"registerGroup\">Register</button>";
	if(isset($_SESSION['groupError']))
		echo "<br>" . $_SESSION['groupError'];
	echo "</form> <br>
		Already have a group?<br>
		<form action=\"controller.php\" method=\"POST\">
		<input class=\"fields\" type=\"text\" placeholder=\"Group Name\" name=\"groupJoin\">
		<button type=\"submit\" name=\"joinGroup\">Join</button>
	</form></div>";
}
?>
</body>
</html>