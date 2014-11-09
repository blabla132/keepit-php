<?php

session_start();
$nv = $_POST['new_view'] or die ("No variable given.");
$_SESSION['lexis_view'] = $nv;

echo "Done.";

?>