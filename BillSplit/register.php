<!DOCTYPE html>
<!-- 
Author: Caylie Dawson
-->
<html>
<head>
<title>Register Page</title>
<style>
body {
	background-image: url("images/greenback.png");
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
form {
  display: grid; 
  grid-template-columns:
80px 140px;
  padding: 5px;
  margin: 10px;
  float: left;
} 
.fields { 
grid-column: 2 / 2; 
height: 30px; 
font-family: Arial; 
font-size: 10pt;
}
h3{
text-align:center;
}

</style>
</head>
<body>
<?php
session_start ();
?>
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