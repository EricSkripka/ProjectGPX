<?php

require("../../../config.php");
//see vail peab olema kõigil lehtedel, kus tahan kasutada session muutujat

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$database = "if16_mattbleh_2";
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

require("../class/Helper.class.php");
$Helper = new Helper();

?>