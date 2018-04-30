<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">

	<title>Admin Page</title>

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
		<?php
// connect to the database
include('config.php');

// get results from database
$result = mysqli_query($connection, "SELECT * FROM surveydata");
?>

<table border>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Description</th>
    <th></th>
    <th></th>
  </tr>
<?php
// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $result )) {
?>
  <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a></td>
    <td><a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
  </tr>
<?php
// close the loop
}
?>
</table>

<div>
	<a href="new.php">Add a new record</a>
</div>

		<p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>

	<footer>
		Team Stockholm
		<br>
		Assignment 5
	</footer>

<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/menu-highlighter.js"></script>

</body>
</html>