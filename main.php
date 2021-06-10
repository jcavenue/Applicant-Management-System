<?php
	session_start();
	if(!isset($_SESSION['userid']) || time() - $_SESSION['login_time'] > 30 * 60){
		session_unset();
		session_destroy();
		header("Location: login.php");
	} else {
		$_SESSION['login_time'] = time();
		session_regenerate_id(true);
	}

	echo "Welcome " . $_SESSION['userid'];
	echo "Your started Session is " . $_SESSION['login_time'] . "time " . time();
?>
<a href="logout.php">logout</a>