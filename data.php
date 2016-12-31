<?php

$asukoht = "../ProjectGPX/uploads";
#$kaart = "../ProjectGPX/uploads/matu--20161114_153234.gpx";
$kaart = "";
$dir = "uploads";
$array = array();

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
	$target_username  = $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
	$target_dir = "uploads/";
    $target_file = $target_dir . $_SESSION["userName"] . "--" . basename($_FILES["fileToUpload"]["name"]);
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

<br>

<p>Olemasolevad GPX failid:</p>

<?php
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
		if ($file != "." && $file != ".."){
			#array_push($array, $file);
			echo $file;
?>	
			<a href="../ProjectGPX/map.php?kaart=<?php echo $file ?>">Vajuta</a><br>
<?php
		}
    }
    closedir($dh);
  }
}
?>


<br><br>
</html>