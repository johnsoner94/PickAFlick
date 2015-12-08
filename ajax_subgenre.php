<?php

// checks if query can be executed 
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
	print "Error - Could not Connect to MySQL";
	exit;
}

// Select the movie database
$er = mysql_select_db("pickaflick");
if (!$er) {
	print "Error - Could not select the pickaflick database";
	exit;
}

function runQuery($result){
	$genre=$_POST['selectedGenre'];
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	$num_rows = mysql_num_rows($result);
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++)
			print "<option value = '$row[$field_num]'>  $row[$field_num] </option>";
			$row = mysql_fetch_array($result);
		}
}

if($_POST['selectedGenre']=='Drama')
{
	$genre=$_POST['selectedGenre'];

	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Crime'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Fantasy'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Biography'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'History'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Romance'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Mystery'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Sci-Fi'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Thriller'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Animation'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'War'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Horror'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Film-Noir'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Musical'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Sport'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Music'");
	error_check($result);
	runQuery($result);
}

elseif($_POST['selectedGenre']=='Action')
{
	$genre=$_POST['selectedGenre'];
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Crime'");
	error_check($result);
	runQuery($result);

	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Western'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Fantasy'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Romance'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Sci-Fi'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Horror'");
	error_check($result);
	runQuery($result);
}


elseif($_POST['selectedGenre']=='Adventure')
{
	$genre=$_POST['selectedGenre'];

	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Western'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Fantasy'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Biography'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'History'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Romance'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Sci-Fi'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Family'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Animation'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'War'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Musical'");
	error_check($result);
	runQuery($result);
}
elseif($_POST['selectedGenre']=='Comedy')
{
	$genre=$_POST['selectedGenre'];
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Biography'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Romance'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Animation'");
	error_check($result);
	runQuery($result);
	
	$result = mysql_query("SELECT tagtest.name FROM tagtest WHERE name = 'Musical'");
	error_check($result);
	runQuery($result);
}

?>