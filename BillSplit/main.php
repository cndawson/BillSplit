<!DOCTYPE html>
<!-- 
Author: Caylie Dawson & Christian Mancha
-->
<html>
<head>
<title>Main Page</title>
<link rel="stylesheet" type="text/css" href="style.css" />
	<?php
	session_start ();
	?>
</head>
<body onload="getData();">

	<!-- If group is set then show the payments else as them to register -->


<div id="mainContainer">
	<div id="header">
		<img id="logo" src="images/blacklogo.png"/>
		<form id="logout" action="controller.php" method="POST">
			<button id="logoutButton" type="submit" name="logout">Logout</button>
		</form>
				<a href="settings.php"><button id="settingsButton" type="submit">Settings</button></a>
	</div>
	<br>
	<br>
	<div id="left">
		<!-- Profile section -->
		<img class="profilePicture" src="images/krabby.gif"/>
		<br>
		<h1 id="welcomeMessage">Hello <?php echo $_SESSION ['user']?>!</h1> 
		<hr>
		<div id="personalInfo">
			<?php
			if (isset ( $_SESSION ['group'] )) {
				echo "<span class=\"font\"> <h3>Your Statement :</h3><span class=\"font\">
								<h4 id=\"statement\"></h4>
								<div id=\"paySection\">
									<form action=\"controller.php\" method=\"POST\">
										Pay your debt here: <input class=\"fields\" type=\"text\" pattern=\"[+-]?([0-9]*[.])?[0-9]+\" placeholder=\"Amount\" name=\"amountPayed\" required>
										<br>
										<button class=\"buttonAdd\" type=\"submit\">Confirm Payment</button>
									</form>
								</div>
							</span>";
			}
			else{
				echo "<span class=\"font\">Hey there! <br>It seems that you are not part of any group yet!
						<br>What are you waiting for?!</span>";
			}
			?>
		</div>
		</div>
		<div id="right">
		<?php
		if (isset ( $_SESSION ['group'] )) {
			echo "
				  <h2><span class=\"font\">". $_SESSION ['group'] . " - Payments";
					if(isset ( $_SESSION ['leader'] )){
					echo "<form id=\"finishForm\" action=\"controller.php\" method=\"POST\">
							<input id=\"invisible\" type=\"text\" name=\"finish\" value=\"1\">
							<button class=\"buttonAdd\" type=\"submit\">Finish trip</button>
						  </form>";
				  }
				  echo "</h2></span>";
				  
				  echo "<div id=\"payments\">
					Loading...
				  </div>
				  <br>
				  <div id=\"bottom\">
					  <div id=\"people\">
						
					  </div>
					  <div id=\"addPayment\">
						<span class=\"font\"><h3>Add payment!</h3>
							<form action=\"controller.php\" method=\"POST\">
								<textarea class=\"fields\" rows=\"6\" cols=\"30\" placeholder=\"Payment description\" name=\"paymentDescription\" required></textarea>
								<input class=\"fields\" type=\"text\" pattern=\"[+-]?([0-9]*[.])?[0-9]+\" placeholder=\"Amount\" name=\"amount\" required>
								<br>
								<button class=\"buttonAdd\" type=\"submit\">Add payment</button>
							</form>
						</span>
					  </div>
				  </div>";
		} else {
			echo "<div class=\"register\">Register for a group here! <br>
				<form action=\"controller.php\" method=\"POST\">
				<input class=\"fields\" type=\"text\" placeholder=\"Name Your Group\" name=\"groupRegister\" required>
				<button type=\"submit\" name=\"registerGroup\">Register</button>";
			
			if (isset ( $_SESSION ['groupRegisterError'] ))
				echo "<br>" . $_SESSION ['groupRegisterError'];
			
			echo "</form> <br>
				Already have a group?<br>
				<form action=\"controller.php\" method=\"POST\">
				<input class=\"fields\" type=\"text\" placeholder=\"Group Name\" name=\"groupJoin\" required>
				<button type=\"submit\" name=\"joinGroup\">Join</button>";
			
			if (isset ( $_SESSION ['groupJoinError'] ))
				echo "<br>" . $_SESSION ['groupJoinError'];
			
			echo "</form></div>";
		}
		?>
	</div>
	</div>
	<script>
