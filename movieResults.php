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
            
			<!-- Aliya, this is code we could potentially use with the database if you'd like -->
			<form>
                   <input type="text" placeholder="Search..." required>
                   <input type="button" value="Search">
			</form>
				
        	</li>
      </ul>
    </div>
  </header> 
  
<div class="img">
			<!--'_blank' opens the linked document in a new window or tab, 'href' specifies the link's destination, img src puts image of current page  --> 
 			<a target="_blank" href="http://ia.media-imdb.com/images/M/MV5BMTY1OTg0MjE3MV5BMl5BanBnXkFtZTcwNTUxMTkyMQ@@._V1_SX214_AL_.jpg"><img src="http://scontent-b.cdninstagram.com/hphotos-xaf1/t51.2885-15/10832278_500686043405146_335466236_n.jpg" alt="Seville Spain" width="300" height="500"></a>
 			<!--Creates a new div in div called desc --> 
 			<div class="desc"> Seville, Spain </div>
		</div>  
  <h2> Your Results </h2>
  
  
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
	
	
//	print "<div class='img'><img src='"
//	http://scontent-b.cdninstagram.com/hphotos-xaf1/t51.2885-15/10832278_500686043405146_335466236_n.jpg" alt='moviePoster' width='300' height='500'></a>
// 			<!--Creates a new div in div called desc --> 
// 			<div class="desc"> Seville, Spain </div>
//		</div>
	
	
	
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
	
//	while ($next_element = each($row)) {
//		$next_element = each($row);
	//	$next_key = $next_element['key'];
	//	print "<th>" . $next_key . "</th>";
	//}
	
	//print "</tr>";
	
	// Output the values of the fields in the row
	
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++){
			echo $row[$field_num];
			print "<img src= '$row[$field_num]''alt='moviePoster' width='300' height='500'>";
			$row = mysql_fetch_array($result);
		}
	}

	}
	
	$question1 = $_POST["question1"];
	$question2 = $_POST["question2"];
	$question3 = $_POST["question3"];


	function returnText($question1, $question2, $question3) {
		if ($question1 == 1 and $question3 == 1) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 0 and 1960 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 2 and $question3 == 1) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 1960 and 1990 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 3 and $question3 == 1) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 1990 and 2005 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 4 and $question3 == 1) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 2005 and 2012 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
			if ($question1 == 5 and $question3 == 1) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 2012 and 2015 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 1 and $question3 == 2) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 0 and 1960 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 2 and $question3 == 2) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 1960 and 1990 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 3 and $question3 == 2) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 1990 and 2005 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
		if ($question1 == 4 and $question3 == 2) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 2005 and 2012 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
			if ($question1 == 5 and $question3 == 2) {
			$query = "SELECT poster FROM movtest WHERE year BETWEEN 2012 and 2015 AND duration BETWEEN 0 and 120 AND rating='". $question2 . "'";
			$result = mysql_query($query);
			error_check($result);
			runQuery($result);
			return;
		}
			else { print "You missed a requirement" ;}
	}	
		returnText($question1, $question2, $question3);
		

	
	
			
			
	?>

	
  
</body>
</html>