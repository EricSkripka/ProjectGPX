<?php

#Tegin kasutajate muutmiselehe. Praegu muudab inimeste andmeid aga ei ole kontrolli, kas ta sisestab sama asja või ei ning ei kontrolli parooli pikust"
#Eraldi ei anna teadet, kui salvestamine õnnestus. Annab siis kui 'Change.class.php' lehel kirjutada eraldi echo-d aga siis kui näiteks muudad 2 asja tuleb ka kaks teadet, et salvestamine õnnestus 

require("../../../config.php");
require("../functions.php");
require("../class/Change.class.php");

$Change = new Change($mysqli);

//defineerin muutujad
$changeEmailError = "";
$changePasswordError = "";
$changeUsernameError = "";
$changeEmail = "";
$changeGender = "";
$changeFirstName= "";
$changeFirstNameError = "";
$changeUsername = "";
$changeLastName = "";
$changeLastNameError = "";
$id = "";
#$answer = "Salvestamine toimus edukalt";

#Esimesel korral ei näita tulemust, et muutmine õnnestus. Andmebaasis muudab ära aga kasutajale seda kohe ei ütle. Peab refreshima kaks korda.
error_reporting(0);	
$answer = $_SESSION['note'];


if(isset($_POST["changeUsername"])) {
	if(empty($_POST["changeUsername"])){
		$changeUsernameError = "Kui tahad muuta enda kasutajanime, siis pead sisestama uue kasutajanime";
	} else {
		$_POST["changeUsername"] = $Helper->cleanInput($_POST["changeUsername"]);
		$changeUsername = $_POST["changeUsername"];
		$id = $_SESSION["userId"];
		$Change->changeUsername($changeUsername, $id);
	}
}


if(isset($_POST["changePassword"])) {
	if(empty($_POST["changePassword"])){
		$changePasswordError = "Kui tahad muuta enda parooli, siis pead sisestama uue parooli";
	} else {
		$_POST["changePassword"] = $Helper->cleanInput($_POST["changePassword"]);
		$changePassword = hash("sha512", $_POST["changePassword"]);
		$id = $_SESSION["userId"];
		$Change->changePassword($changePassword, $id);
	}
}


if(isset($_POST["changeEmail"])) {
	if(empty($_POST["changeEmail"])){
		$changeEmailError = "Kui tahad muuta enda emaili, siis pead sisestama uue emaili";
	} else {
		$_POST["changeEmail"] = $Helper->cleanInput($_POST["changeEmail"]);
		$changeEmail = $_POST["changeEmail"];
		$id = $_SESSION["userId"];
		$Change->changeEmail($changeEmail, $id);
	}
}


if(isset($_POST["changeFirstName"])) {
	if(empty($_POST["changeFirstName"])){
		$changeFirstNameError = "Kui tahad muuta enda eesnime, siis pead sisestama uue eesnime";
	} else {
		$_POST["changeFirstName"] = $Helper->cleanInput($_POST["changeFirstName"]);
		$changeFirstName = $_POST["changeFirstName"];
		$id = $_SESSION["userId"];
		$Change->changeFirstName($changeFirstName, $id);
	}
}


if(isset($_POST["changeLastName"])) {
	if(empty($_POST["changeLastName"])){
		$changeLastNameError = "Kui tahad muuta enda perekonnanime, siis pead sisestama uue perekonnanime";
	} else {
		$_POST["changeLastName"] = $Helper->cleanInput($_POST["changeLastName"]);
		$changeLastName = $_POST["changeLastName"];
		$id = $_SESSION["userId"];
		$Change->changeLastName($changeLastName, $id);
	}
}


if( isset( $_POST["changeGender"] ) ){
	if(!empty( $_POST["changeGender"] ) ){
		$signupGender = $_POST["changeGender"];
		$id = $_SESSION["userId"];
		$Change->changeGender($signupGender, $id);
	}
} 

#echo $answer;
?>


<!DOCTYPE html>
<html>
	<head>
<?php require("../header.php");?>
<h1><a href="data.php"> Tagasi</a></h1>

<h1>Muuda enda andmeid</h1>
<h3>Selleks, et muuta enda andmeid kirjuta lihstalt kastidesse uued andmed.</h3>
<h3>Neid, mida muuta ei taha, jäta tühjaks.</h3><br><br>

<h3>Tulemus: <?php echo $answer; ?></h3><br>


<?php #echo $answer ?>

<!--<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
-->

		<form method="POST"> <br>
		<!--<input type="hidden" name="id" value="<?#=$_GET["id"];?>" -->
			
			<p>Muuda enda kasutajanime<p>
			<input name="changeUsername" placeholder="Kasutajanimi" type="text">
			<p>Muuda enda parooli<p>
			<input name="changePassword" placeholder="Parool" type="password">	
			<p>Muuda enda emaili<p>
			<input name="changeEmail" placeholder="E-post" type="text">
			<p>Muuda enda eesnime<p>
			<input name="changeFirstName" placeholder="Eesnimi" type="text">	
			<p>Muuda enda perekonnanime<p>
			<input name="changeLastName" placeholder="Perekonnanimi" type="text">		
			<p>Muuda enda sugu<p>
			<?php if($changeGender == "male") { ?>
				<input name="changeGender" value="male" type="radio" checked> Mees <br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="changeGender" value="male" type="radio"> Mees <br>
			<?php } ?>	
			
			<?php if($changeGender == "female") { ?>
				<input name="changeGender" value="female" type="radio" checked> Naine <br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="changeGender" value="female" type="radio"> Naine <br>
			<?php } ?> 
			
			<?php if($changeGender == "other") { ?>
				<input name="changeGender" value="other" type="radio" checked> Ei soovi avaldada <br><br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="changeGender" value="other" type="radio"> Ei soovi avaldada <br><br>
			<?php } ?>

			<input type="submit" name="change" value="Muuda"><br><br>
			
		</form>
		
<!--		</div>
	</div>
</div>
-->
</html>
