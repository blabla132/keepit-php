<?php

error_reporting(0);

// DEFINE FUNCTIONS
function get_random_string($valid_chars, $length) {
    $random_string = "";
    $num_valid_chars = strlen($valid_chars);
    for ($i = 0; $i < $length; $i++) {
        $random_pick = mt_rand(1, $num_valid_chars);
        $random_char = $valid_chars[$random_pick-1];
        $random_string .= $random_char;
    }
    return $random_string;
}

session_start();
include("../auth.inc.php");
$id = get_random_string("ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789", 50);
$permitted = array(
	'doc','docx','log','msg','odt','pages','rtf','tex','txt','wpd','wps',
	'csv','dat','gbr','ged','ibooks','key','keychain','pps','ppt','pptx','sdf','tar','vcf','xml',
	'aif','iff','m3u','m4a','mid','midi','mp3','mpa','ra','wav','wma',
	'3g2','3gp','asf','asx','avi','flv','mov','mp4','mpg','rm','srt','swf','vob','wmv',
	'3dm','3ds','max','obj',
	'bmp','dds','gif','jpg','png','psd','pspimage','tga','thm','tif','tiff','yuv',
	'ai','eps','ps','svg',
	'indd','pct','pdf',
	'xlr','xls','xlsx',
	'accdb','db','dbf','mdb','pdb','sql',
	'apk','app','bat','cgi','com','exe','gadget','jar','pif','vb','wsf',
	'dem','gam','nes','rom','sav',
	'dwg','dxf',
	'gpx','kml',
	'asp','aspx','cer','cfm','csr','css','htm','html','js','jsp','php','rss','xhtml',
	'crx','plugin',
	'fnt','fon','otf','ttf',
	'cab','cpl','cur','deskthemepack','dll','dmp','drv','icns','ico','lnk','sys',
	'cfg','ini','prf',
	'hqx','mim','uue',
	'7z','cbr','deb','gz','pkg','rar','rpm','sit','sitx','zip','zipx',
	'bin','cue','dmg','iso','mdf','toast','vcd',
	'asm','c','class','cpp','cs','dtd','fla','h','java','lua','m','pl','py','sh','sln','vcxproj','xcodeproj',
	'bak','tmp',
	'crdownload','ics','msi','part','torrent',
	'scribe',
);
// print_r ( $permitted);
if ($_SESSION['logged'] == 1 && isset($_FILES['uploaded'])) {
	$username = $_SESSION['username'];
    $query2 = mysql_query("select * from `lexis_docbank` where owner = '" . $_SESSION['username'] . "'") or die("Error: " . mysql_error());
    $usage = 0;
    while ($row2 = mysql_fetch_array($query2)) {
        $fileLoc  = "files/" . $row2['id'] . "." . $row2['type'];
		if ($row2['type']!="lexis_directory") {
			$fileSize = filesize($fileLoc);
			$usage += $fileSize;
		}
    }
    $err = "";
    
    if (!isset($_POST['uploaded'])) {
        $err = "No file uploaded.";
    }
	
	$use_dir = $_SESSION['current_dir'];
	echo "Directory: ".$use_dir."<br />";
    
    define("MAX_FILE_SIZE", 1024 * 1024 * 50);
    define("UPLOAD_DIR", "files/");
    $type = strtolower(end(explode('.', $_FILES['uploaded']['name'])));
    $file = $id . "." . $type;
    echo "Destination file: " . $file;
	echo "<p>Wow! ".count($permitted)." extensions supported! <a href='mailto:mzhang@anixospecifications.com' target='_blank'>Request more extensions</a></p>";
    if (in_array($type,$permitted) && $_FILES['uploaded']['size'] > 0 && $_FILES['uploaded']['size'] <= MAX_FILE_SIZE) {
        switch ($_FILES['image']['error']) {
            case 0:
                if (!file_exists(UPLOAD_DIR . $file)) {
                    $success = move_uploaded_file($_FILES['uploaded']['tmp_name'], UPLOAD_DIR . $file);
                } else {
                    unlink(UPLOAD_DIR . $file);
                    $success = move_uploaded_file($_FILES['uploaded']['tmp_name'], UPLOAD_DIR . $file);
                }
                if ($success) {
                    $result = "Your file was uploaded.<br /><a href='index.php'>&laquo; Back to LEXIS</a><script type='text/javascript'>location.href='index.php';</script>";
                    $pieces = explode('.', $_FILES['uploaded']['name']);
                    $query = mysql_query("insert into lexis_docbank (id,title,container,owner,type,dateMod) values('$id','" . $pieces[0] . "','$use_dir','$username','" . $type . "',NOW())") or die("Can't connect: " . mysql_error());
                } else {
                    $result = "Error uploading your file. Please try again. If this problem persists, contact ANIXO Specifications and we will try to help you.";
                }
                break;
            case 8:
                $result = "Error uploading your file. Please try again. If this problem persists, contact ANIXO Specifications and we will try to help you.";
                break;
            case 4:
                $result = "You didn't upload a file.";
                break;
            default:
                break;
        }
    } else {
        $result = "Your file is either too big or is not a file of the specified upload types.";
    }
}
if (isset($result)) {
    echo "<p><b>$result</b></p>";
}
?>
<link rel="stylesheet" href="../page.css" />