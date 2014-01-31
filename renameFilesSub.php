<?php
	$dateitypen= array("mpg", "mkv");
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8"/>
	<meta name="viewport" content="width=device-width">

	<?php
		echo "<title>TV-Scraper</title>";		
	?>

	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="icons/foundation-icons.css"/>
	<style>      
		.size-12 { font-size: 12px; }
		.size-14 { font-size: 14px; }
		.size-16 { font-size: 16px; }
		.size-18 { font-size: 18px; }
		.size-21 { font-size: 21px; }
		.size-24 { font-size: 24px; }
		.size-36 { font-size: 36px; }
		.size-48 { font-size: 48px; }
		.size-60 { font-size: 60px; }
		.size-72 { font-size: 72px; }
		.size-X { font-size: 26px; }
	</style>
</head>

<body>
	<?php
		function directoryToArray($directory, $recursive) {
			$array_items = array();
			if ($handle = opendir($directory)) {
				while (false !== ($file = readdir($handle))) {
				    if ($file != "." && $file != ".." && $file[0] != ".") {
				        if (is_dir($directory. "/" . $file)) {
				            if($recursive) {
				                $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
				            }
				            $file = $directory . "/" . $file;
				            $array_items[] = preg_replace("/\/\//si", "/", $file);
				        } else {
				            $file = $directory . "/" . $file;
				            $array_items[] = preg_replace("/\/\//si", "/", $file);
				        }
				    }
				}
				closedir($handle);
			}
			return $array_items;
		}
	?>

	<?php
	/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
	/* Variablen eintragen */
		foreach ($_POST as $key => $value) {
			switch ($key) {
				case 'dateiAlt':
					$dateiAlt=$value;
					break;
				case 'dateiNeu':
					$dateiNeu=$value;
					break;
				case 'ordner':
					$ordner=$value;
					break;
			}
		}
		if (substr($ordner,-1)!="/") {
			$ordner=$ordner."/";
		}
		$dateiNeu=$ordner.$dateiNeu;
		if ( (file_exists($dateiAlt)==true) AND (file_exists($dateiNeu)==false) ) {
			rename($dateiAlt, $dateiNeu);
			echo "<div class=\"row\">";
				echo "<fieldset>";
					echo "<legend>Datei erfolgreich umbenannt</legend>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "Originalname: ".$dateiAlt."<br>";
						echo "neuer Name: ".$dateiNeu."<br>";
					echo "<div>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					echo "<div>";
				echo "</fieldset>";
			echo "<div>";
		} else {
			echo "<div class=\"row\">";
				echo "<fieldset>";
					echo "<legend>Fehler beim umbenennen der Datei</legend>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "Originalname: ".$dateiAlt."<br>";
						echo "neuer Name: ".$dateiNeu."<br>";
					echo "<div>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					echo "<div>";
				echo "</fieldset>";
			echo "<div>";
		}
		$array_items = directoryToArray("filme", true);
		$arrPercentage = array();
		foreach ($array_items as $key => $fileX) {
			$bName1=basename($fileX);
			$bName2=basename($dateiNeu);
			similar_text($bName1, $bName2, $percentage);
			$arrPercentage[$key]=$percentage;
		}
		array_multisort($arrPercentage,SORT_NUMERIC, SORT_DESC , $array_items, SORT_ASC);
	?>
	<div class="row">
		<table>
			<thead>
				<tr>
					<th>Dateiname</th>
					<th>Ähnlichkeit</th>
				</tr>
			</thead>
			<tbody>
				<?php				
					foreach ($array_items as $key => $fileX) {
						$dateiinfo = pathinfo($fileX);
						if(in_array($dateiinfo['extension'],$dateitypen)) {
							$bName=basename($fileX);
							echo "<tr>";
							echo "<td>".basename($fileX)."</td>";
							$perc=explode(".",$arrPercentage[$key]);
							echo "<td>".$perc[0]."%</td>";
							echo "<tr>";
						}

					}
				?>
			</tbody>
		</table>
	</row>


	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation.alert.js"></script>
	<script>$(document).foundation();</script>  
</body>
