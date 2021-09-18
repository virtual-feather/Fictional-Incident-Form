<!-- Verify the person entered exists in the database -->
<?php
	$servername = "localhost";
	$username = "root"; // Mysql username
	$password = "9121";	// Mysql Password
	$dbname = "CSRIT";	// database name

	$conn = new mysqli($servername, $username, $password, $dbname);
	 
	if ($conn->connect_error)
	    die("Connection failed: " . $conn->connect_error ."<br>");

	$email = $_POST["Email"];
	$pass = $_POST["Password"];

	// Find the person
	$sql = "SELECT firstname FROM PERSON
			WHERE emailAddress = '".$email."'
			AND password = '".$pass."'";
	$result = $conn->query($sql);

	// Check if the query was successful
	if (!$result)
		trigger_error('Invalid query: ' . $conn->error);

	// The person entered does not exist - Back to login
	if( ($row = $result->fetch_assoc()) == 0 )
		header("Location: index.html");
	else
		header("Location: home.html");


	$conn->close();
?>	