<?php
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

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	// get id value
	$id = $_GET['id'];

	// delete the entry
	$result = mysqli_query($connection, "DELETE FROM surveydata WHERE id=$id");

	// redirect back to the view page
	header("Location: admin.php");

} else {
	// if id isn't set, or isn't valid, redirect back to view page
	header("Location: admin.php");
}
?>