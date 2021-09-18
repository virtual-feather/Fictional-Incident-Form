<!DOCTYPE html>
<html>
<head>
	<title>Remove from an Incident</title>
	<link rel="stylesheet" type="text/css" href="css/finalcss.php">
</head>
<body>
	<!-- Connect to the database -->
	<?php
		$servername = "localhost";
		$username = "root"; // Mysql username
		$password = "9121";	// Mysql Password
		$dbname = "CSRIT";	// database name

		$conn = new mysqli($servername, $username, $password, $dbname);
		 
		if ($conn->connect_error)
		    die("Connection failed: " . $conn->connect_error ."<br>");
		
		// echo "<i>DB Connected successfully...</i>";
	?>

	<div class="divContainer">
		<?php
			$incidentNum = $_POST["IncidentNumber"];
			$date = $_POST["DateFiled"];
			$commentID = $_POST["CommentID"];
			$curIP = $_POST["IPAddress"];

			if(!empty($incidentNum) && !empty($date)) {
				// Remove a comment
				if(!empty($commentID)) {
					$sql = "DELETE FROM COMMENTS WHERE 
							IncidentID = ".$incidentNum."
							AND DateOfEntry = '".$date."'
							AND commentID = ".$commentID;
					$result = $conn->query($sql);

					// Check if the query was successful
					if (!$result)
	    				//trigger_error('Invalid query: ' . $conn->error);
	    				echo "<center><h2>The comment/incident could not be found</h2></center>";
	    			else
	    				echo "<center><h2>Double check the 'View Incidents' form to ensure the comment was removed successfully</h2></center>";
				}

				

				// Both were empty
				else if(empty($commentID) && empty($curIP)) 
					echo "<center><h2>The Comment and IP Address fields were both empty!</h2></center>";
			}

			// Remove an IP address
			else if(!empty($curIP)) {
				$sql = "UPDATE IPADDRESS SET IPaddress = ' '
						WHERE IPaddress = '".$curIP."'";
				$result = $conn->query($sql);

				// Check if the query was successful
				if (!$result)
    				//trigger_error('Invalid query: ' . $conn->error);
    				echo "<center><h2>The IP Address could not be found</h2></center>";
    			else
    				echo "<center><h2>Double check the 'View Incidents' form to ensure the IP address was removed successfully</h2></center>";
			}

			// Incident Num and Date were empty
			else
				echo "<center><h2>You must fill out either the remove comment section or remove IP address section!</h2></center>";

			$conn->close();
		?>

		<!-- Return to index button -->
		<center>
			<form action="home.html">
				<input type="submit" value="Return to Home">
			</form>
		</center>
	</div>
</body>
</html>