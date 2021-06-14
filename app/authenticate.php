<?php
	namespace app;


	class Authenticate {

		public static function validate_user($conn, $email, $pw){

			$sql = "SELECT id, email, pw, username FROM hr WHERE email=:email LIMIT 1";
			$stmt = $conn->prepare($sql);
			$stmt->execute([':email'=>$email]);
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);

			if($stmt->rowcount() != 1){
				$_SESSION['error'] = 'No User found';
				header('Location: login');
			} else {
				if(password_verify($pw,$row['pw'])){
					$_SESSION['Auth'] = true;
					$_SESSION['username'] = $row['username'];
					$_SESSION['id'] = $row['id'];
					$_SESSION['login_time'] = time();
					session_write_close();
					header('Location: main/' . $row['username']);
				} else {	
					$_SESSION['error'] = 'Wrong Password';
					header('Location: login');
				}
			}

			$conn = null;

			}
	}
?>