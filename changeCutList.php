<?php
	if($_POST['Submit']){
		$open = fopen("cutList.sh","w+");
		$text = $_POST['update'];
		fwrite($open, $text);
		fclose($open);
		echo "File updated.<br />"; 
		echo "File:<br />";
		$file = file("cutList.sh");
		foreach($file as $text) {
			echo $text."<br />";
		}
	}
//	header("Location: main.php");
	header("Location: listFiles.php?ordner=".$_POST["ordner"]);
?>