<?php

error_reporting(0);

function slash () {
	$dir = substr(getcwd(),strlen("/homepages/21/d438744504/htdocs/wsb7089376101/v3"));
	for ($i=0;$i<substr_count($dir,"/");$i++) {
		echo "../";
	}
}

include ("../../auth.inc.php");
$id = $_POST['id'] or die ("No variable given.");

?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../page.css" />
	
<img src="images/closeIcon.png" id="closeBtn" onclick="javascript:closePreviewPane();" />

<?php

$query = mysql_query("select * from users where username='".$_SESSION['username']."'");
$row = mysql_fetch_array($query);
$lexis_dir = $row['lexis_dir'];

$query = mysql_query("select * from `lexis_docbank` where id='" . $id . "'");
$row = mysql_fetch_array($query);

function filesize_of_folder($id) {
	$filesize = 0;
	$fquery = mysql_query("select * from lexis_docbank where container='" . $id . "'");
	while ($frow = mysql_fetch_array($fquery)) {
		if ($frow['type']=="lexis_directory") {
			$filesize += filesize_of_folder($frow['id']);
		} else {
			$filesize += filesize("../files/".$frow['id'].".".$frow['type']);
		}
	}
	return $filesize;
}

if (isset($row['id']) && strlen($row['id'])>1) {

	if ($row['type'] != "lexis_directory") {
		$filesize = filesize("../files/".$id.".".$row['type']);
	} else {
		$filesize = filesize_of_folder($row['id']);
	}
	
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
	function getIconURL($ext) {
		if ($ext=="lexis_directory") {
			return "images/folder.png";
		} else {
			$x = scandir("../icons/");
			if (in_array($ext.".png",$x)) {
				return "icons/".$ext.".png";
			} else {
				return "images/file.png";
			}
		}
	}
	function filesize_format($size) {
		$i = -1;
		$byteUnits = array(' KB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB');
		do {
			$size = $size / 1024;
			$i++;
		} while ($size > 1024);
		return round(max($size, 0.1),1) ." ". $byteUnits[$i];
	};
	
	?>
	
	<table id="toptable" style="border:none; width:100%;">
		<tr>
			<td id="icon"><img src="<?php echo getIconURL($row['type']); ?>" width="1" height="1" /></td>
			<td id="desc">
				<?php if ($row['type']=="lexis_directory") { ?>
					<a href="index.php?switchDir=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
				<?php } else { ?>
					<form action="downloadFile.php" id="downloadForm" method="POST">
						<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
						<input type="hidden" name="type" value="<?php echo $row['type']; ?>" />
						<input type="hidden" name="title" value="<?php echo $row['title']; ?>" />
						<a href="javascript:$('#downloadForm').submit();"><?php echo $row['title'].".<span style='color:#999;'>".$row['type']."</span>"; ?></a>
					</form>
				<?php } ?>
				
				<!--<h3><?php echo "<a ".(($row['type']!="lexis_directory")?"target='_blank'":"")." href='" . (($row['type']=="lexis_directory")?"index.php?switchDir=".$row['id']:"") . "'>" . $row['title']; ?><?php if ($row['type']!="lexis_directory") echo "<span style='color:#999;'>.".strtolower($row['type'])."</span>"; ?></a></h3>-->
				<small style="display:block;">Type: <?php echo $row['type']=="lexis_directory"?"Folder":strtoupper($row['type'])." file"; ?></small>
				<small style="display:block;">Size: <?php if ($row['type']!="lexis_directory") { echo filesize_format($filesize); } else { echo filesize_format(filesize_of_folder($row['id'])); } ?></small>
			</td>
	</table>
	
	<p>&nbsp;</p>
	
	<div>
		<a href="javascript:renameBtn('<?php echo $row['id']; ?>');" class="button color1">Rename</a><?php if ($row['type']!="lexis_directory") { ?><form style="display:inline;" action="downloadFile.php" id="downloadForm" method="POST"><input type="hidden" name="id" value="<?php echo $row['id']; ?>" /><input type="hidden" name="type" value="<?php echo $row['type']; ?>" /><input type="hidden" name="title" value="<?php echo $row['title']; ?>" /><a class="button color2" href="javascript:$('#downloadForm').submit();">Download</a></form><?php } ?><a href="javascript:void(0);" id="deleteBtn" class="button color7">Delete</a>
	</div>
	
	<p>&nbsp;</p>
	
	<div id="preview">
		<?php if ($row['type']=="lexis_directory") { ?>
				Folder contents:
				<ul style="list-style-type:none;">
				<?php
				$fquery = mysql_query("select * from lexis_docbank where container='".$row['id']."'");
				while($frow = mysql_fetch_array($fquery)) {
					echo "<li><img style='vertical-align:middle;' src='".getIconURL($frow['type'])."' width='30' height='30' />&nbsp;<a href='javascript:showPreviewPane(\"".$frow['id']."\");'>".$frow['title']."</a></li>";
				}
				?>
				</ul>
			<?php } else if (in_array($row['type'],array("zip","7z","gz"))) { ?>
				Zipped folder contents:
				<div>
					<ul style="list-style-type:none;">
					<?php $zip = new ZipArchive;
					if (file_exists("../temp/".$row['id']."/")){
						unlink("../temp/".$row['id']."/");
					}
					$res = $zip->open("../files/".$row['id'].".zip");
					if ($res == TRUE) {
						$zip->extractTo('../temp/'.$row['id'].'/');
						$zip->close();
						$contents = scandir("../temp/".$row['id']."/",0);
						foreach ($contents as $item) {
							echo "<li><img src='images/file.png' width='30' height='30' style='vertical-align:middle;'>&nbsp;".$item."</li>";
						}
					} else {
						echo 'Failed to open contents.';
					} ?>
					</ul>
				</div>
			<?php } else { ?>
				No preview available.
			<?php } ?>
	</div>
	
	<script>
	$("#toptable #icon img").height($("#toptable #desc").height());
	$("#toptable #icon img").width($("#toptable #icon img").height());
	$("#toptable #icon").width($("#toptable #icon img").width()+10);
	
	var confirmOn = false;
	var deleted = false;
	$("#deleteBtn").click(function() {
		if (deleted) {
			if (confirmOn) {
				confirmOn = false;
				location.reload(true);
			} else {
				confirmOn = true;
				$(this).html("Click here to refresh");
			}
		} else {
			if (confirmOn) {
				$.ajax({
					type:"POST",
					url:"ajax/deleteFile.php",
					data: {ID:"<?php echo $row['id']; ?>"},
					dataType: "html",
					success: function (msg) {
						/// alert (msg);
						$("#deleteBtn").removeClass("color7");
						$("#deleteBtn").addClass("color6");
						$("#deleteBtn").html("Deleted");
						confirmOn = false;
						deleted = true;
					},
					error: function(msg) {
						confirmOn = false;
						$(this).html(msg+" Delete");
					}
				});
			} else {
				confirmOn = true;
				$(this).html("Confirm Delete");
			}
		}
	});
	</script>
	
<?php } else { ?>

	Something went wrong... sorry!]

<?php } ?>