<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
<title>Login Page</title>
<style>
body {
	background-image: url("images/greenback.png");
}

form {
	display: grid;
	grid-template-columns: 80px 140px;
	padding: 5px;
	margin: 10px;
	float: left;
}

.centered {
	position: absolute;
	top: 30%;
	left: 45%;
	margin-top: -50px;
	margin-left: -100px;
	padding-bottom: 10px;
	text-align: center;
	background: rgba(0,0,0,.50);
    backdrop-filter:blur(60px);
    border-radius: 25px;
}

.fields {
	grid-column: 2/2;
	height: 30px;
	font-family: Arial;
	font-size: 10pt;
}

.labels {
	grid-column: 1/2;
	font-family: Arial;
	font-size: 8pt;
	text-align: right;
}

h1{
	text-align:center;
}
</style>
</head>
<body>
<?php
session_start ();
?>

<h1>Bill Split</h1>
	<div class="centered">
		<form action="controller.php" method="POST">
			Username <input class="fields" type="text" name="IDL"> <br> Password
			<input class="fields" type="password" name="passwordL"> <br> <input
				type="submit" name="Login" value="Login"> <br> <br>
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