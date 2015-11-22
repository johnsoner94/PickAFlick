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
  
  <h2> What are you feeling like? </h2>
  	
    <!-- Aliya, I am not really sure what to do here since I don't remember your awesome 
    form from yesterday.I did it without the drop downs because I am not sure if we can 
    frasibly do that. This  was my best guess (and my best guess for the action= 
    part and how to set up PHP as well -->
  	<form action="pick.php" method="post" style="margin:5px"> 

		What genre are you feeling like? <input type="text" name="genre"/>
        
        <br/>What mood are you in? <input type="text" name="mood"/>

		<br/>How recent should it be? <input type="text" name="date"/> 

		<br/> Any specific actor? <input type="text" name="actor"/> 

		<br/>Any specific director?  <input type="text" name="director"/> 

		<br/>Are you by yourself or with others? <input type="text" name="company"/> 

		<br/> Do you want it to be about a holiday? Which? <input type="text" name="holiday"/> 

		<br/><input type="submit"/>

	</form>
	
  
</body>
</html>