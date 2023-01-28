<?php
	session_start();
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

		<form class="row mb-0" action="signup_confirmation.php" method="POST">

			<div class="col-12 lexend text-center pt-4 pb-2">
				<h1>Create an Account</h1>
			</div>

			<div class="col-md-1 col-lg-2"></div>
				<div class="col-12 col-md-5 col-lg-8 pt-1 pb-1">
					<label for="email-id" class="form-label">Email: <span class="text-danger">*</span></label>
					<input type="email" class="form-control" placeholder="ttrojan@usc.edu" name="email" id="email-id" aria-label="Email">
					<small id="email-error" class="invalid-feedback">Email is required.</small>
				</div>

				<div class="col-md-1 col-lg-2"></div>
				<div class="col-md-1 col-lg-2"></div>

				<div class="col-12 col-md-5 col-lg-4 pt-1 pb-1">
					<label for="username-id" class="form-label">Username: <span class="text-danger">*</span></label>
					<input type="text" class="form-control" placeholder="Tommy" id="username-id" name="username" aria-label="username">
					<small id="first-error" class="invalid-feedback">Username is required.</small>
				</div>

				<div class="col-12 col-md-5 col-lg-4 pt-1 pb-1">
					<label for="password-id" class="form-label">Password: <span class="text-danger">*</span></label>
					<input type="password" class="form-control" placeholder="Password" id="password-id" name="password" aria-label="Password">
					<small id="password-error" class="invalid-feedback">Password is required.</small>
				</div>

				<div class="col-md-1 col-lg-2"></div>


				<div class="row">
					<div class="col-md-1 col-lg-2"></div>
					<div class="mr-auto col-12 col-md-5 col-lg-4 text-right">
						<span class="text-danger">* Required</span>
					</div>
					<div class="col-md-6 col-lg-2"></div>
				</div>

				<div class="d-grid gap-2 col-4 mx-auto pb-3 pt-3">
					<button type="submit" class="btn btn-primary">Sign Up</button>
				</div>
				<div class="d-grid gap-2 col-4 mx-auto pb-3 pt-3">
					<a href="signin.php" role="button" class="btn btn-outline-dark">Sign In</a>
				</div>

		</form>
	</div>
	<div id="footer" class="container-fluid">
		Copyright 2021 USC CLASS RANKER
	</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script>
		// JS validates the user input. User will NOT be able to submit this form if all inputs are not filled. 
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
  </script>
</body>
</html>