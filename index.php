<?php

session_start();


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

$name = $email = $description = "";
$name_err = $email_err = $description_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    }

    if (empty(trim($_POST["description"]))) {
        $email_err = "Please enter your desription.";
    }


    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);


    $param_name = $name;
    $param_email = $email;
    $param_description = $description;


    if (empty($name_err) && empty($email_err) && empty($desription_err)) {


        $sql = "INSERT INTO surveydata (name, email, description) VALUES (?, ?, ?)";
        if ($stmt = $connection->prepare($sql)) {

            $stmt->bind_param("sss", $param_name, $param_email, $param_description);

            $param_name = $name;
            $param_email = $email;
            $param_desription = $desription;

            if($stmt->execute()) {
                header("location: index.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
    }
    $connection->close();
}
?>

<!doctype html>
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

<div class="grid-container">
<article>
		<p>Sweden's capital Stockholm is situated on the east coast of southern/central Sweden. Its coastal location is not easy to overlook when visiting the city situated on 14 islands. All the water in the city has earned it the nickname "Venice of the North", but unlike Venice the water is clean and clear as you would expect in Nordic countries. You can even see fishermen fishing right off the sidewalks and bridges, with salmon and sea trout being the main targets. At the right time of year you can even see salmon climbing the small waterfalls.</p>

		<p>At Stockholm’s heart lie the cobbled streets of Gamla Stan ("Old Town") where most buildings date from the 16th to 19th century and house numerous little shops, cafés, restaurants, museums and hotels, in addition to the 18th century Royal Palace. Although many of the stores lining the main narrow streets contain the usual tacky items associated with popular tourist attractions, the area is unique, cozy and beautiful. The moment you turn off the main streets you are greeted by a plethora of old buildings and tiny backstreet courtyards, adding to the charm that has made this area so popular. Originally founded in the 13th century, Stockholm's roots might go back even further than Gamla Stan lets on but the city itself is as modern as they come and it's considered one of the most trendy and fashionable cities of Scandinavia. Stockholm also houses over 100 art galleries and 70 museums, no small feat for a city with a population of just 1.6 million, including the metropolitan area.</p>

	</article>


	<aside>
		<div class="Form">  
  			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
   				<h2>Contact Us! We'd love to know more about your time in Stockholm!</h2>
    				<fieldset>
      					<input name = "name" placeholder="Your name" type="text" tabindex="1" required autofocus>
    				</fieldset>
    				<fieldset>
      					<input name = "email" placeholder="Your Email Address" type="email" tabindex="2" required>
    				</fieldset>
    				<fieldset>
     					<textarea name = "description" placeholder="Describe Your Time in Stockholm" tabindex="3" required></textarea>
    				</fieldset>
    				<fieldset>
      					<button name="submit" type="submit" id="contact-submit" data-submit="...Sending" value="Submit">Submit</button>
    				</fieldset>
  			</form>
		</div>
	</aside>
	</div>

	<hr>

	<footer>
		Team Stockholm
		<br>
		Assignment 5
	</footer>


<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/menu-highlighter.js"></script>

</body>
</html>
