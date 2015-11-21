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
	
	$movieId = 3;	// Retrieve the form data...
	
	// Get the information about the movie ...
	// ... first we'll retrieve the basic information
	//		including the name of the state where it is registered.
	
	$query = "SELECT * FROM pickaflick WHERE id=" . $movieId;
	
	$result = mysql_query($query);
	error_check($result);
	
	// Display the results in a table
	
	print "<table><caption> <h2> Query Results </h2> </caption>";
	print "<tr align = 'center'>";
	
	// Get the number of row in the rsult, as well as the first row
	// and the number of rields in the row
	
	$num_rows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	
	// Produce the column loabels
	
	while ($next_element = each($row)) {
		$next_element = each($row);
		$next_key = $next_element['key'];
		print "<th>" . $next_key . "</th>";
	}
	
	print "</tr>";
	
	// Output the values of the fields in the row
	for ($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		print "<tr align = 'center'>";
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++)
			print "<th>" . $row[$field_num] . "</th> ";
		print "</tr>";
		$row = mysql_fetch_array($result);
	}
	print "</table>";
	print("<br/><br/>");
	
	// ... now lets get the cars equipment
	
	$query = "SELECT * FROM pickaflick WHERE id =" . $movieId;
	
	$result = mysql_query($query);
	error_check($result);
	
	// Display the results in a table
	
	print "<table><caption> <h2> Query Results </h2> </caption>";
	print "<tr align = 'center'>";
	
	// Get the number of row in the result, as well as the first row
	// and the number of fields in the rows
	
	$num_rows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	
	if($num_rows == 0) {
		print("No equipment listed<br/>");
		exit;
	}

	// Produce the column labels
	
	while ($next_element = each($row)) {
		$next_element = each($row);
		$next_key = $next_element['key'];
		print "<th>" . $next_key . "</th>";
	}
	
	print "</tr>";
	
	// Output the values of the fields in the row
	
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		print "<tr align = 'center'>";
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++)
			print "<th>" . $row[$field_num] . "</th> ";
		print "</tr>";
		$row = mysql_fetch_array($result);
	}
	print "</table>";

	print("<br/><br/>");
?>
</body> </html>