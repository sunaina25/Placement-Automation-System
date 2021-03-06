<?php

	// connect to database
	require_once(__DIR__ . '/../includes/dbconfig.php');
	session_start();

	// if the user isn't logged in, try to login
	if (!isset($_SESSION['company_id'])) {
		// if the user tried to login
		if (isset($_POST['submit'])) {

			// grab the login data entered by user
			$user_name = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

			// query the database if email and password are not empty
			if (!empty($user_name) && !empty($user_password)) {
				// look up email and password in the database
				$query = "SELECT id, password, name from company WHERE username = '$user_name'";
				$result = mysqli_query($dbc,$query);
				//echo "'$user_email'\n'$user_password'\n$query";

				if (mysqli_num_rows($result) == 1) {
					$row = mysqli_fetch_array($result);
					if (password_verify($user_password, $row['password'])) {
						//$verified = $row['verified'];
						// if ($verified) {
							$_SESSION['company_id'] = $row['id'];
							$_SESSION['name'] = $row['name'];
							// $_SESSION['last_name'] = $row['last_name'];
							// check if the user is a manager
							// $query = "SELECT manager_id FROM managers WHERE user_id = ".$row['user_id'];
							// $result = mysqli_query($dbc, $query);
							// if (mysqli_num_rows($result) == 1) {
								// $row = mysqli_fetch_array($result);
								// $_SESSION['manager_id'] = $row['manager_id'];
							//}
							header('Location: ../compdash/dashboard.php');
						// }
						// else {
						// 	// account is not activated yet
						// 	$err_msg = "You have not activated your account yet.";
						// }
					}
				}
				else {
					// email or password was incorrect so set the error message
					$err_msg = "username or password is incorrect.";
				}
			}
			else
				$err_msg = "username or password missing.";
		}
	}
	/*
	else {
		// user is logged in do redirect to dashboard
		header('Location: public/dashboard.php');
	}*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<title>Company Sign In</title>

	<link href="http://fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<section class="container login-form">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="login">
      <?php if (!empty($err_msg)) {?>
				<div class="alert alert-danger">
					<a href="#" class="alert-link">
						<?php echo $err_msg; ?>
					</a>
				</div>
				<?php } ?>
      <div class="form-group">
   				<div class="input-group">
      				<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					<input type="text" name="username" placeholder="username" required class="form-control input-lg" />
				</div>
			</div>
			<div class="form-group">
   				<div class="input-group">
      				<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
					<input type="password" name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required class="form-control input-lg" />
				</div>
			</div>
			<button type="submit" name="submit" class="btn btn-lg btn-block btn-success">SIGN IN</button>
			<section>
				Not a member? <a href="#">Sign up now <span>&rarr;</span></a>
			</section>
		</form>
	</section>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
