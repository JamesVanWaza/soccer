<?php
	session_start(); //Access the current session.
	//If no session variable exists then redirect the user

	if (!isset($_SESSION['user_id'])) {
		header("Location: index.php");
		exit();
		//Cancel the session and redirect the user:
	}
	else{
		$_SESSION = array(); //Destroy the variables
		session_destroy(); //Destroy the session
		setcookie('PHPSESSID', ", time()-3600,'/',", 0, 0); //Destroy the cookie
		header("Location: index.php");
		exit();
	}
?>
