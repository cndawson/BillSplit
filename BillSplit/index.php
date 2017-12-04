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
			<span class="font">Username</span> <input class="fields" type="text" name="IDL"> 
			<span class="font">Password</span> <input class="fields" type="password" name="passwordL"> <br> 
			<input class="buttonLogin" type="submit" name="Login" value="Login"> <br>
		</form>
		<?php
			if (isset ( $_SESSION ['loginError'] ))
				echo "<br><span class=\"font\">" . $_SESSION ['loginError'] . "<span/>";
		?>
		<p><span class="font">Don't already have an account?</span></p>
		<a href="register.php"><button class="buttonLogin">Register</button></a><br>
	</div>
</body>
</html>