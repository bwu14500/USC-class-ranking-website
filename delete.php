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

    $statement = $mysqli->prepare("DELETE FROM classes WHERE classes.id = ?;");
    $classes_id = (int)$_GET['class_id'];
    $statement->bind_param('i', $classes_id);

    $executed = $statement->execute();
    if(!$executed){
        echo $mysqli->error;
        exit();
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

    <title>USC Class Ranker | Delete class</title>
</head>
<body>
	<?php include 'nav.php'; ?>


	<div class="container-fluid">

        <div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<h1 class="text-success"><?php echo $_GET['class_name']; ?> has been successfully deleted from the database.</h1>
				<?php endif; ?>
		    </div> <!-- .col -->
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