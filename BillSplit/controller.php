<?php
// File name controller.php
// Acts as the go between the view and the model.
// Author Caylie Dawson
include 'DataBaseAdaptor.php';
session_start ();
unset ( $_SESSION ['loginError'] );
unset($_SESSION['registerError'] );
unset($_SESSION['groupRegisterError'] );
unset($_SESSION['groupJoinError'] );
 {
//--------------just to get the users to enter until we've changed this-----
// 	$arr = $theDBA->getQuotesAsArray ();
//	echo json_encode ( $arr );
}
if (isset ( $_POST ['IDL'] ) && isset ( $_POST ['passwordL'] )) {
	$auxIDL = htmlspecialchars($_POST['IDL']);
	$auxpasswordL = htmlspecialchars($_POST['passwordL']);
	$result = $theDBA->LogIN ($auxIDL, $auxpasswordL);
	if( $result == TRUE){
		
		$memberOfGroup = $theDBA->getGroup($auxIDL);
		if($memberOfGroup!=FALSE)
			$_SESSION['group'] = $memberOfGroup;
		
		$paymentType = $theDBA->getType($auxIDL);
			if($paymentType!=FALSE)
				$_SESSION['paymentMethod'] = $paymentType;
			
		$pictureName = $theDBA->getPicture($auxIDL);
			if($pictureName!=FALSE)
				$_SESSION['picture'] = $pictureName;
				
		$leader = $theDBA->isLeader($auxIDL);
		if($leader==TRUE)
			$_SESSION['leader'] = "1";
		
		$_SESSION['user'] = $_POST ['IDL'];
		header('Location: main.php');
		//move to main page
	}
	else {
		$_SESSION['loginError'] = 'Invalid credentials';
		header('Location: index.php');
	}
}
if (isset ( $_POST ['ID'] ) && isset ( $_POST ['password'] )) {
	$auxID = htmlspecialchars($_POST['ID']);
	$auxpassword = htmlspecialchars($_POST['password']);
	$result = $theDBA->addToUsers ($auxID, $auxpassword);
	if ($result == FALSE) { // user already exists 
		$_SESSION['registerError'] = "Username already taken";
		header('Location: register.php');
	}
	else
		 header('Location: index.php');
}
if(isset( $_POST ['group'])){
	$arr = $theDBA->getPaymentsAsArray ($_POST ['group']);
	echo json_encode ( $arr ); 
}
if (isset ( $_POST ['groupRegister'] )) {
	$auxgroupRegister= htmlspecialchars($_POST['groupRegister']);
	$result = $theDBA->registerGroup ($auxgroupRegister, ( $_SESSION ['user'] ));
	if ($result == FALSE) { // group already exists
		$_SESSION['groupRegisterError'] = "Group name not available";
		header('Location: main.php');
	}
	else{
		$_SESSION ['group'] = $_POST ['groupRegister'];
		$_SESSION ['leader'] = "1";
		header('Location: main.php');
	}
}
if (isset ( $_POST ['groupJoin'] )) {
	$auxgroupJoin= htmlspecialchars($_POST['groupJoin']);
	$result = $theDBA->joinGroup ($auxgroupJoin, ( $_SESSION ['user'] ));
	if ($result == FALSE) { // no group by that name 
		$_SESSION['groupJoinError'] = "No group by that name";
		header('Location: main.php');
	}
	else{
		//error_log( $_POST ['groupJoin']);
		$_SESSION ['group'] = $_POST ['groupJoin'];
		
		//$_SESSION ['group'] = "testgroup";
		echo $_POST ['groupJoin'];
		header('Location: main.php');
	}
}
if(isset ( $_GET['getPayments'] ) && $_GET['getPayments']=="yes") {
	$payments = $theDBA->getPaymentsAsArray($_SESSION['group']);
	echo json_encode ( $payments );
}
if(isset ( $_POST['paymentDescription']) && isset($_POST['amount'])){
	$auxpaymentDescription = htmlspecialchars($_POST['paymentDescription']);
	$auxAmount = htmlspecialchars($_POST['amount']);
	$theDBA->addPayment($_SESSION['user'],$_SESSION['group'], $auxpaymentDescription, $auxAmount);
	header('Location: main.php');
}
//if(isset ( $_POST['paymentDescription']) && isset($_POST['amount'])){
//	$theDBA->addPaymentToUsers($_SESSION['user'],$_POST['amount']);
//	header('Location: main.php');
//}
if(isset($_POST['amountPayed'])){
	$theDBA->addUserPayment($_SESSION['user'],$_POST['amountPayed']);
	header('Location: main.php');
}
	
if(isset ( $_GET['getUsersInGroup'] ) && $_GET['getUsersInGroup']=="yes") {
	$usersInGroup = $theDBA->getUsersInGroupAsArray($_SESSION['group'],( $_SESSION ['user'] ));
	echo json_encode ( $usersInGroup );
}
if(isset ( $_GET['getAmountArray'] ) && $_GET['getAmountArray']=="yes") {
	$amounts = $theDBA->getAmount( $_SESSION ['user'] );
	echo json_encode ( $amounts );
}
if(isset($_POST['finish'])){
	$theDBA->finish($_SESSION['group']);
	unset($_SESSION['leader'] );
	unset($_SESSION['group'] );
	header('Location: main.php');
}
if(isset($_POST['paymentType'])){
	$theDBA->paymentMethod($_POST['paymentType'],( $_SESSION ['user']) );
	$_SESSION ['paymentMethod'] = $_POST ['paymentType'];
	header('Location: main.php');
}
if(isset($_FILES['photo']['name'])){
	$folder = "images/profile/";
	opendir($folder);
	$destination = $folder . $_FILES['photo']['name'];
	copy($_FILES['photo']['tmp_name'], $destination);	
	$theDBA->insertPicture($_FILES['photo']['name'], $_SESSION ['user'] );
	$_SESSION ['picture'] = $_FILES['photo']['name'];
	header('Location: settings.php');
}
if (isset ( $_POST ['logout'] )) {
	session_destroy ();
	header ( 'Location: index.php' );
}
?>