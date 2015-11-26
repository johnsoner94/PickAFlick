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

<form action="movieResults.php" method="post" id = "movie" >

	I want to watch a movie which is
	<select name ="question1" form="movie" >
	<option value = ""   > choose your era </option>	
	<option value = "1"  > way back when   </option>	
	<option value = "2"  > from your parent's childhood  </option>	
	<option value = "3"  > from your childhood  </option>
	<option value = "4"  > recent  </option>
	<option value = "5"  > newly released  </option>
	</select> 
	
	that I can watch with 
	<select name ="question2" form="movie" >
	<option value = ""  > choose the rating </option>	
	<option value = "G"  >  my baby cousins  </option>	
	<option value = "PG"  >  my brother   </option>	
	<option value = "PG-13"  > my parents  </option>
	<option value = "R"  >  my friends  </option>
	<option value = "UNRATED"  >  myself  </option>
	</select> 
	
	for  
	<select name ="question3" form="movie" >
	<option value = ""  > choose the length </option>	
	<option value = "1"  >   a short period of time  </option>	
	<option value = "2"  >  lots of time   </option>	
	</select> 
	.

		
<br/><input type="submit"/>

	</form>
	
  
</body>
</html>