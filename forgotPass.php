<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
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

			$email = $_POST["email"];
			$newPassword = $_POST["newPassword"];

			if(!empty($email) && !empty($newPassword)) {
				// Find the person
				$sql = "SELECT firstname FROM PERSON
						WHERE emailAddress = '".$email."'";
				$result = $conn->query($sql);

				// Check if the query was successful
				if (!$result)
					trigger_error('Invalid query: ' . $conn->error);


				// The person entered does not exist - Back to login
				if( ($row = $result->fetch_assoc()) == 0 )
					echo "<center><h2>Could not find an account with that email!</h2></center>";

				// Person Found, Update password
				else {
					$sql = "UPDATE PERSON SET password = '".$newPassword."'
							WHERE emailAddress = '".$email."'";
					$result2 = $conn->query($sql);

					if (!$result2)
						echo "<center><h2>The password you entered could not be used. Please try again.</h2></center>";
					else
						echo "<center><h2>Password Updated!</h2></center>";
				}
			}
			else
				echo "<center><h2>Please insert all the fields.</h2></center>";

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