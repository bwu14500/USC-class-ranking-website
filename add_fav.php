<?php
session_start();
if (!isset($_GET['class_id']) || empty($_GET['class_id'])
    || !isset($_GET['class_name']) || empty($_GET['class_name'])){

	// Missing required fields.
	$error = "Class id or name not specified.";

} else {
	require 'config/config.php';
	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

    $sql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $result = $mysqli->query($sql);
    if(!$result) {
        echo $mysqli->error;
        exit();
    }
    $users_id = $result->fetch_assoc()['id'];
    $classes_id = (int)$_GET['class_id'];

	$statement_added = $mysqli->prepare("SELECT * FROM users_has_classes WHERE users_id = ? and classes_id = ?;");
	$statement_added->bind_param("ii", $users_id, $classes_id);
	$executed_added = $statement_added->execute();
	if (!$executed_added){
		echo $mysqli->error;
	}
	$statement_added->store_result();
	$numrows = $statement_added->num_rows;
	$statement_added->close();

	if ($numrows > 0){
		$error = $_GET['class_name'] . " is already added to your favorites. Add another class.";
	}
	else{

		$statement = $mysqli->prepare("INSERT INTO `users_has_classes` (`users_id`, `classes_id`) VALUES (?, ?);");
		
		$statement->bind_param('ii', $users_id, $classes_id);

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

    <title>USC Class Ranker | Add favorite</title>
</head>
<body>
	<?php include 'nav.php'; ?>


	<div class="container-fluid">

        <div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<h1 class="text-danger"><?php echo $error; ?></h1>
				<?php else : ?>
					<h1 class="text-success"><?php echo $_GET['class_name']; ?> was successfully added to your favorites list.</h1>
				<?php endif; ?>
		    </div> <!-- .col -->
	    </div> <!-- .row -->

        <div class="row mt-4 mb-4">
            <div class="col-12">
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