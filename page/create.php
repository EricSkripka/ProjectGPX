<?php

require("../functions.php");
require("../class/User.class.php");

$User = new User($mysqli);

//kui on sisse logitud, suunab data.php lehele
if (isset($_SESSION["userId"])){
	header("Location: data.php");
	exit();
}
//defineerin muutujad
$signupEmailError = "";
$signupPasswordError = "";
$signupPasswordError2 = "";
$signupUsernameError = "";
$signupEmail = "";
$signupGender = "";
$signupFirstName= "";
$signupFirstNameError = "";
$signupUsername = "";
$signupLastName = "";
$signupLastNameError = "";

//kontrollin kasutaja loomisel sisestavaid väärtusi
if(isset($_POST["signupEmail"])){
	if(empty($_POST["signupEmail"])){
		$signupEmailError = "See väli on kohustuslik";	
	} else {
		$_POST["signupEmail"] = $Helper->cleanInput($_POST["signupEmail"]);
		$signupEmail = $_POST["signupEmail"];
	}
}
if(isset($_POST["signupUsername"])) {
	if(empty($_POST["signupUsername"])){
		$signupUsernameError = "Igal kasutajal peab olema kasutajanimi";
	} else {
		$_POST["signupUsername"] = $Helper->cleanInput($_POST["signupUsername"]);
		$signupUsername = $_POST["signupUsername"];
	}
}
if(isset($_POST["signupPassword"])) {
	if(empty($_POST["signupPassword"])){
		$signupPasswordError = "Parool peab olema";
	} else {
		if (strlen($_POST["signupPassword"]) < 8) {
		$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
		}
	}
}
if(isset($_POST["signupPassword2"])) {	
	if(empty($_POST["signupPassword2"])){
		$signupPasswordError2 = "Parool peab olema";
	} else {
		if (strlen($_POST["signupPassword2"]) < 8) {
			$signupPasswordError2 = "Parool peab olema vähemalt 8 tähemärki pikk";
		} else {
			if ($_POST["signupPassword2"] != $_POST["signupPassword"]){
			$signupPasswordError2 = "Paroolid ei ühti";
			} 
		}
	}
}
if(isset($_POST["signupFirstName"])) {
	if(empty($_POST["signupFirstName"])){
		$signupFirstNameError = "Eesnimi sisestamine on kohustuslik";
	} else {
		$_POST["signupFirstName"] = $Helper->cleanInput($_POST["signupFirstName"]);
		$signupFirstName = $_POST["signupFirstName"];
	}
}
if(isset($_POST["signupLastName"])) {
	if(empty($_POST["signupLastName"])){
		$signupLastNameError = "Perekonnanimi sisestamine on kohustuslik";
	} else {
		$_POST["signupLastName"] = $Helper->cleanInput($_POST["signupLastName"]);
		$signupLastName = $_POST["signupLastName"];
	}
}
if(isset($_POST["signupGender"] ) ){
	if(!empty( $_POST["signupGender"] ) ){
		$signupGender = $_POST["signupGender"];
	}		
} 
if(isset($_POST["signupEmail"]) && 
	isset($_POST["signupPassword"]) &&
	isset($_POST["signupPassword2"]) &&
 	($_POST["signupPassword2"] == $_POST["signupPassword"]) &&
	$signupEmailError == "" && 
	empty($signupPasswordError)){
		$password = hash("sha512", $_POST["signupPassword"]);
		$User->signUp($signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName, $signupGender);
}

$notice = "";

if(isset($_POST["loginEmail"])){
	if(!empty($_POST["loginEmail"])){
		$_POST["loginEmail"] = $Helper->cleanInput($_POST["loginEmail"]);
	if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && 
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])){
			$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
			$loginEmail2 = $_POST["loginEmail"];
	} else {
		$loginEmailError = "Sisselogimiseks peab sisestama e-maili";
		$loginPasswordError = "Sisselogimiseks peab sisetama parooli";
		}
	}
}
?>

<!DOCTYPE html>
<?php require("../header.php");?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">

<html>
	<head>
		<h1>Loo kasutaja</h1>
		<form method="POST"> <br>
		
			<input name="signupUsername" placeholder="Kasutajanimi" type="text" value="<?=$signupUsername;?>"> <?=$signupUsernameError; ?> <br><br>
			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?> <br><br>
			<input name="signupPassword2" placeholder="Sisesta parool uuesti" type="password"> <?php echo $signupPasswordError2; ?> <br><br>
			<input name="signupEmail" placeholder="E-post" type="text" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?> <br><br>
			<input name="signupFirstName" placeholder="Eesnimi" type="text" value="<?=$signupFirstName;?>"> <?php echo $signupFirstNameError; ?> <br><br>
			<input name="signupLastName" placeholder="Perekonnanimi" type="text" value="<?=$signupLastName;?>"> <?php echo $signupLastNameError; ?> <br><br>
			
			<?php if($signupGender == "male") { ?>
				<input name="signupGender" value="male" type="radio" checked> Mees <br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="signupGender" value="male" type="radio"> Mees <br>
			<?php } ?>	
			
			<?php if($signupGender == "female") { ?>
				<input name="signupGender" value="female" type="radio" checked> Naine <br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="signupGender" value="female" type="radio"> Naine <br>
			<?php } ?>
			
			<?php if($signupGender == "other") { ?>
				<input name="signupGender" value="other" type="radio" checked> Ei soovi avaldada <br><br>
			<?php }else { ?> <!--Tühikud peavad olema-->
				<input name="signupGender" value="other" type="radio"> Ei soovi avaldada <br><br>
			<?php } ?>
				
			<input class="btn btn-success btn-sm-block visible-xs-block" type="submit" value="Loo kasutaja">
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Loo kasutaja"><br><br>
			
			<p>On siiski kasjutaja olemas?<a href="login.php"> Vajuta Siia</a></p>
		
		</form>
		
		</div>
	</div>
</div>

</html>