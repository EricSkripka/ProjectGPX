<?php

require("../../config.php");
require("functions.php");


if (isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: data.php");
	exit();
}

$loginEmail2 = "";
$loginEmailError = "";
$loginPasswordError = "";
//kas on üldse olemas selline muutuja


$notice = "";
if(isset($_POST["loginEmail"])){
	//jah on olemas
	//kas on tühi
	if(!empty($_POST["loginEmail"])){
		$_POST["loginEmail"] = $Helper->cleanInput($_POST["loginEmail"]);
		
if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && 
	!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"]))
	{
//ei pea olema sama nimi mis function.php-s. Seal on $error
	
	$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
	$loginEmail2 = $_POST["loginEmail"];
	
} else {
	$loginEmailError = "Sisselogimiseks peab sisestama e-maili";
	$loginPasswordError = "Sisselogimiseks peab sisetama parooli";
}
	}
}
#SEE on TEST
#SEE on KA test
?>

<!DOCTYPE html>
<?php require("header.php");?>
<html>
<head>

	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$notice;?></p>
		<br>
		<input name="loginEmail" placeholder="E-post" type="text" value="<?=$loginEmail2;?>"> <?php echo $loginEmailError; ?> <br><br>
		<input name="loginPassword" placeholder="Parool" type="password"> <?php echo $loginPasswordError; ?> <br><br>
		<input type="submit" value="Logi sisse"> <br><br>
		<p>Ei ole kasutajat? <a href="create_user.php"><?="Vajuta siia";?></a></p>
	</form>

	
</body>
</html>