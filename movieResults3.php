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
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	$num_rows = mysql_num_rows($result);
	
	 
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
			print "<option value = '$row[$field_num]'>  $row[$field_num] </option>";}
			$row = mysql_fetch_array($result);
		}
		print "</select>";
	}
	?>



		
	
	
	
	<form action="movieResults4.php" method="post" id = "movie" class="pick">

	<h4>I want it to be rated...</h4>
	<select name ="question2" form="movie" >
	<?php
	session_start();
	$_SESSION['subgenre'] = $_POST['subgenre'];
	$_SESSION['question1'] = $_POST['question1'];
	$query = "SELECT DISTINCT movtest.rating FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND tagtest.name = '".$_SESSION['subgenre']."' ORDER BY movtest.rating ASC";
	$result = mysql_query($query);
	error_check($result);
	runQuery($result);
	?>
	</select>
	
	<br/><input type="submit"/>

	</form>
		  
</body>
</html>