<?php
class User {
	private $connection;
			
		function __construct($mysqli){
			//This viitab klassile(this == user)
			$this->connection = $mysqli;
		}
	function signUp($signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName, $signupGender) {
		$stmt = $this->connection->prepare("INSERT INTO project_user (username, password, email, firstname, lastname, gender) VALUES (?, ?, ?, ?, ?, ?)");
		echo $this->connection->error;
		$stmt->bind_param("ssssss",$signupUsername, $password, $signupEmail, $signupFirstName, $signupLastName, $signupGender);
		
		//täida käsu
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
	}
		
	function login($loginEmail, $loginPassword) {

		$error = "";
		$password = $loginPassword;
		$email = $loginEmail;

		$stmt = $this->connection->prepare("SELECT id, username, password, email, firstname, lastname, gender FROM project_user WHERE email = ?");
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		//määrna väärtused muutujasse
		$stmt->bind_result($id, $usernameFromDB, $passwordFromDB,  $emailFromDB, $firstnameFromDB, $lastnameFromDB, $genderFromDB);
		$stmt->execute();
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vastus
		
		if($stmt->fetch()){
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDB) {
				echo "Kasutaja logis sisse ".$id;
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDB;
				$_SESSION["userName"] = $usernameFromDB;
				$_SESSION["firstName"] = $firstnameFromDB;
				$_SESSION["lastName"] = $lastnameFromDB;
				$_SESSION["gender"] = $genderFromDB;
				header("Location: data.php");
				exit();
			} else {
				$error = "Vale parool või kasutajanimi";
			}
			//määran sessiooni muutujad
			//header("Location: login.php");
		}
		return $error;
	}
}
?>