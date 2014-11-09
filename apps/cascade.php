<?php

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

include ("../../auth.inc.php");
$username = $_SESSION['username'];
$query = mysql_query("select * from `users` where username = '$owner'") or die("Error: ".mysql_error());
$row = mysql_fetch_array($query);
$doc = $_GET['doc'];
$val = true;
$dir = isset($_SESSION['current_dir'])?$_SESSION['current_dir']:$row['lexis_dir'];
if ($doc == "new") {
	$id = get_random_string("ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789",50);
} else {
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$query2 = mysql_query("select * from `lexis_docbank` where id='$id'") or die ("Error: ".mysql_error());
		$row2 = mysql_fetch_array($query2);
		
		$contents = nl2br(file_get_contents("../files/".$id.".cascade")) or die ("Can't find file");
		if ($username == $row2['owner']) {
			$val = true;
		}
	} else {
		$val = false;
	}
}


$cDir = "";
if ($_SESSION['current_dir'] == $row['lexis_dir']) {
	$cDir = "My Cloud";
} else {
	$nowdir = "[unknown directory]";
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
	$cDir = (($upperDirectory != $row['lexis_dir'])?"... ":"") . $upperName . " &raquo; " . $nowdir;
	// echo "Current directory: <b>" . $nowdir . "</b> (<a href='index.php?switchDir=" . $upperDirectory . "'>Back to " . $upperName . "</a>)";
}

?>

<!--

	CASCADE Spreadsheet Editor
	LEXIS CLOUD OFFICE
	(c) 2012-2013 by ANIXO Specifications
	
	The code you found here is written by Michael Zhang. If you have found the PHP inside it we ask that you don't read any sensitive information. Otherwise, feel free to use some of the scripts here as examples as you create your own website or other such project.
	
	If we didn't write the code for any specific portion, we'll tell you about that.

