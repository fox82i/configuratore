<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "i19691982!D";
$dbname = "configuratore";

// -- do not edit below this line -- 

// connect using PDO
try { // attempt to create a connection to database
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) { // if it fails, we echo the error and die.
	echo $e->getMessage();
	die();
}

?>
