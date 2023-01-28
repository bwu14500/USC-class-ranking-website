<?php
	session_start();
	session_destroy(); // destroys all session variables that exist
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

    <title>USC Class Ranker | Signin</title>
</head>
<body>
    <?php include 'nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 text-center">Logged out.</h1>
			<div class="col-2"></div>
			<a href="../index.php" class="col-3 btn btn-primary">home page</a>  
			<div class="col-2"></div>
			<a href="signin.php" class="col-3 btn btn-primary">log in</a>
			<div class="col-2"></div>
		</div> <!-- .row -->
	</div> <!-- .container -->
    
    <div id="footer" class="container-fluid">
		Copyright 2021 USC CLASS RANKER
	</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
