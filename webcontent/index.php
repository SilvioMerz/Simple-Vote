<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/dependencies.html'); ?>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <script src="../scripts/index.js"></script>
</head>
<body>
<?php include_once('includes/header.html'); ?>

<?php include_once('includes/navbar.php'); ?>

<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-4">
            <h2>Title</h2>
            <h5>Lorem ipsum dolor sit amet.</h5>
            <div class="fakeimg">Image</div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <h3>Some Links</h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <hr class="d-sm-none">
        </div>
        <div class="col-sm-8">
            <h2>TITLE HEADING</h2>
            <h5>Title description</h5>
            <div class="fakeimg">Image</div>
            <p>Some text..</p>
            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                ullamco.</p>
            <br>
            <h2>TITLE HEADING</h2>
            <h5>Title description</h5>
            <div class="fakeimg">Image</div>
            <p>Some text..</p>
            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                ullamco.</p>
        </div>
    </div>
</div>

<?php include_once('includes/footer.html'); ?>
</body>
</html>