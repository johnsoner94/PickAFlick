<!doctype html>
<!--
Class: CSI:210 Software Engineering
Team Members: Emily Johnson, Aliya Gangji, Casie Ropski, Mackensie Weilnau
Date: November-December of 2015

Description: The following page was the second page of the Questionnaire.
The page queries the subgenre that the user selected.  Then, the ratings are put into an
array, so that there is no repitition between the words 'NO RATING' and 'UNRATED'.  
The array content is then used to populate the drop down menu.  

Programming Languages: HTML, PHP , SQL, CSS 
-->
<html>
<head>
	<meta charset="UTF-8">
	<title>Pick A Flick!</title>
		<!--Connects to CSS-->
		<link href="PickAFlick.css" rel="stylesheet" type="text/css">
</head>
<body>
  <!--Embeds Header-->
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
			<!--The following code implements a search bar-->
                   <input type="text" placeholder="Search..." required>
                   <input type="button" value="Search">
			</form>				
        	</li>
      </ul>
    </div>
  </header>   
<?php 
	// gets info from previous PHP session
	session_start();
	
	
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
	
	// gets genre and subgenre variable from the previous form and stores in a 
	// session variable so it can be used later 
	$_SESSION['subgenre'] = $_POST['subgenre'];
	$_SESSION['genre'] = $_POST['genre'];
	
	// uses subgenre variable to query, gets movies from database with specific genre
	$query = "SELECT DISTINCT movtest.rating FROM tagtest, pairingtest, movtest WHERE 
	pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id 
	AND tagtest.name = '".$_SESSION['subgenre']."' ORDER BY movtest.rating ASC";
	
	$result = mysql_query($query);
	error_check($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	$num_rows = mysql_num_rows($result);
	
	// an array to hold what will appear in drop down menu
	$ratings=array();
	
	// for-loop goes through the query results
	for($row_num = 0; $row_num < $num_rows; $row_num++) {		
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
			// prevents UNRATED AND NOT RATED FROM APPEARING TWICE   
			if(($row[$field_num] == "G")  and (in_array("G", $ratings) == false)){
					array_push($ratings,"G");
			}
			if(($row[$field_num] == "NOT RATED")  and (in_array("UNRATED", $ratings) == false)){
					array_push($ratings,"UNRATED"); // option appears as unrated 
			}
			if(($row[$field_num] == "PG")  and (in_array("PG", $ratings) == false)){
					array_push($ratings,"PG");
			}
			if(($row[$field_num] == "PG-13")  and (in_array("PG-13", $ratings) == false)){
					array_push($ratings,"PG-13");
			}
			if(($row[$field_num] == "APPROVED")  and (in_array("APPROVED", $ratings) == false)){
					array_push($ratings,"APPROVED");
			}
			if(($row[$field_num] == "UNRATED")  and (in_array("UNRATED", $ratings) == false)){
					array_push($ratings,"UNRATED"); 
			}
			if(($row[$field_num] == "R")  and (in_array("R", $ratings) == false)){
					array_push($ratings,"R");
			}
			if(($row[$field_num] == "PASSED")  and (in_array("PASSED", $ratings) == false)){
					array_push($ratings,"PASSED");
			}
			if(($row[$field_num] == "X")  and (in_array("X", $ratings) == false)){
					array_push($ratings,"X");
			}
			if(($row[$field_num] == "M")  and (in_array("M", $ratings) == false)){
					array_push($ratings,"M");
			}
			$row = mysql_fetch_array($result); // goes to next row 
		}
	}	
?>
<!---Sends the rating that the user selects to page "Results2.php" ---> 
<form action="Results2.php" method="post" id = "movie" class="pick">
	<h4>Pick a rating...</h4>
		<select name ="rating" form="movie" >
			<?php
				// prints items in the rating array
				for($row_num = 0; $row_num < sizeof($ratings); $row_num++) {		
				print "<option value = '$ratings[$row_num]'>  $ratings[$row_num] </option>";}
			?>
		</select>
	<br/>
	<!--submits form-->
	<input type="submit"/>
</form>
</html>