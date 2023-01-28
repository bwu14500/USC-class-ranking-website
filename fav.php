<?php
	require 'config/config.php';
	session_start();
	$remove_class = false;
	if ( isset($_GET['user_id']) && !empty($_GET['user_id']) 
	&& isset($_GET['class_id']) && !empty($_GET['class_id'])
	&& isset($_GET['class_name']) && !empty($_GET['class_name']) ){
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		$statement = $mysqli->prepare("DELETE FROM users_has_classes WHERE users_has_classes.users_id = ? AND users_has_classes.classes_id = ?;");
		$classes_id = (int)$_GET['class_id'];
		$users_id = (int)$_GET['user_id'];
		
		$statement->bind_param('ii', $users_id, $classes_id);
		$executed = $statement->execute();
		if(!$executed){
			echo $mysqli->error;
			exit();
		}		

		$remove_class = true;
		$mysqli->close();
	}
	if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) {
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

		$sql = "SELECT classes.name AS class_name, classes.id AS class_id, classes.fun_rating AS fun_rating, classes.useful_rating AS useful_rating, 
		classes.overall_rating AS overall_rating FROM users_has_classes JOIN classes ON classes.id = users_has_classes.classes_id 
		WHERE users_id = " . $users_id . ";";
		$class_results = $mysqli->query($sql);
		if(!$class_results) {
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
	<link rel="stylesheet" href="fav.css">

    <title>USC Class Ranker | Favorite Classes</title>
</head>
<body>
	<?php include 'nav.php'; ?>
	
	<div class="container-fluid">
		<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ): ?>
			<div class="row text-center ">
				<h1 class="col-12 mt-4">Your Favorite Classes: </h1>
			</div>
			<div id="result" class="row pb-4">
				<?php while($row = $class_results->fetch_assoc()): ?>
					<div class="col-sm-6 col-lg-4 col-md-4 d-flex flex-column align-items-center pb-4">
						<div class="position-relative poster">
							<img src="images/class.jpeg" alt="" style="width: 100%; height:95%">
							<div class="overlay-text row flex-column" style="width: 100%; height:95%">
								<p>
									Fun Rating: &nbsp;<span><?php echo $row['fun_rating']; ?></span>
								</p>
								<p>
									Usefulness Rating: &nbsp;<span><?php echo $row['useful_rating']; ?></span>
								</p>
								<p>
									Overall Rating: &nbsp;<span><?php echo $row['overall_rating']; ?></span>
								</p>
							</div>
							<p></p>
							<p></p>
						</div>
						<div class="row" width="100%">
							<div class="col-7"><?php echo $row['class_name']; ?></div>
							<div class="col-5">
								<a href="fav.php?user_id=<?php echo $users_id; ?>&class_name=<?php echo $row['class_name']; ?>&class_id=<?php echo $row['class_id']; ?>" class="btn btn-danger" onclick="return confirm('You are about to remove <?php echo $row['class_name']; ?> from your favorite classes.');">
									Remove
								</a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php else: ?>
			<div class="container-fluid">
				<h1>Log in to see your favorites classes</h1>
			<div></div>
		<?php endif; ?>
	</div>

	<div id="footer" class="container-fluid">
		Copyright 2021 USC CLASS RANKER
	</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script>
		<?php if ($remove_class): ?>
			window.alert("<?php echo $_GET['class_name'] ?> has been removed from your favorite classes.");
		<?php endif; ?>
  </script>
</body>
</html>