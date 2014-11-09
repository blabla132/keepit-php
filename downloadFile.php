<?php

$id=$_POST['id'] or die("No id");
$type=$_POST['type'] or die("No type");
$title=$_POST['title'] or die("No title");

copy("files/".$id.".".$type,"temp/".$title.".".$type) or die("NONONONONONONONOO DON'T TOUCH THE FILES");

$file = "temp/".$title.".".$type;

switch(strtolower(substr(strrchr($file, '.'), 1))) {
	case 'pdf': $mime = 'application/pdf'; break;
	case 'zip': $mime = 'application/zip'; break;
	case 'jpeg':
	case 'jpg': $mime = 'image/jpg'; break;
	default: $mime = 'application/force-download';
}
header('Pragma: public'); 	// required
header('Expires: 0');		// no cache
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
header('Cache-Control: private',false);
header('Content-Type: '.$mime);
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.filesize($file));	// provide file size
header('Connection: close');
readfile($file);		// push it out
exit();

?>