-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="copyright" content="(c) 2012-<?php echo date("Y"); ?> by ANIXO Specifications." />
		<title>Cascade Spreadsheet</title>
		<link rel="stylesheet" href="../../page.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
		<script src="shortcut.js"></script>
		<style type="text/css">
		@media screen {
			#topbar {
				width:100%;
				position:fixed;
				top:0px;
				left:0px;
				background-color:#DDDDDD;
				height:40px;
				padding:25px;
				z-index:20;
			}
			#toolbar {
				width:100%;
				position:fixed;
				top:90px;
				left:0px;
				background-color:#CCCCCC;
				height:25px;
				padding:20px;
				border-top:1px solid #999;
				box-shadow:0px 1px 2px #555;
				z-index:19;
				transition:.2s all ease-out;
				-o-transition:.2s all ease-out;
				-ms-transition:.2s all ease-out;
				-moz-transition:.2s all ease-out;
				-webkit-transition:.2s all ease-out;
			}
			#toolbar:before {
				border-radius:10px / 100px;
				-o-border-radius:10px / 100px;
				-ms-border-radius:10px / 100px;
				-moz-border-radius:10px / 100px;
				-webkit-border-radius:10px / 100px;
			}
			#topbar #title {
				font-size:30px;
				display:inline;
				cursor:pointer;
				padding-left:30px;
			}
            #topbar #cascadeTab {
                position:absolute;
                background-color:#33AA43;
                padding:5px 50px 5px 50px;
                right:360px;
                color:#FFF;
                top:0px;
            }
			.menu {
				border-radius:5px;
				padding:5px 15px 5px 15px;
				margin:0px 15px 0px 15px;
				transition:.2s all ease-out;
				-o-transition:.2s all ease-out;
				-ms-transition:.2s all ease-out;
				-moz-transition:.2s all ease-out;
				-webkit-transition:.2s all ease-out;
			}
			.menu:hover {
				background-color:#CDCDCD;
				text-decoration:none;
				box-shadow:0px 2px 5px #999;
			}
			.menu:active, .selected {
				background-color:#ABABAB;
				text-decoration:none;
				box-shadow:inset 0px 2px 5px #999;
			}
			#slideMenu {
				position:fixed;
				top:150px;
				left:0px;
				width:100%;
				background-color:#DEDEDE;
				/* border:1px solid #F00; */
				transition:.2s all ease-out;
				-o-transition:.2s all ease-out;
				-ms-transition:.2s all ease-out;
				-moz-transition:.2s all ease-out;
				-webkit-transition:.2s all ease-out;
				z-index:18;
				padding:10px;
				height:100px;
			}
			.slideMenuUp {
				top:30px;
				opacity:0;
			}
			.slideMenuDown {
				top:150px;
				opacity:1;
			}
			#editor {
				font-family:Arial,Helvetica;
				width:624px;
				padding:96px;
				background-color:#FFF;
				margin:auto;
				position:relative;
				top:170px;
				transition:.2s all ease-out;
				-o-transition:.2s all ease-out;
				-ms-transition:.2s all ease-out;
				-moz-transition:.2s all ease-out;
				-webkit-transition:.2s all ease-out;
				box-shadow:0px 5px 6px #999;
				z-index:5;
				outline:none;
			}
			#editor:focus {
				box-shadow:0px 6px 10px #666;
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
			<?php
			for ($i = 1; $i <= 30; $i++) {
				echo ".shadowBottom".$i." {
					position:relative;
					-webkit-box-shadow:0 1px 4px rgba(0,0,0,0.3);
					box-shadow:0 1px 4px rgba(0,0,0,0.3);
				}
				.shadowBottom".$i.":after{
					content:'';
					z-index:-1;
					position:absolute;
					top:100%;
					left:0px;
					right:0px;
					bottom:0px;
					width:100%;
					height:".$i."px;
					background:-webkit-radial-gradient(50% -3%, ellipse cover, rgba(00, 00, 00, 0.7), rgba(97, 97, 97, 0.0) 50%);
					background:		   radial-gradient(ellipse at 50% -3%, rgba(00, 00, 00, 0.7), rgba(97, 97, 97, 0.0) 50%);
				}";
			}
			?>
		}
		@media print {
			#sidebarLeft, #sidebarRight {
				display:none;
			}
			#topbar {
				display:none;
			}
			#toolbar {
				display:none;
			}
			#slideMenu {
				display:none;
			}
			.dialog {
				display:none;
			}
		}
		</style>
		<script type="text/javascript">
		var unsaved = false;
		<?php $fonts = "Roboto,Arial,Comic Sans MS,Courier New,Georgia,Impact,Tahoma,Times New Roman,Trebuchet MS,Verdana"; echo "var fonts = '".$fonts."'.split(',');"; ?>
		</script>
	</head>
	<body>
    <?php include ("../../sidebars.php"); ?>
	
	<?php
	if ($_SESSION['logged']==1) {
	?>
	
	<div id="topbar">
        <div id="cascadeTab">CASCADE</div>
		<div id="title"><span id="unsaved"></span><span id="actualTitle">Untitled Spreadsheet</a></div>&nbsp;&nbsp;&nbsp;<span id="saveResults" style="color:#444; vertical-align:middle;"></span>
		<br />
		<span id="message">Ready.</span>
	</div>
	<div id="toolbar">
		<a class="menu" id="home" href="#">Home</a>
		<a class="menu" id="insert" href="#">Insert</a>
		<a class="menu" id="view" href="#">View</a>
		<a class="menu" id="design" href="#">Design</a>
		<a class="menu" id="page_layout" href="#">Page Layout</a>
		<a class="menu" id="review" href="#">Review</a>
	</div>
	<div id="slideMenu" class="slideMenuUp">
	</div>
	
	<!-- MODALS -->
	<div id="retitleDialog" class="dialog">
		<div class="mask"></div>
		<div class="window">
			<p><b>Retitle Spreadsheet</b><a style="position:absolute; top:5px; right:5px;" href="#" class="close"><img src="../images/closeIcon.png" style="width:32px;height:32px;" alt="Close" /></a></p>
				<input type="text" class="tf" name="newTitle" id="newTitle" />
			<p><a class="button color2" href="#" id="retitleBtn">Rename</a></p>
			<script type="text/javascript">
				$("#newTitle").val($("#topbar #title #actualTitle").html());
				$("#retitleBtn").click(function() {
					var q = $("#newTitle").val();
					if (q.length > 1) {
						$("#topbar #title #actualTitle").html(q);
						$("#retitleDialog").fadeOut("fast");
					}
				});
			</script>
		</div>
	</div>
	
	<script>
	
	$("#retitleDialog .window").css("left",(window.innerWidth/2-150)+"px");
	$("#retitleDialog .window").css("top",(window.innerHeight/2-125)+"px");
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
	$("#topbar #title #actualTitle").click (function() {
		$("#retitleDialog").fadeIn("fast");
		$("#newTitle").focus();
	});
	
	$("#toolbar .menu").click(function() {
		if ($(this).hasClass("selected")) {
			$(this).removeClass("selected");
			$("#slideMenu").removeClass("slideMenuDown");
			$("#slideMenu").addClass("slideMenuUp");
			isMenuDown = false;
			scrollShadow();
			$("#editor").css("top","170px");
		} else {
			$("#toolbar .menu").each(function() {
				$(this).removeClass("selected");
			});
			$(this).addClass("selected");
			$.ajax({
				type:"POST",
				url:"cascadeSlideMenuAjax.php",
				data:{view:$(this).attr("id")},
				dataType:"html",
				success:function(msg) {
					$("#slideMenu").html(msg);
				}
			});
			$("#slideMenu").addClass("slideMenuDown");
			$("#slideMenu").removeClass("slideMenuUp");
			$("#toolbar").css("box-shadow","none");
			$("#editor").css("top","290px");
		}
	});
	$("#editor").keyup (function(e) {
		if ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=65 && e.keyCode<=90) || (e.keyCode>=112 && e.keyCode<=123) || (e.keyCode==188 || e.keyCode==190 || e.keyCode==19 || e.keyCode==192 || e.keyCode==219 || e.keyCode==220 || e.keyCode==221 || e.keyCode==222 || e.keyCode==32)) {
			unsaved = true;
		}
	});
	function save() {
		$("#results").html("Saving... ");
		$.ajax({
			type:"POST",
			url:"cascadeSave.php",
			data:{id:"<?php echo $id;?>",
				title:$("#title #actualTitle").html(),
				contents:"wrong format!",
				owner:"<?php echo $_SESSION['username'];?>",
				dir:"<?php echo $dir; ?>"},
			dataType:"html",
			success:function(msg) {
				$("#message").html(msg);
				document.title = $("#title #actualTitle").html()+" - Cascade Spreadsheet";
				unsaved = false;
			}
		});
	}
	
	// KEYBOARD SHORTCUTS
	shortcut.add("Ctrl+S",function() {
		save();
	},{'propagate':false});
	shortcut.add("Esc",function() {
		$(".dialog").fadeOut("fast");
	},{'propagate':false});
	
	
	setInterval(function() {
		scrollShadow();
		
		if (unsaved) $("#title #unsaved").html("*");
		else $("#title #unsaved").html("");
	},30);
	
	function scrollShadow() {
		if ($("#slideMenu").hasClass("slideMenuUp")===true) {
			if ($("#topbar").offset().top!==0) {
				var k = $("#topbar").offset().top;
				if ((k/6)>10) k=60;
				if (k>10) {
					$("#toolbar").removeClass();
					$("#toolbar").addClass("shadowBottom"+Math.floor(k/2));
				} else {
					$("#toolbar").removeClass();
					$("#toolbar").addClass("shadowBottom3");
				}
				$("#toolbar").addClass("shadowBottom");
			} else {
				$("#toolbar").removeClass("shadowBottom");
			}
		} else {
			$("#toolbar").removeClass();
			if ($("#topbar").offset().top!==0) {
				var k = $("#topbar").offset().top;
				if ((k/6)>10) k=60;
				if (k>10) {
					$("#slideMenu").removeClass();
					$("#slideMenu").addClass("shadowBottom"+Math.floor(k/2));
				} else {
					$("#slideMenu").removeClass();
					$("#slideMenu").addClass("shadowBottom3");
				}
				$("#slideMenu").addClass("shadowBottom");
			} else {
				$("#slideMenu").removeClass("shadowBottom");
			}
		}
		// background:radial-gradient(50% -3%, ellipse cover, rgba(00, 00, 00, 0.5), rgba(97, 97, 97, 0.0) 50%);
		/* if ($("#slideMenu").hasClass("slideMenuUp")===true) {
			if ($("#topbar").offset().top!==0) {
				var k = $("#topbar").offset().top;
				if ((k / 6) > 10) {
					k = 10 * 6;
				}
				if (k > 10) {
					$("#toolbar").css("box-shadow","0px "+(k/12)+"px "+(k/6)+"px #555");
				} else {
					$("#toolbar").css("box-shadow","0px 1px 2px #555");
				}
			} else {
				$("#toolbar").css("box-shadow","0px 1px 2px #555");
			}
		} else {
			if ($("#topbar").offset().top!==0) {
				var k = $("#topbar").offset().top;
				if ((k / 6) > 10) {
					k = 10 * 6;
				}
				if (k > 10) {
					$("#slideMenu").css("box-shadow","0px "+(k/12)+"px "+(k/6)+"px #555");
				} else {
					$("#slideMenu").css("box-shadow","0px 1px 2px #555");
				}
			} else {
				$("#slideMenu").css("box-shadow","0px 1px 2px #555");
			}
		} */
	}
	
	$("#title #actualTitle").html("<?php echo ($row2['title'])?$row2['title']:"Untitled Spreadsheet"; ?>");
	$("#editor").html("<?php echo $contents; ?>");
	$("#editor").focus();
	
	</script>
	
	<?php } else { ?>
	<h2>You must be signed in to use the LEXIS Cloud Office.</h2>
	<p>Hover over to the right to reveal the sign in page!</p>
	<?php } ?>
	
	</body>
</html>