<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="styleRegister.css"/>
	<?php
		session_start ();
	?>
</head>
<body>
<div class="centered">
<h3>Register</h3>
	<form action="controller.php" method="POST">
		Username <input type="text" class="fields" name="ID" id="ID" pattern=".{4,}" required> <br>
		Password <input type="password" class="fields" name="password" id="password" pattern=".{6,}"  required> <br>
		<!-- Email <input type="text" name="email" id="email" required> <br> -->
	<input type="submit" name="Register" value="Register"> <br> <br>
	<?php
	//$pwd = document.getElementById(password).value;
	//$hash = password_hash($pwd, PASSWORD_DEFAULT);
	//echo $hash;
  if( isset(  $_SESSION['registerError']))
    echo   $_SESSION['registerError'];
	
	?>
</form>
</div>
</body>
</html>