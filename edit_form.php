<?php
if (!isset($_GET['class_id']) || empty($_GET['class_id'])
    || !isset($_GET['class_name']) || empty($_GET['class_name'])){

	// Missing required fields.
	$error = "Class id or name not specified.";

} else {
	require 'config/config.php';
	session_start();
	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql = "SELECT * FROM departments;";
	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT classes.fun_rating AS fun_rating, classes.useful_rating AS useful_rating, departments.name AS departments_name 
	FROM classes JOIN departments ON departments.id = classes.departments_id WHERE classes.id = " . $_GET["class_id"] . ";";
	$class_info = $mysqli->query($sql);
	if ( !$class_info ) {
		echo $mysqli->error;
		exit();
	}
	$class_info = $class_info->fetch_assoc();

	$classes_id = (int)$_GET['class_id'];



	// Close DB Connection
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
		<div class="row text-center">
			<h1 class="col-12 pt-2">Editting a Class</h1>
		</div> <!-- .row -->
		<div id="dom-section" class="row"> 
			<h2 class="col-12 mt-4 mb-1 pb-1 border border-dark text-center org-info">Original info (click to see)</h2>
			<div class="container px-3" style="display: none;"> 
				<div class="row">
					<div class="col col-lg-3 col-mt-6 col-mb-6 fs-5 fw-bold">Class Name: </div>
					<div class="col col-lg-3 col-mt-6 col-mb-6"><?php echo $_GET['class_name']; ?></div>
				</div>
				<div class="row">
					<div class="col col-lg-3 col-mt-6 col-mb-6 fs-5 fw-bold">Department: </div>
					<div class="col col-lg-3 col-mt-6 col-mb-6"><?php echo $class_info['departments_name']; ?></div>
				</div>
				<div class="row">
					<div class="col col-lg-3 col-mt-6 col-mb-6 fs-5 fw-bold">Usefulness Rating: </div>
					<div class="col col-lg-3 col-mt-6 col-mb-6"><?php echo $class_info['useful_rating']; ?></div>
				</div>
				<div class="row">
					<div class="col col-lg-3 col-mt-6 col-mb-6 fs-5 fw-bold">Fun Rating: </div>
					<div class="col col-lg-3 col-mt-6 col-mb-6"><?php echo $class_info['fun_rating']; ?></div>
				</div>
			</div>
		</div>
	</div> <!-- .container -->

	<div class="container">

			<div class="col-12 text-danger">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>
			</div>

			<form action="edit_confirmation.php" method="POST">

				<div class="form-group row pt-3">
					<label for="name-id" class="col-sm-3 col-form-label text-sm-right">Class Name: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="name-id" name="name" value="<?php echo $_GET['class_name']; ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row pt-3">
					<label for="fun-id" class="col-sm-3 col-form-label text-sm-right">Fun Rating: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="number" class="form-control" id="fun-id" name="fun" value="<?php echo $class_info['fun_rating']; ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row pt-3">
					<label for="useful-id" class="col-sm-3 col-form-label text-sm-right">Usefulness Rating: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="number" class="form-control" id="useful-id" name="useful" value="<?php echo $class_info['useful_rating']; ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row pt-3">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div> <!-- .form-group -->

				<input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
			</form>
	</div> 
	<div id="footer" class="container-fluid">
	Copyright 2021 USC CLASS RANKER
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<script>
		$("#dom-section h2").on("mouseenter", function(){
			$(this).css("backgroundColor", "grey");	
		});
		$("#dom-section h2").on("mouseleave", function(){
			$(this).css("backgroundColor", "#d9d9d9");	
		});
		$("#dom-section h2").on("click", function(){
			$(this).next().slideToggle(400, function(){
				console.log("slide effect finished");
			});
		});

		// JS validates the user input. It's the first line of defense. User will NOT be able to submit this form if all inputs are not filled. 
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#name-id').value.trim().length == 0 ) {
				document.querySelector('#name-id').classList.add('is-invalid');
			} else {
				document.querySelector('#name-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#department-id').value.trim().length == 0 ) {
				document.querySelector('#department-id').classList.add('is-invalid');
			} else {
				document.querySelector('#department-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#fun-id').value.trim().length == 0 ) {
				document.querySelector('#fun-id').classList.add('is-invalid');
			} else {
				document.querySelector('#fun-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#useful-id').value.trim().length == 0 ) {
				document.querySelector('#useful-id').classList.add('is-invalid');
			} else {
				document.querySelector('#useful-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</body>
</html>