<?php

error_reporting(0);

include ("../../auth.inc.php");
$id = $_POST['ID'] or die ("Error: No variable given.");

$query = mysql_query("select * from `lexis_docbank` where id='" . $id . "'") or die ("Error: File not found.");
$row = mysql_fetch_array($query);

echo $row['title'];

?>