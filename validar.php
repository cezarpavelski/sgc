<?php
	session_start();
	if ($_SESSION['admSGC'] != "OK"){
		session_unset();
		session_destroy();
		header("Location: index.html");
	}
?>