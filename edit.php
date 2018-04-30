<?php
include('renderform.php');

$server = '66.147.242.186';
$user = 'urcscon3_cbrent1';
$pass = 'coffee1N';
$db = 'urcscon3_cbrentna5';


$connection = mysqli_connect($server,$user,$pass,$db);
if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['submit']))
{
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
	{
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$name = mysqli_real_escape_string($connection, htmlspecialchars($_POST['name']));
		$email = mysqli_real_escape_string($connection, htmlspecialchars($_POST['email']));
		$description = mysqli_real_escape_string($connection, htmlspecialchars($_POST['description']));

		// check that firstname/lastname fields are both filled in
		if ($name == '' || $email == '' || $description == '')
		{
			// generate error message
			$error = 'ERROR: Please fill in all required fields!';

			//error, display form
			renderForm($id, $name, $email, $description, $error);

		} else {
			// save the data to the database
			$result = mysqli_query($connection, "UPDATE surveydata SET name='$name', email='$email', description='$description' WHERE id='$id'");

			// once saved, redirect back to the view page
			header("Location: admin.php");
		}
	} else {
		// if the 'id' isn't valid, display an error
		echo 'Error!';
	}
} else {
	// if the form hasn't been submitted, get the data from the db and display the form
	// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
	{
		// query db
		$id = $_GET['id'];
		$result = mysqli_query($connection, "SELECT * FROM surveydata WHERE id=$id");
		$row = mysqli_fetch_array( $result );

		// check that the 'id' matches up with a row in the databse
		if($row)
		{
		// get data from db
		$name = $row['name'];
		$email = $row['email'];
		$description = $row['description'];

		// show form
		renderForm($id, $name, $email, $description, '');
		} else {
			// if no match, display result
			echo "No results!";
		}
	} else {
		// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
		echo 'Error!';
	}
}
?>