<?php

// File name controller.php
// Acts as the go between the view and the model.
// Author Caylie Dawson
// THISS IS JUST CODE FROM LAST PROJECT NOTHING HAS BEEN CHANGED!!!!
include 'DataBaseAdaptor.php';
session_start ();
unset ( $_SESSION ['loginError'] );
unset($_SESSION['registerError'] );
 {
	//print_r("getQuotesAsArray to quotes\n");
	//echo("getQuotesAsArray to quotes\n");
 	$arr = $theDBA->getQuotesAsArray ();
	echo json_encode ( $arr );
}
if (isset ( $_POST ['IDL'] ) && isset ( $_POST ['passwordL'] )) {
	$result = $theDBA->LogIN ($_POST ['IDL'], $_POST ['passwordL']);
	if( $result == TRUE){
		$_SESSION['user'] = $_POST ['IDL'];
		header('Location: index.php');
	}
	else {
		$_SESSION['loginError'] = 'Invalid credentials';
		header('Location: login.php');
	}
	//echo ("__________________");
	//echo $arr;

}
if (isset ( $_POST ['flag'] ) && isset ( $_POST ['authorN'] )) {
	if($_POST ['flag'] == 0){
	$arr = $theDBA->flagClick(1,$_POST ['authorN']);
	}
	else $arr = $theDBA->flagClick(0,$_POST ['authorN']);
	//echo ($_POST ['flag']);
	//echo ($_POST ['authorN']);
	echo json_encode ( $arr );
	header('Location: index.php');
}

if (isset ( $_POST ['plus'] ) && isset ( $_POST ['authorN'] )) {
	$arr = $theDBA->addRate($_POST ['plus'],$_POST ['authorN']);
	echo json_encode ( $arr );
	header('Location: index.php');
}
if (isset ( $_POST ['minus'] )&& isset ( $_POST ['authorN'] )) {
	$arr = $theDBA->minusRate($_POST ['minus'],$_POST ['authorN']);
	echo json_encode ( $arr );
	header('Location: index.php');
}
if (isset ( $_POST ['unflag'] )) {
	$arr = $theDBA->unflagAll();
	echo json_encode ( $arr );
	header('Location: index.php');
}
////////STILL HAVE TO HASH
if (isset ( $_POST ['ID'] ) && isset ( $_POST ['password'] )) {
	
	$result = $theDBA->addToUsers ($_POST ['ID'], $_POST ['password']);
	if ($result == FALSE) { // user already exists 
		$_SESSION['registerError'] = "Username already taken";
		// echo "Username taken" . PHP_EOL;
		header('Location: register.php');
	}
	else
		 header('Location: index.php');
}
if(isset($_POST['quote'])  && isset($_POST['author'])){
	//print_r("add to quotes\n");
	//echo("add to quotes\n");
	$arr = $theDBA->addToQuotes ($_POST ['quote'], $_POST ['author']);
	echo json_encode ( $arr );
	header('Location: index.php');
}
if (isset ( $_POST ['logout'] )) {
	session_destroy ();
	header ( 'Location: index.php' );
}
?>