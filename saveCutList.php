<?php	
/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
/* Variablen eintragen */
	foreach ($_POST as $key => $value) {
		echo $key." - ";
		echo $value."<br>";
		switch ($key) {
			case 'schnittmarken':
				$schnittmarken=$value;				
				break;
			case 'datei':
				$datei=$value;
				break;
			case 'ordner':
				$ordner=$value;
				break;
		}
	}
?>


<?php
$befehl="";
$i=0;
$schnittmarken=split(",", $schnittmarken);
print_r($schnittmarken);
echo "<br>";
echo "-----<br>";
foreach ($schnittmarken as $value) {
	$i++;
	echo $i;
	echo "<br>";
	switch($i) {
		case "1":
			$befehl=$value."s";		
			break;
		case "2":
			$befehl=$befehl."-".$value."s";
			break;
		case "3":
			$befehl=$befehl.",+".$value."s";
			$i=1;
			break;			
	}
	echo " - ".$befehl."<br>";
}
echo "<br>";
echo "-----<br>";
$schnittmarken=$befehl;
$fp = fopen("cutList.sh","a");
//$befehl = "mkvmerge \"".$datei."\" --split parts:".$schnittmarken." -o \"geschnitten/".basename($datei)."\"; mv \"".$datei."\" \"".$datei.".old\";cat \"cutListOutput.txt\" >> \"cutListOutput.old\";rm \"cutListOutput.txt\"";
$befehl = "mkvmerge \"".$datei."\" --split parts:".$schnittmarken." -o \"geschnitten/".basename($datei)."\"; mv \"".$datei."\" \"".$datei.".old\"";
echo $befehl."<br>";
fwrite($fp, $befehl."\n");
fclose($fp);
header("Location: listFiles.php?ordner=".$ordner); /* Browser umleiten */  
?>

