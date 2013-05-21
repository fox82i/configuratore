<?php

$dbhost = "localhost";
$dbuser = "opalwgb1_drop";
$dbpass = "dropdown";
$dbname = "opalwgb1_dropdown";

// -- do not edit below this line -- 

// connect using PDO
try { // attempt to create a connection to database
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
}
catch(PDOException $e) { // if it fails, we echo the error and die.
	echo $e->getMessage();
	die();
}

?>
