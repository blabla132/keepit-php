<style>
    .resultsList {
        list-style-type: none;
    }
    .searchResult {
        display: block;
        position: relative;
        left: -20px;
        padding: 10px;
        transition:all .2s ease-out;
        -o-transition:all .2s ease-out;
        -ms-transition:all .2s ease-out;
        -moz-transition:all .2s ease-out;
        -webkit-transition:all .2s ease-out;
    }
    .searchResult:hover {
        background-color: #F3F3F3;
    }
    a:hover {
        text-decoration: none;
    }
</style>

<?php

error_reporting(0);

session_start();    

function getIconURL($ext) {
	$x = scandir("../icons/");
	if (in_array($ext.".png",$x)) {
		return "icons/".$ext.".png";
	} else {
		return "images/file.png";
	}
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

function lengthFilter ($text) {
	if (strlen($text) > 15) {
		return substr($text,0,15)."...";
	} else {
		return $text;
	}
}

if ($_SESSION['logged']==1) {
    $words = $_POST['words'];
    $words = strtolower(trim($words));
    if (isset($words) && strlen($words)>0) {
       $not_allowed = array("\"","\'","\\",";","(",")","-");
       foreach ($not_allowed as $char) {
           $words = str_replace($char,"",$words);
       }
       echo "<p>Your search query: ".$words."</p>";

       /*
       PROCEDURE:
            1. GET ALL THE FILES WITH THE SEARCH QUERY IN FILENAME
            2. GET ALL THE FILES WITH THE SEARCH QUERY IN CONTENTS
       */
       $locus = array();
       $terms = explode(" ",$words);

       include ("../../auth.inc.php");
	    $fquery = mysql_query("select * from `lexis_docbank` where owner='".$_SESSION['username']."'") or die("Error: " . mysql_error());
        $allFiles = array();
        while($file= mysql_fetch_array($fquery)) {
            array_push($allFiles,$file);
        }

        foreach ($allFiles as $file) {
            $title = strtolower($file['title']);
            $b = FALSE;
            foreach ($terms as $term) {
                if (strlen($term)>0) {
                    if (strpos($title,$term)!==FALSE) {
                        $b = TRUE;
                    }                    
                } else {
                    $b = FALSE;
                }
            }
            if ($b) {
                array_push($locus,$file);
            }
        }

        if (count($locus)>0) {
            echo "<ul class='resultsList'>";
            foreach ($locus as $file) {
                $type = $file['type'];
                echo "<li>".($type=="lexis_directory"?('<a href="index.php?switchDir='.$file['id'].'" class="searchResult">'):('<a href="'.getLink($file['id'],$type).'" target="_blank" class="searchResult">'))."<img src='".($type=="lexis_directory"?"images/folder.png":getIconURL($type))."' style='width:30px; height:30px; vertical-align:middle;' />&nbsp;&nbsp;".lengthFilter($file['title'])."</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No files found. Sorry :(";
        }
    }
    else {
        echo "<p>You must enter a search string.</p>";
    }
} else {
    echo "<p>You must be logged in.</p>";
}

?>