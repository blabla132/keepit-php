<?php

$view = $_POST['view'] or die ("No variable.");
if ($view == "home") {?>

	<style>
	div.hStack {
		display:inline-block;
		height:100%;
	}
	.item {
		display:inline-block;
		text-align:center;
		vertical-align:middle;
		border-radius:5px;
		padding:5px 15px 5px 15px;
		margin:0px 15px 0px 15px;
		transition:.2s all ease-out;
		-o-transition:.2s all ease-out;
		-ms-transition:.2s all ease-out;
		-moz-transition:.2s all ease-out;
		-webkit-transition:.2s all ease-out;
	}
	.item:hover {
		background-color:#CDCDCD;
		text-decoration:none;
		box-shadow:0px 2px 5px #999;
	}
	.item:active {
		background-color:#ABABAB;
		text-decoration:none;
		box-shadow:inset 0px 2px 5px #999;
	}
	
	.smallImg img {
		width:32px;
		height:32px;
		vertical-align:middle;
		padding-right:5px;
	}
	</style>
	<div class="hStack">
		<table style="height:100%;" class="smallImg">
		<tr>
			<td><a href="scribe.php?doc=new" target="_blank" class="item"><img src="images/new.png" alt="New SCRIBE Document" />New</a></td>
			<td><a href="javascript:save();" class="item"><img src="images/save.png" alt="Save this Document" />Save</a></td>
			<td><a href="javascript:window.close();" class="item"><img src="images/close.png" alt="Close this Document" />Close</a></td>
		</tr><tr>
			<td><a href="javascript:document.execCommand('cut',false,null);" class="item"><img src="images/cut.png" alt="Cut Selected Text" />Cut</a></td>
			<td><a href="javascript:document.execCommand('copy',false,null);" class="item"><img src="images/copy.png" alt="Copy Selected Text" />Copy</a></td>
			<td><a href="javascript:document.execCommand('paste',false,null);" class="item"><img src="images/paste.png" alt="Paste Clipboard Text" />Paste</a></td>
		</tr>
		</table>
	</div>
	<div class="hStack">
		<table><tr><td>
			<select style="width:200px;" id="fontChooser" onChange="javascript:document.execCommand('fontName',false,this.value);">
				<option value="Arial">Arial</option>
				<option value="Comic Sans MS">Comic Sans MS</option>
				<option value="Courier New">Courier New</option>
				<option value="Droid Sans">Droid Sans</option>
				<option value="Georgia">Georgia</option>
				<option value="HelveticaNeue">Helvetica Neue</option>
				<option value="Impact">Impact</option>
				<option value="Open Sans">Open Sans</option>
				<option value="Roboto">Roboto</option>
				<option value="Tahoma">Tahoma</option>
				<option value="Times">Times New Roman</option>
				<option value="Trebuchet MS">Trebuchet MS</option>
				<option value="Verdana">Verdana</option>
			</select>
			<script type="text/javascript">
			
			</script>
		</td></tr><tr><td>
			
		</td></tr></table>
	</div>

<?php } else if ($view == "review") { ?>
	<div id="wordCount"></div>
	<script type="text/javascript">
		setInterval (function() {
			$("#wordCount").html("Word count: "+$("#editor").text().split(" ").length);
		},300);
	</script>
	</script>
<?php } else {
	echo $view;
}

?>