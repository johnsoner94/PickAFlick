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
  
  <h2> Welcome to Pick A Flick, a movie generator based on your personal mood and interests. </h2>
  
  <h3> Make sure to <a href="PickAFlickPick.php">Take Your Pick!</h3>a>
  
  <table style="width:100%">
	<tr>
		<td>
        <h2> Looking to get ready for the Holiday season? Check out these seasonal favorites!  </h2>
        <img src="http://www.mainelights.org/images/lights03a.gif" alt="Christmas Lights">
        
        <!--This is where Christmas movies will be once they are scraped and put into the database-->
        
        </td>
   
		<td>
			
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
			
			$num_rows = mysql_num_rows($result);
			$row = mysql_fetch_array($result);
	
			if($num_rows == 0) {
				print("There are no movies that match your requirements!<br/>");
				exit;
			}
			
			for($row_num = 0; $row_num < $num_rows; $row_num++) {
				print "<img src= '$row[0]''alt='moviePoster' width='300' height='500'>";
				$row = mysql_fetch_array($result);
				reset($row);
			}
		}
		
		$query = "SELECT poster FROM movtest WHERE id BETWEEN 1 and 5;";
		$result = mysql_query($query);
		error_check($result);
		//runQuery($result);
		
		$row = mysql_fetch_array($result);
		
		?>
		
		<h3> This month's top 5 movies: </h3>
		<div class="container">
   			<div id="content-slider">
      			<div id="slider">  <!-- Slider container -->
        			 <div id="mask">  <!-- Mask -->

         			<ul>
                    
        <li id="first" class="firstanimation">  <!-- ID for tooltip and class for animation -->
         <div class="tooltip"> <h4> #1 </h4> </div>
         <a href="#"> 
			 <?php
			 print "<img src=' $row[0]' alt='George' height=360px width=230px /> ";
			 $row = mysql_fetch_array($result);
			 reset($row);
			 ?>
		 </a>

         </li>

         <li id="second" class="secondanimation">
         <div class="tooltip"> <h4> #2 </h4> </div>
         <a href="#"> 
			 <?php
			 print "<img height=360px width=230px src=' $row[0] ' alt='Furry'/> ";
			 $row = mysql_fetch_array($result);
			 reset($row);
			 ?>
		 </a>
         </li>

         <li id="third" class="thirdanimation">
         <div class="tooltip"> <h4> #3 </h4></div>
         <a href="#"> 
			 <?php
			 print "<img height=360px width=230px src='$row[0]' alt='breathing'/> ";
			 $row = mysql_fetch_array($result);
			 reset($row);
			 ?>
		</a>

         </li>

         <li id="fourth" class="fourthanimation">
         <div class="tooltip"><h4>  #4 </h4></div>
         <a href="#">
			 <?php
			 print "<img height=360px width=230px src='$row[0]' alt='Man'/> ";
			 $row = mysql_fetch_array($result);
			 reset($row);
			 ?>
		 </a>

         </li>

         <li id="fifth" class="fifthanimation">
         <div class="tooltip"><h4>  #5 </h4></div>
         <a href="#">
			 <?php
			 print "<img height=360px width=230px src='$row[0]' alt='Monkey'/> ";
			 ?>
		 </a>

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