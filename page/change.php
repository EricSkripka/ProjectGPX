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

#Esimesel korral ei näita tulemust, et muutmine õnnestus. Andmebaasis muudab ära aga kasutajale seda kohe ei ütle. Peab refreshima kaks korda. Tõenäoliselt tuleneb se sellest, kuidas ma seda muutujat trantspordin
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
	exit();
}

#võtab Change.class.php lehelt muutuja. Kuna ei osanud note-i defineerida, siis on selle ees funktsioon, et ei näitaks errorit
error_reporting(0);	
$answer = $_SESSION['note'];

#kontrollib, kas on sisestatud uus kasutajanimi
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

#kontrollib, kas on sisestatud uus parool
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

#kontrollib, kas on sisestatud uus e-mail
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

#kontrollib, kas on sisestatud uus eesnimi
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

#kontrollib, kas on sisestatud uus perekonnanimi
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

#kontrollib, kas on sisestatud uus sugu
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
	<!--Siis on kõik disainielemendid -->
  <title>Project GPX</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--Siin asub tagataust-->
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
  
	<!--Ülemine tööriba-->
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
        
        <!--Paremal asuv riba -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li class="active"><a href="data.php">Kodu</a></li>
              <li><a href="user.php">Hobid</a></li>
              <li><a href="upload.php">Lae üles</a></li>
              <li><a href="change.php">Muuda andmeid</a></li>              
            </ul>
        </div>
	
<div class="col-xs-12 col-sm-9">
<h1>Muuda enda andmeid</h1>
<h3>Selleks, et muuta enda andmeid kirjuta lihstalt kastidesse uued andmed.</h3>
<h3>Neid, mida muuta ei taha, jäta tühjaks.</h3><br>

<h3>Tulemus: <?php echo $answer; ?></h3><br>


<?php #echo $answer ?>

<!--<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
-->
 <!--Uute andmete sisestamine-->
		<form method="POST"> <br>
			
			<label>Muuda enda kasutajanime</label> <br>
			<input name="changeUsername" placeholder="Kasutajanimi" type="text"> <br><br>
			<label>Muuda enda parooli</label> <br>
			<input name="changePassword" placeholder="Parool" type="password"> <br><br>
			<label>Muuda enda emaili</label> <br>
			<input name="changeEmail" placeholder="E-post" type="text"> <br><br>
			<label>Muuda enda eesnime</label> <br>
			<input name="changeFirstName" placeholder="Eesnimi" type="text"> <br><br>
			<label>Muuda enda perekonnanime</label> <br>
			<input name="changeLastName" placeholder="Perekonnanimi" type="text"> <br><br>	
			<label>Muuda enda sugu</label> <br>
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

        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->
</html>
