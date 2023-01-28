<?php
require '../config/config.php';

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}
else{
	// All required input is given.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno){
		echo $mysqli->error;
		exit();
	}

	$password = hash("sha256", $_POST['password']);
	$statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
	$statement_registered->bind_param("ss", $_POST['username'], $_POST['email']);
	$executed_registered = $statement_registered->execute();
	if (!$executed_registered){
		echo $mysqli->error;
	}
	$statement_registered->store_result();
	$numrows = $statement_registered->num_rows;
	$statement_registered->close();
	if ($numrows > 0){
		$error = "Username or email has been taken. Use another one.";
	}
	else{
		// Add user input into the new users table 
		$statement = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
		$statement->bind_param("sss", $_POST['username'], $_POST['email'], $password);
		$executed = $statement->execute();
		if (!$executed){
			echo $mysqli->error;
		}
		$statement->close();
	}
	
	$mysqli->close();
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

    <title>USC Class Ranker | Signup</title>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container-fluid">

        <div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<h1 class="text-danger"><?php echo $error; ?></h1>
				<?php else : ?>
					<h1 class="text-success"><?php echo $_POST['username']; ?> was successfully registered.</h1>
				<?php endif; ?>
		    </div> <!-- .col -->
	    </div> <!-- .row -->

        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="signin.php" role="button" class="btn btn-primary">Login</a>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
            </div> <!-- .col -->
        </div> <!-- .row -->

	</div>
	<div id="footer" class="container-fluid">
		Copyright 2021 USC CLASS RANKER
	</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>