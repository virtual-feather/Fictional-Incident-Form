<!DOCTYPE html>
<html>
<head>
	<title>Create a User</title>
    <link rel="stylesheet" type="text/css" href="css/finalcss.php">
</head>

<body>
	<div class="divContainer">
		<?php
			$servername = "localhost";
			$username = "root"; // Mysql username
			$password = "9121";	// Mysql Password
			$dbname = "CSRIT";	// database name

			$conn = new mysqli($servername, $username, $password, $dbname);
			 
			if ($conn->connect_error)
			    die("Connection failed: " . $conn->connect_error ."<br>");


			$title = $_POST["title"];
			$firstName = $_POST["firstName"];
			$lastName = $_POST["lastName"];
			$email = $_POST["email"];
			$job = $_POST["job"];
			$password = $_POST["password"];

			if(!empty($title) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($job) && !empty($password)) {
				// Check if the person exists
				$sql = "SELECT firstName FROM PERSON
						WHERE emailAddress = '".$email."'";
				$result = $conn->query($sql);

				if(!$result)
					trigger_error('Invalid query: ' . $conn->error);

				// Person not found, create a new person
				if( ($row = $result->fetch_assoc()) == 0) {
					$sql = "INSERT INTO PERSON 
						    VALUES ('".$email."', '".$lastName."', '".$firstName."', '".$job."', '".$title."', '".$password."')";
					$result = $conn->query($sql);

					if(!$result)
						echo "<center><h2>There was a problem creating an account..</h2></center>";
					else
						echo "<center><h2>Account Created!</h2></center>";
				}

				// Person Found. Tell user
				else
					echo "<center><h2>A Person with that email already exists!</h2></center>";

			}

			else
				echo "<center><h2>Please enter all of the fields.</h2></center>";

			$conn->close();

		?>

		<!-- Return to index button -->
		<center>
			<form action="index.html">
				<input type="submit" value="Return to Login">
			</form>
		</center>
	</div>
</body>