<?php

session_start();


$server = '66.147.242.186';
$user = 'urcscon3_cbrent1';
$pass = 'coffee1N';
$db = 'urcscon3_cbrentna5';


$connection = mysqli_connect($server,$user,$pass,$db);
 

if(!$connection){
   echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {

        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $connection->prepare($sql)) {

            $stmt->bind_param("s", $param_username);

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {

                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        $stmt->close();
    }


    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }


    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }


    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = $connection->prepare($sql)) {

            $stmt->bind_param("ss", $param_username, $param_password);
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 

            if ($stmt->execute()) {

                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
    }

    $connection->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">

    <title>Home</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/nav.css">
        <!-- Insert Fonts Here -->
    </head>
    
        
    <body>

<header>
      
        <?php include "includes/nav.inc" ?>
    </header>

<hr>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form> 

<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/menu-highlighter.js"></script>

</body>
</html>