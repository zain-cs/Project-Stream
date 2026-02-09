<?php
	include("includes/chk-session.php");	
	include("includes/config.php");
	
	$_SESSION["firstName"] = "";
	$_SESSION["lastName"] = "";
	$_SESSION["email"] = "";
	$_SESSION["userName"] = "";
	$_SESSION["userEmail"] = "";		
	$_SESSION["userPicture"] = "";
	
	unset($_SESSION["firstName"]);
	unset($_SESSION["lastName"]);
	unset($_SESSION["email"]);
	unset($_SESSION["userName"]);
	unset($_SESSION["userEmail"]);
	unset($_SESSION["userPicture"]);
	session_destroy();
	
	
	echo("<script>window.location.href = '".$localPath."/';</script>");
?>