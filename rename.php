<?php

include ("../auth.inc.php");
$id = $_POST['renameFormItem'] or die ("Error: no variable given.");
$nName = $_POST['name'] or die ("Error: no variable given.");

mysql_query("update `lexis_docbank` set title='".$nName."' where id='".$id."'") or die ("Error: couldn't rename ");

?>

<script>
location.href="index.php";
</script>