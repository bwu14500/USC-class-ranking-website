<?php
if (!isset($_POST['name']) || empty($_POST['name'])
|| !isset($_POST['fun']) || empty($_POST['fun'])
|| !isset($_POST['useful']) || empty($_POST['useful'])
|| !isset($_POST['class_id']) || empty($_POST['class_id'])
){
	$error = 'Please fill out all required fields.';
}else{
	require 'config/config.php';
	session_start();
	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$fun_rating = (int)$_POST['fun'];
	$useful_rating = (int)$_POST['useful'];
	$class_id = (int)$_POST['class_id'];
	$overall_rating = $fun_rating + $useful_rating;

	$statement = $mysqli->prepare("UPDATE classes SET name = ?, useful_rating = ?, fun_rating = ?, overall_rating = ? WHERE id = ?");
	$statement->bind_param('siiii', $_POST['name'], $useful_rating, $fun_rating, $overall_rating, $class_id);
	$executed = $statement->execute();
	if(!$executed){
		echo $mysqli->error;
		exit();
	}

	$isUpdated = false;
	$rows_affected = $statement->affected_rows;
	if($statement->affected_rows == 1){
		$isUpdated = true;
	}
	$statement->close();

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

	<link rel="stylesheet" href="main.css">

    <title>USC Class Ranker | Delete class</title>
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container">
		<div class="row mt-4">
			<div class="col-12 display-3">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>
				<?php if ($isUpdated) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST['name']; ?></span> was successfully edited.
					</div>
				<?php endif; ?>
				<?php if (!$rows_affected) : ?>
					<div class="text-danger">
						Nothing was changed
					</div>
				<?php endif; ?>
				
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div id="footer" class="container-fluid">
	Copyright 2021 USC CLASS RANKER
	</div>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>
</body>
</html>
