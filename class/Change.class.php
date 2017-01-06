<?php
class Change {
	private $connection;
			
		function __construct($mysqli){
			//This viitab klassile(this == change)
			$this->connection = $mysqli;
		}
	
	
	function changeUsername($changeUsername, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET username=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changeUsername, $id);
		
		//täida käsu
		if($stmt->execute()) {		
			$answer = "Muutmine toimus edukalt";
			$_SESSION['note'] = $answer;
		} else {
		 	$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
		}
		//panen ühenduse kinni
		$stmt->close();
	}
	
	function changePassword($changePassword, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET password=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changePassword, $id);
		
		//täida käsu
		if($stmt->execute()) {
			echo "Muutmine toimus edukalt";
		} else {
		 	$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
		}
		//panen ühenduse kinni
		$stmt->close();
	}
	

	function changeEmail($changeEmail, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET email=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changeEmail, $id);
		
		//täida käsu
		if($stmt->execute()) {
			$answer = "Muutmine toimus edukalt";
			$_SESSION['note'] = $answer;
		} else {
		 	$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
		}
		//panen ühenduse kinni
		$stmt->close();
		}
		
		
	function changeFirstName($changeFirstName, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET firstname=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changeFirstName, $id);
		
		//täida käsu
		if($stmt->execute()) {
			$answer = "Muutmine toimus edukalt";
			$_SESSION['note'] = $answer;
		} else {
			$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
		}
		//panen ühenduse kinni
		$stmt->close();
	}
	
	function changeLastName($changeLastName, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET lastname=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changeLastName, $id);
		
		//täida käsu
		if($stmt->execute()) {
			$answer = "Muutmine toimus edukalt";
			$_SESSION['note'] = $answer;
		} else {
			$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
		}
		//panen ühenduse kinni
		$stmt->close();
	}
	
	
	function changeGender($changeGender, $id) {
		$stmt = $this->connection->prepare("UPDATE project_user SET gender=? WHERE id=?");
		echo $this->connection->error;
		$stmt->bind_param("si",$changeGender, $id);
		
		//täida käsu
		if($stmt->execute()) {
			$answer = "Muutmine toimus edukalt";
			$_SESSION['note'] = $answer;
		} else {
			$answer = "ERROR ".$stmt->error;
			$_SESSION['note'] = $answer;
	}
		//panen ühenduse kinni
		$stmt->close();
	}

}
?>