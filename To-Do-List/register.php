<?php
session_start();

// Connect to the database
include_once('includes/scripts/database.php');

$usernameExistQuery = $con->prepare("SELECT * FROM users WHERE username = (?)");
$emailExistQuery = $con->prepare("SELECT * FROM users WHERE email = (?)");
$insertUser = $con->prepare("INSERT INTO users (username, email, password, verificationkey, confirmed) VALUES ((?), (?), (?), (?), 0)");

if (isset($_POST['submit'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $hashedPassword = sha1($password);
    $repeatedPassword = htmlspecialchars(trim($_POST['repeatPassword']));
    $key = rand();

    $usernameExistQuery->bind_param("s", $username);
    $emailExistQuery->bind_param("s", $email);
    $insertUser->bind_param("sssi", $username, $email, $hashedPassword, $key);

    if (isset($username) && $username != "") {
        if (preg_match("/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $email)) {
            if (isset($password) && isset($repeatedPassword)) {
                if ($password == $repeatedPassword) {
                    if (6 <= strlen($password) || strlen($password) <= 32) {
                        $usernameExistQuery->execute();
                        if (mysqli_num_rows($usernameExistQuery->get_result()) == 0) {
                            $usernameExistQuery->close();
                            $emailExistQuery->execute();
                            if (mysqli_num_rows($emailExistQuery->get_result()) == 0) {
                                $emailExistQuery->close();
                                if ($insertUser->execute()) {
                                    $insertUser->close();
                                    include_once('includes/scripts/verificationMail.php');
                                    header("Location: index.php?register=true");
                                } else {
                                    $insertUser->close();
                                    $msg = "An unknown error ocurred. Please contact the development team.";
                                }
                            } else {
                                $msg = "The email is already registered!";
                            }
                        } else {
                            $msg = "The username is already registered!";
                        }
                    } else {
                        $msg = "Password must be more than 5 and less than 33 characters";
                    }
                } else {
                    $msg = "Passwords do not match";
                }
            } else {
                $msg = "Password can't be empty";
            }
        } else {
            $msg = "Please enter a valid e-mail address";
        }
    } else {
        $msg = "Username can't be empty";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Head -->
    <?php include_once('includes/files/head.html'); ?>
</head>
<body style="height: unset;" data-aos="fade-up">

<div class="container p-5 my-5">
    <div class="row my-3">
        <div class="col border-bottom border-primary">
            <h1>To-Do-List</h1>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-md-6">
            <h2>Sign up</h2>
        </div>

        <!-- Alert-Messages -->
        <div class="col-md-6">
            <?php
            if (isset($msg) && isset($_POST['submit'])) {
                echo '<div class="alert alert-dismissible alert-danger">';
                echo $msg;
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <form method="post" action="register.php">
        <div class="row my-3">
            <div class="col-md-6">
                <label>Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username"
                       value="<?php if (isset($username)) echo $username ?>">
            </div>

            <div class="col-md-6">
                <label>E-Mail</label>
                <input class="form-control" type="email" name="email" placeholder="E-Mail"
                       value="<?php if (isset($email)) echo $email ?>">
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-6">
                <label>Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password"
                       value="<?php if (isset($password)) echo $password ?>" maxlength="32" minlength="6">
            </div>

            <div class="col-md-6">
                <label>Repeat Password</label>
                <input class="form-control" type="password" name="repeatPassword" placeholder="Repeat Password"
                       value="<?php if (isset($repeatedPassword)) echo $repeatedPassword ?>" maxlength="32" minlength="6">
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-6 text-left">
                <p>Do you already have an account? <a href="index.php">Sign in here</a></p>
            </div>

            <div class="col-md-6 text-right">
                <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Sign up</button>
            </div>
        </div>
    </form>
</div>

<!-- Scripts and Links -->
<?php include_once('includes/files/bootstrapDependecies.html'); ?>

</body>
</html>