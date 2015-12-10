<html>
<head> <title> Get Movie Information </title> </head> <body>
<?php
	function error_check($query_result) {
		if(!$query_result) {
			print "Error - the query could not be executed";
			$error = mysql_error();
			print "<p>" . $error . "</p>";
			exit;
		}
	}

	// Connect to MySQL
	$db = mysql_connect("localhost", "ej248960", "ej248960");
	if (!db) {
		print "Error - Could not onnect to MySQL";
		exit;
	}
	
	// Select the cars database
	$er = mysql_select_db("pickaflick");
	if (!$er) {
		print "Error - Could not select the cars database";
		exit;
	}
	
	
	print("<br/><br/>");
	print "<h2> Query Results </h2>";
	
	// ... now lets get the cars equipment
	
	$query = "SELECT poster FROM movtest";
	
	$result = mysql_query($query);
	error_check($result);
	results($result);
	
	// Display the results in a table
	
	

	print("<br/><br/>");
	
	function results($result){
		
		$row = mysql_fetch_array($result);			
		$num_rows = mysql_num_rows($result);
		$num_fields = sizeof($row);
		
		
	
		// if no matching movies
		if($num_rows == 0) {
			print("<center>There are no movies that match your requirements!<center><br/>");
			exit;
		}

	
		for($row_num = 0; $row_num < $num_rows; $row_num++) {
			reset($row);
			for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
				
				// HTML code to display poster
				print "<br> <center> <img src='$row[$field_num]' 
				alt='Poster Can Not Be Viewed' width='300' height='500'> </center> <br> ";
				$row = mysql_fetch_array($result);
			}
		}

	}
 

	
	
	
		
?>
</body> </html>