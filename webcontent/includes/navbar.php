<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <?php if (!isset($_SESSION['success'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            <?php endif ?>
            <?php if (isset($_SESSION['success'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="../scripts/logout.php">Log out</a>
                </li>>
                <li class="nav-item active">
                    <a class="nav-link">Logged in as: <?= $_SESSION['username']?></a>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>
