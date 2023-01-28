<?php
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
	if ( $results == false ) {
		echo $mysqli->error;
		exit();
	}



	$mysqli->close();
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

    <div class="container">
        <div class="row d-flex flex-column text-center justify-content-center pt-3">
            <h1>Add a Class You Like</h1>
        </div>
		<form action="add_confirmation.php" method="POST">

            <div class="form-group row pt-3">
				<label for="name-id" class="col-sm-3 col-form-label text-sm-right fw-bold">Class Name: <span class="text-danger">*</span></label>
				<div class="row px-4">
					<input type="text" class="form-control" id="name-id" name="name">
				</div>
			</div> 

			<div class="form-group row pt-3">
				<label for="department-id" class="col-sm-3 col-form-label text-sm-right fw-bold">Department: <span class="text-danger">*</span></label>
				<div class="row px-4">
					<select name="department_id" id="department-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>
                        <?php while ( $row = $results->fetch_assoc() ) : ?>
							<option value="<?php echo $row['id']; ?>">
								<?php echo $row['name']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div> 

            <div class="form-group row pt-3">
				<label for="fun-id" class="col-sm-3 col-form-label text-sm-right fw-bold">Fun Rating: <span class="text-danger">*</span></label>
				<div class="row px-4">
					<input type="number" class="form-control" id="fun-id" name="fun">
				</div>
			</div> 

			<div class="form-group row pt-3">
				<label for="useful-id" class="col-sm-3 col-form-label text-sm-right fw-bold">Usefulness Rating: <span class="text-danger">*</span></label>
				<div class="row px-4">
					<input type="number" class="form-control" id="useful-id" name="useful">
				</div>
			</div>

			<div class="form-group row pt-3">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-5"></div>
				<div class="col-sm-7 mt-2">
					<button type="submit" class="btn btn-primary mx-3">Submit</button>
					<button type="reset" class="btn btn-light mx-3">Reset</button>
				</div>
			</div> 

		</form>

	</div> <!-- .container -->
	<div id="footer" class="container-fluid">
	Copyright 2021 USC CLASS RANKER
	</div>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<script>
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