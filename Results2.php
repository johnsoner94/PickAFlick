<!doctype html>
<!--
Project: Pick A Flick Project  
Class: CSI:210 Software Engineering
Team Members: Emily Johnson, Aliya Gangji, Casie Ropski, Mackensie Weilnau
Date: November-December of 2015

Description: The following is the third page in the Questionnaire.  The page gets the 
years and puts them in an array called decade.  However, the if-statement ensures 
that there is no repeated decades.  

Programming Languages: HTML, PHP , SQL, CSS 
--> 
<html>
	<head>
	<meta charset="UTF-8">
	<title>Pick A Flick!</title>
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
	
	// gets info from previous PHP session 		
	session_start();
	
	// gets rating from previous form  
	$_SESSION['rating'] = $_POST['rating'];
	
	// declare $query variable
	$query = "";
	
	// if UNRATED, queries both 'UNRATED' and 'NOT RATED'
	if ($_SESSION['rating'] == "UNRATED") {
	$query = "SELECT DISTINCT movtest.year FROM tagtest, pairingtest, movtest 
	WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id 
	AND tagtest.name LIKE '".$_SESSION['subgenre']."'AND  
	(movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') 
	ORDER BY movtest.year ASC";
	}
	
	// if other rating 
	else{
	$query = "SELECT DISTINCT movtest.year FROM tagtest, pairingtest, movtest 
	WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id 
	AND movtest.rating = '".$_SESSION['rating']."'AND tagtest.name LIKE '"
	.$_SESSION['subgenre']."' ORDER BY movtest.year ASC";	
	}
	
	
	$result = mysql_query($query);
	error_check($result);
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	$num_rows = mysql_num_rows($result);
	
	// decade array, used to convert yr to decade & prevents repetition 
	$decades=array();
	
	// for loop goes through years that were queried and converts the yr to decade
	// adds decade to the array only if the decade is already not in the array 
	for($row_num = 0; $row_num < $num_rows; $row_num++) {		
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){		
			if(($row[$field_num] >= 1920 && $row[$field_num] <= 1930)  and (in_array("20s", $decades) == false)){
					array_push($decades,"20s");
			}
			if(($row[$field_num] >= 1930 && $row[$field_num] <= 1940)  and (in_array("30s", $decades) == false)){
					array_push($decades,"30s");
			}
			if(($row[$field_num] >= 1940 && $row[$field_num] <= 1950)  and (in_array("40s", $decades) == false)){
					array_push($decades,"40s");
			}
			if(($row[$field_num] >= 1950 && $row[$field_num] <= 1960)  and (in_array("50s", $decades) == false)){
					array_push($decades,"50s");
			}
			if(($row[$field_num] >= 1960 && $row[$field_num] <= 1970)  and (in_array("60s", $decades) == false)){
					array_push($decades,"60s");
			}
			if(($row[$field_num] >= 1970 && $row[$field_num] <= 1980)  and (in_array("70s", $decades) == false)){
					array_push($decades,"70s");
			}
			if(($row[$field_num] >= 1980 && $row[$field_num] <= 1990)  and (in_array("80s", $decades) == false)){
					array_push($decades,"80s");
			}
			if(($row[$field_num] >= 1990 && $row[$field_num] <= 2000)  and (in_array("90s", $decades) == false)){
					array_push($decades,"90s");
			}
			if(($row[$field_num] >= 2000 && $row[$field_num] <= 2010)  and (in_array("2000s", $decades) == false)){
					array_push($decades,"2000s");
			}
			if(($row[$field_num] >= 2010 && $row[$field_num] <= 2016)  and (in_array("recent", $decades) == false)){
					array_push($decades,"recent");
			}
			$row = mysql_fetch_array($result);
		}
	}
?>

<form action="Results3.php" method="post" id = "movie" class="pick">
	<h4>Pick a decade...</h4>
	<select name ="decade" form="movie" >
	<?php
		//gets past PHP Session variables 
		session_start();
	
		//populated the drop down menu 
		for($row_num = 0; $row_num < sizeof($decades); $row_num++) {		
			print "<option value = '$decades[$row_num]'>  $decades[$row_num] </option>";
		}
	?>
	</select>
	
	<br/>
	<br/>
	<input type="submit"/>

</form>
</body>
</html>