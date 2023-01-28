<?php
session_start();
require '../config/config.php';

	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			$passwordInput = hash('sha256', $_POST['password']);
			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			// echo "<hr>" . $sql . "<hr>";
			
			$results = $mysqli->query($sql);
			if(!$results) {
				echo $mysqli->error;
				exit();
			}
			if($results->num_rows > 0) {
				$_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"]; 

				// redirect to home page
				header("Location: ../index.php");
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

	<link rel="stylesheet" href="../main.css">

    <title>USC Class Ranker | Signin</title>
</head>
<body>
    <?php include 'nav.php'; ?>
	<div class="container-fluid">
		<form action="signin.php" method="POST" class="row mb-0">
			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->

			<div class="col-12 lexend text-center pt-4 pb-2">
				<h1>Enter Your Credentials</h1>
			</div>
            <div class="col-md-1 col-lg-2"></div>
            <div class="col-12 col-md-5 col-lg-4 pt-1 pb-1">
                <label for="username" class="form-label">Username: <span class="text-danger">*</span></label>
                <input type="username" class="form-control" placeholder="tommy" name="username" id="username-id" aria-label="username">
                <small id="username-error" class="invalid-feedback">Username is required.</small>
            </div>
            <div class="col-12 col-md-5 col-lg-4 pt-1 pb-1">
                <label for="password" class="form-label">Password: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Password" id="password-id" name="password" aria-label="Password">
                <small id="password-error" class="invalid-feedback">Password is required.</small>
            </div>
            <div class="col-md-1 col-lg-2"></div>

            <div class="d-grid gap-2 col-4 mx-auto pb-3 pt-3">
				<button type="submit" class="btn btn-primary">Sign in</button>
            </div>
		</form>
	</div>
	<div id="footer" class="container-fluid">
		Copyright 2021 USC CLASS RANKER
	</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>