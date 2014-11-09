<?php
// error_reporting (0);
include ("../auth.inc.php");
if ($_GET['switchDir']) {
    $_SESSION['current_dir'] = $_GET['switchDir'];
    echo "<script type='text/javascript'>location.href='index.php';</script>";
}
// DEFINE FUNCTIONS
function get_random_string($valid_chars, $length)
{
    $random_string   = "";
    $num_valid_chars = strlen($valid_chars);
    for ($i = 0; $i < $length; $i++) {
        $random_pick = mt_rand(1, $num_valid_chars);
        $random_char = $valid_chars[$random_pick - 1];
        $random_string .= $random_char;
    }
    return $random_string;
}
function filesize_format($size, $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'))
{
    if ($size == 0)
        return ('');
    return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $sizes[$i]);
}

$username = $_SESSION['username'];
$query = mysql_query("select * from `users` where username = '$username'") or die("Error: " . mysql_error());
$row = mysql_fetch_array($query);
if (!isset($row['lexis_dir']) || strlen($row['lexis_dir']) < 51) {
    $k = get_random_string("ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789", 51);
    mysql_query("update `users` set lexis_dir = '" . $k . "' where username = '$username'") or die("Error: " . mysql_error());
}
if (!isset($_SESSION['lexis_view'])) {
	$_SESSION['lexis_view'] = "icon";
}
?>
<html>
	<head>
		<title>LEXIS Cloud Office</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        <link rel="icon" href="../images/lexis.png" />
		<link rel="stylesheet" href="../page.css" />
        <link rel="stylesheet" href="dtree.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
        <script src="dtree.js" type="text/javascript"></script>
        
        <style type="text/css">
			#container {
				overflow:hidden;
			}
			#topbar {
				width:100%;
				position:absolute;
				left:0px;
				margin:none;
				padding:none;
				z-index:104;
			}
			#topbar a.btn {
				display:inline-block;
				padding:15px 30px 15px 30px;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
			}
			#topbar a.btn:hover {
				text-decoration:none;
			}
			#searchBar {
				width:100%;
				position:absolute;
				left:0px;
			}
			#searchBar #search {
				width:100%;
				height:100%;
				font-family:'Roboto', Arial, Helvetica;
				font-weight:300;
				font-size:15pt;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				border:none;
				outline:none;
			}
			#searchBar #search:focus {
				box-shadow:none;
			}
			#navTree {
				position:absolute;
				left:0px;
				width:30%;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				overflow:auto;
				margin:0px;
			}
			#mainContent {
				position:absolute;
				right:0px;
				width:70%;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				overflow:auto;
				margin:0px;
			}
			.fileNode {
				display:inline-block;
				cursor:pointer;
				width:35%;
				height:60px;
				padding-top:10px;
				padding-bottom:15px;
				padding-left:80px;
				border:1px solid #999;
				/* box-shadow:0px 3px 5px #999; */
				margin:5px;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
				overflow:hidden;
				float:left;
			}
			.fileNode:hover {
				background-color:#FDFDFD;
				/* box-shadow:0px 3px 5px #666; */
			}
			.fileNode:active {
				background-color:#DFDFDF;
				/* box-shadow:0px 3px 5px #333; */
			}
			.nodeDirectory {
				background-image:url(images/folder.png);
				background-repeat:no-repeat;
				background-size:80px;
			}
			.nodeFile {
				background-image:url(images/files.png);
				background-repeat:no-repeat;
				background-size:80px;
			}
			.fileNode span {
				font-size:16pt;
				display:block;
			}
			#menu {
				width:450px;
				position:absolute;
				left:0px;
				background-color:#EEE;
				z-index:100;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
				box-shadow:0px 5px 10px #666;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
			}
			#menu a.btn {
				width:100%;
				display:block;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:10px;
				background-color:#E0E0E0;
				margin-bottom:10px;
				box-shadow:inset 0px 3px 5px #999;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
			}
			#menu a.btn:hover {
				box-shadow:inset 0px 3px 5px #666;
				background-color:#FAFAFA;
				text-decoration:none;
			}
			#menu a.btn:active {
				background-color:#C2C2C2;
			}
			.dialog {
				position:fixed;
				top:0px;
				left:0px;
				display:none;
				z-index:240;
			}
			.dialog .mask {
				width:100%;
				height:100%;
				background-color:#FFF;
				opacity:0.5;
				position:fixed;
				top:0px;
				left:0px;
				z-index:249;
			}
			.dialog .window {
				z-index:251;
				position:absolute;
				top:0px;
				left:0px;
				background-color:#EEE;
				border:1px solid #000;
				padding:15px;
				box-shadow:0px 5px 5px #999;
			}
			.newDialogInnerBtn {
				display:block;
				text-align:center;
			}
			.newDialogInnerBtn:hover {
				text-decoration:none;
			}
			#searchResults {
				position:absolute;
				left:30px;
				z-index:105;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
				box-shadow:0px 5px 10px #666;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				background-color:#EEE;
			}
			#searchResults #results {
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				width:100%;
				height:100%;
				overflow:auto;
				z-index:67;
			}
			#searchResults #closeBtn {
				z-index:68;
				position:absolute;
				right:50px;
				top:10px;
				width:30px;
				height:30px;
				cursor:pointer;
			}
			#previewPane {
				z-index:110;
				position:absolute;
				left:-30%;
				width:30%;
				box-sizing:border-box; -moz-box-sizing:border-box;
				padding:15px;
				overflow:auto;
				margin:0px;
				display:block;
				background-color:#EEE;
				transition:all .3s ease-out;
				-o-transition:all .3s ease-out;
				-ms-transition:all .3s ease-out;
				-moz-transition:all .3s ease-out;
				-webkit-transition:all .3s ease-out;
				border-right:3px solid #999;
			}
			#previewPane #closeBtn {
				z-index:111;
				position:absolute;
				width:25px;
				height:25px;
				cursor:pointer;
				right:10px;
				top:10px;
			}
		</style>
	</head>
	
	<body>
		
		<div id="container">
			
			<?php include ("../header.php"); if ($_SESSION['logged']==1) { ?>
                  
			<?php
                /*
                PROCEDURE:
                1. CHECK WHICH DIRECTORY WE ARE CURRENTLY VIEWING
                2. GO THROUGH THE ENTIRE CLOUD SERVER
                3a. CHECK FOR PERMISSIONS
                3b. RETURN THE FILES THAT ARE IN THE CONTAINING FOLDER
                4. ARRANGE THE FILES IN A CERTAIN ORDER
                5. DISPLAY TO THE USER IN A NEAT, ORGANIZED METHOD.
                */
                // STEP 1
                $current_dir             = (isset($_SESSION['current_dir'])) ? $_SESSION['current_dir'] : $row['lexis_dir'];
                $_SESSION['current_dir'] = $current_dir;
                // STEP 2
                $fquery = mysql_query("select * from `lexis_docbank` where container = '$current_dir'") or die("Error: " . mysql_error());
                $files      = array();
                $totalfiles = array();
                while ($frow = mysql_fetch_array($fquery)) {
                    array_push($totalfiles, $frow);
                    /*
                    CONDITIONS:
                    1. IT MUST BE IN THE CONTAINING FOLDER
                    2. ITS OWNER IS THE USER || THE USER IS AN EDITOR || THE USER IS A VIEWER
                    */
                    $val = false;
                    if ($frow['owner'] == $username) {
                        $val = true;
                    }
                    if ($frow['container'] != $current_dir) {
                        $val = false;
                    }
                    if ($val) {
                        array_push($files, $frow);
                    }
                }
                // STEP 3a
				$cDir = "";
				if ($_SESSION['current_dir'] == $row['lexis_dir']) {
					$cDir = "<a href='index.php'>My Cloud</a>";
				} else {
					/* $nowdir = "[unknown directory]";
					$upperDirectory = "";
					$upperName = "";
					$fquery = mysql_query("select * from `lexis_docbank`") or die("Error: " . mysql_error());
					while ($frow = mysql_fetch_array($fquery)) {
						if ($frow['id'] == $_SESSION['current_dir']) {
							$nowdir = $frow['title'];
							$upperDirectory = $frow['container'];
						}
					}
					if ($upperDirectory == $row['lexis_dir']) {
						$upperName = "My Cloud";
					} else {
						$fquery = mysql_query("select * from `lexis_docbank`") or die("Error: " . mysql_error());
						while ($frow = mysql_fetch_array($fquery)) {
							if ($frow['id'] == $upperDirectory) {
								$upperName = $frow['title'];
							}
						}
					}
					$cDir = (($upperDirectory != $row['lexis_dir'])?"... ":"") . "<a href='index.php?switchDir=" . $upperDirectory . "'>" . $upperName . "</a> &raquo; <a href='index.php'>" . $nowdir . "</a>"; */
					$nowdir = "[unknown directory]";
					$fquery = mysql_query("select * from `lexis_docbank` where id='".$_SESSION['current_dir']."'") or die("Error: " . mysql_error());
					while ($frow = mysql_fetch_array($fquery)) {
						$nowdir = $frow['title'];
					}
					if ($_SESSION['current_dir']==$row['lexis_dir']) {
						$cDir = "<a href='index.php?switchDir=" . $row['lexis_dir'] . "'>My Cloud</a>";
					} else {
						$cur = $_SESSION['current_dir'];
						$cDir = "<a href='index.php?switchDir=" . $cur . "'>" . $nowdir . "</a>";
						$upperDirectory = "";
						$upperName = "";
						$cName = "";
						while ($cur != $row['lexis_dir']) {
							$fquery = mysql_query("select * from `lexis_docbank` where id='".$cur."'") or die("Error: " . mysql_error());
							$frow = mysql_fetch_array($fquery);
							$cName = $frow['title'];
							$upperDirectory = $frow['container'];
							$fquery = mysql_query("select * from `lexis_docbank` where id='".$upperDirectory."'") or die("Error: " . mysql_error());
							$frow = mysql_fetch_array($fquery);
							$upperName = $frow['title'];
							$cDir = "<a href='index.php?switchDir=" . $upperDirectory . "'>" . $upperName . "</a> &raquo; " . $cDir;
							$cur = $upperDirectory;
						}
						$cDir = "<a href='index.php?switchDir=" . $row['lexis_dir'] . "'>My Cloud</a> " . $cDir;
					}
					// echo "Current directory: <b>" . $nowdir . "</b> (<a href='index.php?switchDir=" . $upperDirectory . "'>Back to " . $upperName . "</a>)";
				}
				echo "<br />";
				
				function getLink($id, $ext) {
					if ($ext == "scribe") {
						return "apps/scribe.php?doc=open&id=".$id;
					} else if ($ext == "cascade") {
						return "apps/cascade.php?doc=open&id=".$id;
					} else {
						return "files/".$id.".".$ext;
					}
					return "";
				}
            ?>
		
			<div id="searchBar">
            	<input type="text" id="search" autofocus autocomplete="off" placeholder="Search your cloud..." />
            </div>
            
            <div id="topbar">
				<a href="javascript:void(0);" id="fileBtn" class="btn color1">File</a>
                <a href="javascript:void(0);" id="actionsBtn" class="btn color6">Actions</a>
                <a href="javascript:void(0);" id="viewBtn" class="btn color6">View</a>
                &nbsp;&nbsp;&nbsp;
                <div id="navigation" style="display:inline-block;">
                	<?php echo $cDir; ?>
                </div>
            </div>
            
            <div id="navTree">
				<script type="text/javascript">
                    d = new dTree ('d');
            
                    <?php
                        $c = 1;
                        $t = array();
                        $all = array();
                
                        $root = array(
                            "id" => $row['lexis_dir'],
                            "type" => "lexis_directory",
                            "owner" => $_SESSION['username'],
                            "container" => "n/a",
                            "title" => "My Cloud",
                        );
                        array_push($t,$root);
                
                        $fquery = mysql_query("select * from `lexis_docbank`") or die("Error: " . mysql_error());
                        while ($frow = mysql_fetch_array($fquery)) {
                            array_push ($all,$frow);
                        }
                        foreach ($all as $one) {
                            if ($one['owner']==$_SESSION['username']) {
                                if ($one['type']=='lexis_directory') {
                                    array_push($t,$one);
                                }
                            }
                        }
                        for ($i=0;$i<count($t);$i++) {
                            $one = $t[$i];
                            $k = -1;
                            for ($j=0;$j<count($t);$j++) {
                                $two = $t[$j];
                                if ($two['id']==$one['container']) {
                                    $k = $j;
                                }
                            }
                            echo "d.add(".$i.",".$k.",\"".$one['title']."\",'index.php?switchDir=".$one['id']."','','','images/dTree/folder.png','images/dTree/folderOpen.png');\r\n";
                        }
                    ?>
            
                    document.write (d);
                </script>
            </div>
            
            <div id="mainContent">
                <?php
                function getIconURL($ext) {
                    $x = scandir("icons/");
                    if (in_array($ext.".png",$x)) {
                        return "icons/".$ext.".png";
                    } else {
                        return "images/file.png";
                    }
                }
                
                // ORGANIZE THE FILES
                $ids    = array();
                $titles = array();
                $sizes  = array();
                $types  = array();
                foreach ($files as $file) {
                    if ($file['type'] != "lexis_directory") {
                        $thissize = filesize("files/" . $file['id'] . "." . $file['type']);
                        array_push($ids, $file['id']);
                        array_push($titles, $file['title']);
                        array_push($sizes, $thissize);
                        array_push($types, $file['type']);
                    } else {
                        array_push($ids, $file['id']);
                        array_push($titles, $file['title']);
                        array_push($sizes, "");
                        array_push($types, $file['type']);
                    }
                }
                if (isset($_SESSION['sort']))
                    $meth = $_SESSION['sort'];
                else
                    $meth = "title";
                switch ($meth) {
                    case "title":
                        array_multisort($titles, SORT_STRING, $ids, SORT_STRING, $types, SORT_STRING, $sizes, SORT_NUMERIC);
                        break;
                    case "type":
                        array_multisort($types, SORT_STRING, $ids, SORT_STRING, $titles, SORT_STRING, $sizes, SORT_NUMERIC);
                        break;
                    case "size":
                        array_multisort($sizes, SORT_NUMERIC, $ids, SORT_STRING, $types, SORT_STRING, $titles, SORT_STRING);
                        break;
                    default:
                        array_multisort($titles, SORT_STRING, $ids, SORT_STRING, $types, SORT_STRING, $sizes, SORT_NUMERIC);
                        break;
                }
            ?>
            
            <?php if ($_SESSION['lexis_view']=='icon') { ?>
            <script type="text/javascript">
            function filesize_format(size) {
                var i = -1;
                var byteUnits = [' KB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
                do {
                    size = size / 1024;
                    i++;
                } while (size > 1024);
                return Math.max(size, 0.1).toFixed(1) +" "+ byteUnits[i];
            };
            function fileNode (id, title, type, size) {
                this.id = id;
                this.title = title;
                this.type = type;
                this.size = size;
                function str() {
                    var t = "";
                    if (this.type=="lexis_directory") { t+="<a href='index.php?switchDir="+this.id+"'>"; }
                    else { t+="<a href='files/"+this.id+"."+this.type+"' target='_blank'>"; }
                    t += "<div class='node'><h3>"+this.title+"</h3>"+filesize_format(this.size)+"</div>";
                    t += "</a>";
                    return t;
                }
            }
            </script>
            <?php
            $count = 0;
            echo "<!-- WRITING THE NODES -->";
            for ($i = 0; $i < count($files); $i++) {
                if ($types[$i] == "lexis_directory") {
                    // echo "var node".$count." = new node('".$ids[$i]."','".$titles[$i]."','".$types[$i]."','".$sizes[$i]."');";
                    $t = "";
                    $t .= "<a href='javascript:showPreviewPane(\"".$ids[$i]."\");'>"; //href='index.php?switchDir=".$ids[$i]."'>";
                    $t .= "<div class='fileNode nodeDirectory' contextmenu='menu".$i."'><span>".$titles[$i]."</span>Directory</div>";
                    $t .= "</a>\n";
                    echo $t;
                    $count++;
                }
                echo "\r\n";
            }
            for ($i = 0; $i < count($files); $i++) {
                if ($types[$i] != "lexis_directory") {
                    // echo "var node".$count." = new node('".$ids[$i]."','".$titles[$i]."','".$types[$i]."','".$sizes[$i]."');";
                    $t = "";
                    $t .= "<a href='javascript:showPreviewPane(\"".$ids[$i]."\");'>"; //href='".getLink($ids[$i],$types[$i])."' target='_blank'>";
                    $t .= "<div class='fileNode nodeFile' style='background-image:url(".getIconURL($types[$i]).");'><span>".$titles[$i]."</span>" . strtoupper($types[$i]) . " file<br />".filesize_format($sizes[$i])."</div>";
                    $t .= "</a>\n";
                    echo $t;
                    $count++;
                }
                echo "\r\n";
            }
            ?>
            
            <?php } else { ?>
            
            <div id="dblClickHint"></div>
            <table id="mainTable" style="width:80%; border-collapse:collapse;font-weight:300;">
                <tr style="background-color:#DDD;">
                    <th style="width:30px;"></th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Type</th>
                </tr>
                <?php
                    for ($i = 0; $i < count($files); $i++) {
                        if ($types[$i] == "lexis_directory") {
                            echo "<tr class='row'>";
                            echo "<td><img src='images/folder.png' alt='Folder' width='60' height='60' /></td>";
                            echo "<td style='cursor:pointer;' onclick='javascript:location.href=\"index.php?switchDir=" . $ids[$i] . "\";'>" . $titles[$i] . "</td>";
                            echo "<td></td>";
                            echo "<td>Directory</td>";
                            echo "</tr>";
                        }
                        echo "\r\n";
                    }
                    for ($i = 0; $i < count($files); $i++) {
                        if ($types[$i] != "lexis_directory") {
                            echo "<tr class='row'>";
                            echo "<td><img src='".getIconURL($types[$i])."' alt='File' width='60' height='60' /></td>";
                            echo "<td><a href='".getLink($ids[$i],$types[$i])."' target='_blank'>" . $titles[$i] . "</a></td>";
                            echo "<td>" . filesize_format($sizes[$i]) . "</td>";
                            echo "<td>" . strtoupper($types[$i]) . " file</td>";
                            echo "</tr>";
                        }
                        echo "\r\n";
                    }
            ?>
            </table>
            
            <?php } ?>
            </div>
            
            <div id="menu" style="opacity:0;"></div>
            <div id="searchResults">
            	<img src="images/closeIcon.png" id="closeBtn" />
            	<div id="results"></div>
			</div>
			
			<div id="previewPane">
				&nbsp;
			</div>
            
            <div id="uploadDialog" class="dialog">
                <div class="mask"></div>
                <div class="window">
                    <p><b>Upload File</b><a style="position:absolute; top:5px; right:5px;" href="#" class="close"><img src="images/closeIcon.png" style="width:32px;height:32px;" alt="Close" /></a></p>
                    <form action="upload.php" style="display:inline;" enctype="multipart/form-data" method="post" id="uploadForm">
                        <input type="file" name="uploaded" id="uploaded" />
                    </form>
                    <p><a class="button color2" href="javascript:$('#uploadForm').submit();">Upload</a></p>
                </div>
            </div>
            <div id="newDialog" class="dialog">
                <div class="mask"></div>
                <div class="window">
                    <p><b>Create File</b><a style="position:absolute; top:5px; right:5px;" href="#" class="close"><img src="images/closeIcon.png" style="width:32px;height:32px;" alt="Close" /></a></p>
                    <p>Choose the type of file you want to create.</p>
                    <p class="buttonGroup">
                        <a class="newDialogInnerBtn button color5" href="#" id="newDirBtn">Directory (folder)</a>
                        <a class="newDialogInnerBtn button color1" target="_blank" href="apps/scribe.php?doc=new" id="newScribeBtn">Scribe Document</a>
                        <a class="newDialogInnerBtn button color2" target="_blank" href="apps/cascade.php?doc=new" id="newCascadeBtn">Cascade Spreadsheet (EXPERIMENTAL)</a>
                    </p>
                </div>
            </div>
            <div id="newDirDialog" class="dialog">
                <div class="mask"></div>
                <div class="window">
                    <p><b>Create Directory</b><a style="position:absolute; top:5px; right:5px;" href="#" class="close"><img src="images/closeIcon.png" style="width:32px;height:32px;" alt="Close" /></a></p>
                    <p>Give your new folder a name.</p>
                    <p>
                        <form action="newdir.php" method="POST">
                            <input type="text" name="name" class="tf" autocomplete="off" />
                            <input type="submit" class="button color2" value="Create Folder!" />
                        </form>
                    </p>
                </div>
            </div>
        
			<script type="text/javascript">
				var currentMenu = "fileBtn";
				
				function showPreviewPane(id) {
					$.ajax({
						type:"POST",
						url:"ajax/previewPane.php",
						data: {id:id},
						dataType: "html",
						success: function (msg) {
							$("#previewPane").html(msg);
							$("#previewPane").css("left","0px");
						}
					});
				}
				
				function closePreviewPane() {
					$("#previewPane").css("left","-30%");
				}
			
                setInterval(function() {
					$("#searchResults").width(window.innerWidth*4/5);
					
                    $("#searchBar").css("top",$("#bars").position().top + $("#bars").height());
					$("#searchBar").css("width",window.innerWidth);
                    $("#topbar").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height());
					
					$("#searchResults").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height());
					$("#menu").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height() + $("#topbar").height());
					$("#menu").height(window.innerHeight - $("#bars").position().top - $("#bars").height() - $("#searchBar").height() - $("#topbar").height() - 50);
					
					$("#navTree").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height() + $("#topbar").height());
					$("#navTree").height(window.innerHeight - $("#bars").position().top - $("#bars").height() - $("#searchBar").height() - $("#topbar").height() - 30);
					$("#previewPane").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height() + $("#topbar").height());
					$("#previewPane").height(window.innerHeight - $("#bars").position().top - $("#bars").height() - $("#searchBar").height() - $("#topbar").height() - 30);
					$("#mainContent").css("top",$("#bars").position().top + $("#bars").height() + $("#searchBar").height() + $("#topbar").height());
					$("#mainContent").height(window.innerHeight - $("#bars").position().top - $("#bars").height() - $("#searchBar").height() - $("#topbar").height() - 30);
					
					$("#uploadDialog .window").css("left",(window.innerWidth/2-150)+"px");
					$("#uploadDialog .window").css("top",(window.innerHeight/2-125)+"px");
					$("#newDialog .window").css("left",(window.innerWidth/2-200)+"px");
					$("#newDialog .window").css("top",(window.innerHeight/2-150)+"px");
					$("#newDirDialog .window").css("left",(window.innerWidth/2-150)+"px");
					$("#newDirDialog .window").css("top",(window.innerHeight/2-125)+"px");
					$("#uploadDialog .window").css("width",300);
					$("#uploadDialog .window").css("height",250);
					$("#newDialog .window").css("width",400);
					$("#newDialog .window").css("height",300);
					$("#newDirDialog .window").css("width",300);
					$("#newDirDialog .window").css("height",250);
                });
				
				$("#search").keypress(function(e) {
					if ($("#search").val().length>0) {
						var searchTerm = $("#search").val();
						$.ajax({
							type:"POST",
							url:"ajax/searchAjax.php",
							data: {words:searchTerm},
							dataType: "html",
							success: function (msg) {
								$("#searchResults #results").html(msg);
								showResults();
							}
						});
					} else {
						hideResults();
					}
				});
				$("#searchResults #closeBtn").click(function() {
					hideResults();
				});
				
				function showResults() {
					$("#searchResults").height(window.innerHeight - $("#bars").position().top - $("#bars").height() - $("#searchBar").height() - 50);
					$("#searchResults").css("opacity",1);
					$("#searchResults").css("padding",15);
				}
				function hideResults() {
					$("#searchResults").height(0);
					$("#searchResults").css("opacity",0);
					$("#searchResults").css("padding",0);
				}
				hideResults();
				
				$("#topbar .btn").click(function () {
					if ($("#menu").css("opacity")==1 && currentMenu==$(this).attr("id")) {
						hideMenu()
					} else {
						if ($("#menu").css("opacity")==1) {
							hideMenu();
						}
						$("#menu").css("left",($(this).position().left==0)?15:$(this).position().left);
						var content = "";
						if ($(this).attr("id")=="fileBtn") {
							content = "<h2>File</h2><a href='javascript:newBtn();' class='btn'>Create File</a><a href='javascript:uploadBtn();' class='btn'>Upload File</a><a href='javascript:newDirBtn();' class='btn'>Create Folder</a><a href='javascript:location.href=\"about.php\"' class='btn'>About LEXIS</a>";
						} else if ($(this).attr("id")=="actionsBtn") {
							content = "<h2>Actions</h2><a href='javascript:deleteBtn();' class='btn'>Delete</a>";
						} else if ($(this).attr("id")=="viewBtn") {
							content = "<h2>View</h2><a href='javascript:switchViewBtn();' class='btn'>Switch to <?php echo $_SESSION['lexis_view']=="icon"?"list":"icon"; ?> view</a>";
						}
						currentMenu = $(this).attr("id");
						$("#menu").html(content);
						$("#menu").css("opacity",1);
					}
					closePreviewPane();
				});
				$(".dialog .mask").click(function() {
					$(".dialog .window").css("border","1px solid #F00");
					$(".dialog .window").css("box-shadow","0px 5px 5px #F00");
					setTimeout(function() {
						$(".dialog .window").css("border","1px solid #000");
						$(".dialog .window").css("box-shadow","0px 5px 5px #999");
					},1000);
				});
				$(".dialog .close").click(function() {
					$(".dialog").fadeOut("fast");
				});
				function hideMenu() {
					$("#menu").css("opacity",0);
					$("#menu").css("left",-1*$("#menu").width());
				}
				hideMenu();
				function uploadBtn() {
					$("#uploadDialog").fadeIn("fast");
					hideMenu();
				};
				function newBtn() {
					$("#newDialog").fadeIn("fast");
					hideMenu();
				};
				$("#newScribeBtn").click (function() {
					$(".dialog").fadeOut("fast");
				});
				$("#newCascadeBtn").click (function() {
					$(".dialog").fadeOut("fast");
				});
				function newDirBtn() {
					$(".dialog").fadeOut("fast");
					$("#newDirDialog").fadeIn("fast");
					hideMenu();
				};
				function switchViewBtn() {
					$.ajax({
						type:"POST",
						url:"ajax/switchView.php",
						data: {new_view:"<?php if ($_SESSION['lexis_view']=="icon") { echo "list"; } else { echo "icon"; } ?>"},
						dataType: "html",
						success: function (msg) {
							location.reload(true);
						}
					});
				}
				
				document.title = "<?php echo ($current_dir == $row['lexis_dir']) ? "My Cloud" : $nowdir; ?>";
            </script>
			<?php } else { ?>
            	
                You have to be signed in to use LEXIS!
                
            <?php } ?>
		
		</div>
		
	</body>
</html>