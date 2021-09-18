<!DOCTYPE html>
<html>
<head>
	<title>Respond Incident Form</title>
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
		<table>
			<?php
				$incidentNum = $_POST["IncidentNumber"];
				$date = $_POST["DateFiled"];
				$status = $_POST["status"];
				$curFN = $_POST["FN"];
				$curLN = $_POST["LN"];
				$curJob = $_POST["Job"];
				$curEmail = $_POST["Email"];
				//$curIP = $_POST["IP"];
				$curComment = $_POST["comment"];
				$curDate = $_POST["CurrentDate"];

				// Check if required fields were entered
				if(!empty($incidentNum) && !empty($status) && !empty($curFN) && !empty($curLN) && !empty($curJob) && !empty($curEmail) 
					&& !empty($curDate)) {

					// Find person in database 
					$sql = "SELECT firstname, lastname, emailAddress
							FROM PERSON WHERE
							PERSON.firstname = '".$curFN."' AND
							PERSON.lastname = '".$curLN."' AND
							PERSON.job = '".$curJob."' AND
							PERSON.emailAddress = '".$curEmail."'";
					$result = $conn->query($sql);

					// Check if the query was successful
					if (!$result)
	    				trigger_error('Invalid query: ' . $conn->error);

	    			// The person entered does not exist
	    			if( ($row = $result->fetch_assoc()) == 0 )
	    				echo "<center><h3>There was a problem identifying the person.</h3></center>";

	    			// The person does exist
	    			else {
	    				echo "<center><h2>Welcome ".$curFN." ".$curLN."</h2></center>";

	    				// Check if the incident entered exists or not
	    				$sql = "SELECT IncidentID FROM INCIDENT
	    						WHERE INCIDENT.incidentID = ".$incidentNum;
	    				$result = $conn->query($sql);

						// Check if the query was successful
						if (!$result)
		    				trigger_error('Invalid query: ' . $conn->error);
		    			
		    			// The Incident does not exist
		    			if( ($row = $result->fetch_assoc()) == 0 )
		    				echo "<center><h2>The Incident entered could not be found</h2></center>";

		    			// Incident found
		    			else {
		    				// Update the status
		    				$sql = "UPDATE INCIDENT SET IncidentState = '".$status."'
		    						WHERE INCIDENT.IncidentID = ".$incidentNum;
		    				$result = $conn->query($sql);

		    				// Check if the query was successful
							if (!$result)
			    				trigger_error('Invalid query: ' . $conn->error);

			    			// Add comment if entered
			    			if(!empty($curComment)) {
			    				$sql = "INSERT INTO COMMENTS
			    						VALUES (null,".$incidentNum.",'".$curComment."',
			    						'".$curDate."','".$curEmail."')";
			    				$result = $conn ->query($sql);

		    					// Check if the query was successful
								if (!$result)
					    			trigger_error('Invalid query: ' . $conn->error);

					    		// Display the Incident Table!!!
				    			echo "
							        	<tr>
							          		<th>IncidentID</th>
							            	<th>Type of Incident</th>
							            	<th>Date Filed</th>
							            	<th>Status</th>
							          	</tr>";

							    $sql = "SELECT IncidentID, IncidentType, DateOfEntry, IncidentState 
								    		FROM INCIDENT NATURAL JOIN INCIDENTTYPE
											WHERE INCIDENT.IncidentTypeID = INCIDENTTYPE.IncidentTypeID
											AND INCIDENT.IncidentID = ".$incidentNum;
								$result = $conn->query($sql);

								// Check if the query was successful
								if (!$result)
				    				trigger_error('Invalid query: ' . $conn->error);

				    			while($row = $result->fetch_assoc())
				    				echo "<tr>
							          		<th>".$row["IncidentID"]."</th>
							          		<th>".$row["IncidentType"]."</th>
							          		<th>".$row["DateOfEntry"]."</th>
							          		<th>".$row["IncidentState"]."</th>
							          	  </tr>";

							    // Display Comment
							    echo "<br>
							    	    <table>
								    		<tr>
								    			<th>Comment Added</th>
								    		</tr>
								    		<tr>
								    			<th>".$curComment."
								    		</tr>
							    	    </table>";
				    		}//end if(Comment entered)

				    		// Display Every Comment from everyone

				    		// Display the full Table!!!
			    			echo "<table>
						        	<tr>
						          		<th>Title</th>
						            	<th>First Name</th>
						            	<th>Last Name</th>
						            	<th>Job</th>
						            	<th>Email</th>
						            	<th>IP Address</th>
						            	<th>Comment ID</th>
						            	<th>Comment</th>
						            	<th>Date Added</th>
						          	</tr>";

				    		$sql = "SELECT title, firstname, lastname, job, PERSON.emailAddress, IPaddress, Comment, COMMENTS.dateOfEntry, 
				    				INCIDENT.IncidentID, COMMENTS.CommentID
									FROM PERSON JOIN COMMENTS JOIN IPADDRESS JOIN INCIDENT
									WHERE PERSON.emailAddress = COMMENTS.emailAddress
									AND PERSON.emailAddress = IPADDRESS.emailAddress
									AND COMMENTS.IncidentID = INCIDENT.IncidentID
									AND INCIDENT.IncidentID = ".$incidentNum."
									ORDER BY COMMENTS.CommentID DESC";
							$result = $conn->query($sql);

							// Check if the query was successful
							if (!$result)
			    				trigger_error('Invalid query: ' . $conn->error);

			    			while($row = $result->fetch_assoc()) {
			    				echo "<tr>
						          		<th>".$row["title"]."</th>
						          		<th>".$row["firstname"]."</th>
						          		<th>".$row["lastname"]."</th>
						          		<th>".$row["job"]."</th>
						          		<th><a href='mailto:".$row["emailAddress"]."?&subject=Incident%20Form%20Comment'>".$row["emailAddress"]."</a></th>
						          		<th>".$row["IPaddress"]."</th>
						          		<th>".$row["CommentID"]."</th>
						          		<th>".$row["Comment"]."</th>
						          		<th>".$row["dateOfEntry"]."</th>
						          	  </tr>";
			    			}
						    echo "</table>";
			    			
		    			}//end else(Incident Found)

	    			}//end else(Person exists)

				}//end if(Check fields)

				else
					echo "<cener><h2>Please enter all of the fields</h2></center>";


				$conn->close();
			?>
		</table>

		<!-- Return to index button -->
		<center>
			<form action="home.html">
				<input type="submit" value="Return to Home">
			</form>
		</center>
	</div>

</body>
</html>