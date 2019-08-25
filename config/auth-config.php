
<?php

require 'db.php';

session_start();

use voku\helper\AntiXSS;
require_once '../../vendor/anti-xss/autoload.php';
$antiXss = new AntiXSS();


if (isset($_POST['submit'])) {
    $username = $antiXss->xss_clean($_POST["username"]);
    $password = $antiXss->xss_clean($_POST["password"]);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

	// cek username
	if( mysqli_num_rows($result) === 1 ) {

		// cek password
		$row = mysqli_fetch_assoc($result);
		if( password_verify($password, $row["password"]) ) {
            // set session
            $_SESSION['data'] = $row;
			$_SESSION["login"] = true;
			header("Location: home");
			exit;
		}
	}

	$error = true;
}

if (isset($error)) {
	echo "<script>
	swal('User & Password Invalid', 'If there are problems logging in or new user submission process please contact Ward (Ext. 57242)', 'error')
	</script>";
}
