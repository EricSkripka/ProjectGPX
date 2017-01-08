<?php 
class Interest {

	private $connection;

	function __construct($mysqli){
		$this->connection = $mysqli;
	}

	function get() {
			$stmt = $this->connection->prepare("SELECT id, interest	FROM project_intrests");
			echo $this->connection->error;
			
			$stmt->bind_result($id, $interest);
			$stmt->execute();
			
			//teen massiivi
			$result = array();
		
			// tee seda seni, kuni on rida andmeid mis vastab select lausele
			while ($stmt->fetch()) {
				//tekitan objekti
				$i = new StdClass();
				$i->id = $id;
				$i->interest = $interest;
				array_push($result, $i);
			}
			$stmt->close();
			return $result;
		}
		
	function getUser() {
		
		$stmt = $this->connection->prepare("SELECT interest FROM project_intrests JOIN project_user_interests ON project_intrests.id=project_user_interests.interest_id WHERE project_user_interests.user_id = ?");
		echo $this->connection->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		$stmt->bind_result($interest);
		$stmt->execute();
		
		$result = array();

		while ($stmt->fetch()) {	
			$i = new StdClass();
			$i->interest = $interest;
			array_push($result, $i);
		}
		$stmt->close();
		return $result;
	}
		
	function save ($interest) {
		
		$stmt = $this->connection->prepare("INSERT INTO project_intrests (interest) VALUES (?)");
		echo $this->connection->error;
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			$answer = "Salvestamine õnnestus.";
			$_SESSION['note'] = $answer;
		} else {
			echo "ERROR ".$stmt->error;
		}
		$stmt->close();
	}
		
	function saveUser ($interest) {

		$stmt = $this->connection->prepare("SELECT id FROM project_user_interests WHERE user_id=? AND interest_id=? ");
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if ($stmt->fetch()) {
			// oli olemas juba selline rida
			$answer2 = "Te juba tegelete selle hobiga.";
			$_SESSION['note2'] = $answer2;
			// pärast returni midagi edasi ei tehta funktsioonis
			return;
		} 
		
		$stmt->close();
		// kui ei olnud siis sisestan
		$stmt = $this->connection->prepare("
			INSERT INTO project_user_interests (user_id, interest_id) VALUES (?, ?)");
		echo $this->connection->error;
		$stmt->bind_param("ii", $_SESSION["userId"], $interest);
		
		if ($stmt->execute()) {
			$answer2 = "Salvestamine õnnestus.";
			$_SESSION['note2'] = $answer2;
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
}

?>