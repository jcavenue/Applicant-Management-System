<?php
	session_set_cookie_params(0, '/', 'localhost', true, true);
	session_start();

	if(!isset($_SESSION['userid']) || time() - $_SESSION['login_time'] > 30 * 60){
		session_unset();
		session_destroy();
		header("Location: login");
	} else {
		$_SESSION['login_time'] = time();
		session_regenerate_id(true);
		echo "Welcome " . $_SESSION['userid'] . "<br>";
		$user_id = $_SESSION['userid'];
	}

	require_once("vendor/autoload.php");
	use app\Connection;

	$conn = Connection::get()->connect();

	$sql = "SELECT COUNT(*)FROM applicant WHERE hr_id=:user";
			$stmt = $conn->prepare($sql);
			$stmt->execute([':user'=>$user_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo "Number of applicant : " . $row['count'] . "<br>";
			
?>
<a href="logout.php">logout</a>