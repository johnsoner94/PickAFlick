<!doctype html>
<!--
Project: Pick A Flick Project  
Class: CSI:210 Software Engineering
Team Members: Emily Johnson, Aliya Gangji, Casie Ropski, Mackensie Weilnau
Date: November-December of 2015

Description: The following is the forth page in the Questionnaire.  
The page gets the user's results based on their previous options.  

Programming Languages: HTML, PHP , SQL, CSS 
--> 
<html>
<head>
<meta charset="UTF-8">
<title>Pick A Flick!</title>
<!--The following connects the page to the CSS page--> 
<link href="PickAFlick.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--Embeds Header-->
  <header>
	<h1 class='retroshadow'><a href="PickAFlickHome.php"> Pick A Flick </a> </h1> 
        <div class="nav">
      	<ul>
        	<li class="home"><a href="PickAFlickHome.php">Home</a></li>
        	<li class="profile"><a href="PickAFlickProfile.php">My Profile</a></li>
            <li class="pick"><a href="PickAFlickPick.php">Pick</a></li>
        	<li class="help"><a href="PickAFlickHelp.php">Help</a></li>
            <li>
			<form>
				<!--The following code implements a search 				bar-->						
                <input type="text" placeholder="Search..." required>
                <input type="button" value="Search">
			</form>				
        	</li>
      </ul>
    </div>
  </header> 
  <h2> Your Results </h2>
  <h3>
  <?php 

   
   // Gets session variables from previous page
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
	
	/*
	results() - The following method was written by Aliya Gangji and gets the 
	corresponding posters.
	*/
	function results($result){
		
		$row = mysql_fetch_array($result);			
		$num_rows = mysql_num_rows($result);
		$num_fields = sizeof($row);
		
		
	
		// if no matching movies
		if($num_rows == 0) {
			print("<center>There are no movies that match your requirements!<center><br/>");
			exit;
		}
		// create a table to display posters
		print "<table>";
		print "	<tbody>";
	
		for($row_num = 0; $row_num < $num_rows; $row_num++) {
			reset($row);
			if($row_num%4==0){
				print "		<tr>";
			}
			for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
				
				// HTML code to display poster
				
				print "			<td> <img src='$row[$field_num]' 
				alt='Poster Can Not Be Viewed' width='300' height='500'> </center> </td> ";
				$row = mysql_fetch_array($result);
			}
			if(($row_num+5)%4==0 && $row_num!=0){
				print "		</tr>";
			}
		}
		print "		</tr>";
		print "	</tbody>";
		print "</table>";

	}
 
 	// gets the decade from previous form
	$_SESSION['decade'] = $_POST["decade"];
	
	$query = ""; // declares query variable
	
	// handles 'UNRATED' vs 'NOT RATED'
	if ($_SESSION['rating'] == "UNRATED") {
	
	if ($_SESSION['decade'] == "20s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1920 and 1930) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') ";};
	if ($_SESSION['decade'] == "30s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1930 and 1940) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') ";};
	if ($_SESSION['decade'] == "40s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1940 and 1950) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED')";};
	if ($_SESSION['decade'] == "50s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1950 and 1960) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED')";};
	if ($_SESSION['decade'] == "60s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1960 and 1970) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED')";};
	if ($_SESSION['decade'] == "70s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1970 and 1980) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED')";};
	if ($_SESSION['decade'] == "80s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1980 and 1990) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') ";};
	if ($_SESSION['decade'] == "90s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 1990 and 2000) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') ";};
	if ($_SESSION['decade'] == "2000s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 2000 and 2010) AND tagtest.name LIKE '".$_SESSION['subgenre']."' AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED') ";};
	if ($_SESSION['decade'] == "recent") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND (movtest.year BETWEEN 2010 and 2016) AND tagtest.name LIKE '".$_SESSION['subgenre']."'AND (movtest.rating = 'UNRATED' OR movtest.rating = 'NOT RATED')";};

	}
	else{
	// queries based on decade
	if ($_SESSION['decade'] == "20s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1920 and 1930 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "30s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1930 and 1940 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "40s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1940 and 1950 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "50s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1950 and 1960 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "60s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1960 and 1970 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "70s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1970 and 1980 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "80s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1980 and 1990 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "90s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 1990 and 2000 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "2000s") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 2000 and 2010 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	if ($_SESSION['decade'] == "recent") {$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, movtest WHERE pairingtest.tag_id = tagtest.id AND pairingtest.movie_id = movtest.id AND movtest.rating = '".$_SESSION['rating']."' AND movtest.year BETWEEN 2010 and 2016 AND tagtest.name LIKE '".$_SESSION['subgenre']."'";};
	};	
	
	// center the description
	print "<center> ";
	
	// prints the user's selected options	
	echo "You want to watch a ".$_SESSION['genre']." with some ".$_SESSION['subgenre']." that was rated ".$_SESSION['rating']." and was released in ".$_SESSION['decade'].".";
		
	print "</center>";
	
	
	$result = mysql_query($query);
	error_check($result);
	results($result);	


	?>
</h3>


</body>
</html>