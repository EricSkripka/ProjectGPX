<?php
class comment {
	private $connection;
			
		function __construct($mysqli){
			$this->connection = $mysqli;
		}	
	
	function saveComment($userid, $fail, $comment) {
		$stmt = $this->connection->prepare("INSERT INTO project_kommentaar (user_id, mapname, comment) VALUES (?, ?, ?)");
		echo $this->connection->error;
		$stmt->bind_param("iss",$userid, $fail, $comment);
		
		if($stmt->execute()) {
			$answerComment = "Kommentaari salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
	}
	
	function getComment($fail) {
	$stmt = $this->connection->prepare("
			SELECT username, comment FROM project_kommentaar JOIN project_user on project_user.id=project_kommentaar.user_id WHERE mapname=?");
			$stmt->bind_param("s", $fail);
			$stmt->bind_result($username, $comment);
			$stmt->execute();
			echo $this->connection->error;
					
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$somments = new StdClass();
			
			$somments->username = $username;
			$somments->comment = $comment;
			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $somments);
		}
		$stmt->close();
		return $result;
	}
}
?>