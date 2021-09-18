<!DOCTYPE html>
<html>
<head>
	<title>Indicent Report</title>
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

	<!-- Custom body -->
	<div class="divContainer">
		<table>
			<?php
				$incidentNum = $_POST["IncidentNumber"];
				$date = $_POST["DateFiled"];
				$status = $_POST["status"];
				$incidentType = $_POST["IncidentType"];
				$curFN = $_POST["FN"];
				$curLN = $_POST["LN"];
				$curJob = $_POST["Job"];
				$curEmail = $_POST["Email"];
				$curIP = $_POST["IP"];
				$curComment = $_POST["comment"];
				$curDate = $_POST["CurrentDate"];

				// Check if fields were entered (IP and Comment does not need to be filled)
				if(!empty($incidentNum) && !empty($date) && !empty($status) && !empty($incidentType) && !empty($curFN) && !empty($curLN) &&
				   !empty($curJob) && !empty($curEmail) && !empty($curDate)) {

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
	    				echo "<center><h2>".$curFN." ".$curLN."'s File</h2></center>";

	    				// Check if the incident entered exists or not
	    				$sql = "SELECT IncidentID FROM INCIDENT
	    						WHERE INCIDENT.incidentID = ".$incidentNum."
	    						AND INCIDENT.DateOfEntry = '".$date."'
	    						AND INCIDENT.IncidentState = '".$status."'
	    						AND INCIDENT.IncidentTypeID = ".$incidentType."";
	    				$result = $conn->query($sql);

						// Check if the query was successful
						if (!$result)
		    				trigger_error('Invalid query: ' . $conn->error);
		    			
		    			// The Incident does not exist, create a new incident!
		    			if( ($row = $result->fetch_assoc()) == 0 ) {
		    				$sql = "INSERT INTO INCIDENT
		    						VALUES (null,".$incidentType.",
		    						'".$date."','".$status."')";
		    				$result = $conn->query($sql);

							// Check if the query was successful
							if (!$result)
			    				trigger_error('Invalid query: ' . $conn->error);

			    			// Comment field is filled out, create a new comment attached to the incident
			    			if(!empty($curComment)) {
			    				$getCurID = "SELECT IncidentID FROM INCIDENT
			    							 WHERE INCIDENT.DateOfEntry = '".$date."'
			    							 AND INCIDENT.IncidentState = '".$status."'
			    							 AND INCIDENT.IncidentTypeID = ".$incidentType."";
			    				$result = $conn->query($getCurID);

			    				// Check if the query was successful
								if (!$result)
				    				trigger_error('Invalid query: ' . $conn->error);

				    			// 
				    			if( ($row = $result->fetch_assoc()) == 0 )
				    				echo "<center><h3>Incident ID is not found.</h3></center>";

				    			// Insert the comment
				    			else {
				    				$incidentNum = $row["IncidentID"];

				    				$sql = "INSERT INTO COMMENTS
			    						VALUES (null,".$row["IncidentID"].",'".$curComment."',
			    						'".$date."','".$curEmail."')";
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
								          		<th>".$row["IncidentID"]."
								          		<th>".$row["IncidentType"]."
								          		<th>".$row["DateOfEntry"]."
								          		<th>".$row["IncidentState"]."
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

				    			}

			    			}//end checking comments
		    			}//end if(Create incident)

		    			// Incident does exist, Add a new comment to it!
		    			else {
		    				// Comment is entered
		    				if (!empty($curComment)) {
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
							          		<th>".$row["IncidentID"]."
							          		<th>".$row["IncidentType"]."
							          		<th>".$row["DateOfEntry"]."
							          		<th>".$row["IncidentState"]."
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
				    		}

				    		// Comment is not entered
				    		else {
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
							          		<th>".$row["IncidentID"]."
							          		<th>".$row["IncidentType"]."
							          		<th>".$row["DateOfEntry"]."
							          		<th>".$row["IncidentState"]."
							          	  </tr>";
				    		}

		    			}//end else

		    			// See if the IP Address was given
		    			if(!empty($curIP)) {

		    				// See if IP exists
		    				$sql = "SELECT IPaddress FROM IPADDRESS
		    						WHERE IPADDRESS.emailAddress = '".$curEmail."'";
		    				$result = $conn->query($sql);

		    				// Check if the query was successful
							if (!$result)
				    			trigger_error('Invalid query: ' . $conn->error);

				    		// IPAddress does not exist for email, add it
				    		if( ($row = $result->fetch_assoc()) == 0) {
				    			$sql = "INSERT INTO IPADDRESS
				    					VALUES ('".$curEmail."','".$curIP."')";
				    			$result = $conn->query($sql);

				    			// Check if the query was successful
								if (!$result)
					    			trigger_error('Invalid query: ' . $conn->error);
				    		}

				    		// IPAddress exists for email, update it
				    		else {

				    			if($row["IPaddress"] == $curIP){}
				    			
				    			else{
				    				$sql = "UPDATE IPADDRESS 
				    						SET IPaddress = '".$curIP."'
				    						WHERE emailAddress = '".$curEmail."'";
				    				$result = $conn->query($sql);

					    			// Check if the query was successful
									if (!$result)
						    			trigger_error('Invalid query: ' . $conn->error);
				    			}
					    		
				    		}
		    			}
		    			

	    			}//end else(Person Exists)

				}//end check fields

				// Some fields were empty
				else {
					echo "<center><h3>Some fields were not entered!</h3></center>";
				}//end else

				// Close connection
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