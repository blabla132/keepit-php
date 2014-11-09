<?php

session_start();
include ("../../auth.inc.php");

if(!$_POST['id']) die("no id");
$id = $_POST['id'];
if(!$_POST['title']) die("no title");
$title = $_POST['title'];
if(!$_POST['contents']) die("no contents");
$contents = $_POST['contents'];
if(!$_POST['owner']) die("no owner");
$owner = $_POST['owner'];
if(!$_POST['dir']) die("no dir");
$dir = $_POST['dir'];

$query = mysql_query ("select * from `users` where username = '$owner'") or die ("Error: ".mysql_error());
$row = mysql_fetch_array ($query);

$password = $row['password'];

$file = "../files/".$id.".cascade";
// echo "<script>alert('".$file."');</script>";

if (file_exists($file)) {
	unlink($file);
	file_put_contents($file, $contents) or die ("Error");
	mysql_query("update lexis_docbank set title='$title' where id='$id' and owner='$owner'") or die(mysql_error());
} else {
	$query = mysql_query("insert into lexis_docbank (id,title,container,owner,type) values('$id','$title','$dir','$owner','cascade')") or die("Can't connect: ".mysql_error());
	file_put_contents($file, $contents) or die ("Error");
}

/*$fh = fopen($file, 'w');
fwrite($fh, $contents);
fclose($fh);*/


echo "All changes saved!";

?>