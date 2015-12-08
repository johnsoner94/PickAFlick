<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Pick A Flick!</title>
<link href="PickAFlick.css" rel="stylesheet" type="text/css">
</head>

<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>


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
		
	function runQuery($result){
	$row = mysql_fetch_array($result);
	$num_fields = sizeof($row);
	$num_rows = mysql_num_rows($result);
	
	 
	for($row_num = 0; $row_num < $num_rows; $row_num++) {
		reset($row);
		for ($field_num = 0; $field_num < $num_fields / 2; $field_num++)
			print "<option value = '$row[$field_num]'>  $row[$field_num] </option>";
			$row = mysql_fetch_array($result);
		}
		print "</select>";
	}
	?>

<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
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


<form action="movieResults3.php" method="post" id = "movie" class="pick">


	<h4>I want to watch a... <h4>
	<select name ="question1" form="movie" class="genre">
	<option value = ""> Select your genre </option> 
		<?php
		$query = "SELECT name FROM tagtest WHERE type = 'genre'" ;
		$result = mysql_query($query);
		error_check($result);
		runQuery($result);
		?>
	</select> <br/><br/>
	
	<h4>With a some bit of... <h4>
	<select name="subgenre" form="movie" class="subgenre">
	<option selected=""> Select your subgenre </option>
	</select>
	


				
	<br/><input type="submit"/>

	</form>
	
  
</body>
</html>