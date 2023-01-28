<?php
session_start();
if (!isset($_POST['name']) || empty($_POST['name']) ||
	!isset($_POST['department_id']) || empty($_POST['department_id']) ||
	!isset($_POST['fun']) || empty($_POST['fun']) ||
	!isset($_POST['useful']) || empty($_POST['useful'])){

	// Missing required fields.
	$error = "Please fill out all required fields.";

} else {
	require 'config/config.php';
	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$statement_added = $mysqli->prepare("SELECT * FROM classes WHERE name LIKE ?;");
	$statement_added->bind_param("s", $_POST['name']);
	$executed_added = $statement_added->execute();
	if (!$executed_added){
		echo $mysqli->error;
	}
	$statement_added->store_result();

	$numrows = $statement_added->num_rows;
	$statement_added->close();
	if ($numrows != 0){
		$error = "Class has been added. Add another class.";
	}
	else{
		// overall rating is calculated by: useful rating + fun rating
		$useful_rating = (int)$_POST['useful'];
		$fun_rating = (int)$_POST['fun'];
		$department_id = (int)$_POST['department_id'];
		$overall_rating = $useful_rating + $fun_rating;

		$statement = $mysqli->prepare("INSERT INTO classes (name, useful_rating, fun_rating, overall_rating, departments_id)
						VALUES (?,?,?,?,?);");
		
		$statement->bind_param('siiii', $_POST['name'], $useful_rating, $fun_rating, $overall_rating, $department_id);

		$executed = $statement->execute();
		if(!$executed){
			echo $mysqli->error;
			exit();
		}	
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

	<link rel="stylesheet" href="main.css">

    <title>USC Class Ranker | Add Class</title>
</head>
<body>
	<?php include 'nav.php'; ?>


	<div class="container-fluid">

        <div class="row mt-4">
			<div class="col-12 display-3">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<h1 class="text-success"><?php echo $_POST['name']; ?> was successfully added.</h1>
				<?php endif; ?>
		    </div> <!-- .col -->
	    </div> <!-- .row -->

        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="add.php" role="button" class="btn btn-primary">Add another class</a>
            </div> <!-- .col -->
        </div> <!-- .row -->

	</div>


	<div id="footer" class="container-fluid">
	Copyright 2021 USC CLASS RANKER
	</div>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>