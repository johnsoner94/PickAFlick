<!doctype html>
<!--
Project: Pick A Flick Project  
Class: CSI:210 Software Engineering
Team Members: Emily Johnson, Aliya Gangji, Casie Ropski, Mackensie Weilnau
Date: November-December of 2015

Description: The following page is the Homepage.
  

Programming Languages: HTML, PHP , SQL, CSS 
--> 
<html>
	<head>
		<meta charset="UTF-8">
			<title>Pick A Flick!</title>
			<!--Connect to CSS Page--> 
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
					<!--Inserts Search Bar-->	
                    <input type="text" placeholder="Search..." required>
                    <input type="button" value="Search">
				</form>
        	</li>
      </ul>
    </div>
  </header> 
  
  <h2> Welcome to Pick A Flick, a movie generator based on your personal mood and interests. </h2>
  
  <h3> Make sure to <a href="PickAFlickPick.php" style= "color: #5BD3F8;
	text-shadow: 2px 2px 0px #fff, 5px 5px 0px rgba(0, 0, 0, 0);">Take Your Pick!</a></h3>
  
  <table style="width:100%">
	<tr>
		<td>
        <h2> Looking to get ready for the Holiday season? Check out these seasonal favorites!  </h2>
		<div style="text-align: center">
        <img src="http://www.mainelights.org/images/lights03a.gif" alt="Christmas Lights">
		</div>
        
        
		
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
				
		// a query that calls Christmas movies 
		$query = "SELECT DISTINCT movtest.poster FROM tagtest, pairingtest, 
		movtest WHERE pairingtest.tag_id = tagtest.id 
		AND tagtest.name = 'Christmas' AND pairingtest.movie_id = movtest.id 
		AND tagtest.type = 'subgenre'";
		$result = mysql_query($query);
		error_check($result);
		$row = mysql_fetch_array($result);
?>
		<table align="center">
			<tbody>
				<tr>
					<td>
					 <?php // print first poster
					 print "<img src=' $row[0]' alt='Christmas1' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>  
					 <?php // print second poster
	 				 print "<img src=' $row[0]' alt='Christmas2' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>
					 <?php // print third poster 
					 print "<img src=' $row[0]' alt='Christmas3' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>
					 <?php  // print forth poster
					 print "<img src=' $row[0]' alt='Christmas4' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
				</tr>
				<tr>
					<td>
					 <?php // print first poster
					 print "<img src=' $row[0]' alt='Christmas5' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>  
					 <?php // print second poster
	 				 print "<img src=' $row[0]' alt='Christmas6' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>
					 <?php // print third poster 
					 print "<img src=' $row[0]' alt='Christmas7' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					<td>
					 <?php  // print forth poster
					 print "<img src=' $row[0]' alt='Christmas8' height=360px width=230px /> ";
					 $row = mysql_fetch_array($result);
					 reset($row);
					 ?>
					</td>
					
					
				</tr>
			</tbody>
		</table>
        </td>
		<td>
		<?php
			// query that gets five most popular movies 
			$query = "SELECT poster FROM movtest WHERE id BETWEEN 1 and 5;";
			$result = mysql_query($query);
			error_check($result);
			$row = mysql_fetch_array($result);
		?>
		<h3> This month's top 5 movies: </h3>
		<div class="container">
   			<div id="content-slider">
      			<div id="slider">  <!-- Slider container -->
        			 <div id="mask">  <!-- Mask -->
	         			<ul>
				         <li id="first" class="firstanimation">  <!-- ID for tooltip and class for animation -->
				         <div class="tooltip"> <h5> #1 </h5> </div>
							 <?php // gets first movie 
							 print "<img height=360px width=230px src=' $row[0]' alt='TopFive1' /> ";
							 $row = mysql_fetch_array($result);
							 reset($row);
							 ?>
				         </li>
				         <li id="second" class="secondanimation">
				         <div class="tooltip"> <h5> #2 </h5> </div>
							 <?php  // gets second movie 
							 print "<img height=360px width=230px src=' $row[0] ' alt='TopFive2'/> ";
							 $row = mysql_fetch_array($result);
							 reset($row);
							 ?>
				         </li>
				         <li id="third" class="thirdanimation">
				         <div class="tooltip"> <h5> #3 </h5></div>
							 <?php  // gets third movie 
							 print "<img height=360px width=230px src='$row[0]' alt='TopFive3'/> ";
			 
							 ?>
				         </li>
				         <li id="fourth" class="fourthanimation">
				         <div class="tooltip"><h5>  #4 </h5></div>
							 <?php // gets forth movie 
							 $row = mysql_fetch_array($result);
							 reset($row);
							 print "<img height=360px width=230px src='$row[0]' alt='TopFive4'/> ";
							 ?>
				         </li>
				         <li id="fifth" class="fifthanimation">
				         <div class="tooltip"><h5>  #5 </h5></div>
							 <?php  // gets fifth movie
							 $row = mysql_fetch_array($result);
							 reset($row);
							 print "<img height=360px width=230px src='$row[0]' alt='TopFive5'/> ";
							 ?>
				         </li>        
	         </ul>         
         </div>  <!-- End Mask -->
         <div class="progress-bar"></div>  <!-- Progress Bar -->
      </div>  <!-- End Slider Container -->
   </div>
</div>
</td>
</tr>
</table>
<footer> <h3> &copy; Emaliya and MacCasie Inc. </h3></footer>
</body>
</html>