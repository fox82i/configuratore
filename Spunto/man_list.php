<?php
// manufacturer_list
include("dbconfig.inc.php");

header("Content-type: text/xml");
echo "<?xml version=\"1.0\" ?>\n";
echo "<companies>\n";
$select = "SELECT * FROM manufacturers";
try {
	foreach($dbh->query($select) as $row) {
		echo "<Company>\n\t<id>".$row['man_id']."</id>\n\t<name>".$row['man_name']."</name>\n</Company>\n";
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
echo "</companies>";
?>