<?php  
require("../../../config.php");
require("../functions.php");
require("../class/comment.class.php");
$comment = new comment($mysqli);


#kui ei ole sisse logitud siis suunab login.php lehele
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: data.php");	
	exit();
}



#võtan url-i realt muutuja
$fail = $_GET['map'];
#Kuvan ka üleval selle faili nime

$url = "../uploads/$fail";
$Comment = "";
$userid = $_SESSION["userId"];
$commenterror = "";

if(isset($_POST["Comment"])) {
	if(empty($_POST["Comment"])){
		$commenterror = "kommentaari sisestamine on kohustuslik";
	} else {
		$_POST["Comment"] = $Helper->cleanInput($_POST["Comment"]);
		$Comment = $_POST["Comment"];
		$comment->savecomment($userid, $fail, $Comment);
		
	}
}

$pets = $comment->get($fail);
echo $commenterror;


	
print_r ($pets);


?>
<!DOCTYPE html>
<?php require("../header.php");?>
<html>
  <head>
	<h3><?php echo "Praegu vaatad faili nimega ".$fail;?></h3>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>Google Maps</title>
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
	
	<h1>Kommenteeri</h1>
	
	
	<?php
	
	#$html .="<table>";
	
	#foreach($pets as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		
	
		#$html .= "<tr>";
			#$html .= "<td>".$c->user_id."</td>";
			#$html .= "<td>".$c->comment."</td>";
		#$html .= "</tr>";
		
	
	
	#}

	#$html .="</table>";
	
	#echo $html;

	
	?>
	
	<form method="post">
    <textarea rows="4" cols="100" name="Comment"></textarea>
    <input type="submit" name="submit" value="submit" id="submit"/>
	</form>
	
	<?php
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>comment</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($pets as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->user_id."</td>";
			$html .= "<td>".$c->comment."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	
	?>
	
	
</html>