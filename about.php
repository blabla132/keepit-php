<?php
function getDirectorySize($directory)
{
	$dirSize=0;
	
	if(!$dh=opendir($directory))
	{
		return false;
	}
	
	while($file = readdir($dh))
	{
		if($file == "." || $file == "..")
		{
			continue;
		}
		
		if(is_file($directory."/".$file))
		{
			$dirSize += filesize($directory."/".$file);
		}
		
		if(is_dir($directory."/".$file))
		{
			$dirSize += getDirectorySize($directory."/".$file);
		}
	}
	
	closedir($dh);
	
	return $dirSize;
}

function filesize_format($size, $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'))
{
    if ($size == 0) return('n/a');
    return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $sizes[$i]);
}
function daysAgo($str) { $now=time();
$your_date=strtotime($str); $datediff=$now - $your_date; return floor($datediff/(60*60*24)); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../page.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<title>About LEXIS</title>
<style>
body {
	overflow-x:hidden;
}
#features {
	width:100%;
}
#features tr td {
	width:50%;
}
#features tr td img {
	width:100%;
}
#features tr {
	box-shadow:inset 0px 2px 2px #AAA;
}
#features tr td .title {
	font-size:28pt;
	display:inline-block;
	width:70%;
}
#features tr td .text {
	display:block;
	font-size:15pt;
}
#goToLEXISNow {
	position:fixed;
	bottom:10px;
	right:-250px;
	padding:20px;
	z-index:1000;
	transition:all .3s ease-out;
	-o-transition:all .3s ease-out;
	-ms-transition:all .3s ease-out;
	-moz-transition:all .3s ease-out;
	-webkit-transition:all .3s ease-out;
}
#goToLEXISNow .button {
	box-shadow:0px 5px 5px #000;
}
#bottombar {
	width:100%;
	margin:none;
	background-color:#118821;
	padding:10px 10px 10px 10px;
	text-align:center;
	color:#FFF;
	position:relative;
	left:-10px;
	margin-top:17px;
}
</style>
</head>

<body>
<div id="container">
<?php include ("../header.php"); ?>
<center><span style="font-size:32pt;display:block;">LEXIS Cloud Office</span>
<span style="display:block;">A new dimension of cloud computing.</span></center>
<table id="features">
	<tr>
		<td>
			<span class="title">Take your files with you ... everywhere.<br /><br /></span>
			<span class="text">With the new cloud computing technology of now, you can carry your files from one place to another with great ease. With a click of a button, your files will be saved not only on your work computer, but also your home computer, your phone, your tablet, or whatever other device you use. All your files are saved on our servers safely, you can access them whenever you want... wherever you want.</span>
		</td>
		<td><img src="images/about/take_your_files_with_you.png" /></td>
	</tr><tr>
		<td><img src="images/about/accidents_happen.png" /></td>
		<td>
			<span class="title">Accidents happen, and you lose your files ... or not?<br /><br /></span>
			<span class="text">Your files are always safe. Don't ever worry about losing your files again when you have an accident. When you get a new device, simply install the new LEXIS app, and then all your files are back! </span>
		</td>
	</tr><tr>
		<td>
			<span class="title">Easy-to-use, intuitive, built-in apps!<br /><br /></span>
			<span class="text">At this point, you must be thinking "Office apps? In your browser? You must be kidding!" Nope, we're not. We're totally serious about this. You get the full features of apps like Microsoft Word, PowerPoint, Excel, etc. all in the convenience of your browser. Never have to worry about buying office apps again!</span>
		</td>
		<td><img src="images/about/easy_to_use_intuitive.png" /></td>
	</tr><tr>
		<td><img src="images/about/free.png" /></td>
		<td>
			<span class="title">Free ... ? It can't be!<br /><br /></span>
			<span class="text">It's true. Once you sign up for an ANIXO account, you get 10 gigabytes of free storage. You can use this storage however you want, and you can also expand this space! Simply buy another LEXIS Office Floorplan and you'll have more space in no time!</span>
		</td>
	</tr><tr>
		<td>
			<span class="title">Stats? Just for curious people.<br /><br /></span>
			<span class="text">So far, we are storing a total of <?php $total = getDirectorySize("files/"); echo filesize_format ($total); ?>. We started this project close to the start of ANIXO Specifications, estimated to be around August 28, 2012 (<?php echo daysAgo ("2012-8-28"); ?> days ago).</span>
		</td>
		<td><img src="images/about/stats.png" /></td>
	</tr>
</table>
<div id="bottombar">
	LEXIS &copy; 2012-<?php echo date("Y"); ?> by Michael Zhang, ANIXO Specifications.
</div>
<div style="position:fixed;top:5px;left:15px;" id="disp"></div>
<div id="goToLEXISNow">
	<a class="button color2" href="index.php">Go to your LEXIS cloud now! &raquo;</a>
</div>
<script type="text/javascript">
$("#container").scroll(function() {
	if(Math.abs($("#container").scrollTop())>40) {
		$("#goToLEXISNow").css("right","0px");
	}
});
</script>
</div>
</body>
</html>