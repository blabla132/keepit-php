<?php

session_start();

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
if (isset($_POST['name'])) {
	if ($_SESSION['logged']==1) {

		include ("../auth.inc.php");
		$id = get_random_string("ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789", 50);
	
		$newdir = $_POST['name'] or die ("No name");
		$use_dir = $_SESSION['current_dir'];
		$username = $_SESSION['username'];
		mysql_query("insert into lexis_docbank (id,title,container,owner,type,dateMod) values('$id','$newdir','$use_dir','$username','lexis_directory',NOW())") or die("Error: " . mysql_error());?>
	
	<script type="text/javascript">
	location.href='index.php';
	</script>
	<?php
	}
}
?>