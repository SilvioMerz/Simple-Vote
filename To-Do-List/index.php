<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 26.05.2019
 * Time: 21:09
 */
session_start();

// Connect to the database
include_once('includes/scripts/database.php');

// Query for getting the user from the database
$loginCredentials = $con->prepare("SELECT user_ID, email FROM users WHERE username = (?) AND password = (?) AND confirmed = 1");

// Destroys the session if the user gets logged out (no data in $_SESSION anymore)
if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
    session_destroy();
}

// Successmessage for registering
if (isset($_GET['register']) && ($_GET['register'] == 'true')) {
    $successMessage = "Your registration worked. Please check your mailbox and verify your account to sign in.";
}

// Successmessage for verifying the account
if (isset($_GET['verified']) && ($_GET['verified'] == 'true')) {
    $successMessage = "Your verification worked, you're ready to sign in.";
}

// if the client tries to log in
if (isset($_POST["submit"])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $hashedpassword = sha1($password);

    $loginCredentials->bind_param("ss", $username, $hashedpassword);

    // gets the user credentials from the database
    if ($loginCredentials->execute()) {
        $result = $loginCredentials->get_result();

        // fetches the user credentials in the session if he exists in the database and is verified
        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_array(MYSQLI_NUM);
            $userID = $row[0];
            $email = $row[1];
            $_SESSION['user'] = array(
                "user_ID" => $userID,
                "username" => $username,
                "email" => $email
            );
            $loginCredentials->close();
            // sends user to the main page
            header("Location: sites/main.php");
        } else {
            $message = "Oh No! Your credentials are wrong. Make sure you entered the correct username and password!";
        }
    } else {
        $message = 'An unknown error ocurred. Please contact the development team.';
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Head -->
    <?php include_once('includes/files/head.html') ?>
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
            <h2>Sign in</h2>
        </div>

        <!-- Alert-Messages -->
        <div class="col-md-6">
            <?php
            if (isset($message)) {
                echo '<div class="alert alert-dismissible alert-danger">';
                echo $message;
                echo '</div>';
            }
            if (isset($successMessage)) {
                echo '<div class="alert alert-dismissible alert-success">';
                echo $successMessage;
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <form method="post" action="index.php">
        <div class="row my-3">
            <div class="col-md-6">
                <label>Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username"
                       value="<?php if (isset($username)) echo $username ?>">
            </div>

            <div class="col-md-6">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password"
                       value="<?php if (isset($password)) echo $password ?>" maxlength="32" minlength="6">
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-6 text-left">
                <p>No account yet? <a href="register.php">Register here</a></p>
            </div>

            <div class="col-md-6 text-right">
                <button type="submit" name="submit" class="btn btn-sm btn-outline-primary">Sign in</button>
            </div>
        </div>
    </form>
</div>

<!-- Scripts and Links -->
<?php include_once('includes/files/bootstrapDependecies.html') ?>

</body>
</html>
