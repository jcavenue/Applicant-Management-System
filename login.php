<?php
	require_once("vendor/autoload.php");

	session_start();
	if(isset($_SESSION['error'])){
		echo $_SESSION['error'];
		session_unset();
	}
	
	use app\Connection;
	
	try {
		$conn = Connection::get()->connect();
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

	if(isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['pw'])){
		
		$email = strtolower(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
		$pw = strtolower(trim(htmlspecialchars($_POST['pw'])));

	$sql = "SELECT id, email, pw FROM hr WHERE email=:email LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->execute([':email'=>$email]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowcount() != 1){
			$_SESSION['error'] = 'No User found';
			header('Location: login');
		} else {
			if(password_verify($pw,$row['pw'])){
				$_SESSION['userid'] = $row['id'];
				$_SESSION['login_time'] = time();
				session_write_close();
				header('Location: main');
			} else {	
				$_SESSION['error'] = 'Wrong Password';
				header('Location: login');
			}
		}

		$conn = null;
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