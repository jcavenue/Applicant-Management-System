<?php
	session_set_cookie_params(0, '/', 'localhost', true, true);
	session_start();

	if(!isset($_SESSION['username']) && $_SESSION['Auth'] !== true || time() - $_SESSION['login_time'] > 30 * 60){
		session_unset();
		session_destroy();
		header("Location: login");
	} else {
		$_SESSION['login_time'] = time();
		session_regenerate_id(true);
		echo "Welcome " . $_SESSION['username'] . "<br>";
		$userid = $_SESSION['id'];
	}

	require_once("vendor/autoload.php");
	use app\Connection;
	use app\Dashboard;

	$conn = Connection::get()->connect();
	$account_detail = new Dashboard($conn, $userid);
	$view = $account_detail->getDetails();
	print_r($view);	
?>
<table>
	<?php foreach($view as $key => $value){ ?>
		<tr>
			<td>
				<?php echo $key?>
			</td>
			<td>
				<?php echo $value?>
			</td>
		</tr>
	<?php } ?>

</table>




<a href="../logout">logout</a>