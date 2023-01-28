<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="../images/trojan.png" width="40" height="40" alt="trojan" class="d-inline-block align-text-top">
        </a>
        <a class="navbar-brand" href="../index.php">
            <span class="text-warning">CLASS RANKER</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">Class Ranks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fav.php">Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../add.php">Add Class</a>
                </li>
            </ul>
            <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) : ?>
                <a class="login-btn" href="signup.php">Login</a>
            <?php else : ?>
                <div id="hello">Welcome <?php echo $_SESSION["username"]; ?>!</div>
                <a class="logout-btn" href="../index.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>