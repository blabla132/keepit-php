<?php

include ("../../auth.inc.php");
$id = $_POST['ID'] or die ("Error: no variable given.");

mysql_query("delete from `lexis_docbank` where id='".$id."'") or die ("Error: couldn't delete ");

?>
hai