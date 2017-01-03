<?php

require("../functions.php");
require("../class/User.class.php");

$User = new User($mysqli);

#kui on sisse logitud siis suunab data.php lehele
if (isset($_SESSION["userId"])){
	header("Location: data.php");
	exit();
}

#defineerib muutujad
$loginEmail2 = "";
$loginEmailError = "";
$loginPasswordError = "";
$notice = "";

#sisse logimise kontrollid e-maili ja paroolide jaoks
if(isset($_POST["loginEmail"])){
	if(!empty($_POST["loginEmail"])){
		$_POST["loginEmail"] = $Helper->cleanInput($_POST["loginEmail"]);
		if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])){
				$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
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
		<title>Logi sisse või loo kasutaja</title>
	</head>
	<body>
	
		<h1>Logi sisse</h1><br>
		<form method="POST">
			<p style="color:red;"><?=$notice;?></p>
			<div class="form-group">
				<input class="form-control" placeholder="E-mail" name="loginEmail" type="text" value="<?=$loginEmail2;?>"> <?php echo $loginEmailError; ?>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Parool" name="loginPassword" type="password"> <?php echo $loginPasswordError; ?> <br><br>
				<input class="btn btn-success btn-sm-block visible-xs-block" type="submit" value="Logi sisse">
				<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Logi sisse"><br><br>
			<p>Pole kasutajat? <a href="create.php"> Vajuta Siia</a></p>
			</div>
		</form>
		
			</div>
		</div>
	</div>

	</body>
</html>