<?php
	session_start();
	if(isset($_SESSION['error'])){
		echo $_SESSION['error'];
		session_unset();
	}
	
	require_once("vendor/autoload.php");
	use app\Connection;
	use app\Authenticate;
	
	try {
		$conn = Connection::get()->connect();
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

	if(isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['pw'])){		

		$clean_email = strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
		$clean_pw = strtolower(trim(htmlspecialchars($_POST['pw'])));

		Authenticate::validate_user($conn, $clean_email, $clean_pw);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<label for="">email</label><input type="email" name="email" id="">
			<label for="">password</label><input type="password" name="pw" id="">
			<button type="submit"name="submit">login</button>
		</form>
	</body>
</html>