<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
<title>Main Page</title>
<style>
.register {
	border-radius: 10px;
	float: left;
	position: absolute;
	top: 30%;
	left: 47%;
	margin-top: -50px;
	margin-left: -100px;
	padding: 30px;
	text-align: center;
	background: rgba(0,0,0,.50);
    backdrop-filter:blur(60px);
    border-radius: 25px;
    color: white;
}
.fields{
margin: 10px;
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
	echo "<div onload=\"getData()\"><div id=\"toChange\">This user is member of a group,
			we need to display the payments/dashboard of the user<div><div>";
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
<script>
  </script>
</body>
</html>