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
        	<li class="help"><a href="#">Help</a></li>
			<li>
            
			<!-- Aliya, this is code we could potentially use with the database if you'd like -->
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
	

	$_SESSION['question3'] = $_POST["question3"];
	

	function runQuery($result){
		
	
	// Get the number of row in the result, as well as the first row
	// and the number of fields in the rows
	
	$num_rows = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	
	if($num_rows == 0) {
		print("There are no movies that match your requirements!<br/>");
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
		print "<center> ";
		echo "You want to watch a ".$_SESSION['question1']." that was rated ".$_SESSION['question2']." and was released in".$_SESSION['question3'].".";
		print "</center>";
		$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND name LIKE '%".$_SESSION['question1']."%' AND pairingtest.movie_id = movtest.id AND movtest.rating LIKE '%".$_SESSION['question2']."%' AND movtest.year LIKE '%".$_SESSION['question3']."%'";
		$result = mysql_query($query);
		error_check($result);
		runQuery($result);
		
		
		
		?>
		
		
	
</body>
</html>