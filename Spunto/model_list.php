<?php
// list of printer types for specific manufacturer
include("dbconfig.inc.php");

header("Content-type: text/xml");
//$fp = fopen("log.txt", "a+");
$man = $_POST['man'];
$type = $_POST['typ'];
//fwrite($fp, "\$man = $man - \$typ = $typ\n");
echo "<?xml version=\"1.0\" ?>\n";
echo "<printermodels>\n";

$select = "SELECT model_id, model_text FROM printer_models WHERE man_id = '".$man."' AND type_id = '".$type."' ORDER BY model_text ASC";

try {
	foreach($dbh->query($select) as $row) {
		echo "<Printermodel>\n\t<id>".$row['model_id']."</id>\n\t<name>".$row['model_text']."</name>\n</Printermodel>\n";
		//fwrite($fp, "man = ".$man." typ = ".$typ." model = ".$row['model_text']."\n");
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
//fwrite($fp, "\n");
//fclose($fp);
echo "</printermodels>";
?>