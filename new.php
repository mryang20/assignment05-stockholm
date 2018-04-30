<?php
include('renderform.php');

// connect to the database
include('config.php');

// check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['submit']))
{
	// get form data, making sure it is valid
	$name = mysqli_real_escape_string($connection, htmlspecialchars($_POST['name']));
	$email = mysqli_real_escape_string($connection, htmlspecialchars($_POST['email']));
	$description = mysqli_real_escape_string($connection, htmlspecialchars($_POST['description']));

	// check to make sure both fields are entered
	if ($name == '' || $email == '' || $description == '')
	{
		// generate error message
		$error = 'ERROR: Please fill in all required fields!';

		// if either field is blank, display the form again
		renderForm($id, $name, $email, $description, $error);

	} else {
		// save the data to the database
		$result = mysqli_query($connection, "INSERT INTO surveydata (name, email, description) VALUES ('$name', '$email', '$description')");

		// once saved, redirect back to the view page
		header("Location: view.php");
	}
} else {
	// if the form hasn't been submitted, display the form
	renderForm('','','','','');
}
?>