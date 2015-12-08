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

  <form action="movieResults5.php" method="post" id = "movie" class="pick">

	<h4>I want the decade to be...</h4>
	<select name ="question3" form="movie" >
	<option value = ""> select a year </option> 
	<option value = "1920s"> 20s </option>	
	<option value = "1930s"> 30s </option>
	<option value = "1940s"> 40s </option>
	<option value = "1950s"> 50s </option>
	<option value = "1960s"> 60s </option>
	<option value = "1970s"> 70s </option>
	<option value = "1980s"> 80s </option>
	<option value = "1990s"> 90s </option>
	<option value = "2000s"> 2000s </option>
	<option value = "recently"> recent </option>



	</select>
	<br/><input type="submit"/>
	</form>



</body>
</html>