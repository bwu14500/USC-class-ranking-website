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
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$search = false;
	if (isset($_POST['department_id']) && !empty($_POST['department_id'])) {
		$search = true;
		$class_sql = "SELECT classes.id AS id, classes.name AS class_name, classes.fun_rating, classes.useful_rating, classes.overall_rating FROM classes JOIN departments ON departments.id = classes.departments_id WHERE classes.departments_id = " . $_POST['department_id'] . " ORDER BY classes.overall_rating DESC;";
		$class_results = $mysqli->query($class_sql);
		if ( !$class_results) {
			echo $mysqli->error;
			exit();
		}
	}
	$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

	  <link rel="stylesheet" href="main.css">

	<title>USC Class Ranker | Home</title>

  <style>
	.animate {
		animation-name: move;
		animation-duration: 3s;
		animation-delay: 0s;
		animation-iteration-count: 1;
	}
	.bruin {
		animation-name: FadeIn;
		animation-duration: 2s;
		animation-delay: 0s;
		animation-iteration-count: 1;
	}
	@keyframes move {
		25%, 35% {
			transform: scale(2, .1) translate(0, 0);
		}
		
		35%, 65% {
			transform: scale(1) translate(0, -50px);
		}
		100% {
			transform: scale(1) translate(0, 0);
		}
	}
	@keyframes FadeIn { 
		0% {
			opacity: 0;
			text-shadow: 0 0 50px #fff;
			transform:translateX(-100%);
		}
		100% {
			opacity: 1;
			text-shadow: 0 0 1px #fff;
			transform:translateX(0%);
		}
	}
  </style>
</head>
<body>
  	<?php include 'nav.php'; ?>
	  
	<div class="container-fluid">
	<div id="header" class="row d-flex flex-column justify-content-center mb-4 bg-gradient" style="background-color: #C0C0C0;">
		<h1 class="display-1 animate"style="color: #b3001b; -webkit-text-stroke: 1px gold;">USC CLASS RANKER</h1>
		<h3 class="display-6" id="change">your best helper for selecting classes to take</h3>
		<button class="align-self-center border border-dark col-2 btn"id="button">click me!</button>
	</div>
	<form action="index.php" method="POST">
		<div class="form-group row">
			<h4 class="col-sm-3 font-weight-bold">Choose a Department: </h4>
			<div class="col-sm-7">
			<select name="department_id" id="department-id" class="form-control">
				<option value="" selected>-- All --</option>
				<?php while ( $row = $results->fetch_assoc() ) : ?>
					<option value="<?php echo $row['id']; ?>">
						<?php echo $row['name']; ?>
					</option>
				<?php endwhile; ?>
			</select>
			</div>
			<div class="col-sm-2 mt-sm-0 mt-2">
			<button type="submit" class="btn btn-primary">Search</button>
			</div>
		</div> <!-- .form-group -->
	</form>
	</div>
	<hr size="5" class="bg-red">
	<div class="container-fluid">
		<div class="row text-center">
			<div class="col-12">
				<h4 class="font-weight-bold">Results: </h4>
			</div>
		</div>
		<div class="row">
			<div class="col-12 table-responsive-xl">
				<table class="table table-hover mt-4">
					<?php if ($search) : ?>
						<thead>
							<tr>
								<th>Class Name</th>
								<th>Fun Rating</th>
								<th>Usefulness Rating</th>
								<th>Overall Rating</th>
								<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username']== "Brandon") : ?>
									<th>       </th>
								<?php endif; ?>
								<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) : ?>
									<th>       </th>
									<th>       </th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
								<?php if ($class_results->num_rows == 0) : ?>
									<tr>
										<td class="text-danger"><h4>No classes are added to this department yet.</h4></td>
									</tr>
								<?php endif; ?>
								<?php while ( $row = $class_results->fetch_assoc() ) : ?>
									<tr>
										<td><?php echo $row['class_name']; ?></td>
										<td><?php echo $row['fun_rating']; ?></td>
										<td><?php echo $row['useful_rating']; ?></td>
										<td><?php echo $row['overall_rating']; ?></td>
										<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ) : ?>
										<td>
											<a href="add_fav.php?class_id=<?php echo $row['id']; ?>&class_name=<?php echo $row['class_name']; ?>" onclick="return confirm('Are you sure you want to add this class to your favorites?')" class="btn btn-success add-btn" method="POST">
												ADD TO FAV
											</a>
										</td>
										<?php endif; ?>
										<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['username']== "Brandon") : ?>
											<th>   
												<a href="edit_form.php?class_id=<?php echo $row['id']; ?>&class_name=<?php echo $row['class_name']; ?>" class="btn btn-warning" method="POST">
													Edit
												</a>
											</th>
											<th>
												<a href="delete.php?class_id=<?php echo $row['id']; ?>&class_name=<?php echo $row['class_name']; ?>" class="btn btn-danger" onclick="return confirm('You are about to delete <?php echo $row['class_name']; ?>.');" method="POST">
													Delete
												</a>
											</th>
										<?php endif; ?>
									</tr>
								<?php endwhile; ?>
						</tbody>
					<?php endif; ?>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div>
	<div id="footer" class="container-fluid">
	Copyright 2021 USC CLASS RANKER
	</div>
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<script>
		document.querySelector("#button").onclick = function () {
			document.querySelector("#change").textContent = "Beat the Bruins. Fight On!";
			document.querySelector("#change").classList.add("bruin");
		}
	</script>
</body>
</html>
