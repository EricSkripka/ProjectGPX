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

#kontrollid, mis kontrollivad üleslaetavat faili
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
	#Kui oli kõik korras siis laetakse fail üles
    } else {
		#Kui fail laetakse üles siis antakse ka teade, et see juhtus aga kui ei laetud siis antakse veateade
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$error3 = "Fail ". $target_username. " laeti üles. ";
			
        } else {
            $error3 = "Vabandust, faili laadimisega tekkis probleem. ";
        }
    }
#Kui ei ole faili valitud ja vajutatakse üleslaadimis nuppu, antakse veateade
} else {
	$error4 = "Valige fail, mida üles laadida. ";
}

?>
<h1><h1><?php require("../header.php");?>
	
<p>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</p>
<p>Kasutajanimi: <a href="user.php"><?=$_SESSION["userName"];?></a></p>

<a href="?logout=1">Logi välja</a>  <br> <br>
<!DOCTYPE html>
<html>
<body>

<!--Saab üles laadida .gpx faile -->
<form action="data.php" method="post" enctype="multipart/form-data">
    Valige .GPX fail, mida soovite üles laadia:
    <input type="file" name="fileToUpload" id="fileToUpload"> <br>
    <input type="submit" value="Upload gpx" name="submit">
</form>

<!--Kuvab erinevad veateated-->
<?php echo $error, $error2, $error3, $error4 ?>
</body> <br><br><br>

<!--Kuvab juba üles laetud failid-->
<p>Olemasolevad GPX failid:</p>

<?php

#Vaatab läbi "uploads" kausta ja sorteerib need kohe tähestiku järjekorda ja kuvab ekraanile, koos lingiga, millele vajutades näeb kaarti
#Lisaks ei prindi välja kahte peidetud kausta
$files = scandir($dir);
sort($files);
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo  $file;
?>
		<a href="../page/map.php?map=<?php echo $file ?>">Kaart</a><br>
<?php	
	}
}
?>	

<br><br>
</html>