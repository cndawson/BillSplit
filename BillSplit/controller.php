<?php

// File name controller.php
// Acts as the go between the view and the model.
// Author Caylie Dawson
include 'DataBaseAdaptor.php';
session_start ();
unset ( $_SESSION ['loginError'] );
unset($_SESSION['registerError'] );
 {
//--------------just to get the users to enter until we've changed this-----
// 	$arr = $theDBA->getQuotesAsArray ();
//	echo json_encode ( $arr );
}
if (isset ( $_POST ['IDL'] ) && isset ( $_POST ['passwordL'] )) {
	$result = $theDBA->LogIN ($_POST ['IDL'], $_POST ['passwordL']);
	if( $result == TRUE){
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
	
	$result = $theDBA->addToUsers ($_POST ['ID'], $_POST ['password']);
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

	$result = $theDBA->addGroupToUser ($_POST ['groupRegister'], ( $_SESSION ['user'] ));
	if ($result == FALSE) { // user already exists
		$_SESSION['registerError'] = "Group name already taken";
		header('Location: main.php');
	}
	else
		header('Location: main.php');
}
if (isset ( $_POST ['logout'] )) {
	session_destroy ();
	header ( 'Location: index.php' );
}
?>