<?php
	session_start();

	include("../connect.php");

	// Retrieve POST variables from your form
	$training_title = $_POST['training_title'];
	$organizer      = $_POST['organizer'];
	$date_from      = $_POST['date_from'];
	$date_to        = $_POST['date_to'];
	$venue          = $_POST['venue'];
	$certificate_no = $_POST['certificate_no'];

	// Session variables for activity logging
	$uid  = $_SESSION["id"];
	$name = $_SESSION["name"] . " Inserted 1 Training: " . $training_title;

	// Validation: Check if key fields are empty
	if (empty($training_title) || empty($organizer)) {	
		echo '<script type="text/javascript">';
		echo 'alert("Training Title and Organizer cannot be blank! Please try again.");';
		echo 'window.location="add-training.php";';
		echo '</script>';	
	} else {
		// Insert into the database based on the table schema in image
		$sql = mysqli_query($conn, "INSERT INTO tbltraining (training_title, organizer, date_from, date_to, venue, certificate_no) 
		                            VALUES ('$training_title', '$organizer', '$date_from', '$date_to', '$venue', '$certificate_no')") 
		       or die(mysqli_error($conn)); 

		// Set timezone
		mysqli_query($conn, "SET time_zone = '+08:00'");

		// Log activity into tbllogs
		$sql2 = mysqli_query($conn, "INSERT INTO tbllogs (user_id, activity, date_log) 
		                             VALUES ('$uid', '$name', NOW())") 
		        or die(mysqli_error($conn));     
		
		// Success Alert
		echo '<script type="text/javascript">';
		echo 'alert("One (1) Training record successfully added!");';
		echo 'window.location="add-training.php";';
		echo '</script>';   
	}
?>