<?php
class comment {
	private $connection;
			
		function __construct($mysqli){
			
			$this->connection = $mysqli;
		}	
	
	function savecomment($userid, $fail, $comment) {
		$stmt = $this->connection->prepare("INSERT INTO project_kommentaar (user_id, mapname, comment) VALUES (?, ?, ?)");
		echo $this->connection->error;
		$stmt->bind_param("iss",$userid, $fail, $comment);
		
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
	}
	
	function get() {

	$stmt = $this->connection->prepare("
			SELECT userid, comment
			FROM project_kommentaar WHERE mapname=?
			
		");
			$stmt->bind_param("s", $fail);
			$stmt->bind_result($userid, $comment);
			$stmt->execute();
			echo $this->connection->error;
					
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$somments = new StdClass();
			
			$somments->user_id = $userid;
			$somments->comment = $comment;

			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $somments);
		}
		
		$stmt->close();
		
		
		return $result;
	}
	

}
?>