var total=0.0;
var userTotal=0.0;
var $array = [];
function getData() {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?getPayments=yes", true); // Arguments Method, url, async
	ajax.send();
   ajax.onreadystatechange = function () {
   if (ajax.readyState == 4 && ajax.status == 200) {
      $array = JSON.parse(ajax.responseText);
      if ($array.length == 0){
          str = '<span class="font">There are no payments yet!</span>';
      }
      else{
	      str = "<table>";
	      str += "<th>Who paid for this?</th>"
	      str += "<th style='width:250px;'"+">Description</th>"
	      str += "<th>Amount</th>" 
	      str += "<th>Date</th>"
	
	      for (var i = 0; i < $array.length; i++) {
	         str += "<tr>";
	         str += "<td style='text-align:center;'>" + $array[i]['username'] + "</td>";
	         str += "<td>" + $array[i]['description'] + "</td>";
	         total+=parseFloat($array[i]['amount']);
	         if($array[i]['username'] == "<?php echo $_SESSION ['user']; ?>" )
	        		 userTotal+=parseFloat($array[i]['amount']);
	         str += "<td>$" + $array[i]['amount'] + "</td>";
	         str += "<td>" + $array[i]['date'] + "</td>";
	         str += "</tr>";
	      }
	      str += "</table>";
      }
      var toChange = document.getElementById("payments");
      toChange.innerHTML = str;
      getDataPeople();
    }
  };
}
var numberUsers=1;
var usersPayed=0.0;
function getDataPeople() {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?getUsersInGroup=yes", true); // Arguments Method, url, async
	ajax.send();
   ajax.onreadystatechange = function () {
   if (ajax.readyState == 4 && ajax.status == 200) {
      $array = JSON.parse(ajax.responseText);
      var str2="";
      if ($array.length == 0){
          str2 = '<span class="font">No one else in this group yet</span>';
      }
      else{
    	  str2 = "<table>";
          str2 += "<th>Other users in this group</th>"
	      for (var i = 0; i < $array.length; i++) {
	          numberUsers++;
	         str2 += "<tr>";
	         str2 += "<td style='text-align:center;'>" + $array[i]['username'] + "</td>";
	         str2 += "</tr>";
        	 usersPayed+=parseFloat($array[i]['payed']);
	      }
	      str2 += "</table>";
      }
      var toChange = document.getElementById("people");
      toChange.innerHTML = str2;
      getAmounts();
      //toChange.innerHTML = "CHANGED";
    }
  };
}
function getAmounts() {
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "controller.php?getAmountArray=yes", true); // Arguments Method, url, async
	ajax.send();
   ajax.onreadystatechange = function () {
   if (ajax.readyState == 4 && ajax.status == 200) {
      $array = JSON.parse(ajax.responseText);	
      var totalPayed=parseFloat($array[0]['payed']) + userTotal;
      var $str3="";
      var individualtotal=(total + usersPayed)/numberUsers;
      console.log("total: " + total);
	  console.log("usersPayed: " + usersPayed);
	  console.log("numberUsers: " + numberUsers);
	  console.log("totalPayed: " + parseFloat(totalPayed));
	  console.log("individualtotal: " + individualtotal);
      if(parseFloat(totalPayed) < individualtotal)
      	$str3 = "You have paid $" + totalPayed.toFixed(2) + " out of $" + individualtotal.toFixed(2);

      if(parseFloat(totalPayed) >= individualtotal){
    	$str3 = "The group owes you $" + (totalPayed-individualtotal).toFixed(2);
    	var paySection = document.getElementById("paySection");
        paySection.innerHTML = "";
      }
          
      var toChange = document.getElementById("statement");
      toChange.innerHTML = $str3;
      //toChange.innerHTML = "CHANGED";
    }
  };
}
</script>
</body>
</html>