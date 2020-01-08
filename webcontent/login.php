<?php
include_once('includes/scripts/database.php');

$errors = array();
$loginCredentials = $db->prepare("SELECT idusers, email FROM users WHERE username = (?) AND password = (?)");

if (isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $loginCredentials->bind_param("ss", $username, $password);

    if (isset($username) && $username == "") {
        array_push($errors, "Username is required");
    }
    if (isset($username) && $password == "") {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = sha1($password);
        $loginCredentials->execute();
        $result = $loginCredentials->get_result();
        if (mysqli_num_rows($result) == 1) {
            while ($row = $result->fetch_assoc()) {
                $userId = $row['idusers'];
            }
            include_once('includes/scripts/createSession.php');
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
            $password = "";
        }
        $loginCredentials->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php include_once('includes/dependencies.html'); ?>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" type="text/css" href="../styles/forms.css">
</head>

<body>
<div class="container">
    <h1><a href="index.php">Simple Vote</a></h1>

    <div class="sign">
        <h2>Sign in</h2>
    </div>

    <?php if (count($errors) > 0) : ?>
        <div class="alert alert-dismissible alert-danger">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form method="post" action="login.php">
        <div class="center-screen">
            <input type="text" class="form-control w-50" name="username" placeholder="Username"
                   value="<?php if (isset($username)) echo $username ?>">

            <input type="password" class="form-control w-50" name="password" placeholder="Password"
                   value="<?php if (isset($password)) echo $password ?>" maxlength="32" minlength="6">

            <p>No account yet? <a href="register.php">Register here</a></p>

            <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Sign in</button>
        </div>
    </form>
</div>
</body>
</html>
