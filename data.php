<?php

$url = "../20161114_153234.gpx";


require("../../config.php");
require("functions.php");

//$searching = "r";
//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
	exit();
}

//kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
}

if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["name"])){
	$target_username  = $_SESSION["userName"] . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "uploads/";
    $target_file = $target_dir . $_SESSION["userName"] . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $GPXFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if gpx file is a actual gpx file

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($GPXFileType != "gpx") {
        echo "Sorry, only GPX files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". $target_username. " has been uploaded.";
			
            
            // save file name to DB here
			//Üleslaadimisel märgitakse ära, kes üles laadis (salvestatakse kasutajanimega või id-ga failinimese).
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}else{
    #echo "Please select the file that you want to upload!";
}

?>

<h1>DATA<h1><?php require("header.php");?>
	
<p>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</p>
<p>Kasutajanimi: <a href="user.php"><?=$_SESSION["userName"];?></a></p>

<a href="?logout=1">Logi välja</a>  <br> <br>
<!DOCTYPE html>
<html>
<body>

<form action="data.php" method="post" enctype="multipart/form-data">
    Valige .GPX fail, mida soovite üles laadia:
    <input type="file" name="fileToUpload" id="fileToUpload"> <br>
    <input type="submit" value="Upload gpx" name="submit">
</form>

</body>
</html>

<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>KML Layers</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="map"></div>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMNWr_XhITKj-IvxvIXlay3FemqIIce6w&callback=initMap">
    </script>
  </body>
  <script>
		
	  var map;
		
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {lat: 59.436, lng: 24.753},
		  streetViewControl: false,
		  
        });
		
		 $.ajax({
		  type: "GET",
		  url: "<?=$url;?>",
		  dataType: "xml",
		  success: function(xml) {
			var points = [];
			var bounds = new google.maps.LatLngBounds ();
			$(xml).find("trkpt").each(function() {
			  var lat = $(this).attr("lat");
			  var lon = $(this).attr("lon");
			  var p = new google.maps.LatLng(lat, lon);
			  points.push(p);
			  bounds.extend(p);
			});

			var poly = new google.maps.Polyline({
			  // use your own style here
			  path: points,
			  strokeColor: "#FF00AA",
			  strokeOpacity: .7,
			  strokeWeight: 4
			});
			
			poly.setMap(map);
			
			// fit bounds to track
			map.fitBounds(bounds);
		  }
		});
		
      }
	  
	  
	 
	  
    </script>
</html>