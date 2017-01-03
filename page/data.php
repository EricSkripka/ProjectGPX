<?php

require("../../../config.php");
require("../functions.php");

#defineerib muutujad
$asukoht = "../ProjectGPX/uploads";
#$kaart = "../ProjectGPX/uploads/matu--20161114_153234.gpx";
$kaart = "";
$dir = "../uploads";
$array = array();
$answer = "";
$answer2 = "";
$answer3 = "";
$answer4 = "";

//$searching = "r";

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

#kontrollid, mis kontrollivad üleslaetavat faili
if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["name"])){
	$target_username  = $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "uploads/";
    $target_file = $target_dir . $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $GPXFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	#kontrollib, kas selline fail on juba olemas
    if (file_exists($target_file)) {
        $answer = "Selle nimega fail juba eksisteerib. ";
        $uploadOk = 0;
    }
	#Kontrollib, kas fail on piisava suurusega
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $answer = "See fail on liiga suur. ";
        $uploadOk = 0;
    }
	#Lubab ainult .gpx faililaiendiga faile
    if($GPXFileType != "gpx") {
        $answer = "Ainult .gpx failid on lubatud. ";
        $uploadOk = 0;
    }
	#Kui on tekkinud error, siis kuvatakse järgnev veateade
    if ($uploadOk == 0) {
       $answer2 = "Seda faili ei laetud üles.";
	#Kui oli kõik korras siis laetakse fail üles
    } else {
		#Kui fail laetakse üles siis antakse ka teade, et see juhtus aga kui ei laetud siis antakse veateade
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$answer3 = "Fail ". $target_username. " laeti üles. ";
			
        } else {
            $answer3 = "Vabandust, faili laadimisega tekkis probleem. ";
        }
    }
#Kui ei ole faili valitud ja vajutatakse üleslaadimis nuppu, antakse veateade
} else {
	$answer4 = "Valige fail, mida üles laadida. ";
}


#see teeb põhimõteliselt sama asja aga sellega tekkisid probleemid masiivi panemisega aga muidu prindib välja

#$file = scandir($dir);
#if ($file != "." && $file != "..") {
#	array_push($array, $file);
#}

# käib läbi uploads kataloogi ja lisab kõik olemasolevad mitte peidetud failid masiivi
#if (is_dir($dir)){
#  if ($dh = opendir($dir)){
#    while (($file = readdir($dh)) !== false){
#		if ($file != "." && $file != ".."){
#			array_push($array, $file);
#			echo "GPX fail: " . $file . "<br>";
#		}
#   }
#    closedir($dh);
#  }
#}
#print_r($array);

?>
<h1><h1><?php require("../header.php");?>
	
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

<?php echo $answer ?><?php echo $answer2 ?><?php echo $answer3 ?><?php echo $answer4 ?>
</body>

<br><br><br>

<p>Olemasolevad GPX failid:</p>

<?php
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
		if ($file != "." && $file != ".."){
			#array_push($array, $file);
			echo $file;
?>	
			<a href="../page/map.php?kaart=<?php echo $file ?>">Kaart</a><br>
<?php
		}
    }
    closedir($dh);
  }
}
?>
<br><br>
</html>