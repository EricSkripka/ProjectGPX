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

#kontrollid, mis kontrollivad ülaetavat faili
if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["name"])){
	$target_username  = $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "../uploads/";
    $target_file = $target_dir . $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $GPXFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	#kontrollib, kas selline fail on juba olemas
    if (file_exists($target_file)) {
        $error = "Selle nimega fail juba eksisteerib. ";
        $uploadOk = 0;
    }
	#Kontrollib, kas fail on piisava suurusega
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $error = "See fail on liiga suur. ";
        $uploadOk = 0;
    }
	#Lubab ainult .gpx faililaiendiga faile
    if($GPXFileType != "gpx") {
        $error = "Ainult .gpx failid on lubatud. ";
        $uploadOk = 0;
    }
	#Kui on tekkinud error, siis kuvatakse järgnev veateade
    if ($uploadOk == 0) {
       $error2 = "Seda faili ei laetud üles.";
	#Kui oli korras siis laetakse fail üles
    } else {
		#Kui fail laetakse üles siis antakse ka teade, et see juhtus aga kui ei laetud siis antakse veateade
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$error3 = "Fail ". $target_username. " laeti üles. ";
			
        } else {
            $error3 = "Vabandust, faili laadimisega tekkis probleem. ";
        }
    }
#Kui ei ole faili valitud ja vajutatakse ülaadimis nuppu, antakse veateade
} else {
	$error4 = "Valige fail, mida üles laadida. ";
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
              <li><a href="data.php">Home</a></li>
              <li><a href="user.php">User</a></li>
              <li class="active"><a href="upload.php">Upload</a></li>
              <li><a href="change.php">Change</a></li>              
            </ul>
        </div>
  	
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">
          <h1>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</h1>
		  <form action="upload.php" method="post" enctype="multipart/form-data">
				<p>Valige .GPX fail, mida soovite üles laadida:<p>
				<input type="file" name="fileToUpload" id="fileToUpload"> <br>
				<input type="submit" value="Upload gpx" name="submit">
			</form>

			<!--Kuvab erinevad veateated-->
			<?php echo $error, $error2, $error3, $error4 ?>
    
			
		
    
          
          
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->

</html>