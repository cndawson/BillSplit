<!DOCTYPE html>
<!-- 
Author: Caylie Dawson & Christian Mancha
-->
<html>
<head>
<title>Settings</title>
<link rel="stylesheet" type="text/css" href="styleSettings.css" />
	<?php
	session_start ();
	?>
</head>
<body>
<div id="mainContainer">
<div id="header">
		<img id="logo" src="images/blacklogo.png"/>
		<a href="main.php"><button id="settingsButton" type="submit">Home</button></a>
	</div>
	<div id="centered">
	<?php
		if (isset ( $_SESSION ['picture'] )){
		echo "<img class=\"profilePicture\" src=\"images/profile/". $_SESSION['picture']."\"/>";
		}
		else{
			echo "<img class=\"profilePicture\" src=\"images/profile/default.png\"/>";
		}
	?>
	<form action="controller.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="photo">
			<input type="submit" value="Update">
	</form>
	
	<br><br>
	Chose Payment Method

	<form id="paymentMethod" class ="formPay" action="controller.php" method="POST">
  <input type="radio"  value="Credit" id="credit" name="paymentType"> Credit<br>
  <input type="radio"  value="Debit" id="debit" name="paymentType"> Debit<br>
  <input type="radio"  value="Paypal" id="paypal" name="paymentType"> Paypal<br>
  <button class="buttonAdd" type="submit">Confirm Payment</button>
</form>
	</div>
	</div>
	</body>
	</html>