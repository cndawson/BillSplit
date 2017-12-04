<!DOCTYPE html>
<!-- 
Author: Caylie Dawson & Christian Mancha
-->
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="styleLogin.css"/>
	<?php
		session_start ();
	?>
</head>
<body>
	<div class="centered">
		<img id="logo" src="images/whitelogo.png"/><br>
		<form action="controller.php" method="POST">
			Username <input class="fields" type="text" name="IDL"> <br> 
			Password <input class="fields" type="password" name="passwordL"> <br> 
			<input type="submit" name="Login" value="Login"> <br> <br>
	<?php
	
	if (isset ( $_SESSION ['loginError'] ))
		echo $_SESSION ['loginError'];
	
	?>
</form>
		<br>
		<p>Don't already have an account?</p>
		<a href="register.php"><button>Register</button></a><br>
	</div>
</body>
</html>