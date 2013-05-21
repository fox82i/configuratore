<?php
// list of printer types for specific manufacturer
include("dbconfig.inc.php");

header("Content-type: text/xml");

$manid = $_POST['man'];

echo "<?xml version=\"1.0\" ?>\n";
echo "<printertypes>\n";
$select = "SELECT type_id, type_text FROM printer_types WHERE man_id = '".$manid."'";
try {
	foreach($dbh->query($select) as $row) {
		echo "<Printertype>\n\t<id>".$row['type_id']."</id>\n\t<name>".$row['type_text']."</name>\n</Printertype>\n";
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
echo "</printertypes>";
?>