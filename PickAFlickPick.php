<!doctype html>
<!--
Project: Pick A Flick Project  
Class: CSI:210 Software Engineering
Team Members: Emily Johnson, Aliya Gangji, Casie Ropski, Mackensie Weilnau
Date: November-December of 2015

Description: The following page was the first page of the Questionnaire.
The page asked for the genre that user wanted to watch, which would then populate the 
subgenres that the user could pick from.  

Programming Languages: HTML, PHP , SQL, CSS 
--> 
<html>
<head>
<meta charset="UTF-8">
<title>Pick A Flick!</title>
<link href="PickAFlick.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<body>
  <!--Embeds Header-->
  <header>
	<h1 class='retroshadow'> Pick A Flick </h1> 
        <!--The following code implements a header-->
        <div class="nav">
      	<ul>
        	<li class="home"><a href="PickAFlickHome.php">Home</a></li>
        	<li class="profile"><a href="PickAFlickProfile.php">My Profile</a></li>
			<li class="pick"><a href="PickAFlickPick.php">Pick</a></li>
        	<li class="help"><a href="#">Help</a></li>
			<li>
			 <!--The following code implements a search bar-->
			<form>
                   <input type="text" placeholder="Search..." required>
                   <input type="button" value="Search">
			</form>				
        	</li>
      </ul>
    </div>
  </header> 
<!--The following code is written in PHP and uses SQL commands.  -->
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
		print "Error - Could not select the cars database";
		exit;
	}
	/*
	runQueryForm() - The following function was written by Aliya Gangji and it runs a 
	query and puts the results in the drop down options of the form.  
	*/		
	
	// $result = the query 
	function runQueryForm($result){
	$row = mysql_fetch_array($result);  // creates an array of the query 
	$num_fields = sizeof($row);	  // gets the number of columns 
	$num_rows = mysql_num_rows($result);   // get the number rows 

	for($row_num = 0; $row_num < $num_rows; $row_num++) {  // goes through all the rows 
		reset($row);   // reset row after get result 
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++)
			// gets number of columns
			print "<option value = '$row[$field_num]'>  $row[$field_num] </option>";
			//writes the html 
			$row = mysql_fetch_array($result);  // gets next row
		}
		print "</select>";  // ends the option 
	}
	?>
	<!-- The following connect to the JavaScript API--> 
	<script type="text/javascript" src="http://ajax.googleapis.com/
	ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
	// The following populates the subgenres after the genre is selected 
	$(document).ready(function()
	{
		$(".genre").change(function()
		{
			var selectedGenre=$(this).val();
			var dataString = 'selectedGenre='+ selectedGenre;

			$.ajax
			(
				{
					type: "POST",
					url: "ajax_subgenre.php",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$(".subgenre").html(html);
					} 
				});

		});
	});
</script>
<!---Sends the form results to page "Results1.php" ---> 
<form action="Results1.php" method="post" id = "movie" class="pick">
	<h4>I want to watch a... <h4>
	<!---results stored in variable called genre ---> 
		<select name ="genre" form="movie" class="genre">
			<option value = ""> Select your genre </option> 
				<?php
					// queries the genres from the database
					$query = "SELECT name FROM tagtest WHERE type = 'genre'" ;
					$result = mysql_query($query);
					error_check($result);
					runQueryForm($result); 
				?>
		</select> 
		<br/><br/>
		<!--The following is the subgenre question-->
	<h4>With a some bit of... <h4>
		<!---results stored in variable called subgenre ---> 
		<select name="subgenre" form="movie" class="subgenre">
			<option selected=""> Select your subgenre </option>
		</select>
	<br/>
	<br/>
	<input type="submit"/>
	<!---submits form ---> 
</form>
<!---ends form ---> 
</body>
</html>