<?php
	include "config.php";
	session_start();
	unset($_SESSION["customer"]);
	if(session_destroy()) {
	header("Location: customer-login.php");
	}
?>