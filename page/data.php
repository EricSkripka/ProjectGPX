<?php

require("../../../config.php");
require("../functions.php");

#defineerib muutujad
$map = "";
$dir = "../uploads";
$error = "";
$error2 = "";
$error3 = "";
$error4 = "";

#kui ei ole sisse logitud siis suunab login.php lehele
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
	exit();
}

#kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
  <title>Project GPX</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style>
  body {
  padding-top: 51px;
  background-image: url("http://perthurbanrunners.com/wp-content/gallery/gallery/running-04.jpg");
    background-color: #cccccc;
}
.text-center {
  padding-top: 20px;
}
.col-xs-12 {
  background-color: #fff;
}
#sidebar {
  height: 100%;
  padding-right: 0;
  padding-top: 20px;
}
#sidebar .nav {
  width: 95%;
}
#sidebar li {
  border:0 #f2f2f2 solid;
  border-bottom-width:1px;
}

/* collapsed sidebar styles */
@media screen and (max-width: 767px) {
  .row-offcanvas {
    position: relative;
    -webkit-transition: all 0.25s ease-out;
    -moz-transition: all 0.25s ease-out;
    transition: all 0.25s ease-out;
  }
  .row-offcanvas-right
  .sidebar-offcanvas {
    right: -41.6%;
  }

  .row-offcanvas-left
  .sidebar-offcanvas {
    left: -41.6%;
  }
  .row-offcanvas-right.active {
    right: 41.6%;
  }
  .row-offcanvas-left.active {
    left: 41.6%;
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 41.6%;
  }
  #sidebar {
    padding-top:0;
  }
}
</style>
</head>
<div class="page-container">
  
	<!-- top navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
       <div class="container">
	   <a class="navbar-brand navbar-right" href="?logout=1">Logi välja</a>
    	<div class="navbar-header">
           <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
           <a class="navbar-brand" href="data.php">Project GPX</a>
				
    	</div>
       </div>
    </div>
      
    <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li class="active"><a href="data.php">Kodu</a></li>
              <li><a href="user.php">Hobid</a></li>
              <li><a href="upload.php">Lae üles</a></li>
              <li><a href="change.php">Muuda andmeid</a></li>              
            </ul>
        </div>
  	
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">
          <h1>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</h1>
          
			
    
          <p>Tere tulemast Project GPX kodulehele!</p>
		  
		  <!--Kuvab juba üles laetud failid-->
			<h3>Olemasolevad GPX failid:</h3>

			<?php

			#Vaatab läbi "uploads" kausta ja sorteerib need kohe tähestiku järjekorda ja kuvab ekraanile, koos lingiga, millele vajutades näeb kaarti
			#Lisaks ei prindi välja kahte peidetud kausta
			$files = scandir($dir);
			sort($files);
			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					echo $file;
			?>
					<a href="../page/map.php?map=<?php echo $file ?>">Kaart</a><br>
			<?php	
				}
			}
			?>
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->
</html>