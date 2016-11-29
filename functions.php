<?php

require_once("../../config.php");
//see vail peab olema kõigil lehtedel, kus tahan kasutada session muutujat
$database = "if16_mattbleh_2";
session_start();
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
require("User.class.php");
require("Helper.class.php");
$User = new User($mysqli);
$Helper = new Helper($mysqli);
$database = "if16_mattbleh_2";



//************
//***Signup***
//************




	
function run($userName, $o_course, $distance, $duration, $maxSpeed, $avgSpeed){
	//echo $serverUsername;
	//Ühendus
	$database = "if16_mattbleh_2";

		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		// mysqli rida
		$stmt = $mysqli->prepare("INSERT INTO project_run (name, course, distance, duration, max_speed, avg_pace, date) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
		echo $mysqli->error;
		// stringina üks täht iga muutuja kohta (?), mis t??t
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("sidddd",$userName, $o_course, $distance, $duration, $maxSpeed, $avgSpeed);
		
		//täida käu
		if($stmt->execute()) {
			echo "Salvestamine õnnestus";
			
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		//panen Ühenduse kinni
		$stmt->close();
		$mysqli->close();
	}
	
	//$searching
	

function getRun($searching, $sort, $direction){
	$database = "if16_mattbleh_2";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
	$allowedSortOptions = ["id", "name", "course"];
	
	if(!in_array($sort, $allowedSortOptions)){
			$sort = "id";
		}
		echo "Sorteerin: ".$sort." ";
	
	$orderBy= "ASC";
		if($direction == "descending"){
			$orderBy= "DESC";
		}
		echo "Järjekord: ".$orderBy." ";
	
	if($searching == "") {
		echo "Ei otsi";
	$stmt = $mysqli->prepare ("SELECT id, name, course, distance, duration, max_speed, avg_pace, date FROM project_run WHERE deleted is NULL ORDER BY $sort $orderBy");
	}else{
		echo "Otsib";
		$searchword = "%".$searching."%";
		$stmt = $mysqli->prepare ("SELECT id, name, course, distance, duration, max_speed, avg_pace, date FROM project_run WHERE deleted is NULL 
								   AND (name LIKE ? OR course LIKE ?) ORDER BY $sort $orderBy");
	//OR course LIKE ? OR distance LIKE ? OR duration LIKE ? OR max_speed LIKE ? OR avg_pace LIKE ?
		$stmt->bind_param("ss", $searchword, $searchword);
		}
	$stmt->bind_result($id, $userName, $o_course, $distance, $duration, $maxSpeed, $avgSpeed, $date);
	$stmt->execute();
	
	//tekitan massiivi
	$result = array();	
	
	
	//tee seda seni, kuni on rida andmeid, mis vastab select lausele
	while($stmt->fetch()) {
	//tekitan objekti
		$run = new StdClass();
		
		$run->id = $id;
		$run->userName = $userName;
		$run->o_course = $o_course;
		$run->distance = $distance;
		$run->duration = $duration;
		$run->maxSpeed = $maxSpeed;
		$run->avgSpeed = $avgSpeed;
		$run->date = $date;
		
		
		#echo $plate."<br>";
		//iga korda massiivi lisan juurde numbrimärgi
		array_push($result, $run);
	}
$stmt->close();
$mysqli->close();	
return $result;
}

	
	
 	
 function getSinglerun($edit_id){
     
        $database = "if16_mattbleh_2";
 
 	//echo "id on ".$edit_id;
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		
 $stmt = $mysqli->prepare("SELECT course, distance, duration, max_speed, avg_pace FROM project_run WHERE id = ? ");
 		
		echo $mysqli->error;
		
		$stmt->bind_param("i", $edit_id);
 		$stmt->bind_result($o_course, $distance, $duration, $maxSpeed, $avgSpeed);
 		$stmt->execute();
 		
 		//tekitan objekti
 	$run = new Stdclass();
 		
 		//saime ühe rea andmeid
 		if($stmt->fetch()){
 		// saan siin alles kasutada bind_result muutujaid
 			
			$run->o_course = $o_course;
 			$run->distance = $distance;
			$run->duration = $duration;
			$run->maxSpeed = $maxSpeed;
			$run->avgSpeed = $avgSpeed;
 			
 			
 		}else{
 		// ei saanud rida andmeid kätte
 			// sellist id'd ei ole olemas
 			// see rida võib olla kustutatud
 			header("Location: data.php");
 			exit();
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 		return $run;
 		
 	}
 
 
 	function updateRun($id, $o_course, $distance, $duration, $maxSpeed, $avgSpeed){
     	
         $database = "if16_mattbleh_2";
 
 		
 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
 		echo $mysqli->error;
 		$stmt = $mysqli->prepare("UPDATE project_run SET course = ?, distance = ?, duration = ?, max_speed = ?, avg_pace = ? WHERE id = ?");
    	$stmt->bind_param("iddddi", $o_course, $distance, $duration, $maxSpeed, $avgSpeed, $id);
 		echo $mysqli->error;
 		// kas õnnestus salvestada
 		if($stmt->execute()){
 			// õnnestus
 			echo "salvestus õnnestus!";
 		}
 		
 		$stmt->close();
 		$mysqli->close();
 		
 	}
	

 	
?>