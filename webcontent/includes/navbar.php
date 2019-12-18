<?php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../webcontent/index.php');
}
?>

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
            <?php if (!isset($_SESSION['USER']['SUCCESS'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="../webcontent/register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../webcontent/login.php">Login</a>
                </li>
            <?php endif ?>

            <?php if (isset($_SESSION['USER']['SUCCESS'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="../webcontent/index.php?logout='1'">logout</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link">Logged in as: <?= $_SESSION['USER']['USERNAME'] ?></a>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>
