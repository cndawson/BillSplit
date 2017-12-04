<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="styleLogin.css"/>
	<?php
		session_start ();
	?>
</head>
<body>
<div class="centered">
<h3><span class="font">Sign up</span></h3>
	<form action="controller.php" method="POST">
		<span class="font">Username</span> <input type="text" class="fields" name="ID" id="ID" pattern=".{4,}" required>
		<span class="font">Password</span> <input type="password" class="fields" name="password" id="password" pattern=".{6,}"  required> <br>
		<!-- Email <input type="text" name="email" id="email" required> <br> -->
	<input class="buttonLogin" type="submit" name="Register" value="Register"> <br>
	<?php
	//$pwd = document.getElementById(password).value;
	//$hash = password_hash($pwd, PASSWORD_DEFAULT);
	//echo $hash;
  if( isset(  $_SESSION['registerError']))
  	echo  "<span class=\"font\">" . $_SESSION['registerError'] . "<span/>";
	
	?>
</form>
</div>
</body>
</html>