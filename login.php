<?php
    
include('includes/config.inc');

	$username = $password = "";
	$username_err = $password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = 'Please enter username.';
    } else {
        $username = trim($_POST["username"]);
    }


    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }


    if (empty($username_err) && empty($password_err)) {

        $sql = "SELECT username, password FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            session_start();
                            $_SESSION['username'] = $username;
                            header("location: admin.php");
                        } else {

                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else {

                    $username_err = 'No account found with that username.';
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

      // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">

	<title>Login</title>

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
		<!-- Login Stuff -->

		<h2>Login</h2>
		<p>Please fill in your credentials to login.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up here</a>.</p>
        </form>


<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/menu-highlighter.js"></script>

</body>
</html>