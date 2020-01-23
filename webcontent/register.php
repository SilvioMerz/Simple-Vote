<?php

include_once('includes/scripts/database.php');

$title = "Simple Vote";

$errors = array();
$insertUser = $db->prepare("INSERT INTO users (username, email, password) VALUES ((?), (?), (?))");

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $repeatedPassword = mysqli_real_escape_string($db, $_POST['repeatPassword']);

    $insertUser->bind_param("sss", $username, $email, $password);

    if (isset($username) && $username == "") {
        array_push($errors, "Username is required");
    }
    if (!preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $email)) {
        array_push($errors, "Email is invalid");
    }
    if (isset($password) && $password == "") {
        array_push($errors, "Password is required");
    }
    if (strlen($password) < 6 || strlen($password) > 32) {
        array_push($errors, "Password must have at least 6 and a maximum of 32 characters");
    }
    if ($password != $repeatedPassword) {
        array_push($errors, "The two passwords do not match");
    }


    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = sha1($password);
        $insertUser->execute();
        $insertUser->close();
        $userId = $db->insert_id;
        include_once('includes/scripts/createSession.php');
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('includes/dependencies.html'); ?>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" type="text/css" href="../styles/forms.css">
</head>

<body>
<?php include_once('includes/header.php'); ?>

<div class="container">

    <div class="allItems">
    <div class="sign">
        <h2>Sign up</h2>
    </div>

    <?php if (count($errors) > 0) : ?>
        <div class="alert alert-dismissible alert-danger">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form method="post" action="register.php">
        <div class="center-screen">
            <input class="form-control w-50" type="text" name="username" placeholder="Username"
                   value="<?php if (isset($username)) echo $username ?>">

            <input class="form-control w-50" type="email" name="email" placeholder="E-Mail"
                   value="<?php if (isset($email)) echo $email ?>">

            <input class="form-control w-50" type="password" name="password" placeholder="Password"
                   value="<?php if (isset($password)) echo $password ?>" minlength="6" maxlength="32">

            <input class="form-control w-50" type="password" name="repeatPassword" placeholder="Repeat password"
                   value="<?php if (isset($repeatedPassword)) echo $repeatedPassword ?>" minlength="6" maxlength="32">

            <p>Do you already have an account? <a href="login.php">Sign in here</a></p>

            <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Sign up</button>
        </div>
    </form>
    </div>
</div>
</body>
</html>
