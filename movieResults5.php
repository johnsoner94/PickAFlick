<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Pick A Flick!</title>
<link href="PickAFlick.css" rel="stylesheet" type="text/css">
</head>

<body>
 
  <header>
	<h1 class='retroshadow'> Pick A Flick </h1> 
        <div class="nav">
      	<ul>
        	<li class="home"><a href="PickAFlickHome.php">Home</a></li>
        	<li class="profile"><a href="PickAFlickProfile.php">My Profile</a></li>
            <li class="pick"><a href="PickAFlickPick.php">Pick</a></li>
        	<li class="help"><a href="#">Help</a></li>
            <li>
			<form>
                   <input type="text" placeholder="Search..." required>
                   <input type="button" value="Search">
			</form>
				
        	</li>
      </ul>
    </div>
  </header> 

  <h2> Your Results </h2>
  
  
	<?php 
	session_start();
	
	echo $question1;
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
	$db = mysql_connect("localhost", "ag249083", "ag249083");
	if (!db) {
		print "Error - Could not Connect to MySQL";
		exit;
	}
	
	// Select the movie database
	$er = mysql_select_db("pickaflick");
	if (!$er) {
		print "Error - Could not select the cars database";
		exit;
	}
	
	
	
	function runQuery($result){
		
	
	// Get the number of row in the result, as well as the first row
	// and the number of fields in the rows
	
	$num_rows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	
	if($num_rows == 0) {
		print("<center>There are no movies that match your requirements!<center><br/>");
		exit;
	}
	// Produce the column labels
	
	
	//print "</tr>";
	
	// Output the values of the fields in the row
	
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
			print "<br> <center> <img src='$row[$field_num]' alt='Poster Can Not Be Viewed' width='300' height='500'> </center> <br> ";
			$row = mysql_fetch_array($result);
		}
	}
	}
 
 
 	
?>

		<?php
		$_SESSION['question3'] = $_POST["question3"];
		if ($_SESSION['question3'] == "1920s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1920 and 1930";};
		if ($_SESSION['question3'] == "1930s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1930 and 1940";};
		if ($_SESSION['question3'] == "1940s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1940 and 1950";};
		if ($_SESSION['question3'] == "1950s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1950 and 1960";};
		if ($_SESSION['question3'] == "1960s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1960 and 1970";};
		if ($_SESSION['question3'] == "1970s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1970 and 1980";};
		if ($_SESSION['question3'] == "1980s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1980 and 1990";};
		if ($_SESSION['question3'] == "1990s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 1990 and 2000";};
		if ($_SESSION['question3'] == "2000s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 2000 and 2010";};
		if ($_SESSION['question3'] == "recently") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['question2']."' AND movtest.year BETWEEN 2010 and 2016";};
		
		
		
		
		print "<center> ";
		
		
		
		echo "You want to watch a ".$_SESSION['question1']." with some ".$_SESSION['subgenre']." that was rated ".$_SESSION['question2']." and was released in ".$_SESSION['question3'].".";
		
		print "</center>";
		
		$result = mysql_query($query);
		error_check($result);
		runQuery($result);
		
		
		
		?>
		
		
	
</body>
</html>