<!DOCTYPE html>
<html>
<head>
	<title>View Incident Form</title>
	<link rel="stylesheet" type="text/css" href="css/test-html.css">
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
		<!-- Get Incident -->
		<?php
			$incidentNum = $_POST["IncidentNumber"];

			if(!empty($incidentNum)) {

				// Find Incident
				$sql = "SELECT incidentID, IncidentType, DateOfEntry, IncidentState
						FROM INCIDENT NATURAL JOIN INCIDENTTYPE
						WHERE INCIDENT.incidentID = ".$incidentNum."
						AND INCIDENT.IncidentTypeID = INCIDENTTYPE.IncidentTypeID";
				$result = $conn->query($sql);

				// Check if the query was successful
				if (!$result)
					trigger_error('Invalid query: ' . $conn->error);
				
				if( ($row = $result->fetch_assoc()) == 0)
					echo "<center><h2>No Incident with that ID exists!</h2></center>";
				else
					// Incident found, display
					echo "<table>
							<tr>
								<th>Incident ID</th>
								<th>Incident Type</th>
								<th>Date of Entry</th>
								<th>Incident State</th>
							</tr>
							<tr>
								<th>".$row["incidentID"]."</th>
								<th>".$row["IncidentType"]."</th>
								<th>".$row["DateOfEntry"]."</th>
								<th>".$row["IncidentState"]."</th>
							</tr>
						  </table><br>";

					// Display Comments associated to incident
					$sql = "SELECT Comment, DateOfEntry, emailAddress, IPaddress
							FROM COMMENTS NATURAL JOIN IPADDRESS
							WHERE COMMENTS.emailAddress = IPADDRESS.emailAddress
							AND IncidentID = ".$incidentNum."
							ORDER BY CommentID DESC;";
					$result = $conn->query($sql);

					// Check if the query was successful
					if (!$result)
						trigger_error('Invalid query: ' . $conn->error);

					echo "<table>
							<tr>
								<th>Comment</th>
								<th>Date Entered</th>
								<th>Email</th>
								<th>IP Address</th>
							</tr>";
					while($row = $result->fetch_assoc()) {
						echo "<tr>
								<th>".$row["Comment"]."</th>
								<th>".$row["DateOfEntry"]."</th>
								<th><a href='mailto:".$row["emailAddress"]."?&subject=Incident%20Form%20Comment'>".$row["emailAddress"]."</a></th>
								<th>".$row["IPaddress"]."</th>
							  </tr>";
					}
					echo "</table>";
			}

			else
				echo "<center><h2>You must enter an incident ID!</h2></center>";


		?>
<!-- Testing
		<a href="mailto:name1@CSIRT.com,name2@CSIRT.com?cc=name3@CSIRT.com&bcc=name4@CSIRT.com
		&subject=The%20subject%20of%20the%20email
		&body=The%20body%20of%20the%20email">Send the CSIRT team an email</a>
-->
		<!-- Return to index button -->
		<center>
			<form action="home.html">
				<input type="submit" value="Return to Home">
			</form>
		</center>
	</div>

	<?php 
		$conn->close();
	?>
</body>
</html>