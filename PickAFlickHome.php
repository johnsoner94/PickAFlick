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
				<form>
                    <input type="text" placeholder="Search..." required>
                    <input type="button" value="Search">
				</form>
        	</li>
      </ul>
    </div>
  </header> 
  
  <h2> Welcome to Pick A Flick, a movie generator based on your personal mood and interests. </h2>
  
  <table style="width:100%">
	<tr>
		<td>
        <h2> Whatever we want to put here!! </h2>
        </td>
   
		<td>
		<h3> This month's top 5 movies: </h3>
		<div class="container">
   			<div id="content-slider">
      			<div id="slider">  <!-- Slider container -->
        			 <div id="mask">  <!-- Mask -->

         			<ul>
         			<li id="first" class="firstanimation">  <!-- ID for tooltip and class for animation -->
         			<a href="#"> <img height=350px; width=230px; src="		http://www.impawards.com/1997/posters/george_of_the_jungle_ver3.jpg" alt="George"/> </a>
         			<div class="tooltip"> <h4> George of the Jungle </h4></div>
         			</li>

         <li id="second" class="secondanimation">
         <a href="#"> <img height=350px; width=230px;  src="http://ia.media-imdb.com/images/M/MV5BMjM5Mzg5NjA0Nl5BMl5BanBnXkFtZTcwMjg3MDEyMw@@._V1_UY1200_CR90,0,630,1200_AL_.jpg" alt="Furry"/> </a>
         <div class="tooltip"> <h4> Furry Vengeance</h4> </div>
         </li>

         <li id="third" class="thirdanimation">
         <a href="#"> <img height=350px; width=230px; src="http://ia.media-imdb.com/images/M/MV5BMTY1OTgyNTI2OV5BMl5BanBnXkFtZTcwNDUxMDQyMQ@@._V1_SY317_CR4,0,214,317_AL_.jpg" alt="breathing"/> </a>
         <div class="tooltip"> <h4> Still Breathing </h4></div>
         </li>

         <li id="fourth" class="fourthanimation">
         <a href="#"> <img height=350px; width=230px; src="http://ecx.images-amazon.com/images/I/51BXhPusZIL._SY355_.jpg" alt="Man"/> </a>
         <div class="description"> Encind Man </div>
         </li>

         <li id="fifth" class="fifthanimation">
         <a href="#"> <img height=350px; width=230px;  src="http://i43.tower.com/images/mm107062438/monkeybone-brendan-fraser-dvd-cover-art.jpg" alt="Monkey"/> </a>
         <div class="tooltip"> Monkey Bone </div>
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