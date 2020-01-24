<link rel="stylesheet" type="text/css" href="../styles/footer.css">
<footer>
    <div class="footer-content">
        <div class="col-xl-12 content-middle-of-height">
            <ul>
                <li><a href="../webcontent/index.php">home</a></li>
                <?php if (!isset($_SESSION['USER']['SUCCESS'])) : ?>
                    <li><a href="../webcontent/register.php">Register</a></li>
                    <li><a href="../webcontent/login.php">Login</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['USER']['SUCCESS'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../webcontent/createSurvey.php">Create survey</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webcontent/index.php?logout='1'">logout</a>
                    </li>
                <?php endif; ?>
            </ul>
            <!--                <img src="../Documents/vote.png" alt="Selfhtml">-->
        </div>
    </div>
    <div class="copyright_text">
        <p class=" content-middle-of-height">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script>
            All rights reserved | Website SimpleVote <i class="fa fa-heart-o" aria-hidden="true"></i>
        </p>
    </div>
</footer>