PLANNED QUERIES

# This Query is for the view incident AND for the respond to incident form. It disoplays all the users and their comments 
# That posted the incident

SELECT title, firstname, lastname, job, PERSON.emailAddress, IPaddress, Comment, COMMENTS.dateOfEntry, INCIDENT.IncidentID, COMMENTS.CommentID
FROM PERSON JOIN COMMENTS JOIN IPADDRESS JOIN INCIDENT
WHERE PERSON.emailAddress = COMMENTS.emailAddress
AND PERSON.emailAddress = IPADDRESS.emailAddress
AND COMMENTS.IncidentID = INCIDENT.IncidentID
AND INCIDENT.IncidentID = ".$incidentNum."
ORDER BY COMMENTS.CommentID DESC;


# This Query deletes a specific comment
DELETE FROM `COMMENTS` WHERE 
IncidentID = $incidentNum
AND DateOfEntry = $date
AND commentID = $commentID;


# This Query deletes a specific IP Address
DELETE FROM IPADDRESS
WHERE IPaddress = $curIP;